<?php
require_once(__DIR__ . "/model/database.php");

$stmt = $conn->query("SELECT change_details FROM change_log WHERE affected_table = 'product' AND action = 'delete'");
$restored = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $data = json_decode($row['change_details'], true);
    if (isset($data['deleted']) && is_array($data['deleted'])) {
        $p = $data['deleted'];

        $sql = "INSERT IGNORE INTO products 
            (product_ID, product_Name, manufacturer_ID, product_Description, stock_on_hand, price, image, special)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute([
            $p['product_ID'],
            $p['product_Name'],
            $p['manufacturer_ID'],
            $p['product_Description'],
            $p['stock_on_hand'],
            $p['price'],
            $p['image'],
            $p['special']
        ]);
        $restored++;
    }
}
echo "Restored $restored products.";
?>