# Test 6.3 – Fixed Menu on PC

## User Story
As a desktop (PC) user  
I want the main menu to remain visible at the top of the screen  
So that I can easily access navigation options while scrolling

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.3.1: Fixed Menu is Visible on Desktop
**Given** I am viewing the application on a desktop-sized screen  
**When** the page loads  
**Then** the main navigation/menu is visible at the top of the page

### Scenario 6.3.2: Menu Remains Fixed While Scrolling
**Given** I am on a desktop viewport  
**When** I scroll down the page  
**Then** the main menu remains fixed at the top and does not disappear

### Scenario 6.3.3: Menu is Not Obtrusive
**Given** the menu is fixed  
**When** I interact with the page content  
**Then** the menu does not overlap or obscure important content

---

## Traceability

| Scenario ID | Maps to Test Method                                                   |
|-------------|-----------------------------------------------------------------------|
| 6.3.1       | Test_6_3_FixedMenuPC::test_6_3_1_FixedMenuVisibleOnDesktop           |
| 6.3.2       | Test_6_3_FixedMenuPC::test_6_3_2_MenuRemainsFixedWhileScrolling      |
| 6.3.3       | Test_6_3_FixedMenuPC::test_6_3_3_MenuNotObtrusive                    |