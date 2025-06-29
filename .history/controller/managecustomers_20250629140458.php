<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");

if (isset($_SESSION['permissionsID'])) {
    if ($_SESSION['permissionsID'] == 1) {
        // Customer: show their account page
        // Fetch user info for the view
        $userID = $_SESSION['userID'];
        $sql = "SELECT user.*, permissions.permissions_role 
                FROM user 
                LEFT JOIN permissions ON user.permissionsID = permissions.permissionsID 
                WHERE user.userID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        $is_own_account = true;
        $hideRoleAndStatus = (isset($user['permissions_role']) && $user['permissions_role'] === 'Customer');
        $accountTitle = 'My Account';

        include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/account_user.php");
        exit();
    } elseif (in_array($_SESSION['permissionsID'], [2, 3])) {
        // Admin/Manager: show customer admin
        include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/admin_customers.php");
        exit();
    }
}

// Not logged in: show registration form
include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/register.php");
exit();
?>