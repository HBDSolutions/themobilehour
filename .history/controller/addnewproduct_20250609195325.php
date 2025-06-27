<?php 
include_once("../model/database.php");
require_once("../model/functions.php");

// the following statement can be used for debugging to output the values passed from the form page and stop processing the page
//die(var_dump($_POST));

$filedir = 'assets/images/';

$product_Name = $_POST['product_Name'] ?? '';
$manufacturer_ID = $_POST['manufacturer'] ?? '';
$product_Description = $_POST['product_Description'] ?? '';
$stock_on_hand = $_POST['stock_on_hand'] ?? '';
$price = $_POST['price'] ?? '';
$filedir = 'assets/images/';
$image = '';
if (isset($_FILES['image']) && $_FILES['image']['name']) {
    $image = $filedir . basename($_FILES['image']['name']);
}

//call the add_product() function and pass the variables
$result = add_product($product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image);

if (!$result) {
    echo ("A problem occurred");
}

else {
    header('Location: ../view/admin_product.php');
}

?>