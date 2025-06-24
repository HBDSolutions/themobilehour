# Test 5.3 – Web Connection User Account Creation

## User Story
As a system administrator  
I need a dedicated user account for the web application to connect to the database  
So that I can securely manage application access to the DBMS

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.3.1: Web Application User Account Exists
**Given** the database server is running  
**When** I check the list of MySQL users  
**Then** there is a user account specifically for the web application (e.g., 'webapp_user')

### Scenario 5.3.2: Web User Account Has Application-Appropriate Privileges
**Given** the web application user account exists  
**When** I review the privileges assigned to the user  
**Then** the user has only the minimum necessary privileges to read/write data as required by the application

### Scenario 5.3.3: Application Can Connect Using Web User Account
**Given** the web application is configured to use the web user account  
**When** the application attempts to connect to the database  
**Then** the connection is successful using the web user account credentials

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                        |
|-------------|-------------------------------------------------------------------------------|
| 5.3.1       | Test_5_3_WebUserAccountCreated::test_5_3_1_WebApplicationUserAccountExists    |
| 5.3.2       | Test_5_3_WebUserAccountCreated::test_5_3_2_WebUserAccountHasAppPrivileges     |
| 5.3.3       | Test_5_3_WebUserAccountCreated::test_5_3_3_ApplicationCanConnectWithWebUser   |