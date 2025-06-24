# Test 3.1 – Secure Admin Login

## User Story
As an admin user  
I need to securely log in to the site’s admin area  
So that I can securely manage the website

---

## Acceptance Criteria / BDD Scenarios

### Scenario 3.1.1: Successful Admin Login with Valid Credentials
**Given** an admin user is on the admin login page  
**When** the admin enters valid credentials and submits  
**Then**
- The admin is authenticated and redirected to the admin dashboard
- A secure session is created

### Scenario 3.1.2: Login Fails with Invalid Credentials
**Given** an admin user is on the admin login page  
**When** the admin enters invalid credentials and submits  
**Then**
- The login fails
- An informative, non-specific error message is displayed
- No session is created

### Scenario 3.1.3: Password Transmission is Secure
**Given** an admin submits login details  
**When** the form is sent  
**Then**
- Login credentials are transmitted over HTTPS
- No sensitive data is exposed in network requests

### Scenario 3.1.4: Account Lockout After Repeated Failures
**Given** an admin fails to log in multiple times in succession  
**When** the number of failed attempts exceeds a threshold  
**Then**
- The account is temporarily locked or CAPTCHA is required
- The admin is informed of the lockout or challenge

### Scenario 3.1.5: Session Management After Login
**Given** an admin logs in  
**When** authenticated  
**Then**
- The session token is securely stored (e.g., HTTP-only cookie)
- Session timeout and logout are enforced

---

## Traceability

| Scenario ID | Maps to PHPUnit Method                                               |
|-------------|---------------------------------------------------------------------|
| 3.1.1       | Test_3_1_SecureAdminLogin::test_3_1_1_SuccessfulAdminLogin          |
| 3.1.2       | Test_3_1_SecureAdminLogin::test_3_1_2_LoginFailsWithInvalidCreds    |
| 3.1.3       | Test_3_1_SecureAdminLogin::test_3_1_3_PasswordTransmissionIsSecure  |
| 3.1.4       | Test_3_1_SecureAdminLogin::test_3_1_4_AccountLockout                |
| 3.1.5       | Test_3_1_SecureAdminLogin::test_3_1_5_SessionManagement             |