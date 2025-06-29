<?php 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Administration</title>
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
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <section>
            <h1 class="first_row">Product Administration</h1>

            <form method="get" class="form-inline mb-3">
                <select name="manufacturer_ID" class="form-control mr-2">
                <option value="">All Manufacturers</option>
                <?php foreach ($manufacturers as $m): ?>
                    <option value="<?= htmlspecialchars($m['manufacturer_ID']) ?>" <?= isset($_GET['manufacturer_ID']) && $_GET['manufacturer_ID'] == $m['manufacturer_ID'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['manufacturer_Name']) ?>
                    </option>
                <?php endforeach; ?>
                </select>
                <input type="number" name="min_price" class="form-control mr-2" placeholder="Min Price" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" min="0" step="0.01">
                <input type="number" name="max_price" class="form-control mr-2" placeholder="Max Price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" min="0" step="0.01">
                <button type="submit" class="btn btn-info">Filter</button>
            </form>
            
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Manufacturer</th>
                        <th scope="col">Description</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Price</th>
                        <th scope="col">Image</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($products as $row): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($row['product_Name']) ?></th>
                            <td><?= htmlspecialchars($row['manufacturer_Name']) ?></td>
                            <td><?= htmlspecialchars($row['product_Description']) ?></td>
                            <td><?= htmlspecialchars($row['stock_on_hand']) ?></td>
                            <td>$<?= htmlspecialchars($row['price']) ?></td>
                            <td><img src="../<?= htmlspecialchars($row['image']) ?>" class="imgthumb"></td>
                            <td><a href="/themobilehour/controller/editproduct.php?id=<?= htmlspecialchars($row['product_ID']) ?>"><i class="bi bi-pencil-square"></i></a></td>
                            <td><a href="../controller/deleteproduct.php?id=<?= htmlspecialchars($row['product_ID']) ?>" class="delete"><i class="bi bi-trash"></i></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

            <div class="form-group col-md-12 form-centre">
                <a href="/themobilehour/view/add_product.php" class="btn btn-info">Add Product</a>
            </div>
        </section>
    </main>
    <?php include_once "partials/footer.php" ?>
</body>

</html>