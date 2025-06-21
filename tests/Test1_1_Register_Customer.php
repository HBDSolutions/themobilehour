<?php
use PHPUnit\Framework\TestCase;

class Test1_1_Register_Customer extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Require your DB connection and functions
        require __DIR__ . '/../model/database.php';
        $this->conn = $conn;

        require_once __DIR__ . '/../model/functions.php';
    }

    public function testCustomerCanRegisterAccount()
    {
        $conn = $this->conn;

        $this->assertNotNull($conn, "Database connection (\$conn) should not be null.");

        $email = 'testuser_' . uniqid() . '@example.com';
        $firstname = 'Test';
        $lastname = 'User';
        $password = 'Secret123!';
        $shipping_address = '123 Test Lane, Testville';
        $permissionsID = 2; // Set to your 'customer' role ID
        $isActive = 1;

        // Clean up just in case
        $conn->exec("DELETE FROM user WHERE username = '$email'");

        add_new_user($conn, $firstname, $lastname, $email, $password, $shipping_address, $permissionsID, $isActive);

        $stmt = $conn->prepare("SELECT * FROM user WHERE username = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        $this->assertNotFalse($user, "User should be registered and exist in the database.");
        $this->assertEquals($firstname, $user['firstname']);
        $this->assertEquals($lastname, $user['lastname']);
        $this->assertEquals($email, $user['username']);
        $this->assertEquals($shipping_address, $user['shipping_address']);
        $this->assertEquals($permissionsID, $user['permissionsID']);
        $this->assertEquals($isActive, $user['isActive']);
        $this->assertTrue(password_verify($password, $user['password']), "Password should be hashed and verifiable.");

        // Clean up after test
        $conn->exec("DELETE FROM user WHERE username = '$email'");
    }
}