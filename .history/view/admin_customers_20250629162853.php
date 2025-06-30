<?php 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Administration</title>
    <!-- Link to Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
    <script language="JavaScript" type="text/javascript">
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
    <?php include_once "partials/header.php" ?>

    <main>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
    
        <section>
            <h1 class="first_row">Customer Administration</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Shipping Address</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($customers as $row) {
                            echo "<tr>";
                            echo "<td scope='row'>" . htmlspecialchars($row['firstname']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
                            echo "<td><a href=\"/themobilehour/controller/edituser.php?id=" . $row['userID'] . "\">" . htmlspecialchars($row['username']) . "</a></td>";
                            echo "<td>" . htmlspecialchars($row['shipping_address']) . "</td>";
                            echo "<td><a href=\"/themobilehour/view/edit_customer.php?id=" . $row['userID'] . "\"><i class=\"bi bi-pencil-square\"></i></a></td>";
                            echo "<td><a href=\"/themobilehour/controller/deleteuser.php?userID=" . $row['userID'] . "\" class=\"delete\"><i class=\"bi bi-trash\"></i></a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            </table>
                
            <div class="form-group col-md-12 form-centre">
                <a href="/themobilehour/controller/managecustomers.php?action=add" class="btn btn-info">Add Customer</a>
            </div>
            
        </section>

    </main>

    <?php include_once "partials/footer.php" ?>

</body>
</html>