<?php
/**
 * Improved Markdown-to-PHPUnit BDD Agent
 * 
 * Usage: php tools/md_to_phpunit_methods_recursive.php <root_folder>
 * 
 * - Recursively finds .md files
 * - Parses BDD-style "Scenario" blocks (with Given/When/Then)
 * - Generates PHPUnit test methods with traceable names
 */

if ($argc < 2) {
    echo "Usage: php tools/md_to_phpunit_methods_recursive.php <root_folder>\n";
    exit(1);
}

$rootDir = rtrim($argv[1], '/');
if (!is_dir($rootDir)) {
    echo "ERROR: Directory not found: $rootDir\n";
    exit(1);
}

$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootDir));
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    if (strtolower($file->getExtension()) !== 'md') continue;
    $mdFile = $file->getPathname();

    $scenarios = parseBddScenarios($mdFile);
    if (empty($scenarios)) continue;

    echo "// From: {$mdFile}\n";
    foreach ($scenarios as $sc) {
        $methodName = makeTestMethodName($sc['id'], $sc['title']);
        echo "public function {$methodName}()\n{\n";
        echo "    // Given {$sc['given']}\n";
        echo "    // When {$sc['when']}\n";
        echo "    // Then {$sc['then']}\n";
        echo "    // TODO: Implement test logic for this scenario.\n";
        echo "}\n\n";
    }
}

/**
 * Parses BDD scenarios from a markdown file.
 * Looks for 'Scenario <id>: <title>' followed by Given/When/Then (in any order).
 */
function parseBddScenarios($file) {
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $scenarios = [];
    $current = null;
    foreach ($lines as $line) {
        // Match scenario headers, tolerate variations (with/without "###", with/without "Scenario")
        if (preg_match('/^(?:###\s*)?Scenario\s*([\d\.]+):\s*(.+)$/i', trim($line), $m)) {
            if ($current) $scenarios[] = $current;
            $current = ['id' => $m[1], 'title' => trim($m[2]), 'given' => '', 'when' => '', 'then' => ''];
        } elseif (preg_match('/^\*\*Given\*\*\s*(.+)$/i', $line, $m)) {
            if ($current) $current['given'] = trim($m[1]);
        } elseif (preg_match('/^\*\*When\*\*\s*(.+)$/i', $line, $m)) {
            if ($current) $current['when'] = trim($m[1]);
        } elseif (preg_match('/^\*\*Then\*\*\s*(.+)$/i', $line, $m)) {
            if ($current) $current['then'] = trim($m[1]);
        }
    }
    if ($current) $scenarios[] = $current;
    return $scenarios;
}

/**
 * Creates a PHPUnit test method name from scenario ID and title.
 * Example: 5.4.2, "Database Schema is Present" => test_5_4_2_DatabaseSchemaIsPresent
 */
function makeTestMethodName($id, $title) {
    $idPart = str_replace('.', '_', $id);
    // Remove non-alphanumeric, uppercase first letters of each word
    $titlePart = preg_replace('/[^a-zA-Z0-9]/', '', ucwords(str_replace(['-', '_'], ' ', $title)));
    return "test_{$idPart}_{$titlePart}";
}