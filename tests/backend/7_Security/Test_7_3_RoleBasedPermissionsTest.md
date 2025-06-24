# Test 7.3 – Role-Based Permissions

## User Story
As an application user or administrator  
I want permissions and access to be based on user roles  
So that only authorized users can access restricted features or data

---

## Acceptance Criteria / BDD Scenarios

### Scenario 7.3.1: User with Standard Role Cannot Access Admin Features
**Given** I am logged in as a user with a standard role  
**When** I try to access admin-only features or pages  
**Then** I am denied access and shown an appropriate error or redirect

### Scenario 7.3.2: Admin Can Access Admin Features
**Given** I am logged in as an admin  
**When** I access admin-only features or pages  
**Then** I am granted access

### Scenario 7.3.3: Role Changes Take Effect Immediately
**Given** my role is changed (e.g., from user to admin)  
**When** I refresh or navigate the app  
**Then** my new permissions are immediately applied

---

## Traceability

| Scenario ID | Maps to Test Method                                                      |
|-------------|-------------------------------------------------------------------------|
| 7.3.1       | Test_7_3_RoleBasedPermissions::test_7_3_1_StandardUserDeniedAdmin       |
| 7.3.2       | Test_7_3_RoleBasedPermissions::test_7_3_2_AdminCanAccessAdmin           |
| 7.3.3       | Test_7_3_RoleBasedPermissions::test_7_3_3_RoleChangeTakesEffect         |