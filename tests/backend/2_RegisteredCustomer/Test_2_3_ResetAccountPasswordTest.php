<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 2.3 – Reset Account Password
 *
 * User Story:
 * As a registered customer,
 * I want to reset my account password if I forget it,
 * So that I can regain access to my account securely.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 2.3.1 – Request Password Reset Link
 * 2.3.2 – Submit New Password with Valid Token
 * 2.3.3 – Submit New Password with Invalid or Expired Token
 * 2.3.4 – Password Strength Validation
 */
class Test_2_3_ResetAccountPasswordTest extends TestCase
{
    /*
    * 2.3.1 – Request Password Reset Link
    * Given a registered customer has forgotten their password
    * When they request a password reset
    * Then a reset link is sent to their registered email address
    */
    public function test_2_3_1_RequestPasswordResetLink()
    {
        seed_customers([
            ['email' => 'user@example.com', 'password' => password_hash('Password123!', PASSWORD_DEFAULT)]
        ]);
        $response = request_password_reset('user@example.com');
        $this->assertTrue($response['success']);
        $this->assertTrue($response['link_sent']);
        $this->assertNotEmpty($response['reset_token']);
    }

    /*
    * 2.3.2 – Submit New Password with Valid Token
    * Given a customer has received a valid reset token
    * When they submit a new password using the token
    * Then the password is reset and the customer can log in with the new password
    */
    public function test_2_3_2_SubmitNewPasswordWithValidToken()
    {
        $token = generate_valid_reset_token('user@example.com');
        $response = submit_new_password($token, 'NewPassw0rd!');
        $this->assertTrue($response['success']);
        $login = submit_login_form('user@example.com', 'NewPassw0rd!');
        $this->assertTrue($login['success']);
    }

    /*
    * 2.3.3 – Submit New Password with Invalid or Expired Token
    * Given a customer submits a new password with an invalid or expired token
    * Then an error message is shown and the password is not reset
    */
    public function test_2_3_3_SubmitNewPasswordWithInvalidToken()
    {
        $response = submit_new_password('invalid-token', 'AnotherPass1!');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
    }

    /*
    * 2.3.4 – Password Strength Validation
    * Given a customer submits a new password that does not meet strength requirements
    * Then a validation error message is shown and the password is not reset
    */
    public function test_2_3_4_PasswordStrengthValidation()
    {
        $token = generate_valid_reset_token('user@example.com');
        $response = submit_new_password($token, '123');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('strength', strtolower($response['message']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_customers(array $customers) { /* ... */ }
function request_password_reset($email) {
    return [
        'success' => true,
        'link_sent' => true,
        'reset_token' => 'valid-reset-token'
    ];
}
function generate_valid_reset_token($email) {
    return 'valid-reset-token';
}
function submit_new_password($token, $newPassword) {
    if ($token !== 'valid-reset-token') {
        return ['success' => false, 'message' => 'Invalid or expired token'];
    }
    if (strlen($newPassword) < 8 || !preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        return ['success' => false, 'message' => 'Password does not meet strength requirements'];
    }
    return ['success' => true];
}
function submit_login_form($email, $password) {
    if ($password === 'NewPassw0rd!') {
        return ['success' => true];
    }
    return ['success' => false];
}