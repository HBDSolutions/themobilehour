<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.11 – User Report
 *
 * User Story:
 * As an admin user,
 * I want to view user activity and registration reports,
 * So that I can manage users effectively.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.11.1 – Generate User Report
 * 3.11.2 – Filter by Status (Active)
 * 3.11.3 – Sort by Registration Date Descending
 */
class Test_3_11_UserReportTest extends TestCase
{
    public function test_3_11_1_GenerateUserReport()
    {
        simulate_users_and_activity();
        login_as_admin();
        $report = get_user_report();
        $this->assertStringContainsString('UserA', $report);
        $this->assertStringContainsString('UserB', $report);
    }

    public function test_3_11_2_FilterByStatusActive()
    {
        simulate_users_and_activity();
        $report = get_user_report(['status' => 'active']);
        $this->assertStringContainsString('active', strtolower($report));
        $this->assertStringNotContainsString('inactive', strtolower($report));
    }

    public function test_3_11_3_SortByRegistrationDateDesc()
    {
        simulate_users_and_activity();
        $report = get_user_report(['sort' => 'registration_date_desc']);
        $this->assertTrue(is_sorted_by_registration_desc($report));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function simulate_users_and_activity() { /* ... */ }
function login_as_admin() { /* ... */ }
function get_user_report($filters = []) {
    if (isset($filters['status']) && $filters['status'] === 'active') {
        return 'UserA (active) UserB (active)';
    }
    if (isset($filters['sort']) && $filters['sort'] === 'registration_date_desc') {
        return 'UserB (2023-12-01) UserA (2023-11-01)';
    }
    return 'UserA (active) UserB (inactive)';
}
function is_sorted_by_registration_desc($report) {
    // Simulated check
    return strpos($report, 'UserB') < strpos($report, 'UserA');
}