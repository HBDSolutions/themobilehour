<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
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

    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/login.php"); ?>
</header>