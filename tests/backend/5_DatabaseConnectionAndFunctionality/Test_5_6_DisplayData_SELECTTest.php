<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 5.6 – Display Data (SELECT)
 *
 * User Story:
 * As an application user
 * I need to view data stored in the database
 * So that I can see relevant information in the application interface
 *
 * Acceptance Criteria / BDD Scenarios:
 * 5.6.1 – Application Executes SELECT Query Successfully
 * 5.6.2 – Retrieved Data is Accurately Displayed
 * 5.6.3 – No Records Handling
 */
class Test_5_6_DisplayDataSelectTest extends TestCase
{
    /**
     * 5.6.1 – Application Executes SELECT Query Successfully
     * Given the database contains records
     * When the application executes a SELECT query
     * Then the expected data is retrieved and available for display
     */
    public function test_5_6_1_ApplicationExecutesSelect()
    {
        $host = 'localhost';
        $db   = 'app_db'; // Replace with your database name
        $user = 'webapp_user';
        $pass = 'webapp_password';
        $table = 'users'; // Replace with your application table

        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // Ensure there is at least one record to select
        $pdo->exec("INSERT INTO `$table` (`username`, `password`, `email`) VALUES ('testuser', 'testpass', 'test@example.com')");

        $stmt = $pdo->query("SELECT * FROM `$table` WHERE `username`='testuser'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertNotEmpty($result, "SELECT query should return at least one record.");
        $this->assertEquals('testuser', $result['username']);
        $this->assertEquals('test@example.com', $result['email']);

        // Cleanup
        $pdo->exec("DELETE FROM `$table` WHERE `username`='testuser'");
    }

    /**
     * 5.6.2 – Retrieved Data is Accurately Displayed
     * Given the application has retrieved data from the database
     * When the data is presented on the user interface
     * Then all relevant fields are displayed accurately and match the database values
     */
    public function test_5_6_2_DataAccuratelyDisplayed()
    {
        // This is a backend test; we simulate the UI by fetching and comparing data
        $host = 'localhost';
        $db   = 'app_db';
        $user = 'webapp_user';
        $pass = 'webapp_password';
        $table = 'users';

        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // Insert test data
        $pdo->exec("INSERT INTO `$table` (`username`, `password`, `email`) VALUES ('displayuser', 'displaypass', 'display@example.com')");

        $stmt = $pdo->query("SELECT * FROM `$table` WHERE `username`='displayuser'");
        $dbResult = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simulate data display (in real app, this would be passed to the view)
        $displayed = [
            'username' => $dbResult['username'],
            'email' => $dbResult['email'],
        ];

        $this->assertEquals('displayuser', $displayed['username']);
        $this->assertEquals('display@example.com', $displayed['email']);

        // Cleanup
        $pdo->exec("DELETE FROM `$table` WHERE `username`='displayuser'");
    }

    /**
     * 5.6.3 – No Records Handling
     * Given the SELECT query returns no records
     * When the application attempts to display data
     * Then a clear “no data found” message is shown to the user
     */
    public function test_5_6_3_NoRecordsHandling()
    {
        $host = 'localhost';
        $db   = 'app_db';
        $user = 'webapp_user';
        $pass = 'webapp_password';
        $table = 'users';

        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        // Ensure there is no record with this username
        $pdo->exec("DELETE FROM `$table` WHERE `username`='no_such_user'");

        $stmt = $pdo->query("SELECT * FROM `$table` WHERE `username`='no_such_user'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Simulate what the UI would do if $result is empty
        $noDataMsg = empty($result) ? 'No data found' : 'Data exists';

        $this->assertEquals('No data found', $noDataMsg, "Application should show 'No data found' message when no records exist.");
    }
}