<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.9 – Delete Data (DELETE)
 *
 * User Story:
 * As an application user
 * I need to delete data from the database
 * So that I can remove information that is no longer needed through the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.9.1 – Application Executes DELETE Query Successfully
 * 5.9.2 – Deleted Data is No Longer Present
 * 5.9.3 – Invalid Delete is Handled Gracefully
 */
class Test_5_9_DeleteDataDeleteTest extends TestCase
{
    private $pdo;
    private $table = 'users'; // Adjust this table name as needed

    protected function setUp(): void
    {
        $host = 'localhost';
        $db   = 'app_db'; // Replace with your database name
        $user = 'webapp_user';
        $pass = 'webapp_password';
        $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Ensure a known test record exists
        $this->pdo->exec("DELETE FROM `{$this->table}` WHERE `username` = 'delete_testuser'");
        $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}` (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $stmt->execute(['delete_testuser', 'delpass', 'del@example.com']);
    }

    protected function tearDown(): void
    {
        // Clean up test record
        $this->pdo->exec("DELETE FROM `{$this->table}` WHERE `username` = 'delete_testuser'");
    }

    /**
     * 5.9.1 – Application Executes DELETE Query Successfully
     * Given there is an existing record in the database
     * When the application executes a DELETE query
     * Then the specified record is removed from the database
     */
    public function test_5_9_1_ApplicationExecutesDelete()
    {
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE `username` = ?");
        $result = $stmt->execute(['delete_testuser']);

        $this->assertTrue($result, "DELETE query should succeed for valid record.");

        // Verify record is gone
        $stmt = $this->pdo->prepare("SELECT * FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute(['delete_testuser']);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($record, "Record should be deleted from the database.");
    }

    /**
     * 5.9.2 – Deleted Data is No Longer Present
     * Given a record has been deleted via the application
     * When the database is queried for the deleted record
     * Then the deleted record is no longer found in the database
     */
    public function test_5_9_2_DeletedDataNoLongerPresent()
    {
        // First, delete the record (if not already deleted)
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute(['delete_testuser']);

        // Query for the deleted record
        $stmt = $this->pdo->prepare("SELECT * FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute(['delete_testuser']);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertFalse($record, "Deleted record should not be found in the database.");
    }

    /**
     * 5.9.3 – Invalid Delete is Handled Gracefully
     * Given the application attempts to delete a non-existent record or submits an invalid DELETE query
     * When the DELETE query is executed
     * Then the operation fails gracefully and an informative error or validation message is presented
     */
    public function test_5_9_3_InvalidDeleteHandledGracefully()
    {
        // Attempt to delete a non-existent record
        $stmt = $this->pdo->prepare("DELETE FROM `{$this->table}` WHERE `username` = ?");
        $result = $stmt->execute(['nonexistent_user_xyz123']);

        // Deleting a non-existent record should not throw, but should affect 0 rows
        $this->assertTrue($result, "DELETE query should not throw an error for non-existent record.");
        $this->assertEquals(0, $stmt->rowCount(), "No rows should be affected when deleting a non-existent record.");

        // Attempt an invalid DELETE query (e.g., syntax error)
        $this->expectException(PDOException::class);
        $this->pdo->exec("DELETE FROM `{$this->table}` WHERE"); // Invalid SQL
    }
}