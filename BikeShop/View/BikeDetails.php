<?php
session_start();
include "../Model/db.php";

$database = new db();
$connection = $database->connection();

$bike_id = (int)($_GET["id"] ?? 0);
$bike = $database->getBikeById($connection, $bike_id);

$cart_message = $_SESSION["cart_message"] ?? "";
unset($_SESSION["cart_message"]);

?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $bike ? htmlspecialchars($bike['bike_name']) : 'Bike Not Found'; ?> - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <?php if (!$bike): ?>

                <div class="empty-state">Bike not found. <a href="BrowseBikes.php">Back to Browse Bikes</a></div>

            <?php else: ?>

                <?php if (!empty($cart_message)): ?>
                    <div class="message success" style="max-width:100%;"><?php echo htmlspecialchars($cart_message); ?></div>
                <?php endif; ?>

                <div class="bike-details">

                    <img src="<?php echo htmlspecialchars($bike['bike_image']); ?>" alt="<?php echo htmlspecialchars($bike['bike_name']); ?>">

                    <div class="bike-info">
                        <h1><?php echo htmlspecialchars($bike['bike_name']); ?></h1>
                        <div class="bike-meta">Brand: <?php echo htmlspecialchars($bike['brand']); ?></div>
                        <div class="bike-meta">Model: <?php echo htmlspecialchars($bike['model']); ?></div>
                        <div class="bike-price"><?php echo number_format($bike['price'], 2); ?></div>

                        <p><?php echo nl2br(htmlspecialchars($bike['description'])); ?></p>

                        <?php if ($bike['quantity'] <= 0): ?>
                            <p class="stock-out">Out of stock</p>
                        <?php else: ?>

                            <?php if ($bike['quantity'] <= 2): ?>
                                <p class="stock-low">Only <?php echo $bike['quantity']; ?> left in stock</p>
                            <?php endif; ?>

                            <?php if (isset($_SESSION["customer_id"])): ?>
                                <form class="qty-form" method="post" action="../Controller/CartController.php">
                                    <input type="hidden" name="action" value="add">
                                    <input type="hidden" name="bike_id" value="<?php echo $bike['id']; ?>">
                                    <label for="quantity">Qty:</label>
                                    <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $bike['quantity']; ?>">
                                    <button type="submit" class="btn">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <p><a href="Login.php" class="btn">Login to Add to Cart</a></p>
                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>
    </main>

</body>
</html>
