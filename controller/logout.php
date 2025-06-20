<?php 
    session_start(); 
    session_destroy(); 
    header("Location: /themobilehour/controller/home.php");
?>
