<?php 
include_once("../model/functions.php");

if (!isset($products) || !is_array($products)) {
    die('No direct access.');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <!-- Link to Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

    <!-- Link to local CSS -->
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
    <?php include_once "partials/header.php" ?>

    <main>
        <div class="container-fluid py-4" id="checkout">
            <h1 class="first_row">Checkout</h1>
            <div class="row">
                <div class="col-lg-7 mb-4">
                    <h4>Order Summary</h4>
                    <table class="table" style="table-layout: fixed; width: 100%;">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="price-column">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right" style="width: 16.66%;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['product_Name']) ?></td>
                                <td class="price-column">$<?= number_format($product['price'], 2) ?></td>
                                <td class="text-center"><?= $product['quantity'] ?></td>
                                <td class="text-right">$<?= number_format($product['subtotal'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        <div class="cart-summary text-right">
                            <p><strong>Subtotal:</strong> $<?= number_format($cart_total, 2) ?></p>
                            <p><strong>GST:</strong> $<?= number_format($gst, 2) ?></p>
                            <h5><strong>Purchase Total:</strong> $<?= number_format($purchase_total, 2) ?></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <h4>Shipping & Payment</h4>
                    <form action="../controller/addneworder.php" method="POST">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="<?= $user ? htmlspecialchars(trim($user['firstname'] . ' ' . $user['lastname'])) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Shipping Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                value="<?= $user ? htmlspecialchars($user['shipping_address']) : '' ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?= $user ? htmlspecialchars($user['username']) : '' ?>" required>
                        </div>
                        <!-- Add payment fields as needed -->
                        <div class="cart-summary-btn-group mt-3">
                            <button type="submit" class="btn btn-info btn-sm">Place Order</button>
                            <a href="../view/cart.php" class="btn btn-info btn-sm">Back to Cart</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include_once "partials/footer.php" ?>
</body>
</html>