<?php
session_start();
require_once("../model/functions.php");

$product_id = intval($_GET['id'] ?? 0);
$product = ($product_id > 0) ? get_product_by_id($product_id) : null;

if (!$product) {
    echo "<p>Product not found.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Product Details</title>
  <!-- Link to Bootstrap -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Link to Bootstrap dependencies-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Link to local CSS -->    
      <link rel="stylesheet" href="../css/style.css">

    </head>

  <body>
    <?php include_once "partials/header.php" ?>

    <main>
      <div class="grid-container" id="product-details">
          <h1 class="first_row">Product Details</h1>
          <?php
          $product_ID = isset($_GET['id']) ? intval($_GET['id']) : 0;
          if ($product_ID > 0) {
              $sql = "SELECT products.*, manufacturer.manufacturer_Name
                      FROM products 
                      LEFT JOIN manufacturer ON products.manufacturer_ID = manufacturer.manufacturer_ID 
                      WHERE products.product_ID = :product_ID";
              $statement = $conn->prepare($sql);
              $statement->bindValue(':product_ID', $product_ID, PDO::PARAM_INT);
              $statement->execute();
              $result = $statement->fetchAll();
              $statement->closeCursor();

              foreach ($result as $row):
          ?>
              <div class="item">
                  <span class="item-label"><?= $row['product_Name'] ?></span>
                  <div class="item-image">
                      <img src="/themobilehour/<?= $row['image'] ?>" alt="Product image">
                  </div>
                  <div class="item-details">
                      <p class="item-price">Price: $<?= $row['price'] ?></p>
                      <h5>Manufacturer: <?= $row['manufacturer_Name'] ?></h5>
                      <p class="item-description"><?= $row['product_Description'] ?></p>
                      <div class="d-flex item-actions" style="gap: 1rem;">
                          <form method="POST" action="../controller/managecart.php" class="d-flex" style="gap: 1rem;">
                              <input type="hidden" name="product_ID" value="<?= $row['product_ID'] ?>">
                              <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px; height: 32px; padding: 0.375rem 0.75rem;">
                              <input type="hidden" name="action" value="add">
                              <button type="submit" class="btn btn-info">Add to Cart</button>
                          </form>
                          <button class="btn btn-info" onclick="window.history.back();">Back</button>
                      </div>
                  </div>
              </div>
          <?php
              endforeach;
          } else {
              echo "<p>Product not found.</p>";
          }
          ?>
      </div>
    </main>

    <?php include_once "partials/footer.php" ?>

  </body>
</html>