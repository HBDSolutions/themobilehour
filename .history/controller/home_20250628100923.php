<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

// Fetch manufacturers for the filter
$manufacturers = get_all_manufacturers($conn);

// Fetch filtered specials (products with special=1)
$manufacturer_ID = $_GET['manufacturer_ID'] ?? null;
$min_price = $_GET['min_price'] ?? null;
$max_price = $_GET['max_price'] ?? null;
$search = $_GET['search'] ?? null;

$specials = get_filtered_products($manufacturer_ID, $min_price, $max_price, $search, true);

include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/index.php");