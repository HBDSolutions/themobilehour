<?php 
include_once("../model/database.php");
require_once("../model/functions.php");

// the following statement can be used for debugging to output the values passed from the form page and stop processing the page
//die(var_dump($_POST));

$filedir = 'assets/images/';

// Gather product fields
$product_Name = $_POST['product_Name'] ?? '';
$manufacturer_ID = $_POST['manufacturer'] ?? '';
$product_Description = $_POST['product_Description'] ?? '';
$stock_on_hand = $_POST['stock_on_hand'] ?? '';
$price = $_POST['price'] ?? '';
$image = '';
if (isset($_FILES['image']) && $_FILES['image']['name']) {
    $image = $filedir . basename($_FILES['image']['name']);
}

// Gather features fields
$weight = $_POST['weight'] ?? null;
$height = $_POST['height'] ?? null;
$width = $_POST['width'] ?? null;
$thickness = $_POST['thickness'] ?? null;
$operating_system = $_POST['operating_system'] ?? null;
$screensize = $_POST['screensize'] ?? null;
$resolution = $_POST['resolution'] ?? null;
$cpu = $_POST['cpu'] ?? null;
$ram = $_POST['ram'] ?? null;
$storage = $_POST['storage'] ?? null;
$battery = $_POST['battery'] ?? null;
$rear_camera = $_POST['rear_camera'] ?? null;
$front_camera = $_POST['front_camera'] ?? null;

// Insert features first
$sql = "INSERT INTO features (weight, height, width, thickness, operating_system, screensize, resolution, cpu, ram, storage, battery, rear_camera, front_camera)
        VALUES (:weight, :height, :width, :thickness, :operating_system, :screensize, :resolution, :cpu, :ram, :storage, :battery, :rear_camera, :front_camera)";
$stmt = $conn->prepare($sql);
$stmt->execute([
    ':weight' => $weight,
    ':height' => $height,
    ':width' => $width,
    ':thickness' => $thickness,
    ':operating_system' => $operating_system,
    ':screensize' => $screensize,
    ':resolution' => $resolution,
    ':cpu' => $cpu,
    ':ram' => $ram,
    ':storage' => $storage,
    ':battery' => $battery,
    ':rear_camera' => $rear_camera,
    ':front_camera' => $front_camera
]);
$featureID = $conn->lastInsertId();

// Call the add_product() function and pass the variables, including $featureID
$result = add_product($product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image, $featureID);

if (!$result) {
    echo ("A problem occurred");
} else {
    header('Location: ../view/admin_product.php');
}
?>