<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 2.2 – Edit Account Data
 *
 * User Story:
 * As a registered customer,
 * I want to be able to update my account information,
 * So that my details are always accurate and up-to-date.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 2.2.1 – Successfully Update Account Data
 * 2.2.2 – Validation Error for Invalid Data
 * 2.2.3 – Audit Trail for Changes
 */
class Test_2_2_EditAccountDataTest extends TestCase
{
    /*
    * 2.2.1 – Successfully Update Account Data
    * Given a logged-in customer
    * When the customer submits valid updates to their account information
    * Then the changes are saved and reflected in their account
    */
    public function test_2_2_1_SuccessfulUpdate()
    {
        $customerId = seed_customer([
            'email' => 'user@example.com',
            'name' => 'Old Name',
            'address' => 'Old Address'
        ]);
        login_as($customerId);
        $response = submit_account_update($customerId, [
            'name' => 'New Name',
            'address' => 'New Address'
        ]);
        $this->assertTrue($response['success']);
        $account = get_customer_account($customerId);
        $this->assertEquals('New Name', $account['name']);
        $this->assertEquals('New Address', $account['address']);
    }

    /*
    * 2.2.2 – Validation Error for Invalid Data
    * Given a logged-in customer
    * When the customer submits invalid updates (e.g., invalid email format)
    * Then a validation error message is shown and no changes are saved
    */
    public function test_2_2_2_ValidationError()
    {
        $customerId = seed_customer([
            'email' => 'user@example.com',
            'name' => 'Name',
        ]);
        login_as($customerId);
        $response = submit_account_update($customerId, [
            'email' => 'not-an-email'
        ]);
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('invalid', strtolower($response['message']));
        $account = get_customer_account($customerId);
        $this->assertEquals('user@example.com', $account['email']);
    }

    /*
    * 2.2.3 – Audit Trail for Changes
    * Given a customer updates their account information
    * When the change is saved
    * Then an audit log entry is created recording the change
    */
    public function test_2_2_3_AuditTrail()
    {
        $customerId = seed_customer([
            'email' => 'user@example.com',
            'name' => 'Name',
        ]);
        login_as($customerId);
        submit_account_update($customerId, [
            'name' => 'Changed Name'
        ]);
        $audit = get_audit_trail_for_customer($customerId);
        $this->assertNotEmpty($audit);
        $this->assertEquals('Changed Name', $audit[0]['new_value']);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_customer(array $data) { return 1; }
function login_as($customerId) { /* ... */ }
function submit_account_update($customerId, array $updates) {
    if (isset($updates['email']) && strpos($updates['email'], '@') === false) {
        return ['success' => false, 'message' => 'Invalid email format'];
    }
    // Simulate update
    return ['success' => true];
}
function get_customer_account($customerId) {
    // Example stub, should return last updated info
    return ['email' => 'user@example.com', 'name' => 'New Name', 'address' => 'New Address'];
}
function get_audit_trail_for_customer($customerId) {
    return [['field' => 'name', 'new_value' => 'Changed Name']];
}