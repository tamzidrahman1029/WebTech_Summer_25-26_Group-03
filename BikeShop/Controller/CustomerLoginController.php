<?php
session_start();
include "../Model/db.php";

$email = "";
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    if (empty($email) || empty($password))
    {
        $message = "Please enter both email and password";
    }
    else
    {
        $database = new db();
        $connection = $database->connection();

        $customer = $database->getCustomerByEmail($connection, $email);

        if ($customer && password_verify($password, $customer["password"]))
        {
            $_SESSION["customer_id"] = $customer["id"];
            $_SESSION["customer_name"] = $customer["name"];

            header("Location: BrowseBikes.php");
            exit;
        }
        else
        {
            $message = "Invalid email or password";
        }
    }
}

?>
