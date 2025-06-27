<?php

/**
 * Usage: php tools/md_to_phpunit_methods_recursive.php <path/to/Test_x_y_DescriptionTest.md>
 * 
 * Generates a structured PHPUnit test file based on the markdown spec.
 */

if ($argc < 2) {
    echo "Usage: php tools/md_to_phpunit_methods_recursive.php <spec.md>\n";
    exit(1);
}

$mdFile = $argv[1];
$lines = file($mdFile, FILE_IGNORE_NEW_LINES);

$title = '';
$userStory = [];
$scenarioList = [];
$scenarios = [];
$currentScenario = null;
$inUserStory = false;
$inAcceptance = false;

// Parse the markdown file
foreach ($lines as $idx => $line) {
    // Test title
    if (preg_match('/^#\s*(.+)$/', $line, $m)) {
        $title = trim($m[1]);
        continue;
    }
    // User story block
    if (preg_match('/^##\s*User Story/', $line)) {
        $inUserStory = true;
        continue;
    }
    if ($inUserStory) {
        if (trim($line) === '---' || preg_match('/^##/', $line)) {
            $inUserStory = false;
            continue;
        }
        if (trim($line) !== '') $userStory[] = trim($line);
        continue;
    }
    // Acceptance Criteria block (for scenario listing)
    if (preg_match('/^##\s*Acceptance Criteria|^##\s*BDD Scenarios/i', $line)) {
        $inAcceptance = true;
        continue;
    }
    if ($inAcceptance && (preg_match('/^##/', $line) || trim($line) === '---')) {
        $inAcceptance = false;
        continue;
    }
    if ($inAcceptance && preg_match('/^\s*[-*]\s*([.\d]+)\s*[–-]\s*(.+)/', $line, $m)) {
        $scenarioList[] = trim($m[1] . ' – ' . $m[2]);
        continue;
    }
    // Scenario headers (for methods)
    if (preg_match('/^###\s*Scenario\s*([\d\.]+):\s*(.+)$/', $line, $m)) {
        if ($currentScenario) {
            $scenarios[] = $currentScenario;
        }
        $currentScenario = [
            'id' => $m[1],
            'title' => $m[2],
            'given' => '',
            'when' => '',
            'then' => [],
            'rawthen' => [],
            'raw' => [],
        ];
        continue;
    }
    // Gherkin steps
    if ($currentScenario) {
        // Save raw lines for docblock completeness
        $currentScenario['raw'][] = $line;
        if (preg_match('/^\*\*Given\*\*\s+(.+)/i', $line, $m)) {
            $currentScenario['given'] = $m[1];
        } elseif (preg_match('/^\*\*When\*\*\s+(.+)/i', $line, $m)) {
            $currentScenario['when'] = $m[1];
        } elseif (preg_match('/^\*\*Then\*\*\s+(.+)/i', $line, $m)) {
            // Then can be multiline bullet points or a single line
            $thenText = $m[1];
            $currentScenario['then'][] = $thenText;
            $currentScenario['rawthen'][] = $thenText;
        } elseif (preg_match('/^\s*-\s+(.+)/', $line, $m) &&
                    preg_match('/Then/i', $lines[$idx-1] ?? '')) {
            // Markdown list after Then
            $thenText = $m[1];
            $currentScenario['then'][] = $thenText;
            $currentScenario['rawthen'][] = $thenText;
        }
    }
}
if ($currentScenario) $scenarios[] = $currentScenario;

// Guess class name from file name
$className = preg_replace('/\.md$/', '', basename($mdFile));
$className = preg_replace('/[^a-zA-Z0-9_]/', '_', $className);

echo "<?php\n\n";
echo "require_once __DIR__ . '/../../../model/functions.php';\n\n";
echo "use PHPUnit\\Framework\\TestCase;\n\n";
echo "/**\n";
echo " * {$title}\n";
if ($userStory) {
    echo " *\n";
    echo " * User Story:\n";
    foreach ($userStory as $u) echo " * {$u}\n";
}
if ($scenarioList) {
    echo " *\n";
    echo " * Acceptance Criteria / BDD Scenarios:\n";
    foreach ($scenarioList as $s) echo " * {$s}\n";
}
echo " */\n";
echo "class {$className} extends TestCase\n{\n";

// Output each scenario as a PHPDoc + method
foreach ($scenarios as $sc) {
    echo "    /*\n";
    echo "    * {$sc['id']} – {$sc['title']}\n";
    if ($sc['given']) echo "    * Given {$sc['given']}\n";
    if ($sc['when']) echo "    * When {$sc['when']}\n";
    if (!empty($sc['then'])) {
        echo "    * Then\n";
        foreach ($sc['then'] as $then) {
            echo "    * - {$then}\n";
        }
    }
    echo "    */\n";
    $methodSuffix = preg_replace('/[^a-zA-Z0-9]/', '', str_replace(' ', '', $sc['title']));
    echo "    public function test_" . str_replace('.', '_', $sc['id']) . "_{$methodSuffix}()\n    {\n";
    echo "        // TODO: Implement test logic for this scenario.\n";
    echo "    }\n\n";
}
echo "}\n";