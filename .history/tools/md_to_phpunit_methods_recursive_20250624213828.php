<?php

/**
 * Usage: php tools/md_to_phpunit_methods_recursive.php <directory>
 * 
 * Recursively processes all .md files in <directory>.
 * For each .md file, generates a structured PHPUnit test class .php file next to it.
 */

if ($argc < 2) {
    echo "Usage: php tools/md_to_phpunit_methods_recursive.php <directory>\n";
    exit(1);
}

$rootDir = rtrim($argv[1], '/');
if (!is_dir($rootDir)) {
    echo "ERROR: Directory not found: $rootDir\n";
    exit(1);
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootDir));
foreach ($rii as $file) {
    if ($file->isDir() || strtolower($file->getExtension()) !== 'md') continue;
    $mdFile = $file->getPathname();
    $lines = file($mdFile, FILE_IGNORE_NEW_LINES);

    $title = '';
    $userStory = [];
    $scenarioList = [];
    $scenarios = [];
    $currentScenario = null;
    $inUserStory = false;
    $inAcceptance = false;

    foreach ($lines as $idx => $line) {
        // Test title
        if (preg_match('/^#\s*(.+)$/', $line, $m)) {
            $title = trim($m[1]);
            continue;
        }
        // User story block
        if (preg_match('/^##\s*User Story/i', $line)) {
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
        // For scenario list (if bullets are not used, skip this)
        if ($inAcceptance && preg_match('/^\s*[-*]\s*([.\d]+)\s*[–-]\s*(.+)/', $line, $m)) {
            $scenarioList[] = trim($m[1] . ' – ' . $m[2]);
            continue;
        }
        // Scenario headers (for methods)
        if (preg_match('/^###\s*Scenario\s*([\d\.]+):\s*(.+)$/i', $line, $m)) {
            if ($currentScenario) {
                $scenarios[] = $currentScenario;
            }
            $currentScenario = [
                'id' => $m[1],
                'title' => $m[2],
                'given' => '',
                'when' => '',
                'then' => [],
            ];
            continue;
        }
        // Gherkin steps
        if ($currentScenario) {
            if (preg_match('/^\*\*Given\*\*\s+(.+)/i', $line, $m)) {
                $currentScenario['given'] = $m[1];
            } elseif (preg_match('/^\*\*When\*\*\s+(.+)/i', $line, $m)) {
                $currentScenario['when'] = $m[1];
            } elseif (preg_match('/^\*\*Then\*\*\s+(.+)/i', $line, $m)) {
                $currentScenario['then'][] = $m[1];
            } elseif (preg_match('/^\s*-\s+(.+)/', $line, $m) && preg_match('/Then/i', $lines[$idx-1] ?? '')) {
                $currentScenario['then'][] = $m[1];
            }
        }
    }
    if ($currentScenario) $scenarios[] = $currentScenario;

    // If scenarioList is empty, fill from scenario headers
    if (empty($scenarioList) && $scenarios) {
        foreach ($scenarios as $sc) {
            $scenarioList[] = $sc['id'] . ' – ' . $sc['title'];
        }
    }

    // Guess class name from file name
    $className = preg_replace('/\.md$/', '', basename($mdFile));
    $className = preg_replace('/[^a-zA-Z0-9_]/', '_', $className);

    // Output PHP file path
    $phpFile = preg_replace('/\.md$/', '.php', $mdFile);

    // Begin PHP output
    $php = "<?php\n\n";
    $php .= "require_once __DIR__ . '/../../../model/functions.php';\n\n";
    $php .= "use PHPUnit\\Framework\\TestCase;\n\n";
    $php .= "/**\n";
    $php .= $title ? " * {$title}\n" : '';
    if ($userStory) {
        $php .= " *\n";
        $php .= " * User Story:\n";
        foreach ($userStory as $u) $php .= " * {$u}\n";
    }
    if ($scenarioList) {
        $php .= " *\n";
        $php .= " * Acceptance Criteria / BDD Scenarios:\n";
        foreach ($scenarioList as $s) $php .= " * {$s}\n";
    }
    $php .= " */\n";
    $php .= "class {$className} extends TestCase\n{\n";

    // Output each scenario as a PHPDoc + method
    foreach ($scenarios as $sc) {
        $php .= "    /*\n";
        $php .= "    * {$sc['id']} – {$sc['title']}\n";
        if ($sc['given']) $php .= "    * Given {$sc['given']}\n";
        if ($sc['when']) $php .= "    * When {$sc['when']}\n";
        if (!empty($sc['then'])) {
            $php .= "    * Then\n";
            foreach ($sc['then'] as $then) {
                $php .= "    * - {$then}\n";
            }
        }
        $php .= "    */\n";
        $methodSuffix = preg_replace('/[^a-zA-Z0-9]/', '', str_replace(' ', '', $sc['title']));
        $php .= "    public function test_" . str_replace('.', '_', $sc['id']) . "_{$methodSuffix}()\n    {\n";
        $php .= "        // TODO: Implement test logic for this scenario.\n";
        $php .= "    }\n\n";
    }
    $php .= "}\n";

    file_put_contents($phpFile, $php);
    echo "Generated: $phpFile\n";
}