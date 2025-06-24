# Test 1.7 – Search Products by Name or Model

## User Story
As a website visitor  
I need to search for products by name or model  
So that I can quickly find the product I am looking for

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.7.1: Search by Product Name
**Given** a website visitor is on the products/browse page  
**When** the visitor enters a product name in the search box and submits  
**Then**
- Only products matching the entered name are displayed
- The search term is highlighted in the results (if supported)

### Scenario 1.7.2: Search by Product Model
**Given** a website visitor is on the products/browse page  
**When** the visitor enters a product model in the search box and submits  
**Then**
- Only products matching the entered model are displayed

### Scenario 1.7.3: No Matching Products
**Given** the visitor enters a name or model that does not match any available product  
**When** the search is performed  
**Then**
- A message is displayed indicating no products are found

### Scenario 1.7.4: Search Reset/Empty Query
**Given** a search is performed  
**When** the search box is cleared and the search is submitted again  
**Then**
- All available products are displayed

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                    |
|-------------|--------------------------------------------------------------------------|
| 1.7.1       | Test_1_7_SearchProductsByNameOrModel::test_1_7_1_SearchByProductName     |
| 1.7.2       | Test_1_7_SearchProductsByNameOrModel::test_1_7_2_SearchByProductModel    |
| 1.7.3       | Test_1_7_SearchProductsByNameOrModel::test_1_7_3_NoMatchingProducts      |
| 1.7.4       | Test_1_7_SearchProductsByNameOrModel::test_1_7_4_SearchResetOrEmptyQuery |