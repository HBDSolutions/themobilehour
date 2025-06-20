<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Log</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include_once "partials/header.php"; ?>

    <main>
        <section>
            <h1 class="first_row">Change Log</h1>

            <table class="table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Changed By</th>
                        <th>Table</th>
                        <th>Record ID</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['change_time']) ?></td>
                            <td><?= htmlspecialchars($log['changed_by_firstname'] . ' ' . $log['changed_by_lastname']) ?></td>
                            <td><?= htmlspecialchars($log['affected_table']) ?></td>
                            <td><?= htmlspecialchars($log['affected_id']) ?></td>
                            <td><?= htmlspecialchars($log['action']) ?></td>
                            <td><pre><?= show_changed_fields($log['change_details']) ?></pre></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>            

        </section>
    </main>

    <?php include_once "partials/footer.php"; ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</body>
</html>