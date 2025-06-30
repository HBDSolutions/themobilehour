<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.6 – Ability to Explore Product Detail
 *
 * User Story:
 * As an application user
 * I want to view detailed information about a product
 * So that I can make informed purchasing decisions
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.6.1 – Product Details Page is Accessible from Product List
 * 6.6.2 – Product Details Page Shows Complete Information
 * 6.6.3 – Product Details Page is Well-Organized and Easy to Navigate
 */
class Test_6_6_ExploreProductDetailTest extends TestCase
{
    /**
     * 6.6.1 – Product Details Page is Accessible from Product List
     * Given I am viewing a list of products
     * When I select or click on a product
     * Then I am taken to a product details page
     */
    public function test_6_6_1_AccessProductDetailsPage()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products'); // Change as needed

        // Find the first product link in the list
        $productLink = $crawler->filter('.product a, .product-item a, .product-title a')->first();
        $this->assertGreaterThan(0, $productLink->count(), 'There should be a clickable product link in the list.');
        $productLink->click();

        // Wait for product details page to load
        $client->waitFor('.product-details, #product-details, .product-page', 5);

        // Assert we are on a details page
        $details = $client->getCrawler()->filter('.product-details, #product-details, .product-page');
        $this->assertGreaterThan(0, $details->count(), 'Should be on the product details page after clicking a product.');
    }

    /**
     * 6.6.2 – Product Details Page Shows Complete Information
     * Given I am on a product details page
     * When the page loads
     * Then I can see all relevant information (e.g., name, images, description, price, specifications, reviews)
     */
    public function test_6_6_2_ProductDetailsComplete()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Go directly to a product details page for test
        $crawler = $client->request('GET', 'http://localhost/products/1'); // Adjust as needed

        $details = $crawler->filter('.product-details, #product-details, .product-page');
        $this->assertGreaterThan(0, $details->count(), 'Product details page should be present.');

        // Check for key elements
        $this->assertGreaterThan(0, $details->filter('.product-title, h1, .title')->count(), 'Product title should be visible.');
        $this->assertGreaterThan(0, $details->filter('.product-image img, .product-gallery img, img')->count(), 'Product image(s) should be visible.');
        $this->assertGreaterThan(0, $details->filter('.product-description, .description')->count(), 'Product description should be visible.');
        $this->assertGreaterThan(0, $details->filter('.product-price, .price')->count(), 'Product price should be visible.');
        // Optional: specifications and reviews
        $this->assertGreaterThan(0, $details->filter('.product-specs, .specifications, .product-tabs .specs, .tab-specs')->count() +
                                       $details->filter('.reviews, .product-reviews, .tab-reviews')->count(),
            'Specifications and/or reviews section should be present.');
    }

    /**
     * 6.6.3 – Product Details Page is Well-Organized and Easy to Navigate
     * Given I am on a product details page
     * When I interact with the page
     * Then information is organized with clear sections/tabs and is easy to find
     */
    public function test_6_6_3_ProductDetailsWellOrganized()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products/1'); // Adjust as needed

        $details = $crawler->filter('.product-details, #product-details, .product-page');
        $this->assertGreaterThan(0, $details->count(), 'Product details page should be present.');

        // Check for tabs or section navigation
        $tabs = $crawler->filter('.tabs, .product-tabs, .nav-tabs, .section-tabs');
        $sections = $crawler->filter('.section, .product-section, .tab-pane, [role="tabpanel"]');

        $this->assertTrue(
            $tabs->count() > 0 || $sections->count() > 1,
            'There should be clear sections or tabs for product details organization.'
        );

        // Optionally, interact with tabs/sections
        if ($tabs->count() > 0) {
            $firstTab = $tabs->filter('button, a')->first();
            if ($firstTab->count() > 0) {
                $firstTab->click();
                // Wait for tab content to show
                $client->waitFor('.tab-pane.active, .tab-content .active, [role="tabpanel"]:not([hidden])', 2);
                $activeTab = $crawler->filter('.tab-pane.active, .tab-content .active, [role="tabpanel"]:not([hidden])');
                $this->assertGreaterThan(0, $activeTab->count(), 'Clicking a tab should show its content.');
            }
        }
    }
}