<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");

if (
    !isset($_SESSION['permissions_role']) ||
    $_SESSION['permissions_role'] !== 'Administration Manager'
) {
    header("Location: /themobilehour/controller/managecustomers.php?error=unauthorized");
    exit();
}

if (isset($_GET['userID'])) {
    $userID = intval($_GET['userID']);

    // Fetch the permissionsID for the user being deleted
    $stmt = $conn->prepare("SELECT permissionsID FROM user WHERE userID = ?");
    $stmt->execute([$userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $permissionsID = $user ? intval($user['permissionsID']) : null;

    if (delete_user($conn, $userID)) {
        if ($permissionsID === 1) {
            header("Location: /themobilehour/controller/managecustomers.php?success=User deleted successfully.");
        } else {
            header("Location: /themobilehour/controller/manageadmin.php?action=users&success=User deleted successfully.");
        }
        exit();
    } else {
        if ($permissionsID === 1) {
            header("Location: /themobilehour/controller/managecustomers.php?error=Delete failed.");
        } else {
            header("Location: /themobilehour/controller/manageadmin.php?action=users&error=Delete failed.");
        }
        exit();
    }
} else {
    header("Location: /themobilehour/controller/managecustomers.php?error=Missing user ID.");
    exit();
}
?>