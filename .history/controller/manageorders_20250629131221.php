<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

// Get the userID from session or GET
$userID = $_SESSION['userID'] ?? $_GET['userID'] ?? null;

// Only allow access if logged in
if (!$userID) {
    header("Location: ../index.php");
    exit();
}

$role = $_SESSION['permissions_role'] ?? null;

if ($role === 'Customer') {
    $orders = get_orders_by_user($conn, $userID);
    $stmt = $conn->prepare("SELECT firstname, lastname, username FROM user WHERE userID = :userID");
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    foreach ($orders as &$order) {
        $order['firstname'] = $user['firstname'];
        $order['lastname'] = $user['lastname'];
        $order['username'] = $user['username'];
        $order['items'] = get_order_items($order['orderID']);
    }
    unset($order);
} else {
    $orders = get_all_orders_with_items();
}

include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_orders.php");

?>