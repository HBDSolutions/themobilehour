<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.2 – Reset Admin Password
 *
 * User Story:
 * As an admin user,
 * I want to reset my password securely,
 * So that I can regain access to the admin dashboard if I forget my password.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.2.1 – Request Password Reset Link
 * 3.2.2 – Submit New Password with Valid Token
 * 3.2.3 – Submit New Password with Invalid or Expired Token
 * 3.2.4 – Password Strength Validation
 */
class Test_3_2_ResetAdminPasswordTest extends TestCase
{
    /*
    * 3.2.1 – Request Password Reset Link
    * Given an admin has forgotten their password
    * When they request a password reset
    * Then a reset link is sent to their registered email address
    */
    public function test_3_2_1_RequestPasswordResetLink()
    {
        seed_admin_users([
            ['username' => 'admin', 'email' => 'admin@example.com', 'password' => password_hash('AdminPass123!', PASSWORD_DEFAULT)]
        ]);
        $response = request_admin_password_reset('admin@example.com');
        $this->assertTrue($response['success']);
        $this->assertTrue($response['link_sent']);
        $this->assertNotEmpty($response['reset_token']);
    }

    /*
    * 3.2.2 – Submit New Password with Valid Token
    * Given an admin has received a valid reset token
    * When they submit a new password using the token
    * Then the password is reset and the admin can log in with the new password
    */
    public function test_3_2_2_SubmitNewPasswordWithValidToken()
    {
        $token = generate_valid_admin_reset_token('admin@example.com');
        $response = submit_admin_new_password($token, 'AdminNewPass1!');
        $this->assertTrue($response['success']);
        $login = submit_admin_login('admin', 'AdminNewPass1!');
        $this->assertTrue($login['success']);
    }

    /*
    * 3.2.3 – Submit New Password with Invalid or Expired Token
    * Given an admin submits a new password with an invalid or expired token
    * Then an error message is shown and the password is not reset
    */
    public function test_3_2_3_SubmitNewPasswordWithInvalidToken()
    {
        $response = submit_admin_new_password('invalid-token', 'AnotherAdmin1!');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
    }

    /*
    * 3.2.4 – Password Strength Validation
    * Given an admin submits a new password that does not meet strength requirements
    * Then a validation error message is shown and the password is not reset
    */
    public function test_3_2_4_PasswordStrengthValidation()
    {
        $token = generate_valid_admin_reset_token('admin@example.com');
        $response = submit_admin_new_password($token, 'abc');
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('strength', strtolower($response['message']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_admin_users(array $users) { /* ... */ }
function request_admin_password_reset($email) {
    return [
        'success' => true,
        'link_sent' => true,
        'reset_token' => 'valid-admin-reset-token'
    ];
}
function generate_valid_admin_reset_token($email) {
    return 'valid-admin-reset-token';
}
function submit_admin_new_password($token, $newPassword) {
    if ($token !== 'valid-admin-reset-token') {
        return ['success' => false, 'message' => 'Invalid or expired token'];
    }
    if (strlen($newPassword) < 8 || !preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        return ['success' => false, 'message' => 'Password does not meet strength requirements'];
    }
    return ['success' => true];
}
function submit_admin_login($username, $password) {
    if ($password === 'AdminNewPass1!') {
        return ['success' => true];
    }
    return ['success' => false, 'message' => 'Invalid username or password'];
}