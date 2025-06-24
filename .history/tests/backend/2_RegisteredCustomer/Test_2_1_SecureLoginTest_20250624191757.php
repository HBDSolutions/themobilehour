<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 2.1 – Secure Login
 *
 * User Story:
 * As a registered customer,
 * I want to securely log in to my account,
 * So that I can access my personal dashboard and data.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 2.1.1 – Successful Login with Valid Credentials
 * 2.1.2 – Unsuccessful Login with Invalid Credentials
 * 2.1.3 – Account Lockout after Multiple Failed Attempts
 * 2.1.4 – Secure Session Management
 */
class Test_2_1_SecureLoginTest extends TestCase
{
    /*
    * 2.1.1 – Successful Login with Valid Credentials
    * Given a registered customer with a valid email and password
    * When the customer enters correct credentials and submits the login form
    * Then the customer is logged in and redirected to their dashboard
    */
    public function test_2_1_1_SuccessfulLogin()
    {
        seed_customers([
            ['email' => 'user@example.com', 'password' => password_hash('Password123!', PASSWORD_DEFAULT)],
        ]);
        $response = submit_login_form('user@example.com', 'Password123!');
        $this->assertTrue($response['success']);
        $this->assertEquals('dashboard', $response['redirect']);
    }

    /*
    * 2.1.2 – Unsuccessful Login with Invalid Credentials
    * Given a registered customer
    * When the customer enters an incorrect email or password and submits the login form
    * Then an error message is displayed and the customer is not logged in
    */
    public function test_2_1_2_UnsuccessfulLogin()
    {
        seed_customers([
            ['email' => 'user@example.com', 'password' => password_hash('Password123!', PASSWORD_DEFAULT)],
        ]);
        $response = submit_login_form('user@example.com', 'WrongPassword!');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
    }

    /*
    * 2.1.3 – Account Lockout after Multiple Failed Attempts
    * Given a customer attempts to log in with invalid credentials multiple times
    * When the number of failed attempts exceeds the allowed limit
    * Then the account is locked and cannot be accessed until reset
    */
    public function test_2_1_3_AccountLockout()
    {
        seed_customers([
            ['email' => 'user@example.com', 'password' => password_hash('Password123!', PASSWORD_DEFAULT)],
        ]);
        for ($i = 0; $i < 5; $i++) {
            submit_login_form('user@example.com', 'WrongPassword!');
        }
        $response = submit_login_form('user@example.com', 'Password123!');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('locked', strtolower($response['message']));
    }

    /*
    * 2.1.4 – Secure Session Management
    * Given a customer successfully logs in
    * When the session is created
    * Then the session token is secure and cannot be hijacked
    */
    public function test_2_1_4_SecureSessionManagement()
    {
        seed_customers([
            ['email' => 'user@example.com', 'password' => password_hash('Password123!', PASSWORD_DEFAULT)],
        ]);
        $response = submit_login_form('user@example.com', 'Password123!');
        $this->assertTrue(is_session_token_secure($response['session_token']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_customers(array $customers) { /* ... */ }
function submit_login_form($email, $password) {
    // Example response:
    static $attempts = [];
    $correctPass = 'Password123!';
    $locked = false;
    if (!isset($attempts[$email])) $attempts[$email] = 0;
    if ($attempts[$email] >= 5) $locked = true;
    if ($locked) {
        return [
            'success' => false,
            'redirect' => '',
            'message' => 'Account locked',
            'session_token' => null
        ];
    }
    if ($password !== $correctPass) {
        $attempts[$email]++;
        return [
            'success' => false,
            'redirect' => '',
            'message' => 'Invalid email or password',
            'session_token' => null
        ];
    }
    $attempts[$email] = 0;
    return [
        'success' => true,
        'redirect' => 'dashboard',
        'message' => '',
        'session_token' => bin2hex(random_bytes(16))
    ];
}
function is_session_token_secure($token) { return strlen($token) >= 32; }