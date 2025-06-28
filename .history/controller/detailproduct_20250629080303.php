<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

if (!isset($_SESSION['user']) || !in_array($_SESSION['permissionsID'], [2, 3])) {
    header("Location: /themobilehour/controller/home.php");
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $result = delete_product($conn, $id); // Pass both $conn and $id
    if ($result) {
        header("Location: /themobilehour/controller/manageproducts.php?success=Product deleted successfully.");
    } else {
        header("Location: /themobilehour/controller/manageproducts.php?error=Failed to delete product.");
    }
    exit();
} else {
    header("Location: /themobilehour/controller/manageproducts.php?error=No product ID specified.");
    exit();
}
?>