<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

$action = $_GET['action'] ?? null;

$manufacturer_ID = $_GET['manufacturer_ID'] ?? null;
$min_price = $_GET['min_price'] ?? null;
$max_price = $_GET['max_price'] ?? null;
$search = $_GET['search'] ?? null;

$manufacturers = get_all_manufacturers($conn);
$products = get_filtered_products($conn, $manufacturer_ID, $min_price, $max_price, $search);

if ($action === 'public') {
    // Public products page (no login required)
    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/products.php");
    exit();
}

// Admin/manager only for manage products
if (!isset($_SESSION['user']) || !in_array($_SESSION['permissionsID'], [2, 3])) {
    header("Location: /themobilehour/controller/home.php");
    exit();
}

// Default: admin product management
include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_product.php");
exit();
?>