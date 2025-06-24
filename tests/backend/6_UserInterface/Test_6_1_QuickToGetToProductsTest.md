# Test 6.1 – Quick to Get to Products (One Click)

## User Story
As an application user  
I want to access the products page quickly  
So that I can view available products with minimal navigation

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.1.1: Products Page is Accessible via One Click from Home
**Given** I am on the application’s home page  
**When** I look for navigation or action buttons  
**Then** there is a clearly labeled "Products" button or link  
**And** clicking it takes me directly to the products page

### Scenario 6.1.2: Products Button is Prominently Visible
**Given** I am on the home page  
**When** the page loads  
**Then** the "Products" button or link is visible above the fold (no scrolling required)

---

## Traceability

| Scenario ID | Maps to Test Method                                                  |
|-------------|----------------------------------------------------------------------|
| 6.1.1       | Test_6_1_QuickToGetToProducts::test_6_1_1_ProductsOneClickFromHome   |
| 6.1.2       | Test_6_1_QuickToGetToProducts::test_6_1_2_ProductsButtonVisible      |