<?php
session_start();
require_once("../model/database.php");
require_once("../model/functions.php");

// Validate cart and form data
if (empty($_SESSION['cart']) || empty($_POST)) {
    header("Location: ../view/cart.php");
    exit;
}

$userID = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
$address = trim($_POST['address']);
$cart_items = $_SESSION['cart'];

// Calculate total
$cart_total = 0;
foreach ($cart_items as $item) {
    $product = get_product_by_id($conn, $item['product_ID']);
    if ($product) {
        $cart_total += $product['price'] * $item['quantity'];
    }
}
$gst = $cart_total * 0.1;
$purchase_total = $cart_total + $gst;

// Insert order (status default to 'Pending', created_at auto, order_date = NOW())
$order_id = add_order($conn, $userID, $address, $purchase_total);

if ($order_id) {
    foreach ($cart_items as $item) {
        $product = get_product_by_id($conn, $item['product_ID']);
        if ($product) {
            add_order_item($conn, $order_id, $item['product_ID'], $item['quantity'], $product['price']);
        }
    }
    // Log the new order creation
    log_change(
        $conn
        $_SESSION['userID'],
        'order',
        $order_id,
        'insert',
        json_encode([
            'address' => $address,
            'total' => $purchase_total,
            'items' => $cart_items
        ])
    );
    unset($_SESSION['cart']); // Clear cart
    header("Location: ../view/payment_successful.php");
    exit;
} else {
    echo "Order could not be processed. Please try again.";
}