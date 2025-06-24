# Test 4.4 – Report of All Admin Users

## User Story
As an admin manager  
I need a report of all admin users  
So that I can analyse appropriate site access

---

## Acceptance Criteria / BDD Scenarios

### Scenario 4.4.1: Generate Admin User Report
**Given** an admin manager is logged into the admin management area  
**When** the admin manager requests a report of all admin users  
**Then**
- The system generates a report including all admin user accounts
- The report includes names, emails, roles, permissions, status, and last login/activity

### Scenario 4.4.2: Report Data Accuracy
**Given** the admin user report is generated  
**When** the admin manager reviews the data  
**Then**
- All admin user details, roles, permissions, and statuses match the system data

### Scenario 4.4.3: Filter and Sort Admin User Report
**Given** the admin manager is viewing the admin user report  
**When** the admin manager applies filters or sorting (by role, status, last login, etc.)  
**Then**
- The displayed data matches the selected filter or sorting criteria

### Scenario 4.4.4: Export Admin User Report
**Given** the admin manager is viewing the admin user report  
**When** the admin manager chooses to export the report (CSV, Excel, PDF, etc.)  
**Then**
- The system creates a downloadable file in the selected format with accurate data

### Scenario 4.4.5: Access Control for Admin User Reports
**Given** a non-manager or unauthorized user attempts to access the admin user report  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                               |
|-------------|---------------------------------------------------------------------|
| 4.4.1       | Test_4_4_AdminUserReport::test_4_4_1_GenerateAdminUserReport        |
| 4.4.2       | Test_4_4_AdminUserReport::test_4_4_2_ReportDataAccuracy             |
| 4.4.3       | Test_4_4_AdminUserReport::test_4_4_3_FilterAndSortAdminUserReport   |
| 4.4.4       | Test_4_4_AdminUserReport::test_4_4_4_ExportAdminUserReport          |
| 4.4.5       | Test_4_4_AdminUserReport::test_4_4_5_AccessControlForAdminUserReports|