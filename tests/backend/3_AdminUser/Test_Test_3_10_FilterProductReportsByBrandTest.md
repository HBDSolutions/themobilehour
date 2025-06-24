# Test 3.10 – Filter Product Reports by Brands

## User Story
As an admin user  
I need to filter product reports by brands  
So that I can manage product availability by supplier

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.10.1: Filter Product Report by Single Brand
**Given** an admin is viewing the product report  
**When** the admin selects a specific brand to filter by  
**Then**
- Only products from the selected brand are shown in the report
- All report data (sales, stock, etc.) pertains only to that brand

### Scenario 3.10.2: Filter Product Report by Multiple Brands
**Given** an admin is viewing the product report  
**When** the admin selects multiple brands to filter by  
**Then**
- Only products from the selected brands are shown in the report

### Scenario 3.10.3: No Results for Unused Brand
**Given** an admin selects a brand with no associated products  
**When** the filter is applied  
**Then**
- The report indicates there are no products for the selected brand(s)

### Scenario 3.10.4: Brand Filter Persists with Export
**Given** an admin filters the product report by brand(s)  
**When** the admin exports the report  
**Then**
- The exported file contains only products from the selected brand(s)

### Scenario 3.10.5: Access Control for Brand-Filtered Reports
**Given** a non-admin or unauthorized user attempts to access a brand-filtered product report  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                     |
|-------------|---------------------------------------------------------------------------|
| 3.10.1      | Test_3_10_FilterProductReportsByBrand::test_3_10_1_FilterBySingleBrand    |
| 3.10.2      | Test_3_10_FilterProductReportsByBrand::test_3_10_2_FilterByMultipleBrands |
| 3.10.3      | Test_3_10_FilterProductReportsByBrand::test_3_10_3_NoResultsForUnusedBrand|
| 3.10.4      | Test_3_10_FilterProductReportsByBrand::test_3_10_4_BrandFilterPersistsWithExport |
| 3.10.5      | Test_3_10_FilterProductReportsByBrand::test_3_10_5_AccessControlForBrandFilteredReports |