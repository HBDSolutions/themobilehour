<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.9 – Optimise Website Speed
 *
 * User Story:
 * As a website visitor,
 * I need to optimise speed of the website for all users,
 * So that I experience minimal page and data load times.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.9.1 – Fast Page Load Under Normal Conditions
 * 1.9.2 – Optimised Resource Delivery
 * 1.9.3 – Performance Under Heavy Load
 * 1.9.4 – Ongoing Performance Monitoring
 */
class Test_1_9_OptimiseWebsiteSpeedTest extends TestCase
{
    /*
    * 1.9.1 – Fast Page Load Under Normal Conditions
    * Given a website visitor accesses any page
    * When the page loads under normal network and server conditions
    * Then
    * - The page loads within an acceptable time threshold (e.g., under 2 seconds)
    * - All critical resources (HTML, CSS, JS, images) load promptly
    */
    public function test_1_9_1_FastPageLoad()
    {
        simulate_normal_conditions();
        $loadTime = get_page_load_time();
        $this->assertLessThan(2.0, $loadTime);
        $resources = get_critical_resources_loaded();
        $this->assertContains('HTML', $resources);
        $this->assertContains('CSS', $resources);
        $this->assertContains('JS', $resources);
        $this->assertContains('images', $resources);
    }

    /*
    * 1.9.2 – Optimised Resource Delivery
    * Given the website delivers resources to users
    * When a user loads a page
    * Then
    * - Resources are minified and compressed
    * - Images are delivered in optimised formats and sizes
    * - Unused scripts and CSS are not loaded
    */
    public function test_1_9_2_OptimisedResourceDelivery()
    {
        $resources = get_delivered_resources();
        foreach ($resources as $resource) {
            $this->assertTrue($resource['minified']);
            $this->assertTrue($resource['compressed']);
        }
        $images = get_loaded_images();
        foreach ($images as $img) {
            $this->assertTrue($img['optimised']);
        }
        $this->assertFalse(are_unused_scripts_loaded());
        $this->assertFalse(are_unused_css_loaded());
    }

    /*
    * 1.9.3 – Performance Under Heavy Load
    * Given the website experiences high user traffic
    * When pages are accessed
    * Then
    * - Most users continue to experience acceptable load times
    * - Performance degradation is minimal and does not result in timeouts
    */
    public function test_1_9_3_PerformanceUnderHeavyLoad()
    {
        simulate_heavy_traffic();
        $loadTimes = get_multiple_page_load_times(100);
        $acceptable = array_filter($loadTimes, function($t) { return $t < 2.5; });
        $this->assertGreaterThanOrEqual(90, count($acceptable)); // At least 90% under 2.5s
        $this->assertFalse(any_timeouts_occurred());
    }

    /*
    * 1.9.4 – Ongoing Performance Monitoring
    * Given the website is live
    * When performance metrics fall below defined thresholds
    * Then
    * - Alerts are generated for the support/engineering team
    * - Performance incidents are logged for review
    */
    public function test_1_9_4_OngoingPerformanceMonitoring()
    {
        simulate_performance_drop();
        $this->assertTrue(performance_alert_generated());
        $this->assertTrue(performance_incident_logged());
    }
}

// ---
// Stub helper functions for illustration purposes only:
function simulate_normal_conditions() { /* ... */ }
function get_page_load_time() { return 1.5; /* ... */ }
function get_critical_resources_loaded() { return ['HTML', 'CSS', 'JS', 'images']; }
function get_delivered_resources() { return [['minified'=>true,'compressed'=>true]]; }
function get_loaded_images() { return [['optimised'=>true]]; }
function are_unused_scripts_loaded() { return false; }
function are_unused_css_loaded() { return false; }
function simulate_heavy_traffic() { /* ... */ }
function get_multiple_page_load_times($n) { return array_fill(0, $n, 2.0); }
function any_timeouts_occurred() { return false; }
function simulate_performance_drop() { /* ... */ }
function performance_alert_generated() { return true; }
function performance_incident_logged() { return true; }