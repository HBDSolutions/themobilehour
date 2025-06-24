# Test 5.1 – DBMS Active Check

## User Story
As a system administrator  
I need to verify that the DBMS (MySQL) is active via phpMyAdmin and XAMPP  
So that I can ensure the database is available for application use

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.1.1: DBMS Running in XAMPP
**Given** XAMPP is running on the server  
**When** I check the status of the MySQL module in XAMPP Control Panel  
**Then** the MySQL service is shown as "Running"

### Scenario 5.1.2: DBMS Accessible via phpMyAdmin
**Given** MySQL is running in XAMPP  
**When** I open phpMyAdmin in a web browser  
**Then** I can log in and view the database server status and databases list

### Scenario 5.1.3: Application Can Connect to DBMS
**Given** the application is configured to use MySQL  
**When** the application attempts to connect to the database  
**Then** the connection is successful and no "cannot connect" errors occur

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                |
|-------------|----------------------------------------------------------------------|
| 5.1.1       | Test_5_1_DBMSActive::test_5_1_1_DBMSRunningInXAMPP                   |
| 5.1.2       | Test_5_1_DBMSActive::test_5_1_2_DBMSAccessibleViaPhpMyAdmin          |
| 5.1.3       | Test_5_1_DBMSActive::test_5_1_3_ApplicationCanConnectToDBMS          |