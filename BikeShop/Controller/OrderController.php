<?php
session_start();
include "../Model/db.php";

if (!isset($_SESSION["customer_id"]))
{
    header("Location: ../View/Login.php");
    exit;
}

$customer_id = $_SESSION["customer_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $database = new db();
    $connection = $database->connection();

    $order_id = $database->placeOrder($connection, $customer_id);

    if ($order_id)
    {
        header("Location: ../View/OrderConfirmation.php?order_id=" . $order_id);
        exit;
    }
    else
    {
        $_SESSION["cart_message"] = "Could not place order. Please check item stock and try again.";
        header("Location: ../View/Cart.php");
        exit;
    }
}

header("Location: ../View/Cart.php");
exit;
?>
