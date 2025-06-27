<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.5 – Reusable Database Connection Script
 *
 * User Story:
 * As a system administrator
 * I need a reusable database connection script that uses the web application connection user account
 * So that application code can connect securely and consistently to the database
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.5.1 – Connection Script Exists and Uses Web User Credentials
 * 5.5.2 – Script Allows Successful Application Connection
 * 5.5.3 – Script is Reusable and Modular
 * 5.5.4 – Script Handles Connection Errors Gracefully
 */
class Test_5_5_ReusableConnectionScriptTest extends TestCase
{
    /**
     * 5.5.1 – Connection Script Exists and Uses Web User Credentials
     * Given the web user account credentials are available
     * When I review the database connection script
     * Then the script uses the correct web user account credentials (not root or admin accounts)
     */
    public function test_5_5_1_ConnectionScriptUsesWebUser()
    {
        $connectionScriptPath = __DIR__ . '/../../../model/db_connect.php'; // Adjust path as needed
        $this->assertFileExists($connectionScriptPath, "Database connection script should exist at $connectionScriptPath");

        $scriptContents = file_get_contents($connectionScriptPath);
        $this->assertStringContainsString('webapp_user', $scriptContents, "Connection script should use 'webapp_user' credentials");
        $this->assertStringNotContainsString('root', $scriptContents, "Connection script should NOT use 'root' credentials");
        $this->assertStringNotContainsString('admin', $scriptContents, "Connection script should NOT use 'admin' credentials");
    }

    /**
     * 5.5.2 – Script Allows Successful Application Connection
     * Given the connection script is included in application code
     * When the application calls the script to connect to the database
     * Then the database connection is established successfully using the web user account
     */
    public function test_5_5_2_ScriptAllowsSuccessfulConnection()
    {
        require_once __DIR__ . '/../../../model/db_connect.php'; // should define $pdo or similar

        // Check if $pdo is set and is a PDO instance
        $this->assertTrue(isset($pdo) && $pdo instanceof PDO, "db_connect.php should initialize a PDO instance");
        // Test connectivity
        $stmt = $pdo->query("SELECT 1");
        $this->assertEquals(1, $stmt->fetchColumn(), "Connection script should allow successful queries");
    }

    /**
     * 5.5.3 – Script is Reusable and Modular
     * Given the connection script is used in multiple parts of the application
     * When different components require database access
     * Then they can all include or require the same connection script without code duplication
     */
    public function test_5_5_3_ScriptIsReusableAndModular()
    {
        $connectionScriptPath = __DIR__ . '/../../../model/db_connect.php';
        $this->assertFileExists($connectionScriptPath, "Database connection script should exist for reuse");

        // Simulate inclusion from different files
        require $connectionScriptPath;
        $this->assertTrue(isset($pdo) && $pdo instanceof PDO, "Connection script should initialize PDO on first include");

        // Simulate a second include (should not redeclare or cause error)
        require_once $connectionScriptPath;
        $this->assertTrue(isset($pdo) && $pdo instanceof PDO, "Connection script should support multiple includes without error");
    }

    /**
     * 5.5.4 – Script Handles Connection Errors Gracefully
     * Given the connection script is used
     * When a connection attempt fails (e.g., wrong credentials, db not available)
     * Then the script handles the error gracefully and returns or logs an informative error
     */
    public function test_5_5_4_ScriptHandlesConnectionErrors()
    {
        // We'll temporarily override env vars or simulate broken credentials.
        $connectionScriptPath = __DIR__ . '/../../../model/db_connect.php';

        // Backup original script
        $original = file_get_contents($connectionScriptPath);

        // Inject bad credentials
        $brokenScript = str_replace(
            ["'webapp_password'", '"webapp_password"'],
            ["'bad_password'", '"bad_password"'],
            $original
        );
        $tmpPath = __DIR__ . '/../../../model/db_connect_test_tmp.php';
        file_put_contents($tmpPath, $brokenScript);

        ob_start();
        try {
            include $tmpPath;
        } catch (\Throwable $e) {
            $output = ob_get_clean();
            $this->assertStringContainsString('error', strtolower($e->getMessage() . $output));
            unlink($tmpPath);
            return;
        }
        $output = ob_get_clean();
        unlink($tmpPath);

        $this->assertStringContainsString('error', strtolower($output), "Connection script should handle errors gracefully");
    }
}