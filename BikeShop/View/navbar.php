<?php
// Expects session_start() to already have been called by the including page.
$is_logged_in = isset($_SESSION["customer_id"]);
?>
<div class="navbar">
    <div class="navbar-inner">
        <a class="navbar-brand" href="BrowseBikes.php">Bike Shop</a>

        <div class="navbar-links">
            <a href="BrowseBikes.php">Browse Bikes</a>

            <?php if ($is_logged_in): ?>
                <a href="Cart.php">Cart</a>
                <a href="OrderHistory.php">Order History</a>
                <span class="navbar-user"><?php echo htmlspecialchars($_SESSION["customer_name"]); ?></span>
                <a href="Logout.php">Logout</a>
            <?php else: ?>
                <a href="Login.php">Login</a>
                <a href="Register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</div>
