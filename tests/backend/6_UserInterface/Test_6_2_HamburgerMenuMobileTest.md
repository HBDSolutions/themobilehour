# Test 6.2 – Hamburger Menu on Mobile

## User Story
As a mobile user  
I want a hamburger menu to access navigation options  
So that the interface is clean and usable on small screens

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.2.1: Hamburger Menu is Displayed on Mobile
**Given** I am viewing the application on a mobile device or with a narrow viewport  
**When** the page loads  
**Then** a hamburger menu icon is visible in the main navigation/header  
**And** the standard navigation links are hidden

### Scenario 6.2.2: Hamburger Menu Opens Navigation
**Given** the hamburger menu icon is visible  
**When** I tap the hamburger menu  
**Then** the main navigation options are displayed as a menu or drawer

### Scenario 6.2.3: Hamburger Menu Closes After Selection
**Given** the navigation menu is open  
**When** I tap a navigation link  
**Then** the navigation menu closes

---

## Traceability

| Scenario ID | Maps to Test Method                                                  |
|-------------|----------------------------------------------------------------------|
| 6.2.1       | Test_6_2_HamburgerMenuMobile::test_6_2_1_HamburgerMenuDisplayed      |
| 6.2.2       | Test_6_2_HamburgerMenuMobile::test_6_2_2_HamburgerMenuOpensNav       |
| 6.2.3       | Test_6_2_HamburgerMenuMobile::test_6_2_3_HamburgerMenuClosesOnSelect |