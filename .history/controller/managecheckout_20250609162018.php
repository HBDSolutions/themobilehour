<?php
session_start();
require_once("../model/database.php");
require_once("../model/functions.php");

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

// Fetch user info if logged in
$user = null;
if (isset($_SESSION['userID'])) {
    $user = get_user_by_id($_SESSION['userID']);
}

// Prepare cart summary
$cart_items = $_SESSION['cart'];
$cart_total = 0;
$products = [];
foreach ($cart_items as $item) {
    $product = get_product_by_id($item['product_ID']);
    if ($product) {
        $product['quantity'] = $item['quantity'];
        $product['subtotal'] = $product['price'] * $item['quantity'];
        $cart_total += $product['subtotal'];
        $products[] = $product;
    }
}
$gst = $cart_total * 0.1;
$purchase_total = $cart_total + $gst;

// Pass all data to the view
include("../view/checkout.php");