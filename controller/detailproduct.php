<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");

$product_id = intval($_GET['id'] ?? 0);
$product = ($product_id > 0) ? get_product_with_features($conn, $product_id) : null;

include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/product_detail.php");
exit();
?>