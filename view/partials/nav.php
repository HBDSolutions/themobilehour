<?php
$current = basename($_SERVER['PHP_SELF']);
$current_action = $_GET['action'] ?? null;
?>

<nav>
    <div class="menu-button-container" onclick="toggleMenu()">
      <div class="menu-button" id="menu-btn"></div>
    </div>
    <ul class="menu" id="main-menu">
        <li>
            <a href="/themobilehour/controller/home.php"
               class="<?= $current == 'home.php' ? 'active' : '' ?>">Home</a>
        </li>

        <li>
            <a href="/themobilehour/controller/manageproducts.php?action=public"
               class="<?= ($current == 'manageproducts.php' && $current_action == 'public') ? 'active' : '' ?>">Products</a>
        </li>

        <?php if (isset($_SESSION['userID'])): ?>
            <li>
                <a href="/themobilehour/controller/edituser.php?id=<?= $_SESSION['userID'] ?>"
                   class="<?= $current == 'edituser.php' ? 'active' : '' ?>">My Account</a>
            </li>
            <?php
                require_once($_SERVER['DOCUMENT_ROOT'] . "/themobilehour/model/functions.php");
                $hasOrders = false;
                if (function_exists('user_has_orders')) {
                    $hasOrders = user_has_orders($_SESSION['userID']);
                } else {
                    global $conn;
                    $stmt = $conn->prepare("SELECT COUNT(*) FROM orders WHERE userID = :userID");
                    $stmt->bindValue(':userID', $_SESSION['userID']);
                    $stmt->execute();
                    $hasOrders = $stmt->fetchColumn() > 0;
                }
            ?>

            <?php if ($hasOrders): ?>
                <li>
                    <a href="/themobilehour/controller/manageorders.php?userID=<?= $_SESSION['userID'] ?>"
                       class="<?= $current == 'manageorders.php' ? 'active' : '' ?>">My Orders</a>
                </li>
            <?php endif; ?>

            <?php if (
                isset($_SESSION['permissionsID']) &&
                in_array($_SESSION['permissionsID'], [2, 3])
            ): ?>
                <li>
                    <a href="/themobilehour/controller/manageadmin.php"
                       class="<?= $current == 'manageadmin.php' ? 'active' : '' ?>">Admin Home</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        <li>
            <a href="/themobilehour/view/cart.php"
               class="<?= $current == 'cart.php' ? 'active' : '' ?>">Cart</a>
        </li>

        <?php if (isset($_SESSION['user'])): ?>
            <li>
                <a href="/themobilehour/controller/logout.php">Logout</a>
            </li>
        <?php else: ?>
            <li>
                <a href="#" data-toggle="modal" data-target="#loginModal">Login</a>
            </li>
        <?php endif; ?>
        
        <?php if (!isset($_SESSION['userID'])): ?>
            <li>
                <a href="/themobilehour/view/register.php"
                   class="<?= $current == 'register.php' ? 'active' : '' ?>">Register</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>