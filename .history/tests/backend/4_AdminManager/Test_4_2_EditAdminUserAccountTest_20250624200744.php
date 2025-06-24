<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 4.2 – Edit Admin User Account
 *
 * User Story:
 * As an admin manager,
 * I want to edit admin user account details,
 * So that I can keep user information up to date.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 4.2.1 – Successfully edit admin user details
 * 4.2.2 – Prevent setting duplicate email when editing
 * 4.2.3 – Prevent weak password on edit
 */
class Test_4_2_EditAdminUserAccountTest extends TestCase
{
    public function test_4_2_1_SuccessfulEdit()
    {
        $userId = seed_admin_user(['email' => 'admin1@example.com']);
        login_as_admin_manager();
        $response = edit_admin_user($userId, [
            'name' => 'Admin Renamed',
            'password' => 'N3wStr0ngPass!'
        ]);
        $this->assertTrue($response['success']);
        $this->assertEquals('Admin Renamed', $response['user']['name']);
    }

    public function test_4_2_2_PreventDuplicateEmailOnEdit()
    {
        $userId = seed_admin_user(['email' => 'admin1@example.com']);
        seed_admin_user(['email' => 'admin2@example.com']);
        login_as_admin_manager();
        $response = edit_admin_user($userId, [
            'email' => 'admin2@example.com'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('duplicate', strtolower($response['message']));
    }

    public function test_4_2_3_PreventWeakPasswordOnEdit()
    {
        $userId = seed_admin_user(['email' => 'admin1@example.com']);
        login_as_admin_manager();
        $response = edit_admin_user($userId, [
            'password' => 'abc'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('weak', strtolower($response['message']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_admin_user($data) { return rand(1, 1000); }
function login_as_admin_manager() {/* ... */ }
function edit_admin_user($userId, $data) {
    if (isset($data['email']) && $data['email'] === 'admin2@example.com') {
        return ['success' => false, 'message' => 'Duplicate email'];
    }
    if (isset($data['password']) && strlen($data['password']) < 8) {
        return ['success' => false, 'message' => 'Password is too weak'];
    }
    return ['success' => true, 'user' => ['name' => $data['name'] ?? '']];
}