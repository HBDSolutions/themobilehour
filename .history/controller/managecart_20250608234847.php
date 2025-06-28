<?php
session_start();
require_once("../model/functions.php");

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$product_id = intval($_GET['id'] ?? $_POST['product_ID'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1); // ✅ get the quantity properly

if ($action === 'add' && $product_id > 0) {
    add_to_cart($product_id, $quantity); // ✅ pass the quantity!
} elseif ($action === 'remove' && $product_id > 0) {
    remove_from_cart($product_id);
}

header("Location: ../view/cart.php");
exit();
