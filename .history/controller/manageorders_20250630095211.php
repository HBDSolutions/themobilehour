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
$permissionsID = $_SESSION['permissionsID'] ?? 0;

// Status options for dropdown
$statuses = ['Pending', 'Packaged', 'Despatched', 'Delivered'];
// Only permissionsID 2 and 3 can edit status
$can_edit_status = in_array($permissionsID, [2, 3]);

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
        $order['items'] = get_order_items($conn, $order['orderID']);
    }
    unset($order);
} else {
    $orders = get_all_orders_with_items($conn);
    // Only show active orders (not delivered)
    $orders = array_filter($orders, function($order) {
        return $order['order_status'] !== 'Delivered';
    });
}

include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_orders.php");
?>