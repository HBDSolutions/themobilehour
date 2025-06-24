# Test 6.9 – Navigation

## User Story
As an application user  
I want clear and consistent navigation throughout the site  
So that I can easily find my way to key pages and features

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.9.1: Main Navigation is Consistent Across Pages
**Given** I am on any main page of the application  
**When** the page loads  
**Then** the main navigation menu is present and follows a consistent layout and style

### Scenario 6.9.2: Navigation Links Work as Expected
**Given** I see navigation links (e.g., Home, Products, Cart, Profile)  
**When** I click a navigation link  
**Then** I am taken to the correct destination page

### Scenario 6.9.3: Current Page is Clearly Indicated in Navigation
**Given** I am on a specific page  
**When** I view the navigation menu  
**Then** there is a clear visual indication of the current/active page

---

## Traceability

| Scenario ID | Maps to Test Method                                                |
|-------------|--------------------------------------------------------------------|
| 6.9.1       | Test_6_9_Navigation::test_6_9_1_MainNavigationConsistent           |
| 6.9.2       | Test_6_9_Navigation::test_6_9_2_NavigationLinksWork                |
| 6.9.3       | Test_6_9_Navigation::test_6_9_3_CurrentPageIndicated               |