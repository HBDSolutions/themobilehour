# Test 1.2 – Responsive Website Design

## User Story
As a website visitor  
I need a responsive website design  
So that the UX for site functionality is optimal on phone, tablet, or PC

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.2.1: Layout Adjusts to Device Size
**Given** a website visitor accesses the site on a phone, tablet, or PC  
**When** the viewport size changes  
**Then**  
- Content and navigation automatically adapt for readability and usability  
- No horizontal scrolling is required  
- Key actions (e.g., register, login, browse products) remain accessible

### Scenario 1.2.2: Images and Media Are Responsive
**Given** the site contains images or media  
**When** viewed on different device sizes  
**Then**  
- Images and media scale proportionally  
- They do not overflow or break the layout

### Scenario 1.2.3: Forms and Buttons Are Usable on All Devices
**Given** a website visitor interacts with forms or buttons  
**When** using touch (mobile/tablet) or mouse (PC)  
**Then**  
- Input fields are readable and accessible  
- Buttons are of appropriate size and spacing for touch

### Scenario 1.2.4: No Functional Differences Across Devices
**Given** a visitor uses any supported device  
**When** performing website actions  
**Then**  
- All core features (registration, login, browsing, etc.) work correctly  
- There are no critical UI or functional bugs unique to a device type

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                    |
|-------------|--------------------------------------------------------------------------|
| 1.2.1       | Test_1_2_ResponsiveWebsiteDesign::test_1_2_1_LayoutAdjustsToDeviceSize   |
| 1.2.2       | Test_1_2_ResponsiveWebsiteDesign::test_1_2_2_ImagesAndMediaAreResponsive |
| 1.2.3       | Test_1_2_ResponsiveWebsiteDesign::test_1_2_3_FormsAndButtonsUsable       |
| 1.2.4       | Test_1_2_ResponsiveWebsiteDesign::test_1_2_4_NoFunctionalDifferences     |