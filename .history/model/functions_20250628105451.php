<?php
// define a global variable for the default user profile image
$default_image = 'images/user_profile.png';


//USER MANAGEMENT FUNCTIONS

//create a function to login 
function login($conn, $username, $password) { 
    global $permissions;

    $sql = "SELECT * FROM user WHERE username = :username";
    $statement = $conn->prepare($sql);
    $statement->bindValue(':username', $username); 
    $statement->execute(); 
    $result = $statement->fetch();
    $statement->closeCursor();

    if ($result) {
        if (password_verify($password, $result['password'])) {
            $permissions = $result['permissionsID'];
            return $result;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

//create a function to retrieve salt 
function retrieve_salt($conn, $username) { 
    $sql = "SELECT * FROM user WHERE username = :username";
    $statement = $conn->prepare($sql); 
    $statement->bindValue(':username', $username); 
    $statement->execute(); 
    $result = $statement->fetch(); 
    $statement->closeCursor(); 
    return $result; 
}

//create a function to add a new user 
function add_new_user($conn, $firstname, $lastname, $email, $password, $shipping_address, $permissionsID, $isActive) {
    // $default_image = 'images/user_profile.png';

    //if (!empty($profileimage) && ($profileimage != $default_image)) {
    //    $uploaddir = '../images/';
    //    $uploadfile = $uploaddir . basename($profileimage);
    //    if (move_uploaded_file($_FILES['profileimage']['tmp_name'], $uploadfile)) {
    //        echo "File is valid, and was successfully uploaded.\n";
    //    }
    //}
    
    // Hash and salt the password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (firstname, lastname, username, password, shipping_address, permissionsID, isActive)
            VALUES (:firstname, :lastname, :username, :password, :shipping_address, :permissionsID, :isActive)";
 
    $statement = $conn->prepare($sql); 
    $statement->bindValue(':firstname', $firstname); 
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':username', $email);
    $statement->bindValue(':password', $hashed_password);
    $statement->bindValue(':shipping_address', $shipping_address);
    $statement->bindValue(':permissionsID', $permissionsID, PDO::PARAM_INT);
    $statement->bindValue(':isActive', $isActive);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;  
}

// Create a function to check if an email is already registered
function email_exists($conn, $email) {
    $sql = "SELECT COUNT(*) FROM user WHERE username = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $stmt->closeCursor();
    return $count > 0;
}

// Create a function to validate a password
function is_valid_password($password) {
    // At least 8 characters, one uppercase, one lowercase, one number, one special character
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}
    
 //create a function to update an existing user 
function update_user($conn, $id, $firstname, $lastname, $email, $password, $shipping_address, $permissionsID, $isActive) { 
    // Hash and salt the password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE user SET firstname = :firstname, lastname = :lastname, username = :username, password = :password, shipping_address = :shipping_address, permissionsID = :permissionsID, isActive = :isActive WHERE userID = :id";
    $statement = $conn->prepare($sql); 
    $statement->bindValue(':id', $id);
    $statement->bindValue(':firstname', $firstname); 
    $statement->bindValue(':lastname', $lastname);
    $statement->bindValue(':username', $email);
    $statement->bindValue(':password', $hashed_password);
    $statement->bindValue(':shipping_address', $shipping_address);
    $statement->bindValue(':permissionsID', $permissionsID);
    $statement->bindValue(':isActive', $isActive, PDO::PARAM_INT);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;  
    }

//*create a function to fetch existing user
function get_user_by_id($conn, $id) {
    $sql = "SELECT user.*, permissions.permissions_role 
            FROM user 
            LEFT JOIN permissions ON user.permissionsID = permissions.permissionsID 
            WHERE user.userID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $user;
}

// Create a function to delete an existing user
function delete_user($conn, $userID) {
    $sql = "DELETE FROM user WHERE userID = :userID";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $result = $stmt->execute();
    $stmt->closeCursor();
    return $result;
}



// PRODUCT MANAGEMENT FUNCTIONS

//create a function to add a new product 
function add_product($conn, $product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image, $featureID) {
    $uploaddir = '../assets/images/';
    $uploadfile = $uploaddir . basename($image);

    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }
        move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
    }

    $sql = "INSERT INTO products (product_Name, manufacturer_ID, product_Description, stock_on_hand, price, image, featureID) 
            VALUES (:product_Name, :manufacturer_ID, :product_Description, :stock_on_hand, :price, :image, :featureID)"; 
    $statement = $conn->prepare($sql); 
    $statement->bindValue(':product_Name', $product_Name); 
    $statement->bindValue(':manufacturer_ID', $manufacturer_ID);
    $statement->bindValue(':product_Description', $product_Description);
    $statement->bindValue(':stock_on_hand', $stock_on_hand);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':image', $image);
    $statement->bindValue(':featureID', $featureID, PDO::PARAM_INT);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result; 
}

