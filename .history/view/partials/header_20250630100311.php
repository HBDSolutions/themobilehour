<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set $userHasOrders for nav menu
$userHasOrders = false;
if (
    isset($_SESSION['userID'], $_SESSION['permissionsID']) &&
    $_SESSION['permissionsID'] == 1 // Customer
) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");
    $userHasOrders = user_has_active_orders($conn, $_SESSION['userID']);
}
?>
<header class="header">
    <?php include_once "nav.php"; ?>
    <h1 class="site_title">The Mobile Hour</h1>
    
    <script>
        function toggleMenu() {
            var menu = document.getElementById('main-menu');
            var btn = document.getElementById('menu-btn');
            menu.classList.toggle('show');
            btn.classList.toggle('active');
        }
    </script>
</header>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/login.php"); ?>