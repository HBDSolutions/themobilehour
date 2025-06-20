<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include_once "partials/header.php"; ?>

    <main>
        <section>
            <h1 class="first_row">Orders Administration</h1>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Shipping Address</th>
                            <th>Total Amount</th>
                            <th>Order Items</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= $order['orderID'] ?></td>
                                <td><?= $order['order_date'] ?></td>
                                <td>
                                    <?php
                                        $status = strtolower($order['order_status']);
                                        $badge = 'secondary';
                                        if ($status === 'processing') $badge = 'info';
                                        elseif ($status === 'completed') $badge = 'success';
                                        elseif ($status === 'cancelled') $badge = 'danger';
                                    ?>
                                    <span class="badge badge-<?= $badge ?>">
                                        <?= htmlspecialchars($order['order_status']) ?>
                                    </span>
                                </td>
                                <td><?= isset($order['firstname']) ? htmlspecialchars($order['firstname'] . ' ' . $order['lastname']) : '' ?></td>
                                <td><?= isset($order['username']) ? htmlspecialchars($order['username']) : '' ?></td>
                                <td><?= htmlspecialchars($order['shipping_address']) ?></td>
                                <td>$<?= number_format($order['total_amount'], 2) ?></td>
                                <td>
                                    <button class="btn btn-info btn-sm" type="button" data-toggle="collapse" data-target="#orderItems<?= $order['orderID'] ?>">
                                        View Items
                                    </button>
                                </td>
                            </tr>
                            <tr class="collapse bg-light" id="orderItems<?= $order['orderID'] ?>">
                                <td colspan="8">
                                    <strong>Order Items:</strong>
                                    <table class="table table-sm mt-2">
                                        <thead>
                                            <tr>
                                                <th>Product ID</th>
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Price at Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($order['items'] as $item): ?>
                                            <tr>
                                                <td><?= $item['product_ID'] ?></td>
                                                <td><?= htmlspecialchars($item['product_Name']) ?></td>
                                                <td><?= $item['quantity'] ?></td>
                                                <td>$<?= number_format($item['price_at_time'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <?php include_once "partials/footer.php"; ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>