//create a function to delete an existing product 
function delete_product($conn, $id) {
    $sql = "DELETE FROM products WHERE product_ID = :id";
    
    $statement = $conn->prepare($sql);
    $statement->bindValue(':id', $id);
    $result = $statement->execute();
    $statement->closeCursor();
    return $result;

}

//create a function to update an existing product 
function update_product($conn, $product_ID, $product_Name, $manufacturer_ID, $product_Description, $stock_on_hand, $price, $image) { 
    $uploaddir = '../images/';
    $uploadfile = $uploaddir . basename($image);
    

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
        echo "File is valid, and was successfully uploaded.\n";
    }

    $sql = "UPDATE products SET product_Name = :product_Name, manufacturer_ID = :manufacturer_ID, product_Description = :product_Description, stock_on_hand = :stock_on_hand, price = :price, image = :image WHERE product_ID = :product_ID"; 
    $statement = $conn->prepare($sql); 
    $statement->bindValue(':product_ID', $product_ID);
    $statement->bindValue(':product_Name', $product_Name); 
    $statement->bindValue(':manufacturer_ID', $manufacturer_ID);
    $statement->bindValue(':product_Description', $product_Description);
    $statement->bindValue(':stock_on_hand', $stock_on_hand);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':image', $image); 
    $result = $statement->execute(); 
    $statement->closeCursor(); 
    return $result;
    }

