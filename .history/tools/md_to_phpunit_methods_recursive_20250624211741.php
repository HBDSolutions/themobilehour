<?php
/**
 * Improved Agent: Generates full PHPUnit test classes from BDD-style markdown files.
 * 
 * Usage: php tools/md_to_phpunit_classes_recursive.php <root_folder>
 * Outputs each test class as a separate PHP file alongside its markdown source.
 */

if ($argc < 2) {
    echo "Usage: php tools/md_to_phpunit_classes_recursive.php <root_folder>\n";
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

    // Class name from file name (strip extension)
    $filename = basename($mdFile, '.md');
    $className = preg_replace('/[^a-zA-Z0-9_]/', '', $filename);

    // Destination PHP file (same folder, .php extension)
    $phpFile = dirname($mdFile) . DIRECTORY_SEPARATOR . $className . '.php';

    $classCode = "<?php\n";
    $classCode .= "use PHPUnit\\Framework\\TestCase;\n\n";
    $classCode .= "class $className extends TestCase\n{\n";
    foreach ($scenarios as $sc) {
        $methodName = makeTestMethodName($sc['id'], $sc['title']);
        $classCode .= "    public function {$methodName}()\n    {\n";
        $classCode .= "        // Given {$sc['given']}\n";
        $classCode .= "        // When {$sc['when']}\n";
        $classCode .= "        // Then {$sc['then']}\n";
        $classCode .= "        // TODO: Implement test logic for this scenario.\n";
        $classCode .= "    }\n\n";
    }
    $classCode .= "}\n";

    file_put_contents($phpFile, $classCode);
    echo "Generated: $phpFile\n";
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

function makeTestMethodName($id, $title) {
    $idPart = str_replace('.', '_', $id);
    $titlePart = preg_replace('/[^a-zA-Z0-9]/', '', ucwords(str_replace(['-', '_'], ' ', $title)));
    return "test_{$idPart}_{$titlePart}";
}