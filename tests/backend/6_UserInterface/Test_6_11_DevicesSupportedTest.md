# Test 6.11 – Devices Supported

## User Story
As an application user  
I want the site to work well on all major device types  
So that I can access and use it from desktop, tablet, or mobile

---

## Acceptance Criteria / BDD Scenarios

### Scenario 6.11.1: Application Renders Correctly on Desktop
**Given** I open the site on a desktop device  
**When** the page loads  
**Then** the layout is optimized for large screens and all features are usable

### Scenario 6.11.2: Application Renders Correctly on Tablet
**Given** I open the site on a tablet device  
**When** the page loads  
**Then** the layout adapts to medium-sized screens and navigation/features remain accessible

### Scenario 6.11.3: Application Renders Correctly on Mobile
**Given** I open the site on a mobile device  
**When** the page loads  
**Then** the layout is optimized for small screens, navigation is easy, and all key features are accessible

---

## Traceability

| Scenario ID | Maps to Test Method                                                      |
|-------------|-------------------------------------------------------------------------|
| 6.11.1      | Test_6_11_DevicesSupported::test_6_11_1_RendersOnDesktop                |
| 6.11.2      | Test_6_11_DevicesSupported::test_6_11_2_RendersOnTablet                 |
| 6.11.3      | Test_6_11_DevicesSupported::test_6_11_3_RendersOnMobile                 |