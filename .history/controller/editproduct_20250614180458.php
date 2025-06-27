<?php 
include_once("../model/database.php");
require_once("../model/functions.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
else {
    header('Location: /themobilehour/controller/manageproducts.php');
}

// the following statement can be used for debugging to output the values passed from the form page and stop processing the page
//die(var_dump($_POST));


$filedir = 'assets/images/';

// assign the form data to the relevant variables
if (isset($_POST['product_Name'])) {
    $product_Name = $_POST['product_Name'];
}
if (isset($_POST['manufacturer'])) {
    $manufacturer_ID = $_POST['manufacturer'];
}
if (isset($_POST['description'])) {
    $product_Description = $_POST['description'];
}
if (isset($_POST['stock'])) {
    $stock_on_hand = $_POST['stock'];
}
if (isset($_POST['price'])) {
    $price = $_POST['price'];
}

// if no new file has been added then set the image value to the existing value
if($_FILES['image']['size'] == 0) {
    $image = $_POST['image'];    
}
// if a new file for upload has been added set the filename to the new file
else {
    $image = $filedir . basename($_FILES['image']['name']);
}    

//call the update_product() function and pass the variables including the primary key for the record to be updated
$result = update_product($id, $product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image);

if (!$result) {
    echo ("A problem occurred");
}

else {
    header('Location: /themobilehour/controller/manageproducts.php');
}

?>