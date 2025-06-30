<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.7 – Insert Data (INSERT)
 *
 * User Story:
 * As an application user
 * I need to add new data to the database
 * So that I can store new information through the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.7.1 – Application Executes INSERT Query Successfully
 * 5.7.2 – Inserted Data is Accurately Stored
 * 5.7.3 – Invalid Data is Handled Gracefully
 */
class Test_5_7_InsertDataInsertTest extends TestCase
{
    private $pdo;
    private $table = 'users'; // Adjust the table name as needed

    protected function setUp(): void
    {
        $host = 'localhost';
        $db   = 'app_db'; // Replace with your database name
        $user = 'webapp_user';
        $pass = 'webapp_password';
        $this->pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function tearDown(): void
    {
        // Clean up any test records
        $this->pdo->exec("DELETE FROM `{$this->table}` WHERE `username` LIKE 'insert_testuser%'");
    }

    /**
     * 5.7.1 – Application Executes INSERT Query Successfully
     * Given the application receives new data from a user input
     * When the application executes an INSERT query
     * Then the new record is added to the correct table in the database
     */
    public function test_5_7_1_ApplicationExecutesInsert()
    {
        $username = 'insert_testuser1';
        $password = 'testpass1';
        $email    = 'insert1@example.com';

        $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}` (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $result = $stmt->execute([$username, $password, $email]);

        $this->assertTrue($result, "INSERT query should succeed for valid data.");

        // Verify record exists
        $stmt = $this->pdo->prepare("SELECT * FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute([$username]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($record, "Newly inserted record should exist in the database.");
    }

    /**
     * 5.7.2 – Inserted Data is Accurately Stored
     * Given the application has executed an INSERT query
     * When the database is queried for the new data
     * Then all fields of the new record match the input data
     */
    public function test_5_7_2_InsertedDataAccuratelyStored()
    {
        $username = 'insert_testuser2';
        $password = 'testpass2';
        $email    = 'insert2@example.com';

        $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}` (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $email]);

        $stmt = $this->pdo->prepare("SELECT * FROM `{$this->table}` WHERE `username` = ?");
        $stmt->execute([$username]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($username, $record['username'], "Username should match input data.");
        $this->assertEquals($password, $record['password'], "Password should match input data.");
        $this->assertEquals($email, $record['email'], "Email should match input data.");
    }

    /**
     * 5.7.3 – Invalid Data is Handled Gracefully
     * Given the application receives invalid or incomplete input
     * When the application attempts to execute an INSERT query
     * Then the insert fails gracefully and an informative error or validation message is presented
     */
    public function test_5_7_3_InvalidDataHandledGracefully()
    {
        $username = ''; // Invalid: empty username (assume NOT NULL constraint)
        $password = 'testpass3';
        $email    = 'insert3@example.com';

        $this->expectException(PDOException::class);

        $stmt = $this->pdo->prepare("INSERT INTO `{$this->table}` (`username`, `password`, `email`) VALUES (?, ?, ?)");
        $stmt->execute([$username, $password, $email]);
    }
}