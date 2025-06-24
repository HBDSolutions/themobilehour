<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.8 – High Availability of Website
 *
 * User Story:
 * As a website visitor,
 * I need high availability of the website to users,
 * So that I experience smooth access as traffic and usage.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.8.1 – Website is Accessible During Peak Traffic
 * 1.8.2 – Automatic Failover and Redundancy
 * 1.8.3 – Monitoring and Alerting for Downtime
 * 1.8.4 – Status Page Availability
 */
class Test_1_8_HighAvailabilityTest extends TestCase
{
    /*
    * 1.8.1 – Website is Accessible During Peak Traffic
    * Given a high number of users simultaneously access the website
    * When peak traffic occurs
    * Then
    * - The website remains accessible without significant delays
    * - No server errors (e.g., 503 Service Unavailable) are encountered
    */
    public function test_1_8_1_AccessibleDuringPeakTraffic()
    {
        simulate_users(1000);
        $response = get_site_status();
        $this->assertStringNotContainsString('503', $response);
        $this->assertLessThan(2.0, get_page_load_time()); // Page loads in under 2 seconds
    }

    /*
    * 1.8.2 – Automatic Failover and Redundancy
    * Given a failure of a primary server or component
    * When an outage or hardware failure occurs
    * Then
    * - The website automatically redirects traffic to backup or redundant systems
    * - Users experience minimal or no service interruption
    */
    public function test_1_8_2_AutomaticFailover()
    {
        simulate_primary_server_failure();
        $response = get_site_status();
        $this->assertStringContainsString('backup', $response); // Redirected to backup
        $this->assertTrue(is_site_accessible());
    }

    /*
    * 1.8.3 – Monitoring and Alerting for Downtime
    * Given a monitoring system is in place
    * When the website becomes unavailable or response times degrade
    * Then
    * - The support/engineering team is alerted immediately
    * - Uptime and downtime incidents are logged for review
    */
    public function test_1_8_3_MonitoringAndAlerting()
    {
        trigger_downtime();
        $this->assertTrue(was_alert_sent());
        $this->assertTrue(was_incident_logged());
    }

    /*
    * 1.8.4 – Status Page Availability
    * Given there is an ongoing outage or major incident
    * When users attempt to access the website
    * Then
    * - A status page or notification is presented with up-to-date information
    */
    public function test_1_8_4_StatusPageAvailability()
    {
        simulate_outage();
        $response = get_site_status_page();
        $this->assertStringContainsString('status', strtolower($response));
        $this->assertStringContainsString('incident', strtolower($response));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function simulate_users($count) { /* ... */ }
function get_site_status() { return ''; /* ... */ }
function get_page_load_time() { return 1.5; /* ... */ }
function simulate_primary_server_failure() { /* ... */ }
function is_site_accessible() { return true; }
function trigger_downtime() { /* ... */ }
function was_alert_sent() { return true; }
function was_incident_logged() { return true; }
function simulate_outage() { /* ... */ }
function get_site_status_page() { return 'Status: incident ongoing'; }