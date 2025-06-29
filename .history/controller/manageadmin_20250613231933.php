<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");

// Permissions check: only allow permissionsID 2 or 3
if (!isset($_SESSION['user']) || !in_array($_SESSION['permissionsID'], [2, 3])) {
    header("Location: /themobilehour/controller/home.php");
    exit();
}

$permissionsID = $_SESSION['permissionsID'];
$action = $_GET['action'] ?? null;

// Only Admin Manager can access User Admin page
if ($action === 'users' && $permissionsID == 3) {
    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_users.php");
    exit();
}
if ($action === 'adduser' && $permissionsID == 3) {
    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/add_user.php");
    exit();
}

// If action is users/adduser but not permissionsID 3, redirect to home
if (in_array($action, ['users', 'adduser']) && $permissionsID != 3) {
    header("Location: /themobilehour/controller/home.php");
    exit();
}

// Default: show admin home (both 2 and 3)
include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_home.php");
exit();
?>