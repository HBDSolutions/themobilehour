<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 6.4 – Logical Flow: Home > Product Search > Product Details > Add to Cart > Checkout
 *
 * User Story:
 * As an application user
 * I want a logical, intuitive flow from browsing to purchasing products
 * So that I can easily find, select, and buy products online
 *
 * Acceptance Criteria / BDD Scenarios:
 * 6.4.1 – User Can Navigate from Home to Product Search
 * 6.4.2 – User Can View Selected Product Details
 * 6.4.3 – User Can Add Product to Cart from Details Page
 * 6.4.4 – User Can Proceed to Checkout from Cart
 * 6.4.5 – User Can Complete Purchase from Checkout
 */
class Test_6_4_LogicalFlowTest extends TestCase
{
    /**
     * 6.4.1 – User Can Navigate from Home to Product Search
     * Given I am on the home page
     * When I use the product search or filter options
     * Then I am shown a list of products matching my search or filters
     */
    public function test_6_4_1_NavigateHomeToProductSearch()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/'); // Change to your home page

        // Fill the search box and submit
        $searchBox = $crawler->filter('input[type="search"], input[name="search"], #search');
        $this->assertGreaterThan(0, $searchBox->count(), 'Search box should be present on home page.');
        $searchBox->first()->sendKeys('test product');

        // Submit search (try form submit or button click)
        $searchForm = $searchBox->parents()->filter('form');
        if ($searchForm->count() > 0) {
            $searchForm->form()->submit();
        } else {
            $searchButton = $crawler->selectButton('Search');
            if ($searchButton->count() > 0) {
                $searchButton->click();
            }
        }

        // Wait for products list to appear
        $client->waitFor('.product-list, #product-list, .products', 5);

        // Assert that products are shown
        $products = $client->getCrawler()->filter('.product-list .product, #product-list .product, .products .product, .product-item');
        $this->assertGreaterThan(0, $products->count(), 'A list of products should be displayed after search.');
    }

    /**
     * 6.4.2 – User Can View Selected Product Details
     * Given I am viewing the search results
     * When I select a product
     * Then I am taken to a product details page with relevant information
     */
    public function test_6_4_2_ViewSelectedProductDetails()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/products?search=test+product'); // Or whatever your products URL is

        $productLink = $crawler->filter('.product a, .product-item a, .product-title a')->first();
        $this->assertGreaterThan(0, $productLink->count(), 'At least one product should have a clickable details link.');
        $productLink->click();

        $client->waitFor('.product-details, #product-details, .product-page', 5);

        // Check for typical product details fields
        $details = $client->getCrawler()->filter('.product-details, #product-details, .product-page');
        $this->assertGreaterThan(0, $details->count(), 'Product details page should be displayed.');
        $this->assertGreaterThan(0, $details->filter('.product-title, h1, .title')->count(), 'Product title should be visible on details page.');
    }

    /**
     * 6.4.3 – User Can Add Product to Cart from Details Page
     * Given I am on a product details page
     * When I click "Add to Cart"
     * Then the selected product is added to my shopping cart
     */
    public function test_6_4_3_AddProductToCart()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Go directly to a known product details URL for test
        $crawler = $client->request('GET', 'http://localhost/products/1'); // Replace with a real product URL or use dynamic from previous test

        $addToCart = $crawler->selectButton('Add to Cart');
        $this->assertGreaterThan(0, $addToCart->count(), 'Add to Cart button should be present.');
        $addToCart->click();

        // Wait for cart update (some apps show a message, others update cart count)
        $client->waitFor('.cart-count, .cart-badge, .cart-dialog, .alert-success', 5);

        // Assert cart has at least one item (look for cart count/badge or cart dialog)
        $cartCount = $client->getCrawler()->filter('.cart-count, .cart-badge');
        if ($cartCount->count() > 0) {
            $count = (int) preg_replace('/\D/', '', $cartCount->text());
            $this->assertGreaterThan(0, $count, 'Cart count should be incremented after adding product.');
        } else {
            $cartDialog = $client->getCrawler()->filter('.cart-dialog, .alert-success');
            $this->assertGreaterThan(0, $cartDialog->count(), 'Some confirmation should be visible after adding product to cart.');
        }
    }

    /**
     * 6.4.4 – User Can Proceed to Checkout from Cart
     * Given I have added products to my cart
     * When I view the cart and click "Checkout"
     * Then I am taken to the checkout page to enter payment and shipping details
     */
    public function test_6_4_4_ProceedToCheckout()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        // Go to cart page
        $crawler = $client->request('GET', 'http://localhost/cart'); // Change as needed

        $checkoutButton = $crawler->selectButton('Checkout');
        $this->assertGreaterThan(0, $checkoutButton->count(), 'Checkout button should be visible on cart page.');
        $checkoutButton->click();

        $client->waitFor('.checkout-page, #checkout, form[action*="checkout"]', 5);

        // Assert we're on the checkout page
        $checkoutPage = $client->getCrawler()->filter('.checkout-page, #checkout, form[action*="checkout"]');
        $this->assertGreaterThan(0, $checkoutPage->count(), 'User should be on the checkout page after clicking Checkout.');
    }

    /**
     * 6.4.5 – User Can Complete Purchase from Checkout
     * Given I am on the checkout page
     * When I provide valid payment and shipping information and confirm
     * Then my order is completed and I receive an order confirmation
     */
    public function test_6_4_5_CompletePurchase()
    {
        $client = \Symfony\Component\Panther\Client::createChromeClient();
        $crawler = $client->request('GET', 'http://localhost/checkout'); // Change as needed

        // Fill in shipping and payment info - adjust selectors as needed
        $form = $crawler->filter('form')->first();
        $this->assertGreaterThan(0, $form->count(), 'Checkout form should be present.');

        $form->fill([
            'name' => 'Test User',
            'address' => '123 Test St',
            'city' => 'Testville',
            'zip' => '12345',
            'card_number' => '4111111111111111', // Test Visa
            'card_expiry' => '12/30',
            'card_cvc' => '123',
        ]);
        $form->submit();

        // Wait for order confirmation
        $client->waitFor('.order-confirmation, #order-confirmation, .alert-success', 10);

        $confirmation = $client->getCrawler()->filter('.order-confirmation, #order-confirmation, .alert-success');
        $this->assertGreaterThan(0, $confirmation->count(), 'Order confirmation should be visible after completing purchase.');
        $this->assertStringContainsString(
            'Thank you', 
            $confirmation->text(),
            'Confirmation message should thank the user or confirm the order.'
        );
    }
}