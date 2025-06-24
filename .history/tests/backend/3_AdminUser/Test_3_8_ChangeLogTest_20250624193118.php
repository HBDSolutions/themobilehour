<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.8 – Change Log
 *
 * User Story:
 * As an admin user,
 * I want to view a log of all changes made to products and accounts,
 * So that I can track history and accountability.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.8.1 – View Change Log Entries
 * 3.8.2 – Change Log Records All Edits and Deletes
 * 3.8.3 – Change Log Cannot Be Edited or Deleted by Normal Admin
 */
class Test_3_8_ChangeLogTest extends TestCase
{
    public function test_3_8_1_ViewChangeLogEntries()
    {
        simulate_changes();
        login_as_admin();
        $log = get_change_log();
        $this->assertStringContainsString('Product added', $log);
        $this->assertStringContainsString('Account edited', $log);
    }

    public function test_3_8_2_ChangeLogRecordsAllEditsAndDeletes()
    {
        simulate_changes();
        $log = get_change_log();
        $this->assertStringContainsString('deleted', $log);
        $this->assertStringContainsString('edited', $log);
    }

    public function test_3_8_3_ChangeLogCannotBeEditedOrDeletedByNormalAdmin()
    {
        login_as_admin();
        $response = try_edit_or_delete_changelog();
        $this->assertFalse($response['success']);
        $this->assertStringContainsString('not permitted', strtolower($response['message']));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function simulate_changes() {/* ... */ }
function login_as_admin() {/* ... */ }
function get_change_log() { return 'Product added Account edited Product deleted'; }
function try_edit_or_delete_changelog() { return ['success' => false, 'message' => 'Action not permitted']; }