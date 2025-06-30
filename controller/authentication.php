<?php 
//start session management 
session_start(); 
//connect to the database 
require($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php"); 
//retrieve the functions 
require($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php"); 

//retrieve the username and password entered into the form 
$username = $_POST["username"]; 
$password = $_POST["password"]; 

// Call the login() function (it should use password_verify internally)
$login_success = login($conn, $username, $password);

if ($login_success) { 
    // Fetch the user's info and permissions
    $sql = "SELECT user.userID, user.firstname, user.permissionsID, permissions.permissions_role 
            FROM user 
            JOIN permissions ON user.permissionsID = permissions.permissionsID 
            WHERE user.username = :username";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetch();

    $_SESSION["user"] = $username; 
    $_SESSION["userID"] = $user['userID'];
    $_SESSION["firstname"] = $user['firstname'];
    $_SESSION["permissionsID"] = $user['permissionsID'];
    $_SESSION["permissions_role"] = $user['permissions_role'];
    $_SESSION["success"] = $user['firstname'] . ". Welcome to the administration dashboard! What would you like to do next?";

    if ($user['permissions_role'] === 'Customer') {
        // Customers go to their account controller
        header("Location: /themobilehour/controller/edituser.php?id=" . $user['userID']);
    } elseif (
        $user['permissions_role'] === 'Administrator' ||
        $user['permissions_role'] === 'Administration Manager'
    ) {
        // Admins and managers go to the admin dashboard via controller
        header("Location: /themobilehour/controller/manageadmin.php");
    } else {
        // All others: show error and redirect to login
        $_SESSION["error"] = "You do not have permission to access this area.";
        header("Location: /themobilehour/controller/home.php");
    }
    exit();
} else { 
    $_SESSION["error"] = "Incorrect username or password. Please try again."; 
    header("Location: /themobilehour/controller/home.php"); 
    exit();
}
?>