<?php 
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($accountTitle); ?></title>
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
            <!-- Fetch an existing user form. Ensure the enctype is included to permit file upload -->
                <h1 class="first_row"><?= htmlspecialchars($accountTitle); ?></h1>
                
                <form class="item-form" enctype="multipart/form-data" action="../controller/edituser.php?id=<?= $user['userID'] ?>" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First name:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['firstname']); ?></p>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="lastname">Last name:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['lastname']); ?></p>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Email address:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['username']); ?></p>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">Password:</label>
                            <p class="form-control-plaintext">********</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <?php if (!$hideRoleAndStatus): ?>
                        <div class="form-group col-md-6">
                            <label for="permissions_role">User Role:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['permissions_role']); ?></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="isActive">Account Status:</label>
                            <p class="form-control-plaintext">
                                <?= $user['isActive'] == 1 ? 'Active' : 'Inactive'; ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Shipping Address:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($user['shipping_address']); ?></p>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-12 form-centre">
                        <a href="/themobilehour/view/edit_user.php?id=<?= $user['userID']; ?>" class="btn btn-info">Edit Account</a>
                    </div>
                    <?php
                    
                    ?>
                </form>
            </section>
        </main>
        <?php include_once "partials/footer.php" ?>
    </body>

</html>