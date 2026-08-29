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
$order_id = (int)($_GET["order_id"] ?? 0);

$orderItems = $database->getOrderItems($connection, $order_id, $customer_id);

// find the matching order (only from this customer's own orders)
$order = null;
foreach ($database->getOrdersByCustomer($connection, $customer_id) as $o)
{
    if ($o["id"] == $order_id)
    {
        $order = $o;
        break;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmed - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <?php if (!$order): ?>

                <div class="empty-state">Order not found.</div>

            <?php else: ?>

                <div class="message success" style="max-width:100%;">
                    Thank you! Your order #<?php echo $order['id']; ?> has been placed successfully.
                </div>

                <div class="card">
                    <h2>Order #<?php echo $order['id']; ?></h2>
                    <p>Date: <?php echo htmlspecialchars($order['order_date']); ?></p>
                    <p>Status: <span class="status-badge"><?php echo htmlspecialchars($order['status']); ?></span></p>

                    <table class="cart-table">
                        <tr>
                            <th>Bike</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['bike_name']); ?></td>
                                <td><?php echo number_format($item['price'], 2); ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['subtotal'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <div class="cart-summary">
                        <div class="row total">
                            <span>Total</span>
                            <span><?php echo number_format($order['total'], 2); ?></span>
                        </div>
                    </div>
                </div>

                <p><a href="BrowseBikes.php" class="btn">Continue Shopping</a>
                   <a href="OrderHistory.php" class="btn btn-secondary">View Order History</a></p>

            <?php endif; ?>

        </div>
    </main>

</body>
</html>
