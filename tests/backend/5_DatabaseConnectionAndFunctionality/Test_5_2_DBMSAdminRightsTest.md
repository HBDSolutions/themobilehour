# Test 5.2 – DBMS Administration Rights Assignment

## User Story
As a system administrator  
I need to ensure that administration rights have been assigned for the DBMS  
So that authorized users can perform necessary database management tasks

---

## Acceptance Criteria / BDD Scenarios

### Scenario 5.2.1: Admin User Has Full DBMS Privileges
**Given** a user is assigned as a DBMS administrator  
**When** the user logs into MySQL (via phpMyAdmin or command line)  
**Then**
- The user can create, read, update, and delete databases and tables
- The user can manage user accounts and permissions

### Scenario 5.2.2: Non-Admin User Cannot Perform Admin Actions
**Given** a user is not assigned as a DBMS administrator  
**When** the user attempts to perform administrative actions (e.g., create/drop database, manage users)  
**Then**
- The system denies the action and displays an appropriate error or warning

### Scenario 5.2.3: Audit/Admin Log Records Privilege Assignments
**Given** administration rights are assigned to a user  
**When** the assignment occurs  
**Then**
- The event is recorded in an audit or admin log with the user, grantor, and timestamp

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                |
|-------------|----------------------------------------------------------------------|
| 5.2.1       | Test_5_2_DBMSAdminRights::test_5_2_1_AdminUserHasFullDBMSPrivileges  |
| 5.2.2       | Test_5_2_DBMSAdminRights::test_5_2_2_NonAdminUserCannotAdmin         |
| 5.2.3       | Test_5_2_DBMSAdminRights::test_5_2_3_AuditLogRecordsPrivilegeAssignment |