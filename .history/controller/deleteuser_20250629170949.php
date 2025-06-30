<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

if (
    !isset($_SESSION['permissions_role']) ||
    $_SESSION['permissions_role'] !== 'Administration Manager'
) {
    header("Location: /themobilehour/controller/managecustomers.php?error=unauthorized");
    exit();
}

if (isset($_GET['userID'])) {
    $userID = intval($_GET['userID']);
    if (delete_user($conn,$userID)) {
        header("Location: /themobilehour/controller/managecustomers.php?success=User deleted successfully.");
        exit();
    } else {
        header("Location: /themobilehour/controller/managecustomers.php?error=Delete failed.");
        exit();
    }
} else {
    header("Location: /themobilehour/controller/managecustomers.php?error=Missing user ID.");
    exit();
}
?>