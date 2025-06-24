# Test 1.3 – Browse All Available Products

## User Story
As a website visitor  
I need to browse all available products  
So that I can compare and select my favourites

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.3.1: View All Products
**Given** a website visitor is on the products/browse page  
**When** the page loads  
**Then**  
- All available products are displayed  
- Each product shows key information (e.g., name, image, price, short description)

### Scenario 1.3.2: Products Are Sortable and Pageable
**Given** there are more products than can fit on a single page  
**When** the visitor browses the product list  
**Then**  
- Products are divided into pages or can be loaded dynamically  
- Sorting options (e.g., by price, popularity, newest) are available

### Scenario 1.3.3: Product Comparison Features
**Given** a website visitor is browsing products  
**When** the visitor marks products as favourites or for comparison  
**Then**  
- The visitor can view a list of selected favourites  
- Optional: The visitor can compare selected products side by side

### Scenario 1.3.4: No Products Available
**Given** there are no products in the system  
**When** the visitor browses the products page  
**Then**  
- A message is displayed indicating no products are available

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                               |
|-------------|---------------------------------------------------------------------|
| 1.3.1       | Test_1_3_BrowseAllProducts::test_1_3_1_ViewAllProducts              |
| 1.3.2       | Test_1_3_BrowseAllProducts::test_1_3_2_ProductsAreSortableAndPageable |
| 1.3.3       | Test_1_3_BrowseAllProducts::test_1_3_3_ProductComparisonFeatures    |
| 1.3.4       | Test_1_3_BrowseAllProducts::test_1_3_4_NoProductsAvailable          |