<?php 
include_once("../model/database.php");
session_start();
if (!isset($_SESSION['user']) || $_SESSION['permissionsID'] < 2) {
    // Only allow Administrator users
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
        <title>Add New Product</title>
        <!-- Link to Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- Link to local CSS -->
        <link rel="stylesheet" href="../css/style.css">

        <!-- Link to Bootstrap dependencies-->
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

                <h1 class=first_row>Add New Product</h1>
                <form class="item-form" enctype="multipart/form-data" action="../controller/addnewproduct.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="product">Product name:</label>
                            <input type="text" id="product" name="product_Name" placeholder="Enter product Name" class="form-control" required />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="manufacturer">Select manufacturer:</label>
                            <select id="manufacturer" name="manufacturer" class="form-control" required>
                                <option value="" disabled selected>Select Manufacturer</option>
                                <?php
                                    $sql = "SELECT manufacturer_ID, manufacturer_Name FROM manufacturer";
                                    $result = $conn->query($sql);
                                    foreach($result as $row) {
                                        echo "<option value='" . $row['manufacturer_ID'] . "'>" . ($row['manufacturer_Name']) . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price">Product price:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" id="price" name="price" placeholder="Enter price" class="form-control" step=".01" required />
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="stock">Initial stock-on-hand total:</label>
                            <input type="number" id="stock" name="stock_on_hand" placeholder="Enter initial stock number" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description">Product description:</label>
                            <textarea placeholder="Describe the product in 1000 words or less" id="description" name="product_Description" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
               
                    <div class="form-group">
                        <label for="image">Upload product image file</label>
                        <input name="image" type="file" class="form-control-file" id="image" />
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
                            <input type="text" maxlength="64" name="cpu" id="cpu" class="form-control" placeholder="Enter CPU/chip name (max 64 characters), e.g., Snapdragon 8 Gen 2"
                                value="<?php echo htmlspecialchars($features['cpu'] ?? $_POST['cpu'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="ram">RAM (GB)</label>
                            <input type="number" min="0" max="65535" name="ram" id="ram" class="form-control" placeholder="Enter RAM in GB (0 – 65535). Leave blank if unknown"
                                value="<?php echo htmlspecialchars($features['ram'] ?? $_POST['ram'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="storage">Storage (GB)</label>
                            <input type="number" min="0" max="65535" name="storage" id="storage" class="form-control" placeholder="Enter storage in GB (0 – 65535). Leave blank if unknown"
                                value="<?php echo htmlspecialchars($features['storage'] ?? $_POST['storage'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="battery">Battery (mAh)</label>
                            <input type="number" min="0" max="65535" name="battery" id="battery" class="form-control" placeholder="Enter battery capacity in mAh (0 – 65535). Leave blank if unknown"
                                value="<?php echo htmlspecialchars($features['battery'] ?? $_POST['battery'] ?? ''); ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rear_camera">Rear Camera (megapixels)</label>
                            <input type="number" step="0.01" min="0" max="999.99" name="rear_camera" id="rear_camera" class="form-control" placeholder="Enter rear camera resolution in MP (0.00 – 999.99). Leave blank if unknown"
                                value="<?php echo htmlspecialchars($features['rear_camera'] ?? $_POST['rear_camera'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="front_camera">Front Camera (megapixels)</label>
                            <input type="number" step="0.01" min="0" max="999.99" name="front_camera" id="front_camera" class="form-control" placeholder="Enter front camera resolution in MP (0.00 – 999.99). Leave blank if unknown"
                                value="<?php echo htmlspecialchars($features['front_camera'] ?? $_POST['front_camera'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="form-group col-md-12 form-centre">
                        <button class="btn btn-info" type="submit">Add product</button>
                        <button class="btn btn-info" type="reset">Reset</button>
                    </div>
                </form>
            </section>
        </main>

        <?php include_once "partials/footer.php" ?>

    </body>
</html>