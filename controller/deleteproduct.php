<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        // Optionally fetch product data before deletion for logging
        $stmt = $conn->prepare("SELECT * FROM products WHERE product_ID = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // FIX: Pass both $conn and $id to delete_product
        $result = delete_product($conn, $id);

        if ($result) {
            // FIX: Pass $conn as the first argument to log_change
            log_change($conn, $_SESSION['userID'], 'product', $id, 'delete', json_encode(['deleted' => $product_data]));
            header('Location: /themobilehour/controller/manageproducts.php?success=Product deleted successfully.');
            exit();
        } else {
            header('Location: /themobilehour/controller/manageproducts.php?error=Failed to delete product.');
            exit();
        }
    } catch (PDOException $e) {
        if ($e->getCode() == '23000') {
            header('Location: /themobilehour/controller/manageproducts.php?error=Cannot delete product: it is referenced in existing orders.');
            exit();
        } else {
            header('Location: /themobilehour/controller/manageproducts.php?error=Database error: ' . urlencode($e->getMessage()));
            exit();
        }
    }
} else {
    header('Location: /themobilehour/controller/manageproducts.php?error=No product ID specified.');
    exit();
}
?>