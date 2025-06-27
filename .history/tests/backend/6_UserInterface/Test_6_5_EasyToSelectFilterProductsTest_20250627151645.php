<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.5 – Easy to Select/Filter Products
 *
 * User Story:
 * As an application user
 * I want to easily select or filter products based on my preferences
 * So that I can quickly find items that meet my needs
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.5.1 – Filters Are Clearly Visible and Accessible
 * 6.5.2 – Selecting a Filter Updates Product List
 * 6.5.3 – Multiple Filters Can Be Combined
 * 6.5.4 – Filters Can Be Cleared Easily
 */
class Test_6_5_EasyToSelectFilterProductsTest extends TestCase
{
    /**
     * 6.5.1 – Filters Are Clearly Visible and Accessible
     * Given I am on the products/search page
     * When the page loads
     * Then filtering options (e.g., by category, price, brand) are clearly visible and accessible without extra clicks
     */
    public function test_6_5_1_FiltersVisible()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products'); // Adjust URL as needed

        // Look for filter elements (checkboxes, dropdowns, etc.)
        $filters = $crawler->filter('.filters, .product-filters, #filters, [data-testid="filters"]');
        $this->assertGreaterThan(0, $filters->count(), 'Filtering options should be visible on the products page.');

        // Check for some common filter controls (category, price, brand)
        $hasCategory = $crawler->filter('select[name*="category"], input[name*="category"]')->count() > 0;
        $hasPrice = $crawler->filter('select[name*="price"], input[name*="price"]')->count() > 0;
        $hasBrand = $crawler->filter('select[name*="brand"], input[name*="brand"]')->count() > 0;

        $this->assertTrue($hasCategory || $hasPrice || $hasBrand, 'At least one common filter (category, price, brand) should be present.');
    }

    /**
     * 6.5.2 – Selecting a Filter Updates Product List
     * Given I am viewing the products page
     * When I select or change a filter
     * Then the product list updates to show only items matching the selected filters
     */
    public function test_6_5_2_FilterUpdatesList()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products');

        // Find a category filter (adjust selector for your UI)
        $categoryFilter = $crawler->filter('select[name*="category"], input[name*="category"]');
        $this->assertGreaterThan(0, $categoryFilter->count(), 'A category filter should be present.');

        // Remember initial product count
        $productsBefore = $crawler->filter('.product, .product-item')->count();

        // Select a filter value (for select or checkbox)
        if ($categoryFilter->nodeName() === 'select') {
            $options = $categoryFilter->children('option');
            $this->assertGreaterThan(1, $options->count(), 'Category select should have more than one option.');
            $value = $options->eq(1)->attr('value');
            $categoryFilter->selectOption($value);
        } else {
            // For checkbox/radio, check the first unchecked
            foreach ($categoryFilter as $filterInput) {
                if (!$filterInput->isChecked()) {
                    $filterInput->click();
                    break;
                }
            }
        }

        // Wait for AJAX/filter update
        $client->waitFor('.product, .product-item', 5);

        // Check that product list changed
        $productsAfter = $client->getCrawler()->filter('.product, .product-item')->count();
        $this->assertNotEquals($productsBefore, $productsAfter, 'Product list should update after setting a filter.');
    }

    /**
     * 6.5.3 – Multiple Filters Can Be Combined
     * Given I have applied one filter
     * When I apply additional filters
     * Then the product list updates to match all selected criteria
     */
    public function test_6_5_3_CombinedFilters()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products');

        // Apply first filter (category)
        $categoryFilter = $crawler->filter('select[name*="category"], input[name*="category"]');
        $this->assertGreaterThan(0, $categoryFilter->count(), 'Category filter should be present.');
        if ($categoryFilter->nodeName() === 'select') {
            $options = $categoryFilter->children('option');
            $value = $options->eq(1)->attr('value');
            $categoryFilter->selectOption($value);
        } else {
            foreach ($categoryFilter as $filterInput) {
                if (!$filterInput->isChecked()) {
                    $filterInput->click();
                    break;
                }
            }
        }
        $client->waitFor('.product, .product-item', 5);
        $productsAfterFirst = $client->getCrawler()->filter('.product, .product-item')->count();

        // Apply second filter (brand)
        $brandFilter = $client->getCrawler()->filter('select[name*="brand"], input[name*="brand"]');
        if ($brandFilter->count() > 0) {
            if ($brandFilter->nodeName() === 'select') {
                $options = $brandFilter->children('option');
                $value = $options->eq(1)->attr('value');
                $brandFilter->selectOption($value);
            } else {
                foreach ($brandFilter as $filterInput) {
                    if (!$filterInput->isChecked()) {
                        $filterInput->click();
                        break;
                    }
                }
            }
            $client->waitFor('.product, .product-item', 5);
            $productsAfterSecond = $client->getCrawler()->filter('.product, .product-item')->count();

            $this->assertNotEquals($productsAfterFirst, $productsAfterSecond, 'Product list should update after combining filters.');
        } else {
            $this->markTestSkipped('Brand filter not present, cannot test combined filters.');
        }
    }

    /**
     * 6.5.4 – Filters Can Be Cleared Easily
     * Given I have selected one or more filters
     * When I want to reset the filters
     * Then I can easily clear all filters and return to the full product list
     */
    public function test_6_5_4_ClearFilters()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products');

        // Apply a filter first
        $categoryFilter = $crawler->filter('select[name*="category"], input[name*="category"]');
        if ($categoryFilter->count() > 0) {
            if ($categoryFilter->nodeName() === 'select') {
                $options = $categoryFilter->children('option');
                $value = $options->eq(1)->attr('value');
                $categoryFilter->selectOption($value);
            } else {
                foreach ($categoryFilter as $filterInput) {
                    if (!$filterInput->isChecked()) {
                        $filterInput->click();
                        break;
                    }
                }
            }
            $client->waitFor('.product, .product-item', 5);
        }

        // Click "Clear" or "Reset" filters button
        $clearButton = $client->getCrawler()->selectButton('Clear')->first();
        if ($clearButton->count() === 0) {
            $clearButton = $client->getCrawler()->selectButton('Reset')->first();
        }
        $this->assertGreaterThan(0, $clearButton->count(), 'A "Clear" or "Reset" filters button should be present.');
        $clearButton->click();

        // Wait for reset
        $client->waitFor('.product, .product-item', 5);

        // Assert that all items are shown again (product count increased or matches unfiltered count)
        $productsAfterClear = $client->getCrawler()->filter('.product, .product-item')->count();
        $this->assertGreaterThan(0, $productsAfterClear, 'Product list should be restored after clearing filters.');
    }
}