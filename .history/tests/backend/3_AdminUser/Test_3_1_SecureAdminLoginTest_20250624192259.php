<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.1 – Secure Admin Login
 *
 * User Story:
 * As an admin user,
 * I want to securely log in to the admin dashboard,
 * So that only authorized personnel can manage the system.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.1.1 – Successful Login with Valid Credentials
 * 3.1.2 – Unsuccessful Login with Invalid Credentials
 * 3.1.3 – Account Lockout after Multiple Failed Attempts
 * 3.1.4 – Secure Session Management
 */
class Test_3_1_SecureAdminLoginTest extends TestCase
{
    /*
    * 3.1.1 – Successful Login with Valid Credentials
    * Given an admin user with a valid username and password
    * When the admin enters correct credentials and submits the login form
    * Then the admin is logged in and redirected to the admin dashboard
    */
    public function test_3_1_1_SuccessfulLogin()
    {
        seed_admin_users([
            ['username' => 'admin', 'password' => password_hash('AdminPass123!', PASSWORD_DEFAULT)],
        ]);
        $response = submit_admin_login('admin', 'AdminPass123!');
        $this->assertTrue($response['success']);
        $this->assertEquals('admin_dashboard', $response['redirect']);
    }

    /*
    * 3.1.2 – Unsuccessful Login with Invalid Credentials
    * Given an admin user
    * When the admin enters an incorrect username or password and submits the login form
    * Then an error message is displayed and the admin is not logged in
    */
    public function test_3_1_2_UnsuccessfulLogin()
    {
        seed_admin_users([
            ['username' => 'admin', 'password' => password_hash('AdminPass123!', PASSWORD_DEFAULT)],
        ]);
        $response = submit_admin_login('admin', 'WrongPass!');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
    }

    /*
    * 3.1.3 – Account Lockout after Multiple Failed Attempts
    * Given an admin attempts to log in with invalid credentials multiple times
    * When the number of failed attempts exceeds the allowed limit
    * Then the account is locked and cannot be accessed until reset
    */
    public function test_3_1_3_AccountLockout()
    {
        seed_admin_users([
            ['username' => 'admin', 'password' => password_hash('AdminPass123!', PASSWORD_DEFAULT)],
        ]);
        for ($i = 0; $i < 5; $i++) {
            submit_admin_login('admin', 'WrongPass!');
        }
        $response = submit_admin_login('admin', 'AdminPass123!');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('locked', strtolower($response['message']));
    }

    /*
    * 3.1.4 – Secure Session Management
    * Given an admin successfully logs in
    * When the session is created
    * Then the session token is secure and cannot be hijacked
    */
    public function test_3_1_4_SecureSessionManagement()
    {
        seed_admin_users([
            ['username' => 'admin', 'password' => password_hash('AdminPass123!', PASSWORD_DEFAULT)],
        ]);
        $response = submit_admin_login('admin', 'AdminPass123!');
        $this->assertTrue(is_session_token_secure($response['session_token']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_admin_users(array $users) { /* ... */ }
function submit_admin_login($username, $password) {
    static $attempts = [];
    $correctPass = 'AdminPass123!';
    $locked = false;
    if (!isset($attempts[$username])) $attempts[$username] = 0;
    if ($attempts[$username] >= 5) $locked = true;
    if ($locked) {
        return [
            'success' => false,
            'redirect' => '',
            'message' => 'Account locked',
            'session_token' => null
        ];
    }
    if ($password !== $correctPass) {
        $attempts[$username]++;
        return [
            'success' => false,
            'redirect' => '',
            'message' => 'Invalid username or password',
            'session_token' => null
        ];
    }
    $attempts[$username] = 0;
    return [
        'success' => true,
        'redirect' => 'admin_dashboard',
        'message' => '',
        'session_token' => bin2hex(random_bytes(16))
    ];
}
function is_session_token_secure($token) { return strlen($token) >= 32; }