<?php 
include_once("../model/database.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add User</title>
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
                <!-- New admin user form -->
                <h1 class="first_row">Add New Admin User</h1>
                <form class="item-form" enctype="multipart/form-data" action="../controller/addnewuser.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First name:</label>
                            <input type="text" id="firstname" name="firstname" placeholder="Enter user first name" class="form-control" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last name:</label>
                            <input type="text" id="lastname" name="lastname" placeholder="Enter user last name" class="form-control" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email" placeholder="Enter user email address (user@example)" pattern="^[a-zA-Z0-9]+@[a-zA-Z0-9]+$" title="Username must be in the format xxxxxxx@xxxx (letters/numbers only, no dots or TLD)." class="form-control" required autocomplete="off" value="" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Min 8 chars, incl. upper, lower, number, special" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$" title="Password must be at least 8 characters and include uppercase, lowercase, number, and special character." class="form-control" required autocomplete="off" value="" />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="permissionsID">User Role:</label>
                            <select id="permissionsID" name="permissionsID" class="form-control" required>
                                <?php
                                    // Get all roles from the permissions table
                                    $rolesSql = "SELECT permissionsID, permissions_role FROM permissions";
                                    $rolesStmt = $conn->query($rolesSql);
                                    foreach ($rolesStmt as $role) {
                                        echo "<option value='" . $role['permissionsID'] . "'>" . htmlspecialchars($role['permissions_role']) . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="isActive">Account Status:</label>
                            <select id="isActive" name="isActive" class="form-control" required>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
                        <button class="btn btn-info" type="submit">Register User</button>
                        <button class="btn btn-info" type="reset">Reset</button>
                        <a href="/themobilehour/controller/manageadmin.php?action=users" class="btn btn-info">User Admin</a>
                    </div>
                </form>
            </section>
        </main>

        <?php include_once "partials/footer.php" ?>

    </body>

</html>