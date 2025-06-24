# Test 2.3 – Reset Account Password

## User Story
As a registered customer account user  
I need to reset my account password  
So that I reduce the risk of others accessing my account

---

## Acceptance Criteria / BDD Scenarios

### Scenario 2.3.1: Request Password Reset
**Given** a registered customer is on the login or forgot password page  
**When** the user submits a valid email address for password reset  
**Then**
- A reset email with a secure, time-limited link is sent to that address
- The user receives appropriate confirmation feedback

### Scenario 2.3.2: Handle Invalid/Unknown Email
**Given** a user submits an invalid or unregistered email address  
**When** requesting a password reset  
**Then**
- No reset email is sent
- A generic confirmation message is shown (not revealing if the email is registered)

### Scenario 2.3.3: Reset Link and Token Security
**Given** a user receives a password reset email  
**When** the reset link is used  
**Then**
- The link is single-use and expires after a short time
- The reset form is only accessible if the token is valid

### Scenario 2.3.4: Set New Password
**Given** a user follows a valid password reset link  
**When** the user submits a new password  
**Then**
- The password is updated securely
- The user can log in with the new password
- The reset token cannot be reused

### Scenario 2.3.5: Password Complexity and Validation
**Given** a user sets a new password  
**When** the password does not meet complexity requirements  
**Then**
- The system rejects the password and shows validation feedback

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                               |
|-------------|---------------------------------------------------------------------|
| 2.3.1       | Test_2_3_ResetAccountPassword::test_2_3_1_RequestPasswordReset      |
| 2.3.2       | Test_2_3_ResetAccountPassword::test_2_3_2_HandleInvalidEmail        |
| 2.3.3       | Test_2_3_ResetAccountPassword::test_2_3_3_ResetLinkAndTokenSecurity |
| 2.3.4       | Test_2_3_ResetAccountPassword::test_2_3_4_SetNewPassword            |
| 2.3.5       | Test_2_3_ResetAccountPassword::test_2_3_5_PasswordComplexity        |