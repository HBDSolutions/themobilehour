# Test 2.1 – Secure Login

## User Story
As a registered customer account user  
I need to securely log in to my account  
So that I can safely buy, track and view history

---

## Acceptance Criteria / BDD Scenarios

### Scenario 2.1.1: Successful Login with Valid Credentials
**Given** a registered customer is on the login page  
**When** the customer enters valid credentials and submits  
**Then**
- The customer is authenticated and redirected to their account/dashboard
- A secure session is created

### Scenario 2.1.2: Login Fails with Invalid Credentials
**Given** a registered customer is on the login page  
**When** the customer enters invalid credentials and submits  
**Then**
- The login fails
- An informative, non-specific error message is displayed ("Invalid login" rather than "Wrong password")
- No session is created

### Scenario 2.1.3: Password Transmission is Secure
**Given** a customer submits login details  
**When** the form is sent  
**Then**
- Login credentials are transmitted over HTTPS
- No sensitive data is exposed in network requests

### Scenario 2.1.4: Account Lockout After Repeated Failures
**Given** a customer fails to log in multiple times in succession  
**When** the number of failed attempts exceeds a threshold  
**Then**
- The account is temporarily locked or CAPTCHA is required
- The customer is informed of the lockout or challenge

### Scenario 2.1.5: Session Management After Login
**Given** a customer logs in  
**When** authenticated  
**Then**
- The session token is securely stored (e.g., HTTP-only cookie)
- Session timeout and logout are enforced

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                             |
|-------------|-------------------------------------------------------------------|
| 2.1.1       | Test_2_1_SecureLogin::test_2_1_1_SuccessfulLogin                  |
| 2.1.2       | Test_2_1_SecureLogin::test_2_1_2_LoginFailsWithInvalidCredentials |
| 2.1.3       | Test_2_1_SecureLogin::test_2_1_3_PasswordTransmissionIsSecure     |
| 2.1.4       | Test_2_1_SecureLogin::test_2_1_4_AccountLockout                   |
| 2.1.5       | Test_2_1_SecureLogin::test_2_1_5_SessionManagement                |