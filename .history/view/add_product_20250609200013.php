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
                            <label for="product_Name">Product name:</label>
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
               
                    <div class="form-row">
                    </div>
                    <div class="form-group">
                        <label for="image">Upload product image file</label>
                        <input name="image" type="file" class="form-control-file" id="image" />
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