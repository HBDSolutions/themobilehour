<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.1 – Quick to Get to Products (One Click)
 *
 * User Story:
 * As an application user
 * I want to access the products page quickly
 * So that I can view available products with minimal navigation
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.1.1 – Products Page is Accessible via One Click from Home
 * 6.1.2 – Products Button is Prominently Visible
 */
class Test_6_1_QuickToGetToProductsTest extends TestCase
{
    /**
     * 6.1.1 – Products Page is Accessible via One Click from Home
     * Given I am on the application’s home page
     * When I look for navigation or action buttons
     * Then there is a clearly labeled "Products" button or link
     * And clicking it takes me directly to the products page
     */
    public function test_6_1_1_ProductsOneClickFromHome()
    {
        // This test assumes you are using a browser automation library such as Laravel Dusk, Symfony Panther, or Codeception.
        // Here, we demonstrate with Panther (headless Chrome).
        // You may adapt to whichever UI testing library you use.

        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/'); // Change to your actual home URL

        // Check for a "Products" button or link
        $productsLink = $crawler->selectLink('Products');
        $this->assertGreaterThan(0, $productsLink->count(), 'There should be a "Products" button or link on the home page.');

        // Click the "Products" link
        $productsLink->link()->click();
        $client->waitFor('.products-list, #products-list, [data-testid="products-page"]', 5); // Wait for products page to load (adjust selector as needed)

        // Assert that we're on the products page (check URL or page content)
        $this->assertStringContainsString(
            '/products',
            $client->getCurrentURL(),
            'Clicking "Products" should navigate directly to the products page.'
        );
    }

    /**
     * 6.1.2 – Products Button is Prominently Visible
     * Given I am on the home page
     * When the page loads
     * Then the "Products" button or link is visible above the fold (no scrolling required)
     */
    public function test_6_1_2_ProductsButtonVisible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/'); // Change to your actual home URL

        // Find the "Products" button or link
        $productsLink = $crawler->selectLink('Products');
        $this->assertGreaterThan(0, $productsLink->count(), 'The "Products" button or link should be present.');

        $element = $productsLink->getElement(0);

        // Check if the element is displayed and within the viewport (above the fold)
        $isDisplayed = $client->executeScript("return arguments[0].offsetParent !== null;", [$element]);
        $rect = $client->executeScript("return arguments[0].getBoundingClientRect();", [$element]);
        // Assume 800px is the fold line (can be adjusted)
        $aboveTheFold = $rect['top'] >= 0 && $rect['top'] < 800;

        $this->assertTrue($isDisplayed, 'The "Products" button or link should be visible.');
        $this->assertTrue($aboveTheFold, 'The "Products" button or link should be above the fold (no scrolling required).');
    }
}