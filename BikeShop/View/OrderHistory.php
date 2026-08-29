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
$orders = $database->getOrdersByCustomer($connection, $customer_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Order History - Bike Shop</title>
    <link rel="stylesheet" href="customer-style.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main>
        <div class="page-container">

            <h1>Order History</h1>

            <?php if (empty($orders)): ?>

                <div class="empty-state">You haven't placed any orders yet. <a href="BrowseBikes.php">Browse bikes</a></div>

            <?php else: ?>

                <table class="order-table">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach ($orders as $order): ?>
                        <?php $items = $database->getOrderItems($connection, $order['id'], $customer_id); ?>
                        <tr>
                            <td>#<?php echo $order['id']; ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                            <td><?php echo number_format($order['total'], 2); ?></td>
                            <td><span class="status-badge"><?php echo htmlspecialchars($order['status']); ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <ul class="order-items-list">
                                    <?php foreach ($items as $item): ?>
                                        <li><?php echo htmlspecialchars($item['bike_name']); ?> &times; <?php echo $item['quantity']; ?> (<?php echo number_format($item['subtotal'], 2); ?>)</li>
                                    <?php endforeach; ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php endif; ?>

        </div>
    </main>

</body>
</html>
