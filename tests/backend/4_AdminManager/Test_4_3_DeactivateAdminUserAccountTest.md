# Test 4.3 – Deactivate Admin User Accounts

## User Story
As an admin manager  
I need to deactivate admin user accounts  
So that I can restrict access as required

---

## Acceptance Criteria / BDD Scenarios

### Scenario 4.3.1: Successful Deactivation of Admin Account
**Given** an admin manager is logged into the admin management area  
**When** the admin manager selects an active admin user and submits a request to deactivate the account  
**Then**
- The admin user's account is marked as inactive or deactivated
- The deactivated admin can no longer log in or access admin functionalities
- The admin manager receives confirmation of the deactivation

### Scenario 4.3.2: Audit Log for Admin Account Deactivation
**Given** an admin manager deactivates an admin user account  
**When** the action is performed  
**Then**
- An audit log records the admin manager’s identity, the deactivated admin’s details, and the timestamp

### Scenario 4.3.3: Validation/Error on Deactivating Already Inactive Account
**Given** an admin manager attempts to deactivate an already inactive admin account  
**When** the request is submitted  
**Then**
- The system prevents the action and displays a relevant error message

### Scenario 4.3.4: Access Control for Deactivating Admin Accounts
**Given** a non-manager or unauthorized user tries to deactivate an admin user account  
**When** access is attempted  
**Then**
- The system denies access and shows an appropriate message

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                                         |
|-------------|-------------------------------------------------------------------------------|
| 4.3.1       | Test_4_3_DeactivateAdminUserAccount::test_4_3_1_SuccessfulDeactivationOfAdminAccount |
| 4.3.2       | Test_4_3_DeactivateAdminUserAccount::test_4_3_2_AuditLogForAdminAccountDeactivation  |
| 4.3.3       | Test_4_3_DeactivateAdminUserAccount::test_4_3_3_ValidationErrorOnDeactivatingInactiveAccount |
| 4.3.4       | Test_4_3_DeactivateAdminUserAccount::test_4_3_4_AccessControlForDeactivatingAdminAccounts |