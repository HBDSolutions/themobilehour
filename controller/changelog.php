<?php
session_start();
require_once("../model/database.php");
require_once("../model/functions.php");

$sql = "SELECT cl.*, u.firstname AS changed_by_firstname, u.lastname AS changed_by_lastname
        FROM change_log cl
        LEFT JOIN user u ON cl.changed_by = u.userID
        ORDER BY cl.change_time DESC";
$stmt = $conn->query($sql);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

include("../view/change_log.php");