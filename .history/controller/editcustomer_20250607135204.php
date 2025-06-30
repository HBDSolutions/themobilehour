<?php 
include_once("../model/database.php");
require_once("../model/functions.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
else {
    header('Location: ../view/admin_customers.php');
}

// the following statement can be used for debugging to output the values passed from the form page and stop processing the page
// die(var_dump($_POST));


$filedir = 'images/';

if (isset($_POST['firstname'])) {
    $firstname = $_POST['firstname'];
}
if (isset($_POST['lastname'])) {
    $lastname = $_POST['lastname'];
}
if (isset($_POST['username'])) {
    $username = $_POST['username'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_BCRYPT);
}
if (isset($_POST['shipping_address'])) {
    $shipping_address = $_POST['shipping_address'];
} else {
    $shipping_address = null;
}
if (isset($_POST['permissionsID'])) {
    $permissionsID = $_POST['permissionsID'];
} else {
    $permissionsID = 1;
}
if (isset($_POST['isActive'])) {
    $isActive = $_POST['isActive'];
} else {
    $isActive = 1;
}

//call the update_user() function and pass the variables including the primary key for the record to be updated
$result = update_user($id, $firstname, $lastname, $username, $password, $shipping_address, $permissionsID, $isActive);

if (!$result) {
    echo ("A problem occurred");
}

else {
    header('Location: ../view/admin_customers.php');
}

?>