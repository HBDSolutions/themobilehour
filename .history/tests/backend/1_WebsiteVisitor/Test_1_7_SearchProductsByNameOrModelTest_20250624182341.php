<?php

/**
 * Test 1.7 – Search Products By Name Or Model
 *
 * See acceptance criteria and scenarios:
 * @see https://github.com/HBDSolutions/themobilehour/blob/main/tests/backend/1_WebsiteVisitor/Test_1_7_SearchProductsByNameOrModelTest.md
 */

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

class Test_1_7_SearchProductsByNameOrModelTest extends TestCase
{
    /**
     * 1.7.1 – Search Input Exists
     * Given a visitor is on the browse page
     * When the page loads
     * Then a search input box appears
     */
    public function test_1_7_1_SearchInputExists()
    {
        // Arrange/Act
        $response = get_products_browse_page();

        // Assert
        $this->assertStringContainsString('search', $response);
        $this->assertStringContainsString('type="text"', $response);
    }

    /**
     * 1.7.2 – Search By Name
     * Given a visitor enters a product name and searches
     * When results are shown
     * Then only products matching the name are listed
     */
    public function test_1_7_2_SearchByName()
    {
        // Arrange
        seed_products([
            ['name' => 'Pixel 8', 'model' => 'P8'],
            ['name' => 'iPhone 15', 'model' => 'IP15'],
        ]);

        // Act
        $response = get_products_browse_page(['search' => 'Pixel']);

        // Assert
        $this->assertStringContainsString('Pixel 8', $response);
        $this->assertStringNotContainsString('iPhone 15', $response);
    }

    /**
     * 1.7.3 – Search By Model Number
     * Given a visitor enters a model number and searches
     * When results are shown
     * Then only products matching the model number are listed
     */
    public function test_1_7_3_SearchByModelNumber()
    {
        // Arrange
        seed_products([
            ['name' => 'Galaxy S21', 'model' => 'SM-G991B'],
            ['name' => 'Nokia 3310', 'model' => 'N3310'],
        ]);

        // Act
        $response = get_products_browse_page(['search' => 'SM-G991B']);

        // Assert
        $this->assertStringContainsString('Galaxy S21', $response);
        $this->assertStringNotContainsString('Nokia 3310', $response);
    }

    /**
     * 1.7.4 – No Results Message
     * Given a visitor searches for a name/model with no results
     * Then a no results message is shown
     */
    public function test_1_7_4_NoResultsMessage()
    {
        // Arrange
        seed_products([
            ['name' => 'Redmi Note', 'model' => 'RN10'],
        ]);

        // Act
        $response = get_products_browse_page(['search' => 'NotAProduct']);

        // Assert
        $this->assertStringContainsString('No products found', $response);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function get_products_browse_page(array $params = []) { return ''; /* ... */ }