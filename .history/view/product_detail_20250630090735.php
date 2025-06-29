<?php
if (!$product): ?>
    <p>Product not found.</p>
    <?php exit(); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Product Details</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="../css/style.css">
  </head>
  <body>
    <?php include_once "partials/header.php" ?>

    <main>
      <div class="grid-container" id="product-details">
          <h1 class="first_row">Product Details</h1>
          <div class="item">
              <span class="item-label"><?= htmlspecialchars($product['product_Name']) ?></span>
              <div class="item-image">
                  <img src="/themobilehour/<?= htmlspecialchars($product['image']) ?>" alt="Product image">
              </div>
              <div class="item-details">
                  <p class="item-price">Price: $<?= htmlspecialchars($product['price']) ?></p>
                  <h5>Manufacturer: <?= htmlspecialchars($product['manufacturer_Name']) ?></h5>
                  <p class="item-description"><?= htmlspecialchars($product['product_Description']) ?></p>
                  <h5>Product Features:</h5>
                  <?php
                  // Check if any feature exists
                  $has_features = (
                      !empty($product['weight']) ||
                      !empty($product['height']) ||
                      !empty($product['width']) ||
                      !empty($product['thickness']) ||
                      !empty($product['operating_system']) ||
                      !empty($product['screensize']) ||
                      !empty($product['resolution']) ||
                      !empty($product['cpu']) ||
                      !empty($product['ram']) ||
                      !empty($product['storage']) ||
                      !empty($product['battery']) ||
                      !empty($product['rear_camera']) ||
                      !empty($product['front_camera'])
                  );
                  ?>
                  <?php if ($has_features): ?>
                    <div class="row">
                      <div class="col-md-6">
                        <ul>
                          <li>Weight: <?= htmlspecialchars($product['weight']) ?> g</li>
                          <li>Height: <?= htmlspecialchars($product['height']) ?> mm</li>
                          <li>Width: <?= htmlspecialchars($product['width']) ?> mm</li>
                          <li>Thickness: <?= htmlspecialchars($product['thickness']) ?> mm</li>
                          <li>Operating System: <?= htmlspecialchars($product['operating_system']) ?></li>
                          <li>Screen Size: <?= htmlspecialchars($product['screensize']) ?> in</li>
                          <li>Resolution: <?= htmlspecialchars($product['resolution']) ?> px</li>
                        </ul>
                      </div>
                      <div class="col-md-6">
                        <ul>
                          <li>CPU: <?= htmlspecialchars($product['cpu']) ?></li>
                          <li>RAM: <?= htmlspecialchars($product['ram']) ?> GB</li>
                          <li>Storage: <?= htmlspecialchars($product['storage']) ?> GB</li>
                          <li>Battery: <?= htmlspecialchars($product['battery']) ?> mAh</li>
                          <li>Rear Camera: <?= htmlspecialchars($product['rear_camera']) ?> megapixels</li>
                          <li>Front Camera: <?= htmlspecialchars($product['front_camera']) ?> megapixels</li>
                        </ul>
                      </div>
                    </div>
                  <?php else: ?>
                    <p>No features listed for this product.</p>
                  <?php endif; ?>
                  <div class="d-flex item-actions" style="gap: 1rem;">
                      <form method="POST" action="../controller/managecart.php" class="d-flex" style="gap: 1rem;">
                          <input type="hidden" name="product_ID" value="<?= $product['product_ID'] ?>">
                          <input type="number" name="quantity" value="1" min="1" class="form-control" style="width: 80px; height: 32px; padding: 0.375rem 0.75rem;">
                          <input type="hidden" name="action" value="add">
                          <button type="submit" class="btn btn-info">Add to Cart</button>
                      </form>
                      <button class="btn btn-info" onclick="window.history.back();">Back</button>
                  </div>
              </div>
          </div>
      </div>
    </main>

    <?php include_once "partials/footer.php" ?>
  </body>
</html>