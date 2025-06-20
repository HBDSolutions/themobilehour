<?php
session_start();
require_once("../model/database.php");
require_once("../model/functions.php");

// Initialise cart array if empty
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart_items = $_SESSION['cart'];
$cart_total = 0;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

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
    <div class="container-fluid py-4" id="cart">
        <h1 class="first_row">Your Cart</h1>

        <?php if (empty($cart_items)): ?>
            <h3 class="text-center text-muted mt-4">Your cart is empty.</h3>
        <?php else: ?>
        <div class="row">
            <div class="col-lg-12">
                <table class="table" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th class="cart-image-col"></th>
                            <th>Item</th>
                            <th class="price-column">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right" style="width: 16.66%;">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($cart_items as $item) {
                            $sql = "SELECT product_Name, price, image FROM products WHERE product_ID = :product_ID";
                            $statement = $conn->prepare($sql);
                            $statement->bindValue(':product_ID', $item['product_ID'], PDO::PARAM_INT);
                            $statement->execute();
                            $product = $statement->fetch();
                            $statement->closeCursor();

                            if ($product) {
                                $subtotal = $product['price'] * $item['quantity'];
                                $cart_total += $subtotal;
                            echo "<tr>";
                            echo "<td class='cart-image-cell'><img src='../assets/images/" . basename($product['image']) . "' alt='Product image' style='width: 80px;'></td>";
                            echo "<td>" . ($product['product_Name']) . "</td>";
                            echo "<td class='price-column'>$" . number_format($product['price'], 2) . "</td>";
                            echo "<td class='text-center'>" . $item['quantity'] . "</td>";
                            echo "<td class='text-right'>$" . number_format($subtotal, 2) . "</td>";
                            echo "<td class='text-right align-middle' style='vertical-align: top;'>
                                    <a href='../controller/managecart.php?action=remove&id=" . $item['product_ID'] . "' class='btn btn-link p-0' title='Remove from cart' style='vertical-align: middle;'>
                                        <i class='bi bi-trash' style='font-size: 1.3rem; color: #EF8354; vertical-align: middle;'></i>
                                    </a>
                                </td>";
                            echo "</tr>";

                            }
                        }
                        
                        $gst = $cart_total * 0.1;
                        $purchase_total = $cart_total + $gst;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <div class="cart-summary text-right">
                <p><strong>Subtotal:</strong> $<?= number_format($cart_total, 2) ?></p>
                <p><strong>GST:</strong> $<?= number_format($gst, 2) ?></p>
                <h5><strong>Purchase Total:</strong> $<?= number_format($purchase_total, 2) ?></h5>
                <div class="cart-summary-btn-group mt-2">
                    <a href="../controller/managecheckout.php" class="btn btn-info btn-sm">Checkout</a>
                    <a href="../controller/managecart.php?action=clear" class="btn btn-info btn-sm">Clear Cart</a>
                </div>
            </div>
        </div>


        <?php endif; ?>
    </div>
</main>

    <?php include_once "partials/footer.php" ?>
</body>