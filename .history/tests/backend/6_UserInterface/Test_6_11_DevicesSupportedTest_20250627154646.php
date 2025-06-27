<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.11 – Devices Supported
 *
 * User Story:
 * As an application user
 * I want the site to work well on all major device types
 * So that I can access and use it from desktop, tablet, or mobile
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.11.1 – Application Renders Correctly on Desktop
 * 6.11.2 – Application Renders Correctly on Tablet
 * 6.11.3 – Application Renders Correctly on Mobile
 */
class Test_6_11_DevicesSupportedTest extends TestCase
{
    /**
     * 6.11.1 – Application Renders Correctly on Desktop
     * Given I open the site on a desktop device
     * When the page loads
     * Then the layout is optimized for large screens and all features are usable
     */
    public function test_6_11_1_RendersOnDesktop()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Typical desktop size
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(1440, 900));
        $crawler = $client->request('GET', 'http://localhost/');

        // Check for desktop navigation/menu visibility
        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), 'Navigation menu should be visible on desktop.');

        // Check main content area is present
        $main = $crawler->filter('main, .main-content, #content');
        $this->assertGreaterThan(0, $main->count(), 'Main content should be present on desktop.');

        // Example: check that hamburger menu is not visible
        $hamburger = $crawler->filter('.hamburger, .menu-toggle, .mobile-menu');
        $this->assertEquals(0, $hamburger->count(), 'Hamburger/mobile menu should not be visible on desktop.');

        // Optionally: check a feature e.g. product search
        $search = $crawler->filter('input[type="search"], input[name="search"], #search');
        $this->assertGreaterThan(0, $search->count(), 'Product search should be accessible on desktop.');
    }

    /**
     * 6.11.2 – Application Renders Correctly on Tablet
     * Given I open the site on a tablet device
     * When the page loads
     * Then the layout adapts to medium-sized screens and navigation/features remain accessible
     */
    public function test_6_11_2_RendersOnTablet()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // iPad size
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(768, 1024));
        $crawler = $client->request('GET', 'http://localhost/');

        // Navigation/menu should still be accessible
        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), 'Navigation menu should be visible on tablet.');

        // Main content area
        $main = $crawler->filter('main, .main-content, #content');
        $this->assertGreaterThan(0, $main->count(), 'Main content should be present on tablet.');

        // Hamburger menu may be present or not, but navigation must be accessible
        $navVisible = $client->executeScript("return window.getComputedStyle(arguments[0]).display !== 'none';", [$nav->getElement(0)]);
        $this->assertTrue($navVisible, 'Navigation should be accessible on tablet.');

        // Example: check a feature e.g. product search
        $search = $crawler->filter('input[type="search"], input[name="search"], #search');
        $this->assertGreaterThan(0, $search->count(), 'Product search should be accessible on tablet.');
    }

    /**
     * 6.11.3 – Application Renders Correctly on Mobile
     * Given I open the site on a mobile device
     * When the page loads
     * Then the layout is optimized for small screens, navigation is easy, and all key features are accessible
     */
    public function test_6_11_3_RendersOnMobile()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Typical mobile size
        $client->manage()->window()->setSize(new \Facebook\WebDriver\WebDriverDimension(375, 667));
        $crawler = $client->request('GET', 'http://localhost/');

        // Hamburger/mobile menu should be visible
        $hamburger = $crawler->filter('.hamburger, .menu-toggle, .mobile-menu');
        $this->assertGreaterThan(0, $hamburger->count(), 'Hamburger or mobile menu should be visible on mobile.');

        // Navigation must still be accessible (may require opening hamburger)
        if ($hamburger->count() > 0) {
            $hamburger->first()->click();
            usleep(200000);
        }
        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), 'Navigation menu should be accessible on mobile.');

        // Main content area
        $main = $crawler->filter('main, .main-content, #content');
        $this->assertGreaterThan(0, $main->count(), 'Main content should be present on mobile.');

        // Example: product search should be accessible
        $search = $crawler->filter('input[type="search"], input[name="search"], #search');
        $this->assertGreaterThan(0, $search->count(), 'Product search should be accessible on mobile.');
    }
}