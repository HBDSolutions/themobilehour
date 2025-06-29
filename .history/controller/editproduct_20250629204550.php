<?php
include_once("../model/database.php");
require_once("../model/functions.php");

if (!isset($_GET['id'])) {
    header('Location: /themobilehour/controller/manageproducts.php');
    exit();
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- PROCESS FORM SUBMISSION ---
    $product_Name = $_POST['product_Name'] ?? '';
    $manufacturer_ID = $_POST['manufacturer'] ?? '';
    $product_Description = $_POST['description'] ?? '';
    $stock_on_hand = $_POST['stock'] ?? '';
    $price = $_POST['price'] ?? '';

    // Handle image upload or use existing image
    $filedir = 'assets/images/';
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $filedir . basename($_FILES['image']['name']);
    } elseif (isset($_POST['existing_image'])) {
        $image = $_POST['existing_image'];
    } else {
        $image = '';
    }

    // Validate manufacturer_ID
    if (empty($manufacturer_ID)) {
        die("Manufacturer is required.");
    }

    // --- Features fields ---
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

    // --- Check if features row exists for this product ---
    $sql = "SELECT featureID FROM features WHERE product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $featureID = $row['featureID'] ?? null;

    if ($featureID) {
        // Update existing features row
        $sql = "UPDATE features SET weight=?, height=?, width=?, thickness=?, operating_system=?, screensize=?, resolution=?, cpu=?, ram=?, storage=?, battery=?, rear_camera=?, front_camera=?
                WHERE product_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $weight, $height, $width, $thickness, $operating_system, $screensize, $resolution, $cpu, $ram, $storage, $battery, $rear_camera, $front_camera, $id
        ]);
    } else {
        // Insert new features row with product_ID
        $sql = "INSERT INTO features (product_ID, weight, height, width, thickness, operating_system, screensize, resolution, cpu, ram, storage, battery, rear_camera, front_camera)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $id, $weight, $height, $width, $thickness, $operating_system, $screensize, $resolution, $cpu, $ram, $storage, $battery, $rear_camera, $front_camera
        ]);
    }

    // --- Update product ---
    $result = update_product($conn, $id, $product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image);

    if (!$result) {
        echo ("A problem occurred");
    } else {
        header('Location: /themobilehour/controller/manageproducts.php');
        exit();
    }
} else {
    // --- SHOW THE FORM ---
    // Fetch product
    $sql = "SELECT * FROM products WHERE product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch features using product_ID
    $sql_feat = "SELECT * FROM features WHERE product_ID = ?";
    $stmt_feat = $conn->prepare($sql_feat);
    $stmt_feat->execute([$id]);
    $features = $stmt_feat->fetch(PDO::FETCH_ASSOC);

    include($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/edit_product.php");
    exit();
}
?>