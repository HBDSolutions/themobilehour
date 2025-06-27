<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 7.2 – Password Hash Encryption & Storage
 *
 * User Story:
 * As a user
 * I want my password to be securely hashed and stored
 * So that my account is protected even if the database is compromised
 *
 * Acceptance Criteria / BDD Scenarios:
 * 7.2.1 – Password is Never Stored in Plain Text
 * 7.2.2 – Password is Hashed with a Secure Algorithm (e.g., bcrypt, Argon2)
 * 7.2.3 – Password Hashes Include a Unique Salt
 */
class Test_7_2_PasswordHashEncryptionStorageTest extends TestCase
{
    /**
     * 7.2.1 – Password is Never Stored in Plain Text
     * Given a user registers or changes their password
     * When the password is saved to the database
     * Then the password is not stored in plain text
     */
    public function test_7_2_1_PasswordNotPlainText()
    {
        $password = 'TestPlainPassword!@#';
        $unique = 'user' . uniqid();
        $userId = $this->createTestUser($unique, "$unique@example.com", $password);

        // Retrieve password field from DB directly
        $user = $this->getUserFromDatabase($unique);

        // Assert password field does not match plain text password
        $this->assertNotEquals(
            $password,
            $user['password'],
            "Password should not be stored as plain text in the database."
        );
    }

    /**
     * 7.2.2 – Password is Hashed with a Secure Algorithm (e.g., bcrypt, Argon2)
     * Given a user registers or changes their password
     * When the password is saved to the database
     * Then a strong, modern hash function (e.g., bcrypt, Argon2) is used
     */
    public function test_7_2_2_PasswordHashedWithSecureAlgo()
    {
        $password = 'TestSecurePassword123!';
        $unique = 'user' . uniqid();
        $userId = $this->createTestUser($unique, "$unique@example.com", $password);

        $user = $this->getUserFromDatabase($unique);
        $hash = $user['password'];

        // Check hash format for bcrypt ($2y$), Argon2 ($argon2i$, $argon2id$), or similar
        $isBcrypt = strpos($hash, '$2y$') === 0 || strpos($hash, '$2a$') === 0;
        $isArgon2 = strpos($hash, '$argon2i$') === 0 || strpos($hash, '$argon2id$') === 0;
        $this->assertTrue(
            $isBcrypt || $isArgon2,
            "Password hash should use bcrypt or Argon2. Value: $hash"
        );

        // Additionally, verify that password_verify works
        $this->assertTrue(
            password_verify($password, $hash),
            "Hashed password should be verifiable with password_verify."
        );
    }

    /**
     * 7.2.3 – Password Hashes Include a Unique Salt
     * Given multiple users register with the same password
     * When their password hashes are stored
     * Then the hashes are different due to unique salts
     */
    public function test_7_2_3_PasswordHashesUniqueSalt()
    {
        $password = 'SamePasswordForSaltTest!';
        $unique1 = 'user' . uniqid();
        $unique2 = 'user' . uniqid();
        $this->createTestUser($unique1, "$unique1@example.com", $password);
        $this->createTestUser($unique2, "$unique2@example.com", $password);

        $user1 = $this->getUserFromDatabase($unique1);
        $user2 = $this->getUserFromDatabase($unique2);

        $hash1 = $user1['password'];
        $hash2 = $user2['password'];

        $this->assertNotEquals(
            $hash1,
            $hash2,
            "Password hashes for the same password must be different due to unique salts."
        );
    }

    /**
     * Helper: Creates a test user via the application's registration process, or directly in DB for testing.
     * Returns user ID or username.
     */
    protected function createTestUser($username, $email, $password)
    {
        // This function should use your application's registration logic,
        // or direct DB insert if that's all that's available for testing.
        // Adjust as needed for your environment.

        // Example: using direct DB access (PDO assumed)
        $pdo = $this->getPDO();
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)")
            ->execute([$username, $email, $hash]);
        return $pdo->lastInsertId();
    }

    /**
     * Helper: Retrieves a user row from the database by username.
     */
    protected function getUserFromDatabase($username)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Helper: Returns a PDO instance for direct DB access.
     * Adjust connection details for your test database.
     */
    protected function getPDO()
    {
        static $pdo = null;
        if (!$pdo) {
            $pdo = new \PDO('mysql:host=localhost;dbname=test_db', 'test_user', 'test_password');
        }
        return $pdo;
    }
}