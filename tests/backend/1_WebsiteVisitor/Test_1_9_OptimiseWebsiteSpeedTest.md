# Test 1.9 – Optimise Website Speed

## User Story
As a website visitor  
I need to optimise speed of the website for all users  
So that I experience minimal page and data load times

---

## Acceptance Criteria / BDD Scenarios

### Scenario 1.9.1: Fast Page Load Under Normal Conditions
**Given** a website visitor accesses any page  
**When** the page loads under normal network and server conditions  
**Then**
- The page loads within an acceptable time threshold (e.g., under 2 seconds)
- All critical resources (HTML, CSS, JS, images) load promptly

### Scenario 1.9.2: Optimised Resource Delivery
**Given** the website delivers resources to users  
**When** a user loads a page  
**Then**
- Resources are minified and compressed
- Images are delivered in optimised formats and sizes
- Unused scripts and CSS are not loaded

### Scenario 1.9.3: Performance Under Heavy Load
**Given** the website experiences high user traffic  
**When** pages are accessed  
**Then**
- Most users continue to experience acceptable load times
- Performance degradation is minimal and does not result in timeouts

### Scenario 1.9.4: Ongoing Performance Monitoring
**Given** the website is live  
**When** performance metrics fall below defined thresholds  
**Then**
- Alerts are generated for the support/engineering team
- Performance incidents are logged for review

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                 |
|-------------|-----------------------------------------------------------------------|
| 1.9.1       | Test_1_9_OptimiseWebsiteSpeed::test_1_9_1_FastPageLoad                |
| 1.9.2       | Test_1_9_OptimiseWebsiteSpeed::test_1_9_2_OptimisedResourceDelivery   |
| 1.9.3       | Test_1_9_OptimiseWebsiteSpeed::test_1_9_3_PerformanceUnderHeavyLoad   |
| 1.9.4       | Test_1_9_OptimiseWebsiteSpeed::test_1_9_4_OngoingPerformanceMonitoring|