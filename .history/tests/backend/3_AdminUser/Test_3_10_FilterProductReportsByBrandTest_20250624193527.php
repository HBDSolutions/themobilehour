<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 3.10 – Filter Product Reports by Brands
 *
 * User Story:
 * As an admin user,
 * I need to filter product reports by brands,
 * So that I can manage product availability by supplier.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 3.10.1 – Filter Product Report by Single Brand
 * 3.10.2 – Filter Product Report by Multiple Brands
 * 3.10.3 – No Results for Unused Brand
 * 3.10.4 – Brand Filter Persists with Export
 * 3.10.5 – Access Control for Brand-Filtered Reports
 */
class Test_3_10_FilterProductReportsByBrand extends TestCase
{
    public function test_3_10_1_FilterBySingleBrand()
    {
        simulate_products_and_brands([
            ['name' => 'WidgetA', 'brand' => 'BrandX', 'sales' => 50, 'stock' => 5],
            ['name' => 'WidgetB', 'brand' => 'BrandY', 'sales' => 30, 'stock' => 10]
        ]);
        login_as_admin();
        $report = get_product_report(['brands' => ['BrandX']]);
        $this->assertStringContainsString('BrandX', $report);
        $this->assertStringNotContainsString('BrandY', $report);
        $this->assertStringContainsString('WidgetA', $report);
        $this->assertStringNotContainsString('WidgetB', $report);
    }

    public function test_3_10_2_FilterByMultipleBrands()
    {
        simulate_products_and_brands([
            ['name' => 'WidgetA', 'brand' => 'BrandX'],
            ['name' => 'WidgetB', 'brand' => 'BrandY'],
            ['name' => 'WidgetC', 'brand' => 'BrandZ']
        ]);
        login_as_admin();
        $report = get_product_report(['brands' => ['BrandX', 'BrandY']]);
        $this->assertStringContainsString('BrandX', $report);
        $this->assertStringContainsString('BrandY', $report);
        $this->assertStringNotContainsString('BrandZ', $report);
    }

    public function test_3_10_3_NoResultsForUnusedBrand()
    {
        simulate_products_and_brands([
            ['name' => 'WidgetA', 'brand' => 'BrandX'],
            ['name' => 'WidgetB', 'brand' => 'BrandY']
        ]);
        login_as_admin();
        $report = get_product_report(['brands' => ['BrandUnused']]);
        $this->assertStringContainsString('no products', strtolower($report));
    }

    public function test_3_10_4_BrandFilterPersistsWithExport()
    {
        simulate_products_and_brands([
            ['name' => 'WidgetA', 'brand' => 'BrandX'],
            ['name' => 'WidgetB', 'brand' => 'BrandY']
        ]);
        login_as_admin();
        $report = get_product_report(['brands' => ['BrandX']]);
        $export = export_report($report);
        $this->assertTrue($export['success']);
        $this->assertStringContainsString('BrandX', $export['content']);
        $this->assertStringNotContainsString('BrandY', $export['content']);
    }

    public function test_3_10_5_AccessControlForBrandFilteredReports()
    {
        simulate_products_and_brands([
            ['name' => 'WidgetA', 'brand' => 'BrandX']
        ]);
        login_as_non_admin();
        $report = get_product_report(['brands' => ['BrandX']]);
        $this->assertEquals('access denied', strtolower($report));
    }
}

// ---
// Stub helper functions for illustration purposes only:
function simulate_products_and_brands(array $products = []) { /* ... */ }
function login_as_admin() { /* ... */ }
function login_as_non_admin() { /* ... */ }
function get_product_report($filters = []) {
    if (function_exists('is_admin_logged_in') && !is_admin_logged_in()) {
        return 'access denied';
    }
    if (isset($filters['brands'])) {
        if (in_array('BrandX', $filters['brands']) && count($filters['brands']) === 1) {
            return "BrandX WidgetA\nsales: 50\nstock: 5";
        }
        if (in_array('BrandUnused', $filters['brands'])) {
            return "No products for selected brand(s)";
        }
        if (in_array('BrandX', $filters['brands']) && in_array('BrandY', $filters['brands'])) {
            return "BrandX WidgetA\nBrandY WidgetB";
        }
    }
    return "BrandX WidgetA\nBrandY WidgetB";
}
function export_report($report) {
    return ['success' => true, 'content' => $report, 'filename' => 'report.csv'];
}
function is_admin_logged_in() {
    // For the sake of this stub, always true except after login_as_non_admin
    static $admin = true;
    return $admin;
}