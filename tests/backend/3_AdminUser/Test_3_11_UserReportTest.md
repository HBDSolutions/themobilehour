# Test 3.11 – User Report for All Registered Users

## User Story
As an admin user  
I need a report of all registered users  
So that I can analyse site user trends

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.11.1: Generate User Report
**Given** an admin is logged into the admin area  
**When** the admin requests a user report  
**Then**
- The system generates a report including all registered users
- The report includes registration date, activity, status, and profile data

### Scenario 3.11.2: Report Data Accuracy
**Given** the user report is generated  
**When** the admin reviews the data  
**Then**
- All user information, activity, and statuses match the actual system data

### Scenario 3.11.3: Filter and Sort User Report
**Given** the admin is viewing the user report  
**When** the admin applies filters or sorting (by registration date, activity level, status, etc.)  
**Then**
- The displayed data matches the selected filters or sorting criteria

### Scenario 3.11.4: Export User Report
**Given** the admin is viewing a user report  
**When** the admin chooses to export the report (CSV, Excel, PDF, etc.)  
**Then**
- The system creates a downloadable file in the selected format with accurate data

### Scenario 3.11.5: Access Control for User Reports
**Given** a non-admin or unauthorized user attempts to access the user report  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                             |
|-------------|-------------------------------------------------------------------|
| 3.11.1      | Test_3_11_UserReport::test_3_11_1_GenerateUserReport              |
| 3.11.2      | Test_3_11_UserReport::test_3_11_2_ReportDataAccuracy              |
| 3.11.3      | Test_3_11_UserReport::test_3_11_3_FilterAndSortUserReport         |
| 3.11.4      | Test_3_11_UserReport::test_3_11_4_ExportUserReport                |
| 3.11.5      | Test_3_11_UserReport::test_3_11_5_AccessControlForUserReports     |