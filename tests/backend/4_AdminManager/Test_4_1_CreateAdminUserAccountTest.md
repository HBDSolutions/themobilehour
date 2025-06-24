# Test 4.1 – Create New Admin User Accounts

## User Story
As an admin manager  
I need to create new admin user accounts  
So that admins can perform website and database management tasks

---

## Acceptance Criteria / BDD Scenarios

### Scenario 4.1.1: Successful Admin User Account Creation
**Given** an admin manager is logged into the admin management area  
**When** the admin manager submits a valid form to create a new admin user account  
**Then**
- The new admin user account is created
- The new admin receives login credentials or an invitation email
- The admin manager receives confirmation of the creation

### Scenario 4.1.2: Validation Errors on Admin User Account Creation
**Given** an admin manager is creating a new admin user account  
**When** the form is submitted with missing or invalid details (e.g., duplicate email, weak password)  
**Then**
- The system prevents account creation
- The admin manager is shown clear validation error messages

### Scenario 4.1.3: Audit Log for Admin Account Creation
**Given** an admin manager creates a new admin user account  
**When** the account is successfully created  
**Then**
- An audit log records the admin manager’s identity, the new admin’s details, and the timestamp

### Scenario 4.1.4: Access Control for Admin User Creation
**Given** a non-manager or unauthorized user tries to access the admin creation functionality  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                      |
|-------------|----------------------------------------------------------------------------|
| 4.1.1       | Test_4_1_CreateAdminUserAccount::test_4_1_1_SuccessfulAdminUserAccountCreation      |
| 4.1.2       | Test_4_1_CreateAdminUserAccount::test_4_1_2_ValidationErrorsOnAdminUserAccountCreation |
| 4.1.3       | Test_4_1_CreateAdminUserAccount::test_4_1_3_AuditLogForAdminAccountCreation         |
| 4.1.4       | Test_4_1_CreateAdminUserAccount::test_4_1_4_AccessControlForAdminUserCreation       |