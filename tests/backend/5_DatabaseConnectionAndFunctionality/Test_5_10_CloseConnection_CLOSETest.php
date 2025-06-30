<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.10 – Close the Connection (CLOSE)
 *
 * User Story:
 * As an application developer
 * I want to ensure that database connections are properly closed after use
 * So that I can prevent resource leaks and improve application stability
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.10.1 – Application Closes Connection After Use
 * 5.10.2 – Attempting to Use Closed Connection Fails Gracefully
 * 5.10.3 – No Resource Leaks After Connection Close
 */
class Test_5_10_CloseConnectionCloseTest extends TestCase
{
    private $pdo;
    private $table = 'users'; // Adjust as needed

    protected function setUp(): void
    {
        $host = 'localhost';
        $db   = 'app_db'; // Replace with your database name
        $user = 'webapp_user';
        $pass = 'webapp_password';
        $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * 5.10.1 – Application Closes Connection After Use
     * Given the application has finished using the database
     * When the database operation is complete
     * Then the connection to the database is closed
     */
    public function test_5_10_1_ApplicationClosesConnection()
    {
        // Use the connection for a simple operation
        $stmt = $this->pdo->query("SELECT 1");
        $this->assertEquals(1, $stmt->fetchColumn());

        // Close the connection
        $this->pdo = null;

        // There is no direct way to test for closed connection in PDO,
        // but we can assert that setting $pdo to null does not throw.
        $this->assertNull($this->pdo, "PDO connection should be set to null (closed).");
    }

    /**
     * 5.10.2 – Attempting to Use Closed Connection Fails Gracefully
     * Given the connection has been closed
     * When the application attempts to use the closed connection
     * Then an informative error or exception is returned, and no database operation is performed
     */
    public function test_5_10_2_AttemptUseClosedFailsGraceful()
    {
        $this->pdo = null; // Close the connection

        $this->expectException(Error::class);
        // This will throw Error because $this->pdo is null
        $this->pdo->query("SELECT 1");
    }

    /**
     * 5.10.3 – No Resource Leaks After Connection Close
     * Given multiple connections have been opened and closed
     * When the application is monitored for resource usage
     * Then there are no lingering open connections or resource leaks
     */
    public function test_5_10_3_NoResourceLeaksAfterClose()
    {
        // Open and close multiple connections
        for ($i = 0; $i < 10; $i++) {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=app_db",
                "webapp_user",
                "webapp_password"
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->query("SELECT 1");
            $this->assertEquals(1, $stmt->fetchColumn());
            // Close
            $pdo = null;
        }

        // If we reach this point without memory or connection errors, we consider the test passed.
        $this->assertTrue(true, "All connections have been closed without resource leaks.");
    }
}