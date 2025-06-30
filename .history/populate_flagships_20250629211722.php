<?php
require_once __DIR__ . '/model/database.php'; // Adjust path if needed

// Array of flagship phones
$flagships = [
    [
        'product_Name' => 'iPhone 16 Pro Max',
        'manufacturer_ID' => 1,
        'product_Description' => 'Apple flagship phone for 2025',
        'stock_on_hand' => 50,
        'price' => 1999,
        'image' => 'assets/images/iphone_16_pro_max.png',
        'special' => 1,
        'features' => [
            'weight' => 225,
            'height' => 160.8,
            'width' => 78.1,
            'thickness' => 7.8,
            'operating_system' => 'iOS 18',
            'screensize' => 6.7,
            'resolution' => '1290x2796',
            'cpu' => 'Apple A19 Pro',
            'ram' => 8,
            'storage' => 256,
            'battery' => 4500,
            'rear_camera' => 48,
            'front_camera' => 12
        ]
    ],
    [
        'product_Name' => 'Galaxy S25 Ultra',
        'manufacturer_ID' => 2,
        'product_Description' => 'Samsung flagship phone for 2025',
        'stock_on_hand' => 50,
        'price' => 1899,
        'image' => 'assets/images/galaxy_s25_ultra.png',
        'special' => 1,
        'features' => [
            'weight' => 233,
            'height' => 162.3,
            'width' => 79.0,
            'thickness' => 8.9,
            'operating_system' => 'Android 14',
            'screensize' => 6.8,
            'resolution' => '1440x3200',
            'cpu' => 'Snapdragon 8 Gen 4',
            'ram' => 12,
            'storage' => 256,
            'battery' => 5000,
            'rear_camera' => 200,
            'front_camera' => 12
        ]
    ],
    [
        'product_Name' => 'Xiaomi 15 Ultra',
        'manufacturer_ID' => 3,
        'product_Description' => 'Xiaomi flagship phone for 2025',
        'stock_on_hand' => 50,
        'price' => 1499,
        'image' => 'assets/images/xiaomi_15_ultra.png',
        'special' => 1,
        'features' => [
            'weight' => 227,
            'height' => 163.2,
            'width' => 74.6,
            'thickness' => 8.9,
            'operating_system' => 'Android 14',
            'screensize' => 6.73,
            'resolution' => '1440x3200',
            'cpu' => 'Snapdragon 8 Gen 4',
            'ram' => 16,
            'storage' => 512,
            'battery' => 5300,
            'rear_camera' => 200,
            'front_camera' => 32
        ]
    ],
    [
        'product_Name' => 'Find X8 Pro',
        'manufacturer_ID' => 4,
        'product_Description' => 'Oppo flagship phone for 2025',
        'stock_on_hand' => 50,
        'price' => 1399,
        'image' => 'assets/images/find_x8_pro.png',
        'special' => 1,
        'features' => [
            'weight' => 218,
            'height' => 164.3,
            'width' => 74.2,
            'thickness' => 8.6,
            'operating_system' => 'Android 14',
            'screensize' => 6.82,
            'resolution' => '1440x3168',
            'cpu' => 'Snapdragon 8 Gen 4',
            'ram' => 16,
            'storage' => 512,
            'battery' => 5000,
            'rear_camera' => 50,
            'front_camera' => 32
        ]
    ],
    [
        'product_Name' => 'P70 Pro',
        'manufacturer_ID' => 5,
        'product_Description' => 'Huawei flagship phone for 2025',
        'stock_on_hand' => 50,
        'price' => 1599,
        'image' => 'assets/images/p70_pro.png',
        'special' => 1,
        'features' => [
            'weight' => 209,
            'height' => 162.6,
            'width' => 75.6,
            'thickness' => 8.3,
            'operating_system' => 'HarmonyOS 4',
            'screensize' => 6.6,
            'resolution' => '1228x2700',
            'cpu' => 'Kirin 9010',
            'ram' => 12,
            'storage' => 256,
            'battery' => 5050,
            'rear_camera' => 50,
            'front_camera' => 13
        ]
    ],
    [
        'product_Name' => 'Edge 50 Ultra',
        'manufacturer_ID' => 6,
        'product_Description' => 'Motorola flagship phone for 2025',
        'stock_on_hand' => 50,
        'price' => 1299,
        'image' => 'assets/images/edge_50_ultra.png',
        'special' => 1,
        'features' => [
            'weight' => 197,
            'height' => 161.1,
            'width' => 72.4,
            'thickness' => 8.6,
            'operating_system' => 'Android 14',
            'screensize' => 6.7,
            'resolution' => '1220x2712',
            'cpu' => 'Snapdragon 8s Gen 3',
            'ram' => 12,
            'storage' => 512,
            'battery' => 4500,
            'rear_camera' => 50,
            'front_camera' => 50
        ]
    ]
];

try {
    foreach ($flagships as $phone) {
        // Insert product
        $stmt = $conn->prepare("INSERT INTO products (product_Name, manufacturer_ID, product_Description, stock_on_hand, price, image, special)
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $phone['product_Name'],
            $phone['manufacturer_ID'],
            $phone['product_Description'],
            $phone['stock_on_hand'],
            $phone['price'],
            $phone['image'],
            $phone['special']
        ]);
        $product_ID = $conn->lastInsertId();

        // Insert features
        $f = $phone['features'];
        $stmt2 = $conn->prepare("INSERT INTO features (product_ID, weight, height, width, thickness, operating_system, screensize, resolution, cpu, ram, storage, battery, rear_camera, front_camera)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt2->execute([
            $product_ID,
            $f['weight'],
            $f['height'],
            $f['width'],
            $f['thickness'],
            $f['operating_system'],
            $f['screensize'],
            $f['resolution'],
            $f['cpu'],
            $f['ram'],
            $f['storage'],
            $f['battery'],
            $f['rear_camera'],
            $f['front_camera']
        ]);
        echo "Inserted {$phone['product_Name']} (product_ID: $product_ID)<br>";
    }
    echo "<br>All flagship phones inserted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>