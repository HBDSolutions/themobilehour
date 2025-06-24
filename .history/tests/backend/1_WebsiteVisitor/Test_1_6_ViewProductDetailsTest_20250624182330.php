<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.6 – View Product Details
 *
 * User Story:
 * As a website visitor,
 * I need to view detailed information and images about a specific product,
 * So that I can make an informed decision prior to buying.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.6.1 – View Product Details Page
 * 1.6.2 – Image Zoom and Gallery Features
 * 1.6.3 – Handling Missing Product Details
 * 1.6.4 – Product Not Found
 */
class Test_1_6_ViewProductDetailsTest extends TestCase
{
    /*
    * 1.6.1 – View Product Details Page
    * Given a website visitor clicks on a product from the product list
    * When the product details page loads
    * Then
    * - The page displays the product’s name, description, price, and availability
    * - The page shows a gallery or carousel of all available product images
    * - The page displays key attributes (e.g., brand, dimensions, specifications)
    */
    public function test_1_6_1_ViewProductDetailsPage()
    {
        seed_products([
            [
                'id' => 1,
                'name' => 'iPhone 13',
                'description' => 'Latest Apple phone',
                'price' => 1000,
                'availability' => 'In Stock',
                'images' => ['img1.jpg', 'img2.jpg'],
                'brand' => 'Apple',
                'dimensions' => '146.7x71.5x7.7 mm',
                'specifications' => 'A15 Bionic, 5G'
            ]
        ]);
        $response = get_product_details_page(1);
        $this->assertStringContainsString('iPhone 13', $response);
        $this->assertStringContainsString('Latest Apple phone', $response);
        $this->assertStringContainsString('1000', $response);
        $this->assertStringContainsString('In Stock', $response);
        $this->assertStringContainsString('img1.jpg', $response);
        $this->assertStringContainsString('img2.jpg', $response);
        $this->assertStringContainsString('Apple', $response);
        $this->assertStringContainsString('146.7x71.5x7.7', $response);
        $this->assertStringContainsString('A15 Bionic', $response);
    }

    /*
    * 1.6.2 – Image Zoom and Gallery Features
    * Given the product details page displays images
    * When the visitor interacts with an image (e.g., clicks or hovers)
    * Then
    * - The image can be viewed in a larger format (e.g., lightbox or zoom)
    * - The visitor can browse through all available product images
    */
    public function test_1_6_2_ImageZoomAndGallery()
    {
        seed_products([
            [
                'id' => 1,
                'name' => 'iPhone 13',
                'images' => ['img1.jpg', 'img2.jpg'],
            ]
        ]);
        $response = get_product_details_page(1, ['interact_with_image' => true]);
        $this->assertStringContainsString('zoom', $response); // e.g. a zoomed image markup
        $this->assertStringContainsString('img2.jpg', $response); // Can browse gallery
    }

    /*
    * 1.6.3 – Handling Missing Product Details
    * Given a specific product is missing some details or images
    * When the details page loads
    * Then
    * - The page gracefully indicates missing information (e.g., “Image not available”)
    * - The layout and core information remain usable
    */
    public function test_1_6_3_HandlingMissingDetails()
    {
        seed_products([
            [
                'id' => 2,
                'name' => 'Mysterious Phone',
                // No description, price, or images
            ]
        ]);
        $response = get_product_details_page(2);
        $this->assertStringContainsString('Mysterious Phone', $response);
        $this->assertStringContainsString('not available', strtolower($response));
    }

    /*
    * 1.6.4 – Product Not Found
    * Given a website visitor tries to view a product that does not exist
    * When the details page loads
    * Then
    * - An appropriate “Product not found” message is displayed
    */
    public function test_1_6_4_ProductNotFound()
    {
        $response = get_product_details_page(999); // Non-existent product
        $this->assertStringContainsString('product not found', strtolower($response));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function seed_products(array $products) { /* ... */ }
function get_product_details_page($productId, array $params = []) { return ''; /* ... */ }