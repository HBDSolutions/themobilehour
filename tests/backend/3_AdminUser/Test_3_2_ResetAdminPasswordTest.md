# Test 3.2 – Reset Admin Password

## User Story
As an admin user  
I need to reset my password  
So that I can regain secure access as required

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.2.1: Request Admin Password Reset
**Given** an admin is on the admin login or forgot password page  
**When** the admin submits a valid admin email address for password reset  
**Then**
- A reset email with a secure, time-limited link is sent to that address
- The admin receives appropriate confirmation feedback

### Scenario 3.2.2: Handle Invalid/Unknown Email
**Given** an admin submits an invalid or unregistered email address  
**When** requesting a password reset  
**Then**
- No reset email is sent
- A generic confirmation message is shown (not revealing if the email is registered)

### Scenario 3.2.3: Reset Link and Token Security
**Given** an admin receives a password reset email  
**When** the reset link is used  
**Then**
- The link is single-use and expires after a short time
- The reset form is only accessible if the token is valid

### Scenario 3.2.4: Set New Admin Password
**Given** an admin follows a valid password reset link  
**When** the admin submits a new password  
**Then**
- The password is updated securely
- The admin can log in with the new password
- The reset token cannot be reused

### Scenario 3.2.5: Admin Password Complexity and Validation
**Given** an admin sets a new password  
**When** the password does not meet complexity requirements  
**Then**
- The system rejects the password and shows validation feedback

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                             |
|-------------|-------------------------------------------------------------------|
| 3.2.1       | Test_3_2_ResetAdminPassword::test_3_2_1_RequestAdminPasswordReset |
| 3.2.2       | Test_3_2_ResetAdminPassword::test_3_2_2_HandleInvalidEmail        |
| 3.2.3       | Test_3_2_ResetAdminPassword::test_3_2_3_ResetLinkAndTokenSecurity |
| 3.2.4       | Test_3_2_ResetAdminPassword::test_3_2_4_SetNewAdminPassword       |
| 3.2.5       | Test_3_2_ResetAdminPassword::test_3_2_5_AdminPasswordComplexity   |