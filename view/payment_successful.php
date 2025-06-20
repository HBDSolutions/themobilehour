<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <?php include_once "partials/header.php"; ?>
    <main>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="text-center w-100">
                <h1 class="mb-4 text-success"><i class="bi bi-check-circle"></i> Payment Successful</h1>
                <p class="lead">Thank you for your order!<br>
                Your payment has been processed and your order is being prepared.</p>
                <div class="d-flex justify-content-center">
                    <a href="/themobilehour/controller/home.php" class="btn btn-info btn-sm mt-4 px-3">Return to Home</a>
                </div>
            </div>
        </div>
    </main>
    <?php include_once "partials/footer.php"; ?>
</body>
</html>