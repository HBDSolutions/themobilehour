<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

session_start();

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
if (!$email || !preg_match('/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+$/', $email)) {
    $errors[] = "Username must be in the format xxxxxxx@xxxx (letters, numbers, and dots allowed, no TLD required).";
}
if (!$password) $errors[] = "Password is required.";
if (!is_valid_password($password)) $errors[] = "Password does not meet requirements.";

if (!empty($errors)) {
    header('Location: /themobilehour/controller/managecustomers.php?action=add&error=' . urlencode(implode(' ', $errors)));
    exit();
}

if (email_exists($conn, $email)) {
    header('Location: /themobilehour/controller/managecustomers.php?action=add&error=Email already registered.');
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
    // If admin manager adds an admin user
    if (isset($_SESSION['permissionsID']) && $_SESSION['permissionsID'] == 3 && $permissionsID != 1) {
        header('Location: /themobilehour/controller/manageadmin.php?action=users&success=User added successfully.');
        exit();
    }
    // If admin manager or admin adds a customer (or admin_add is set)
    if (
        (isset($_SESSION['permissionsID']) && in_array($_SESSION['permissionsID'], [2, 3]) && $permissionsID == 1)
        || (isset($_POST['admin_add']) && $_POST['admin_add'] == 1)
    ) {
        header('Location: /themobilehour/controller/managecustomers.php?success=Customer added successfully.');
        exit();
    }
    // If a user self-registers as a customer (no admin session)
    // Log them in:
    $user = get_user_by_email($conn, $email); // You need this function in your model
    if ($user) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['userID'] = $user['userID'];
        $_SESSION['permissionsID'] = $user['permissionsID'];
    }
    header('Location: /themobilehour/controller/managecustomers.php?success=Registration successful.');
    exit();
}
?>