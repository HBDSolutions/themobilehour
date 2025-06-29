<?php 
include_once("../model/database.php");
session_start();
if (!isset($_SESSION['user']) || $_SESSION['permissionsID'] < 2) {
    header("location:../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>

<body>
    <?php include_once "partials/header.php" ?>

    <main>
        <section>
            <h1 class="first_row">Edit Product</h1>
            <?php
                if (isset($_GET['id'])) {
                    $id = intval($_GET['id']);
                } else {
                    header('Location: /themobilehour/controller/manageproducts.php');
                    exit();
                }

                // Fetch product and featureID
                $sql = "SELECT * FROM products WHERE product_ID = $id";
                $result = $conn->query($sql);
                $row = $result->fetch(PDO::FETCH_ASSOC);

                // Fetch features using featureID
                $featureID = $row['featureID'];
                $features = [];
                if ($featureID) {
                    $sql_feat = "SELECT * FROM features WHERE featureID = ?";
                    $stmt_feat = $conn->prepare($sql_feat);
                    $stmt_feat->execute([$featureID]);
                    $features = $stmt_feat->fetch(PDO::FETCH_ASSOC);
                }
            ?>
            <form class="item-form" enctype="multipart/form-data" action="/themobilehour/controller/editproduct.php?id=<?php echo $id?>" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="product_Name">Edit product name:</label>
                        <input type="text" id="product_Name" name="product_Name" value="<?php echo htmlspecialchars($row['product_Name']); ?>" class="form-control" required />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="manufacturer">Edit manufacturer:</label>
                        <select id="manufacturer" name="manufacturer" class="form-control" required>
                            <option value="" disabled <?= empty($row['manufacturer_ID']) ? 'selected' : 'hidden' ?>>Select Manufacturer</option>
                            <?php
                                $sql = "SELECT manufacturer_ID, manufacturer_Name FROM manufacturer";
                                $manufacturers = $conn->query($sql);
                                foreach($manufacturers as $manufacturer) {
                                    $selected = ($manufacturer['manufacturer_ID'] == $row['manufacturer_ID']) ? 'selected' : '';
                                    echo "<option value='" . $manufacturer['manufacturer_ID'] . "' $selected>" . htmlspecialchars($manufacturer['manufacturer_Name']) . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price">Edit product price:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" step=".01" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="stock">Edit stock-on-hand total:</label>
                        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($row['stock_on_hand']); ?>" class="form-control" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="description">Enter a description:</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($row['product_Description']); ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Edit product image file:</label>
                    <input name="image" type="file" class="form-control-file" id="image" /><br>
                    <img src="../<?php echo htmlspecialchars($row['image']); ?>" width="75" height="75" />
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($row['image']);?>" />
                </div>

                <!-- Features fields -->
                <h3>Product Features</h3>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="weight">Weight (g)</label>
                        <input type="number" step="0.01" min="0" max="9999.99" name="weight" id="weight" class="form-control" placeholder="Enter weight in grams (0.00 – 9999.99). Leave blank if unknown"
                            value="<?php echo htmlspecialchars($features['weight'] ?? $_POST['weight'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="height">Height (mm)</label>
                        <input type="number" step="0.01" min="0" max="9999.99" name="height" id="height" class="form-control" placeholder="Enter height in millimeters (0.00 – 9999.99). Leave blank if unknown"
                            value="<?php echo htmlspecialchars($features['height'] ?? $_POST['height'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="width">Width (mm)</label>
                        <input type="number" step="0.01" min="0" max="9999.99" name="width" id="width" class="form-control" placeholder="Enter width in millimeters (0.00 – 9999.99). Leave blank if unknown"
                            value="<?php echo htmlspecialchars($features['width'] ?? $_POST['width'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="thickness">Thickness (mm)</label>
                        <input type="number" step="0.01" min="0" max="99.99" name="thickness" id="thickness" class="form-control" placeholder="Enter thickness in millimeters (0.00 – 99.99). Leave blank if unknown"
                            value="<?php echo htmlspecialchars($features['thickness'] ?? $_POST['thickness'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="operating_system">Operating System</label>
                        <input type="text" maxlength="32" name="operating_system" id="operating_system" class="form-control" placeholder="Enter OS name (max 32 characters), e.g., Android, iOS"
                            value="<?php echo htmlspecialchars($features['operating_system'] ?? $_POST['operating_system'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="screensize">Screen Size (in)</label>
                        <input type="number" step="0.01" min="0" max="99.99" name="screensize" id="screensize" class="form-control" placeholder="Enter screen size in inches (0.00 – 99.99). Leave blank if unknown"
                            value="<?php echo htmlspecialchars($features['screensize'] ?? $_POST['screensize'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="resolution">Resolution (pixels)</label>
                        <input type="text" maxlength="16" name="resolution" id="resolution" class="form-control" placeholder="Enter resolution in pixels (e.g., 1080x2400) (max 16 characters). Leave blank if unknown"
                            value="<?php echo htmlspecialchars($features['resolution'] ?? $_POST['resolution'] ?? ''); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cpu">CPU (chip name)</label>
                        <input type="text" maxlength="64" name="cpu" id="cpu" class="form-control"
                            value="<?php echo htmlspecialchars($features['cpu'] ?? $_POST['cpu'] ?? ''); ?>">
                        <small class="form-text text-muted">Enter CPU/chip name (max 64 characters), e.g., Snapdragon 8 Gen 2.</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="ram">RAM (GB)</label>
                        <input type="number" min="0" max="65535" name="ram" id="ram" class="form-control"
                            value="<?php echo htmlspecialchars($features['ram'] ?? $_POST['ram'] ?? ''); ?>">
                        <small class="form-text text-muted">Enter RAM in GB (0 – 65535). Leave blank if unknown.</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="storage">Storage (GB)</label>
                        <input type="number" min="0" max="65535" name="storage" id="storage" class="form-control"
                            value="<?php echo htmlspecialchars($features['storage'] ?? $_POST['storage'] ?? ''); ?>">
                        <small class="form-text text-muted">Enter storage in GB (0 – 65535). Leave blank if unknown.</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="battery">Battery (mAh)</label>
                        <input type="number" min="0" max="65535" name="battery" id="battery" class="form-control"
                            value="<?php echo htmlspecialchars($features['battery'] ?? $_POST['battery'] ?? ''); ?>">
                        <small class="form-text text-muted">Enter battery capacity in mAh (0 – 65535). Leave blank if unknown.</small>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="rear_camera">Rear Camera (megapixels)</label>
                        <input type="number" step="0.01" min="0" max="999.99" name="rear_camera" id="rear_camera" class="form-control"
                            value="<?php echo htmlspecialchars($features['rear_camera'] ?? $_POST['rear_camera'] ?? ''); ?>">
                        <small class="form-text text-muted">Enter rear camera resolution in MP (0.00 – 999.99). Leave blank if unknown.</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="front_camera">Front Camera (megapixels)</label>
                        <input type="number" step="0.01" min="0" max="999.99" name="front_camera" id="front_camera" class="form-control"
                            value="<?php echo htmlspecialchars($features['front_camera'] ?? $_POST['front_camera'] ?? ''); ?>">
                        <small class="form-text text-muted">Enter front camera resolution in MP (0.00 – 999.99). Leave blank if unknown.</small>
                    </div>
                </div>

                <div class="form-group col-md-12 form-centre">
                    <button class="btn btn-info" type="submit">Update product</button>
                    <button class="btn btn-info" type="reset">Reset</button>
                </div>
            </form>
        </section>
    </main>
    <?php include_once "partials/footer.php" ?>
</body>
</html>