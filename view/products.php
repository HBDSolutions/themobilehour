<?php

?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Our Products</title>
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
      <div class="grid-container">
        <div class="first_row d-flex align-items-center justify-content-between" style="gap: 1rem;">
          <h1 style="margin: 0;">Our Products</h1>

          <form method="get" class="form-inline mb-3">
            <input type="hidden" name="action" value="public">
            <select name="manufacturer_ID" class="form-control mr-2">
              <option value="">All Manufacturers</option>
              <?php foreach ($manufacturers as $m): ?>
                <option value="<?= htmlspecialchars($m['manufacturer_ID']) ?>" <?= isset($_GET['manufacturer_ID']) && $_GET['manufacturer_ID'] == $m['manufacturer_ID'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($m['manufacturer_Name']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <input type="number" name="min_price" class="form-control mr-2" placeholder="Min Price" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" min="0" step="0.01">

            <input type="number" name="max_price" class="form-control mr-2" placeholder="Max Price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" min="0" step="0.01">

            <button type="submit" class="btn btn-info">Filter</button>
          </form>

          <form class="form-inline" style="margin: 0;">
            <input type="hidden" name="action" value="public">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

            <button class="btn btn-info" type="submit">Search</button>
          </form>
        </div>

        <?php
        //display the result set 
        foreach($products as $row):
            echo "<div class='item'>";
              echo "<span class='item-label'>" . $row['product_Name'] . "</span>";
              echo "<div class='item-image'><img src='/themobilehour/" . $row['image'] . "' alt='Product image'></div>";
                echo "<div class='item-details'>";
                  echo "<p class='item-price'>Price: $" . $row['price'] . "</p>";
                  echo "<p class='item-description'>" . $row['product_Description'] . "</p>";
                  echo "<div class='d-flex item-actions'>";
                  echo "<form method='POST' action='../controller/managecart.php' class='d-flex' style='gap: 0.5rem; margin-left: 0.5rem;'>"; 
                  echo "<input type='hidden' name='product_ID' value='" . $row['product_ID'] . "'>";
                  echo "<input type='hidden' name='action' value='add'>";
                  echo "<input type='number' name='quantity' value='1' min='1' class='form-control form-control-sm' style='width: 70px;'>";
                  echo "<button type='submit' class='btn btn-info btn-sm'>Add to Cart</button>";
                  echo "<a href='/themobilehour/controller/detailproduct.php?id=" . $row['product_ID'] . "' class='btn btn-info'>View Details</a>";
                  echo "</form>";
                echo "</div>";
              echo "</div>";
            echo "</div>";          
        endforeach;          
        ?>    
      </div>
    </main>

    <?php include_once "partials/footer.php" ?>

  </body>
</html>