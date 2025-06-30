<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");

// If admin/manager clicked "Add Customer"
if (isset($_GET['action']) && $_GET['action'] === 'add') {
    $isAdminAdding = (isset($_SESSION['permissionsID']) && in_array($_SESSION['permissionsID'], [2, 3]));
    $registerTitle = $isAdminAdding ? "Register New Customer (Admin)" : "Customer Registration";
    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/register.php");
    exit();
}

// If the user is a customer, show their account page
if (isset($_SESSION['permissionsID']) && $_SESSION['permissionsID'] == 1) {
    $userID = $_SESSION['userID'];
    $sql = "SELECT user.*, permissions.permissions_role 
            FROM user 
            LEFT JOIN permissions ON user.permissionsID = permissions.permissionsID 
            WHERE user.userID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    $is_own_account = true;
    $hideRoleAndStatus = (isset($user['permissions_role']) && $user['permissions_role'] === 'Customer');
    $accountTitle = 'My Account';

    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/account_user.php");
    exit();
}

// If admin/manager, show customer admin page
if (isset($_SESSION['permissionsID']) && in_array($_SESSION['permissionsID'], [2, 3])) {
    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_customers.php");
    exit();
}

// Not logged in: show registration form
$registerTitle = "Customer Registration";
include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/register.php");
exit();
?>