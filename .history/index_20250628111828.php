<?php
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>The Mobile Hour</title>
  <!-- Link to Bootstrap -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Link to Bootstrap dependencies-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  <!-- Link to local CSS -->    
      <link rel="stylesheet" href="/themobilehour/css/style.css">

  </head>

  <body>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/partials/header.php"); ?>

    <main>
      <div class="grid-container">
        <div class="first_row d-flex align-items-center justify-content-between" style="gap: 1rem;">
          <h1 style="margin: 0;">Latest Specials!</h1>

          <div class="first_row-forms">
            <form method="get" class="form-inline mb-3">
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
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
              <button class="btn btn-info" type="submit">Search</button>
            </form>
          </div>
        </div>
        
        <?php foreach ($specials as $product): ?>
          <div class="item">
            <div class="item-image">
              <span class="item-label"><?= htmlspecialchars($product['product_Name']) ?></span>
              <img src="/themobilehour/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['product_Name']) ?>">
            </div>
            <div class="item-details">
              <p class="item-price">Price: $<?= number_format($product['price'], 2) ?></p>
              <p class="item-description"><?= htmlspecialchars($product['product_Description']) ?></p>
              <div class="item-actions d-flex align-items-center" style="gap: 0.5rem;">
                <form method="POST" action="../controller/managecart.php" class="d-flex align-items-center" style="gap: 0.5rem;">
                  <input type="hidden" name="product_ID" value="<?= $product['product_ID'] ?>">
                  <input type="number" name="quantity" value="1" min="1" step="1" class="form-control" style="width: 70px; height: 32px;">
                  <input type="hidden" name="action" value="add">
                  <button type="submit" class="btn btn-info">Add to Cart</button>
                </form>
                <a href="/themobilehour/controller/detailproduct.php?id=<?= $product['product_ID'] ?>" class="btn btn-info">View Details</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </main>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/partials/footer.php"); ?>
  </body>
</html>