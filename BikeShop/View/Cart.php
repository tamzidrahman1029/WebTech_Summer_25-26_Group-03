<?php
session_start();

if (!isset($_SESSION["customer_id"]))
{
    header("Location: Login.php");
    exit;
}

include "../Model/db.php";

$database = new db();
$connection = $database->connection();

$customer_id = $_SESSION["customer_id"];
$cartItems = $database->getCartItems($connection, $customer_id);

$total = 0;
foreach ($cartItems as $item)
{
    $total += $item["price"] * $item["quantity"];
}

$cart_message = $_SESSION["cart_message"] ?? "";
unset($_SESSION["cart_message"]);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <h1>Your Cart</h1>

            <?php if (!empty($cart_message)): ?>
                <div class="message error" style="max-width:100%;"><?php echo htmlspecialchars($cart_message); ?></div>
            <?php endif; ?>

            <?php if (empty($cartItems)): ?>

                <div class="empty-state">Your cart is empty. <a href="BrowseBikes.php">Browse bikes</a></div>

            <?php else: ?>

                <table class="cart-table">
                    <tr>
                        <th>Bike</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>

                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td>
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <img src="<?php echo htmlspecialchars($item['bike_image']); ?>" alt="">
                                    <span><?php echo htmlspecialchars($item['bike_name']); ?></span>
                                </div>
                            </td>
                            <td><?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form class="qty-form" method="post" action="../Controller/CartController.php">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>">
                                    <button type="submit" class="btn btn-small">Update</button>
                                </form>
                            </td>
                            <td><?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <form method="post" action="../Controller/CartController.php">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                    <button type="submit" class="btn btn-small btn-secondary">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <div class="cart-summary">
                    <div class="row total">
                        <span>Total</span>
                        <span><?php echo number_format($total, 2); ?></span>
                    </div>
                </div>

                <form method="post" action="../Controller/OrderController.php" style="text-align:right; margin-top:16px;">
                    <button type="submit" class="btn">Place Order</button>
                </form>

            <?php endif; ?>

        </div>
    </main>

</body>
</html>
