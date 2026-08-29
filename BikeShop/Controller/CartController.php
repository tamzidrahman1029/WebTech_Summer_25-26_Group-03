<?php
session_start();
include "../Model/db.php";

// Cart actions require a logged-in customer
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

    $action = $_POST["action"] ?? "";

    if ($action == "add")
    {
        $bike_id = (int)($_POST["bike_id"] ?? 0);
        $quantity = (int)($_POST["quantity"] ?? 1);

        if ($quantity < 1)
        {
            $quantity = 1;
        }

        $added = $database->addToCart($connection, $customer_id, $bike_id, $quantity);

        if ($added)
        {
            $_SESSION["cart_message"] = "Added to cart";
        }
        else
        {
            $_SESSION["cart_message"] = "Not enough stock available";
        }

        header("Location: ../View/BikeDetails.php?id=" . $bike_id);
        exit;
    }

    else if ($action == "update")
    {
        $cart_item_id = (int)($_POST["cart_item_id"] ?? 0);
        $quantity = (int)($_POST["quantity"] ?? 1);

        if ($quantity < 1)
        {
            $quantity = 1;
        }

        $updated = $database->updateCartItemQuantity($connection, $cart_item_id, $customer_id, $quantity);

        if (!$updated)
        {
            $_SESSION["cart_message"] = "Requested quantity exceeds available stock";
        }

        header("Location: ../View/Cart.php");
        exit;
    }

    else if ($action == "remove")
    {
        $cart_item_id = (int)($_POST["cart_item_id"] ?? 0);

        $database->removeCartItem($connection, $cart_item_id, $customer_id);

        header("Location: ../View/Cart.php");
        exit;
    }
}

header("Location: ../View/Cart.php");
exit;
?>
