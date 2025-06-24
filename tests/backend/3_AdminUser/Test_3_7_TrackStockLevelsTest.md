# Test 3.7 – Track Stock Levels for Each Product and Brand

## User Story
As an admin user  
I need to track stock levels for each product and brand  
So that I can effectively manage inventory and availability on the site

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.7.1: View Current Stock Levels
**Given** an admin is logged into the admin area  
**When** the admin navigates to the product or brand inventory page  
**Then**
- The current stock levels for each product and brand are displayed accurately

### Scenario 3.7.2: Update Stock Levels for a Product
**Given** an admin is viewing a product's details  
**When** the admin updates the stock quantity and submits  
**Then**
- The new stock level is saved and reflected in the system
- The update is confirmed to the admin

### Scenario 3.7.3: Prevent Negative Stock Values
**Given** an admin attempts to set a stock level to a negative value  
**When** the stock update is submitted  
**Then**
- The system prevents the update
- The admin is shown a clear validation error message

### Scenario 3.7.4: Stock Alerts for Low or Out-of-Stock Products
**Given** a product or brand falls below a defined stock threshold  
**When** the admin views the inventory  
**Then**
- A low stock or out-of-stock alert is displayed for the affected products or brands

### Scenario 3.7.5: Audit Log for Stock Changes
**Given** an admin changes a stock level  
**When** the update is saved  
**Then**
- An audit log records the admin’s identity, the affected product/brand, the stock change, and the timestamp

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                   |
|-------------|--------------------------------------------------------------------------|
| 3.7.1       | Test_3_7_TrackStockLevels::test_3_7_1_ViewCurrentStockLevels             |
| 3.7.2       | Test_3_7_TrackStockLevels::test_3_7_2_UpdateStockLevelsForProduct        |
| 3.7.3       | Test_3_7_TrackStockLevels::test_3_7_3_PreventNegativeStockValues         |
| 3.7.4       | Test_3_7_TrackStockLevels::test_3_7_4_StockAlertsForLowOrOutOfStock      |
| 3.7.5       | Test_3_7_TrackStockLevels::test_3_7_5_AuditLogForStockChanges            |