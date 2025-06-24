
<?php

require_once __DIR__ . '/../../../model/functions.php';

use PHPUnit\Framework\TestCase;

/**
 * Test 1.1 – Customer Account Registration
 *
 * User Story:
 * As a website visitor,
 * I need to create and register a customer account,
 * So that I can use saved data to buy, track and view history.
 *
 * Acceptance Criteria / BDD Scenarios:
 * 1.1.1 – Successful Account Registration
 * 1.1.2 – Duplicate Email Registration
 * 1.1.3 – Missing Required Fields
 * 1.1.4 – Password Validation
 * 1.1.5 – View Account Data After Registration
 */
class Test_1_1_RegisterCustomerTest extends TestCase
{
    /*
    * 1.1.1 – Successful Account Registration
    * Given a website visitor is on the registration page  
    * When the visitor submits valid registration details (e.g., name, email, password, and any required fields)  
    * Then  
    * - A new customer account is created  
    * - The user is informed of successful registration  
    * - The user is logged in and redirected to their account/dashboard page
    */
    public function test_1_1_1_SuccessfulRegistration()
    {
        $_POST = [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'username' => 'john@example.com',
            'password' => 'SecurePass123!',
            'shipping_address' => '123 Main St'
        ];
        $result = register_customer($_POST);
        $this->assertTrue($result);

        $user = get_user_by_username('john@example.com');
        $this->assertNotEquals('SecurePass123!', $user['password']);
        $this->assertTrue(password_verify('SecurePass123!', $user['password']));
    }

    /*
    * 1.1.2 – Duplicate Email Registration
    * Given a website visitor attempts to register using an email address already associated with an existing account  
    * When the visitor submits the registration form  
    * Then  
    * - Registration fails  
    * - The user is shown a clear error message indicating the email is already in use
    */
    public function test_1_1_2_DuplicateEmailRegistration()
    {
        $_POST = [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'username' => 'existing@example.com',
            'password' => 'Pass123!',
            'shipping_address' => '456 Oak St'
        ];
        $result = register_customer($_POST);
        $this->assertFalse($result);
        $this->assertStringContainsString('already exists', get_last_error_message());
    }

    /*
    * 1.1.3 – Missing Required Fields
    * Given a website visitor is on the registration page  
    * When the visitor submits the form with one or more required fields left blank  
    * Then  
    * - Registration fails  
    * - The user is shown errors indicating which fields are missing or invalid
    */
    public function test_1_1_3_MissingRequiredFields()
    {
        $_POST = [
            'firstname' => '',
            'lastname' => '',
            'username' => '',
            'password' => '',
            'shipping_address' => ''
        ];
        $result = register_customer($_POST);
        $this->assertFalse($result);
        $this->assertStringContainsString('required', get_last_error_message());
    }

    /*
    * 1.1.4 – Password Validation
    * Given a website visitor is on the registration page  
    * When the visitor submits a password that does not meet complexity requirements (e.g., too short, lacks numbers/special characters)  
    * Then  
    * - Registration fails  
    * - The user receives an error message describing the password requirements
    */
    public function test_1_1_4_PasswordValidation()
    {
        $_POST = [
            'firstname' => 'Sam',
            'lastname' => 'Adams',
            'username' => 'sam@example.com',
            'password' => 'short',
            'shipping_address' => '789 Pine St'
        ];
        $result = register_customer($_POST);
        $this->assertFalse($result);
        $this->assertStringContainsString('password', get_last_error_message());
    }

    /*
    * 1.1.5 – View Account Data After Registration
    * Given a user has successfully registered and is logged in  
    * When the user navigates to their account page  
    * Then  
    * - The user can view their account details  
    * - The user can access options to buy, track orders, and view order history
    */
    public function test_1_1_5_ViewAccountDataAfterRegistration()
    {
        $_POST = [
            'firstname' => 'Alice',
            'lastname' => 'Wonderland',
            'username' => 'alice@example.com',
            'password' => 'CheshireCat42!',
            'shipping_address' => 'Rabbit Hole'
        ];
        register_customer($_POST);

        $user = get_user_by_username('alice@example.com');
        $this->assertEquals('Alice', $user['firstname']);
        $this->assertEquals('Wonderland', $user['lastname']);
        $this->assertEquals('alice@example.com', $user['username']);
        $this->assertEquals('Rabbit Hole', $user['shipping_address']);

        $this->assertTrue(can_access_order_history($user));
        $this->assertTrue(can_track_orders($user));
        $this->assertTrue(can_buy($user));
    }
}
