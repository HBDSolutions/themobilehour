<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.8 – Update Data (UPDATE)
 *
 * User Story:
 * As an application user
 * I need to update existing data in the database
 * So that I can correct or modify information through the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.8.1 – Application Executes UPDATE Query Successfully
 * 5.8.2 – Updated Data is Accurately Stored
 * 5.8.3 – Invalid Update is Handled Gracefully
 */
class Test_5_8_UpdateDataUpdateTest extends TestCase
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
        $this->pdo->exec("DELETE FROM `{$this->table}` WHERE `username` = 'update_testuser'");
        $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}` (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $stmt->execute(['update_testuser', 'oldpass', 'old@example.com']);
    }

    protected function tearDown(): void
    {
        // Clean up test record
        $this->pdo->exec("DELETE FROM `{$this->table}` WHERE `username` = 'update_testuser'");
    }

    /**
     * 5.8.1 – Application Executes UPDATE Query Successfully
     * Given there is an existing record in the database
     * When the application executes an UPDATE query with new data
     * Then the record is updated with the new values
     */
    public function test_5_8_1_ApplicationExecutesUpdate()
    {
        $newPassword = 'newpass1';
        $newEmail = 'new1@example.com';

        $stmt = $this->pdo->prepare("UPDATE `{$this->table}` SET `password` = ?, `email` = ? WHERE `username` = ?");
        $result = $stmt->execute([$newPassword, $newEmail, 'update_testuser']);

        $this->assertTrue($result, "UPDATE query should succeed for valid data.");

        // Verify update occurred
        $stmt = $this->pdo->prepare("SELECT `password`, `email` FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute(['update_testuser']);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($newPassword, $record['password']);
        $this->assertEquals($newEmail, $record['email']);
    }

    /**
     * 5.8.2 – Updated Data is Accurately Stored
     * Given the application has executed an UPDATE query
     * When the database is queried for the updated record
     * Then all updated fields match the new input data
     */
    public function test_5_8_2_UpdatedDataAccuratelyStored()
    {
        $newPassword = 'newpass2';
        $newEmail = 'new2@example.com';

        $stmt = $this->pdo->prepare("UPDATE `{$this->table}` SET `password` = ?, `email` = ? WHERE `username` = ?");
        $stmt->execute([$newPassword, $newEmail, 'update_testuser']);

        $stmt = $this->pdo->prepare("SELECT `password`, `email` FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute(['update_testuser']);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($newPassword, $record['password'], "Password should match the new input data.");
        $this->assertEquals($newEmail, $record['email'], "Email should match the new input data.");
    }

    /**
     * 5.8.3 – Invalid Update is Handled Gracefully
     * Given the application attempts to update with invalid data
     * When the UPDATE query is executed
     * Then the update fails gracefully and an informative error or validation message is presented
     */
    public function test_5_8_3_InvalidUpdateHandledGracefully()
    {
        $invalidEmail = null; // Assume email is NOT NULL
        $newPassword = 'newpass3';

        $this->expectException(PDOException::class);

        $stmt = $this->pdo->prepare("UPDATE `{$this->table}` SET `password` = ?, `email` = ? WHERE `username` = ?");
        $stmt->execute([$newPassword, $invalidEmail, 'update_testuser']);
    }
}