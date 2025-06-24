# Test 5.4 – Database Creation/Import and Availability

## User Story
As a system administrator  
I need to ensure that the application database has been created or imported and is available  
So that the application can reliably store and retrieve data

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.4.1: Database Exists
**Given** MySQL is running  
**When** I check the list of databases  
**Then** the application database (e.g., `app_db`) is present

### Scenario 5.4.2: Database Schema is Present
**Given** the application database exists  
**When** I inspect its tables  
**Then** all required tables and columns (according to the application schema) are present

### Scenario 5.4.3: Database is Accessible
**Given** the application is configured to connect to the database  
**When** the application attempts to query the database  
**Then** queries succeed and no access errors occur

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                      |
|-------------|-----------------------------------------------------------------------------|
| 5.4.1       | Test_5_4_DatabaseCreatedAndAvailable::test_5_4_1_DatabaseExists             |
| 5.4.2       | Test_5_4_DatabaseCreatedAndAvailable::test_5_4_2_DatabaseSchemaIsPresent    |
| 5.4.3       | Test_5_4_DatabaseCreatedAndAvailable::test_5_4_3_DatabaseIsAccessible       |