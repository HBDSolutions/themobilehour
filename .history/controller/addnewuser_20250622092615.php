<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

// the following statement can be used for debugging to output the values passed from the form page and stop processing the page
// die(var_dump($_POST));


$filedir = 'images/';

// Sanitize input
$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING));
$lastname = trim(filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING));
$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$password = $_POST['password'] ?? '';
$shipping_address = trim(filter_input(INPUT_POST, 'shipping_address', FILTER_SANITIZE_STRING));
$permissionsID = intval($_POST['permissionsID'] ?? 1);
$isActive = 1;

// Validate input
$errors = [];
if (!$firstname) $errors[] = "First name is required.";
if (!$lastname) $errors[] = "Last name is required.";
if (!$email || !preg_match('/^[a-zA-Z0-9]+@[a-zA-Z0-9]+$/', $email)) {
    $errors[] = "Username must be in the format xxxxxxx@xxxx (letters/numbers only, no dots or TLD).";
}
if (!$password) $errors[] = "Password is required.";
if (!is_valid_password($password)) $errors[] = "Password does not meet requirements.";

if (!empty($errors)) {
    header('Location: /themobilehour/controller/manageadmin.php?action=adduser&error=' . urlencode(implode(' ', $errors)));
    exit();
}

if (email_exists($email)) {
    header('Location: /themobilehour/controller/manageadmin.php?action=adduser&error=Email already registered.');
    exit();
}

// check to see if a profile image has been added
// set the profile image filepath if an image has been addedd
//if($_FILES['profileimage']['size'] != 0) {
//    $profileimage = $filedir . basename($_FILES['profileimage']['name']);
//}
// set a default profile image if no image has been added
//else {
//    $profileimage = $default_image;
//}


// Call the model function
$result = add_new_user($conn, $firstname, $lastname, $email, $password, $shipping_address, $permissionsID, $isActive);

if ($result) {
    header('Location: /themobilehour/controller/manageadmin.php?action=users&success=User added successfully.');
    exit();
} else {
    header('Location: /themobilehour/controller/manageadmin.php?action=adduser&error=Failed to add user.');
    exit();
}
?>