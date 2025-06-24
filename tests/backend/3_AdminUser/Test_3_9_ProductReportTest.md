# Test 3.9 – Product Report for All Products and Brands

## User Story
As an admin user  
I need a product report for all products and brands  
So that I can analyse sales trends and manage inventory

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.9.1: Generate Product Report
**Given** an admin is logged into the admin area  
**When** the admin requests a product report  
**Then**
- The system generates a report including all products and brands
- The report includes sales data, inventory levels, and trends

### Scenario 3.9.2: Report Data Accuracy
**Given** the product report is generated  
**When** the admin reviews the data  
**Then**
- All product and brand information, sales, and stock levels match the actual system data

### Scenario 3.9.3: Filter and Sort Report Data
**Given** the admin is viewing the product report  
**When** the admin applies filters or sorting (by date, product, brand, sales volume, etc.)  
**Then**
- The displayed data matches the selected filters or sorting criteria

### Scenario 3.9.4: Export Product Report
**Given** the admin is viewing a product report  
**When** the admin chooses to export the report (CSV, Excel, PDF, etc.)  
**Then**
- The system creates a downloadable file in the selected format with accurate data

### Scenario 3.9.5: Access Control for Reports
**Given** a non-admin or unauthorized user attempts to access the product report  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                               |
|-------------|---------------------------------------------------------------------|
| 3.9.1       | Test_3_9_ProductReport::test_3_9_1_GenerateProductReport            |
| 3.9.2       | Test_3_9_ProductReport::test_3_9_2_ReportDataAccuracy               |
| 3.9.3       | Test_3_9_ProductReport::test_3_9_3_FilterAndSortReportData          |
| 3.9.4       | Test_3_9_ProductReport::test_3_9_4_ExportProductReport              |
| 3.9.5       | Test_3_9_ProductReport::test_3_9_5_AccessControlForReports          |