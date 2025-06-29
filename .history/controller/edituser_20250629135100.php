<?php
session_start();
require_once("../model/database.php");
require_once("../model/functions.php");

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ../index.php");
    exit();
}

// If form is submitted (POST), process update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch old data before update
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $old_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Collect new data from POST
    $firstname = $_POST['firstname'] ?? $old_data['firstname'];
    $lastname = $_POST['lastname'] ?? $old_data['lastname'];
    $username = $_POST['username'] ?? $old_data['username'];
    $password = isset($_POST['password']) && $_POST['password'] !== '' ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $old_data['password'];
    $shipping_address = $_POST['shipping_address'] ?? $old_data['shipping_address'];
    $permissionsID = $_POST['permissionsID'] ?? $old_data['permissionsID'];
    $isActive = $_POST['isActive'] ?? $old_data['isActive'];

    // Update user
    $result = update_user($conn, $id, $firstname, $lastname, $username, $password, $shipping_address, $permissionsID, $isActive);

    // Fetch new data after update
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $new_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Log the change
    log_change($conn, $_SESSION['userID'], 'user', $id, 'update', json_encode(['before' => $old_data, 'after' => $new_data]));

    if (!$result) {
        echo ("A problem occurred");
        exit();
    } else {
        // Admin manager edits admin user
        if (isset($_SESSION['permissionsID']) && $_SESSION['permissionsID'] == 3 && $permissionsID != 1) {
            header('Location: /themobilehour/controller/manageadmin.php?action=users&success=User updated successfully.');
            exit();
        }
        // Admin manager or admin edits customer
        if (isset($_SESSION['permissionsID']) && in_array($_SESSION['permissionsID'], [2, 3]) && $permissionsID == 1) {
            header('Location: /themobilehour/controller/manageadmin.php?action=customers&success=Customer updated successfully.');
            exit();
        }
        // Customer edits their own account
        header('Location: /themobilehour/view/account.php?success=Account updated successfully.');
        exit();
    }
}

// If GET, show the user account view
// Fetch user data for display
$sql = "SELECT user.*, permissions.permissions_role 
        FROM user 
        LEFT JOIN permissions ON user.permissionsID = permissions.permissionsID 
        WHERE user.userID = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

// Set variables for the view
$is_own_account = (isset($_SESSION['userID']) && $_SESSION['userID'] == $id);
$hideRoleAndStatus = ($is_own_account && isset($user['permissions_role']) && $user['permissions_role'] === 'Customer');

if ($is_own_account) {
    $accountTitle = 'My Account';
} elseif (isset($user['permissions_role']) && $user['permissions_role'] === 'Customer') {
    $accountTitle = 'Customer Account';
} else {
    $accountTitle = 'User Account';
}

include("../view/account_user.php");
?>