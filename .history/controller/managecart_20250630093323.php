<?php
session_start();
require_once("../model/database.php");
require_once("../model/functions.php");

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$product_id = intval($_GET['id'] ?? $_POST['product_ID'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);

if ($action === 'add' && $product_id > 0) {
    add_to_cart($product_id, $quantity);
    header("Location: managecart.php");
    exit();
} elseif ($action === 'remove' && $product_id > 0) {
    remove_from_cart($product_id);
    header("Location: managecart.php");
    exit();
}

// --- Display the cart ---
$cart_items = $_SESSION['cart'] ?? [];
$cart_total = 0;
$products = [];
foreach ($cart_items as $item) {
    $product = get_product_by_id($conn, $item['product_ID']);
    if ($product) {
        $product['quantity'] = $item['quantity'];
        $product['subtotal'] = $product['price'] * $item['quantity'];
        $cart_total += $product['subtotal'];
        $products[] = $product;
    }
}

// Calculate GST and purchase total for the view
$gst = $cart_total * 0.1;
$purchase_total = $cart_total + $gst;

// Pass all data to the view
include("../view/cart.php");
exit();
?>