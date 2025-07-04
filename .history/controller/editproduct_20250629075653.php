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

    // --- Fetch featureID for this product ---
    $sql = "SELECT featureID FROM products WHERE product_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $featureID = $row['featureID'] ?? null;

    if ($featureID) {
        // Update existing features row
        $sql = "UPDATE features SET weight=?, height=?, width=?, thickness=?, operating_system=?, screensize=?, resolution=?, cpu=?, ram=?, storage=?, battery=?, rear_camera=?, front_camera=?
                WHERE featureID=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $weight, $height, $width, $thickness, $operating_system, $screensize, $resolution, $cpu, $ram, $storage, $battery, $rear_camera, $front_camera, $featureID
        ]);
    } else {
        // Insert new features row
        $sql = "INSERT INTO features (weight, height, width, thickness, operating_system, screensize, resolution, cpu, ram, storage, battery, rear_camera, front_camera)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $weight, $height, $width, $thickness, $operating_system, $screensize, $resolution, $cpu, $ram, $storage, $battery, $rear_camera, $front_camera
        ]);
        $featureID = $conn->lastInsertId();

        // Update product to set new featureID
        $sql = "UPDATE products SET featureID=? WHERE product_ID=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$featureID, $id]);
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
    // Redirect to the view, passing the product ID
    header("Location: /themobilehour/view/edit_product.php?id=$id");
    exit();
}
?>