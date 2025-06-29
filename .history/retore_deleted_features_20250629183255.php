<?php
require_once(__DIR__ . "/model/database.php");

$stmt = $conn->query("SELECT change_details FROM change_log WHERE affected_table = 'features' AND action = 'delete'");
$restored = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data = json_decode($row['change_details'], true);
    if (isset($data['deleted']) && is_array($data['deleted'])) {
        $f = $data['deleted'];

        // Adjust the columns and values below to match your features table and JSON structure
        $sql = "INSERT IGNORE INTO features 
            (featureID, product_ID /*, other columns if needed */)
            VALUES (?, ? /*, other values if needed */)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute([
            $f['featureID'],
            $f['product_ID'],
            // ...add other fields as needed
        ]);
        $restored++;
    }
}
echo "Restored $restored features.";
?>