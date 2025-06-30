<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.12 – Browser Compatibility
 *
 * User Story:
 * As an application user
 * I want the site to function correctly in all major web browsers
 * So that I can use it regardless of my browser choice
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.12.1 – Application Works in Latest Chrome
 * 6.12.2 – Application Works in Latest Firefox
 * 6.12.3 – Application Works in Latest Safari
 * 6.12.4 – Application Works in Latest Microsoft Edge
 */
class Test_6_12_BrowserCompatibilityTest extends TestCase
{
    /**
     * 6.12.1 – Application Works in Latest Chrome
     */
    public function test_6_12_1_WorksInChrome()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $this->assertSiteWorksAsExpected($client, 'Chrome');
    }

    /**
     * 6.12.2 – Application Works in Latest Firefox
     */
    public function test_6_12_2_WorksInFirefox()
    {
        $client = \Symfony\Component\Panther\Client::createFirefoxClient();
        $this->assertSiteWorksAsExpected($client, 'Firefox');
    }

    /**
     * 6.12.3 – Application Works in Latest Safari
     * Note: Panther does not support Safari; this serves as a placeholder for manual or external integration.
     */
    public function test_6_12_3_WorksInSafari()
    {
        $this->markTestSkipped('Automated Safari testing is not supported in Panther. Run this test with a tool like BrowserStack or manually.');
    }

    /**
     * 6.12.4 – Application Works in Latest Microsoft Edge
     * Note: Edge can be tested using the Chrome driver in Panther, as Edge is Chromium-based.
     */
    public function test_6_12_4_WorksInEdge()
    {
        // If you have Edge WebDriver, you can use createChromeClient() with the Edge binary.
        // For most environments, test with Chrome as a proxy for Edge.
        $client = \Symfony\Component\Panther\Client::createChromeClient(); // Or configure Edge binary here
        $this->assertSiteWorksAsExpected($client, 'Edge');
    }

    /**
     * Helper to test basic site features and layout in a given browser client.
     */
    private function assertSiteWorksAsExpected($client, $browserName)
    {
        $crawler = $client->request('GET', 'http://localhost/');

        // Navigation/menu present
        $nav = $crawler->filter('nav, .main-menu, .navbar');
        $this->assertGreaterThan(0, $nav->count(), "Navigation menu should be visible in $browserName.");

        // Main content area
        $main = $crawler->filter('main, .main-content, #content');
        $this->assertGreaterThan(0, $main->count(), "Main content should be present in $browserName.");

        // Product search presence
        $search = $crawler->filter('input[type="search"], input[name="search"], #search');
        $this->assertGreaterThan(0, $search->count(), "Product search should be accessible in $browserName.");

        // Add more feature checks as required for your application:
        // - Can click navigation links
        $link = $crawler->selectLink('Products');
        $this->assertGreaterThan(0, $link->count(), "Products link should be present in $browserName.");
        $link->click();
        $client->waitFor('.product-list, .products, #product-list', 5);
        $products = $client->getCrawler()->filter('.product, .product-item');
        $this->assertGreaterThan(0, $products->count(), "Product list should be visible in $browserName.");

        // - Responsive check: viewport width
        $width = $client->executeScript('return window.innerWidth;');
        $this->assertGreaterThan(0, $width, "$browserName viewport should be set.");

        // - No visible JS errors on load (basic check)
        $logs = $client->manage()->getLog('browser');
        $jsErrors = array_filter($logs, function ($entry) {
            return $entry['level'] === 'SEVERE';
        });
        $this->assertCount(0, $jsErrors, "There should be no severe JS errors in console on $browserName: " . json_encode($jsErrors));
    }
}