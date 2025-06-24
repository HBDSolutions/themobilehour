# Test 7.6 – Security Protocols

## User Story
As an application user  
I want the site to use strong security protocols  
So that my personal data and activity are protected

---

## Acceptance Criteria / BDD Scenarios

### Scenario 7.6.1: All Sensitive Data Transmissions Use HTTPS
**Given** I am using the application  
**When** I submit login, registration, or other sensitive forms  
**Then** the data is transmitted via HTTPS

### Scenario 7.6.2: Security Headers Are Present in Responses
**Given** I access any page  
**When** the HTTP response is received  
**Then** the response includes security-related headers (e.g., Strict-Transport-Security, X-Content-Type-Options, Content-Security-Policy, X-Frame-Options)

### Scenario 7.6.3: CSRF Protection Is Enabled on Forms
**Given** I submit a sensitive form (login, registration, profile update, etc.)  
**When** I inspect the form  
**Then** a CSRF token is present and required for submission

---

## Traceability

| Scenario ID | Maps to Test Method                                                    |
|-------------|-----------------------------------------------------------------------|
| 7.6.1       | Test_7_6_SecurityProtocols::test_7_6_1_HTTPSForSensitiveData          |
| 7.6.2       | Test_7_6_SecurityProtocols::test_7_6_2_SecurityHeadersPresent         |
| 7.6.3       | Test_7_6_SecurityProtocols::test_7_6_3_CSRFProtectionOnForms          |