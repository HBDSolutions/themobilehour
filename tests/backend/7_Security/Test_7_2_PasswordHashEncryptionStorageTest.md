# Test 7.2 – Password Hash Encryption & Storage

## User Story
As a user  
I want my password to be securely hashed and stored  
So that my account is protected even if the database is compromised

---

## Acceptance Criteria / BDD Scenarios

### Scenario 7.2.1: Password is Never Stored in Plain Text
**Given** a user registers or changes their password  
**When** the password is saved to the database  
**Then** the password is not stored in plain text

### Scenario 7.2.2: Password is Hashed with a Secure Algorithm (e.g., bcrypt, Argon2)
**Given** a user registers or changes their password  
**When** the password is saved to the database  
**Then** a strong, modern hash function (e.g., bcrypt, Argon2) is used

### Scenario 7.2.3: Password Hashes Include a Unique Salt
**Given** multiple users register with the same password  
**When** their password hashes are stored  
**Then** the hashes are different due to unique salts

---

## Traceability

| Scenario ID | Maps to Test Method                                                                |
|-------------|-----------------------------------------------------------------------------------|
| 7.2.1       | Test_7_2_PasswordHashEncryptionStorage::test_7_2_1_PasswordNotPlainText           |
| 7.2.2       | Test_7_2_PasswordHashEncryptionStorage::test_7_2_2_PasswordHashedWithSecureAlgo   |
| 7.2.3       | Test_7_2_PasswordHashEncryptionStorage::test_7_2_3_PasswordHashesUniqueSalt       |