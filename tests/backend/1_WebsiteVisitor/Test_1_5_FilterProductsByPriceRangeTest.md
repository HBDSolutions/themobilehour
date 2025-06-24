# Test 1.5 – Filter Products by Price Range

## User Story
As a website visitor  
I need to filter available products by price range  
So that I can select from the products within my budget

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.5.1: Filter Products Within a Price Range
**Given** a website visitor is on the products/browse page  
**When** the visitor selects a minimum and maximum price range  
**Then**  
- Only products with prices within the selected range are displayed  
- The price filter controls remain visible and reflect the selected range

### Scenario 1.5.2: No Products Match Selected Price Range
**Given** a website visitor selects a price range  
**When** no products are available within that range  
**Then**  
- A message is displayed indicating no products are available within the selected range

### Scenario 1.5.3: Remove Price Filter
**Given** a price filter is applied  
**When** the visitor removes the filter or resets the price range  
**Then**  
- All available products are displayed again

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                   |
|-------------|-------------------------------------------------------------------------|
| 1.5.1       | Test_1_5_FilterProductsByPriceRange::test_1_5_1_FilterWithinPriceRange  |
| 1.5.2       | Test_1_5_FilterProductsByPriceRange::test_1_5_2_NoProductsInPriceRange  |
| 1.5.3       | Test_1_5_FilterProductsByPriceRange::test_1_5_3_RemovePriceFilter       |