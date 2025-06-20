<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administration Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $("a.delete").click(function(e){
                if(!confirm('Click OK to confirm delete?')){
                    e.preventDefault();
                    return false;
                }
                return true;
            });
        });
    </script>
</head>
<body>
    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/partials/header.php"); ?>

    <main>
        <section>
            <h1 class="first_row">Administration Home</h1>
            <h5>User Role: 
                <?php
                    if ($permissionsID == 3) {
                        echo "Administration Manager";
                    } elseif ($permissionsID == 2) {
                        echo "Administrator";
                    } else {
                        echo "Unknown";
                    }
                ?>
            </h5>
            <p>
                Hi <?php echo isset($_SESSION["success"]) ? htmlspecialchars($_SESSION["success"]) : ''; ?>.
                You have successfully logged in as <?php echo htmlspecialchars($_SESSION["user"]); ?>
            </p>
            <div class="admin-tile-container">
                <!-- Manage Users Tile -->
                <?php if ($permissionsID == 3): ?>
                    <a href="/themobilehour/controller/manageadmin.php?action=users" class="admin-tile text-center text-decoration-none">Manage Users</a>
                <?php endif; ?>
                <!-- Manage Products Tile -->
                <a href="/themobilehour/controller/manageproducts.php" class="admin-tile text-center text-decoration-none">Manage Products</a>
                <!-- Manage Customers Tile -->
                <a href="/themobilehour/view/admin_customers.php" class="admin-tile text-center text-decoration-none">Manage Customers</a>
                <!-- Manage Orders Tile -->
                <a href="/themobilehour/controller/manageorders.php" class="admin-tile text-center text-decoration-none">Manage Orders</a>
                <!-- Change Log Tile -->
                <a href="/themobilehour/controller/changelog.php" class="admin-tile text-center text-decoration-none">Change Log</a>
            </div>
        </section>
    </main>

    <?php include_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/view/partials/footer.php"); ?>
</body>
</html>