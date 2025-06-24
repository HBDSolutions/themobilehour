# Test 6.5 – Easy to Select/Filter Products

## User Story
As an application user  
I want to easily select or filter products based on my preferences  
So that I can quickly find items that meet my needs

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.5.1: Filters Are Clearly Visible and Accessible
**Given** I am on the products/search page  
**When** the page loads  
**Then** filtering options (e.g., by category, price, brand) are clearly visible and accessible without extra clicks

### Scenario 6.5.2: Selecting a Filter Updates Product List
**Given** I am viewing the products page  
**When** I select or change a filter  
**Then** the product list updates to show only items matching the selected filters

### Scenario 6.5.3: Multiple Filters Can Be Combined
**Given** I have applied one filter  
**When** I apply additional filters  
**Then** the product list updates to match all selected criteria

### Scenario 6.5.4: Filters Can Be Cleared Easily
**Given** I have selected one or more filters  
**When** I want to reset the filters  
**Then** I can easily clear all filters and return to the full product list

---

## Traceability

| Scenario ID | Maps to Test Method                                                  |
|-------------|----------------------------------------------------------------------|
| 6.5.1       | Test_6_5_EasyToSelectFilterProducts::test_6_5_1_FiltersVisible       |
| 6.5.2       | Test_6_5_EasyToSelectFilterProducts::test_6_5_2_FilterUpdatesList    |
| 6.5.3       | Test_6_5_EasyToSelectFilterProducts::test_6_5_3_CombinedFilters      |
| 6.5.4       | Test_6_5_EasyToSelectFilterProducts::test_6_5_4_ClearFilters         |