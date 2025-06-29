<?php 
include_once("../model/database.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Customer</title>
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
            <!-- Edit an existing user form. Ensure the enctype is included to permit file upload -->
                <h1 class="first_row">Edit Customer</h1>
                <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                    }
                    else {
                        header('Location: ../view/admin_customers.php');
                    }
                ?>
                <form class="item-form" enctype="multipart/form-data" action="../controller/editcustomer.php?id=<?php echo $id?>" method="POST">
                    <?php
                        $sql = "SELECT * FROM user where userID = $id";
                        //execute the query
                        $result = $conn->query($sql);
                        foreach($result as $row) {
                    ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">Edit first name:</label>
                            <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" class="form-control" required />
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="lastname">Edit last name:</label>
                            <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" class="form-control" required />
                            </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Edit email:</label>
                            <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" class="form-control" required />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="password">Edit password:</label>
                            <input type="password" id="password" name="password" value="<?php echo $row['password']; ?>" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="shipping_address">Shipping Address:</label>
                            <input type="text" id="shipping_address" name="shipping_address" value="<?php echo $row['shipping_address']; ?>" class="form-control" autocomplete="off" required />
                        </div>
                    </div>

                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0VscnG0pfroJhzQAvGWme_ofewXihlYs&libraries=places"></script>
                    <script>
                        function initAutocomplete() {
                        var input = document.getElementById('shipping_address');
                        if (input) {
                            var autocomplete = new google.maps.places.Autocomplete(input, {
                            types: ['geocode'],
                            });
                        }
                        }
                        google.maps.event.addDomListener(window, 'load', initAutocomplete);
                    </script>

                    
                    <div class="form-group col-md-12 form-centre">
                        <button class="btn btn-info" type="submit">Save Changes</button>
                        <button class="btn btn-info" type="reset">Reset</button>
                    </div>
                    <?php
                    }
                    ?>
                </form>
            </section>
        </main>
        <?php include_once "partials/footer.php" ?>
    </body>

</html>