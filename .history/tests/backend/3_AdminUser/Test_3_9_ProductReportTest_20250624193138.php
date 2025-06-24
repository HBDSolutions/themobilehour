<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.9 – Product Report
 *
 * User Story:
 * As an admin user,
 * I want to view reports on products and brands,
 * So that I can analyze sales and inventory.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.9.1 – Generate Report with Products and Brands
 * 3.9.2 – Report Shows Multiple Products and Sales
 * 3.9.3 – Report Can Be Exported
 */
class Test_3_9_ProductReportTest extends TestCase
{
    public function test_3_9_1_GenerateReportWithProductsAndBrands()
    {
        simulate_products_and_brands();
        login_as_admin();
        $report = get_product_report();
        $this->assertStringContainsString('BrandA', $report);
        $this->assertStringContainsString('Product1', $report);
    }

    public function test_3_9_2_ReportShowsMultipleProductsAndSales()
    {
        simulate_products_and_brands();
        $report = get_product_report();
        $this->assertStringContainsString('Product2', $report);
        $this->assertStringContainsString('sales', strtolower($report));
    }

    public function test_3_9_3_ReportCanBeExported()
    {
        $report = get_product_report();
        $export = export_report($report);
        $this->assertTrue($export['success']);
        $this->assertStringContainsString('.csv', $export['filename']);
    }
}

// ---
// Stub helper functions for illustration purposes only:
function simulate_products_and_brands() { /* ... */ }
function login_as_admin() { /* ... */ }
function get_product_report() { return 'BrandA Product1 Product2 sales: 100'; }
function export_report($report) { return ['success' => true, 'filename' => 'report.csv']; }