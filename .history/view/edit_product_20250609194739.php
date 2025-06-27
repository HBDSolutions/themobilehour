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
        <title>Edit Product</title>
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
        <!-- Edit an existing product form. Ensure the enctype is included to permit file upload -->
            <h1 class="first_row">Edit Product</h1>
            <?php
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                }
                else {
                    header('Location: ../view/admin_product.php');
                }
            ?>
            <form class="item-form" enctype="multipart/form-data" action="../controller/editproduct.php?id=<?php echo $id?>" method="POST">
                <?php
                    $sql = "SELECT * FROM products where product_ID = $id";
                    //execute the query
                    $result = $conn->query($sql);
                    foreach($result as $row) {
                ?>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="product_Name">Edit product name:</label>
                        <input type="text" id="product_Name" name="product_Name" value="<?php echo $row['product_Name']; ?>" class="form-control" required />
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="manufacturer">Edit manufacturer:</label>
                        <select id="manufacturer" name="manufacturer" class="form-control" required>
                                <option value="" disabled>Select Manufacturer</option>
                                <?php
                                    $sql = "SELECT manufacturer_ID, manufacturer_Name FROM manufacturer";
                                    $manufacturers = $conn->query($sql);
                                    foreach($manufacturers as $manufacturer) {
                                        $selected = ($manufacturer['manufacturer_ID'] == $row['manufacturer_ID']) ? 'selected' : '';
                                        echo "<option value='" . $manufacturer['manufacturer_ID'] . "' $selected>" . ($manufacturer['manufacturer_Name']) . "</option>";
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
                            <input type="number" id="price" name="price" value="<?php echo $row['price']; ?>" step=".01" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="stock">Edit stock-on-hand total:</label>
                        <input type="number" id="stock" name="stock" value="<?php echo $row['stock_on_hand']; ?>" class="form-control" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="description">Enter a description:</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required><?php echo $row['product_Description']; ?></textarea>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="image">Edit product image file:</label>
                    <input name="image" type="file" class="form-control-file" id="image" /><br>
                    <img src="../<?php echo $row['image']; ?>" width="75" height="75" />
                    <!-- use a hidden form field to hold the existing image filename value -->
                    <input type="hidden" name="image" value="<?php echo $row['image'];?>" />
                </div>
                    <div class="form-group col-md-12 form-centre">
                    <button class="btn btn-info" type="submit">Update product</button>
                    <button class="btn btn-info" type="reset">Reset</button>
                </div>
                <?php
                }
                ?>
            </form>
            </section>
        </main>
        <?php include_once "partials/footer.php" ?>
    </body>

</html>