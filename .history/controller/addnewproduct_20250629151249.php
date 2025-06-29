<?php 
include_once("../model/database.php");
require_once("../model/functions.php");

session_start();

// Optionally, add permission checks for admin/manager here
if (!isset($_SESSION['permissionsID']) || $_SESSION['permissionsID'] < 2) {
    header("Location: /themobilehour/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch manufacturers for the dropdown
    $stmt = $conn->query("SELECT manufacturer_ID, manufacturer_Name FROM manufacturer");
    $manufacturers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/add_product.php");
    exit();
}

// POST: Process form submission
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
$result = add_product($conn, $product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image, $featureID);

if (!$result) {
    echo ("A problem occurred");
} else {
    header('Location: /themobilehour/controller/manageproducts.php');
}
?>