// Create a function to fetch all manufacturers
function get_all_manufacturers($conn) {
    $stmt = $conn->query("SELECT manufacturer_ID, manufacturer_Name FROM manufacturer ORDER BY manufacturer_Name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create a function to filter products
function get_filtered_products($conn, $manufacturer_ID = null, $min_price = null, $max_price = null, $search = null, $specialOnly = false) {
    $sql = "SELECT p.*, m.manufacturer_Name 
            FROM products p 
            JOIN manufacturer m ON p.manufacturer_ID = m.manufacturer_ID
            WHERE 1=1";
    $params = [];

    if ($specialOnly) {
        $sql .= " AND p.special = 1";
    }
    if ($manufacturer_ID) {
        $sql .= " AND p.manufacturer_ID = :manufacturer_ID";
        $params[':manufacturer_ID'] = $manufacturer_ID;
    }
    if ($min_price !== null && $min_price !== '') {
        $sql .= " AND p.price >= :min_price";
        $params[':min_price'] = $min_price;
    }
    if ($max_price !== null && $max_price !== '') {
        $sql .= " AND p.price <= :max_price";
        $params[':max_price'] = $max_price;
    }
    if ($search) {
        $sql .= " AND (p.product_Name LIKE :search OR p.product_Description LIKE :search)";
        $params[':search'] = '%' . $search . '%';
    }

    $stmt = $conn->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create functions to fetch products
function get_product_by_id($conn, $product_id) {
    $sql = "SELECT * FROM products WHERE product_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_all_products($conn) {
    $query = "SELECT * FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Create a function to fetch a selected product with its features and manufacturer
function get_product_with_features($conn, $product_id) {
    $sql = "SELECT p.*, m.manufacturer_Name, f.weight, f.height, f.width, f.thickness, f.operating_system, f.screensize, f.resolution, f.cpu, f.ram, f.storage, f.battery, f.rear_camera, f.front_camera
            FROM products p
            LEFT JOIN manufacturer m ON p.manufacturer_ID = m.manufacturer_ID
            LEFT JOIN features f ON p.featureID = f.featureID
            WHERE p.product_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $product;
}



// ORDER MANAGEMENT FUNCTIONS

// Create functions to manage the shopping cart
function initiate_cart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
}

function add_to_cart($product_id, $quantity = 1) {
    initiate_cart();

    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_ID'] === $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    unset($item);

    if (!$found) {
        $_SESSION['cart'][] = [
            'product_ID' => $product_id,
            'quantity' => $quantity
        ];
    }
}

function remove_from_cart($product_id) {
    initiate_cart();
    $_SESSION['cart'] = array_filter($_SESSION['cart'], fn($item) => $item['product_ID'] !== $product_id);
}

function get_cart_items() {
    return $_SESSION['cart'] ?? [];
}

// Create functions to manage orders
function add_order($conn, $userID, $shipping_address, $total_amount) {
    $sql = "INSERT INTO orders (userID, order_date, order_status, shipping_address, total_amount, created_at)
            VALUES (:userID, NOW(), 'Pending', :shipping_address, :total_amount, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID);
    $stmt->bindValue(':shipping_address', $shipping_address);
    $stmt->bindValue(':total_amount', $total_amount);
    $stmt->execute();
    $order_id = $conn->lastInsertId();
    $stmt->closeCursor();
    return $order_id;
}

function add_order_item($conn, $order_id, $product_ID, $quantity, $price_at_time) {
    $sql = "INSERT INTO order_items (orderID, product_ID, quantity, price_at_time)
            VALUES (:orderID, :product_ID, :quantity, :price_at_time)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':orderID', $order_id);
    $stmt->bindValue(':product_ID', $product_ID);
    $stmt->bindValue(':quantity', $quantity);
    $stmt->bindValue(':price_at_time', $price_at_time);
    $stmt->execute();
    $stmt->closeCursor();
}

function get_all_orders_with_items($conn) {
    $sql = "SELECT o.orderID, o.order_date, o.order_status, o.shipping_address, o.total_amount, 
                   u.firstname, u.lastname, u.username
            FROM orders o
            LEFT JOIN user u ON o.userID = u.userID
            ORDER BY o.order_date DESC";
    $orders = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as &$order) {
        $order['items'] = get_order_items($conn, $order['orderID']);
    }
    unset($order);
    return $orders;
}

function get_order_items($conn, $orderID) {
    $sql = "SELECT oi.product_ID, p.product_Name, oi.quantity, oi.price_at_time
            FROM order_items oi
            LEFT JOIN products p ON oi.product_ID = p.product_ID
            WHERE oi.orderID = :orderID";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':orderID', $orderID, PDO::PARAM_INT);
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $items;
}

function get_orders_by_user($conn, $userID) {
    $sql = "SELECT * FROM orders WHERE userID = :userID ORDER BY order_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $orders;
}

function user_has_orders($conn, $userID) {
    $sql = "SELECT COUNT(*) FROM orders WHERE userID = :userID";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    $stmt->closeCursor();
    return $count > 0;
}


// CHANGE LOG FUNCTIONS

// Create a function to only show changed fields and mask passwords
function show_changed_fields($details) {
    $data = json_decode($details, true);
    if (!is_array($data)) {
        return htmlspecialchars($details);
    }
    // Mask passwords
    array_walk_recursive($data, function (&$value, $key) {
        if (strtolower($key) === 'password') {
            $value = '********';
        }
    });

    // Only show changed fields if both 'before' and 'after' exist
    if (isset($data['before']) && isset($data['after'])) {
        $changes = [];
        foreach ($data['before'] as $field => $beforeValue) {
            $afterValue = $data['after'][$field] ?? null;
            if ($beforeValue !== $afterValue) {
                $changes[$field] = [
                    'from' => $beforeValue,
                    'to' => $afterValue
                ];
            }
        }
        if (empty($changes)) {
            return '<em>No changes</em>';
        }
        $output = "";
        foreach ($changes as $field => $change) {
            $output .= htmlspecialchars($field) . ": '" . htmlspecialchars($change['from']) . "' → '" . htmlspecialchars($change['to']) . "'\n";
        }
        return nl2br($output);
    }

    // For inserts or other actions, just show the masked data
    return htmlspecialchars(print_r($data, true));
}

// Create a change log function

function log_change($conn, $changed_by, $affected_table, $affected_id, $action, $change_details) {
    $stmt = $conn->prepare("INSERT INTO change_log (changed_by, affected_table, affected_id, action, change_details) VALUES (:changed_by, :affected_table, :affected_id, :action, :change_details)");
    $stmt->bindValue(':changed_by', $changed_by, PDO::PARAM_INT);
    $stmt->bindValue(':affected_table', $affected_table);
    $stmt->bindValue(':affected_id', $affected_id, PDO::PARAM_INT);
    $stmt->bindValue(':action', $action);
    $stmt->bindValue(':change_details', $change_details);
    $stmt->execute();
}
?>