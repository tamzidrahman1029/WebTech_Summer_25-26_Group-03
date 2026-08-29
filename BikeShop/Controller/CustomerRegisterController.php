<?php
session_start();
include "../Model/db.php";

$name = "";
$email = "";
$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = trim($_POST["password"] ?? "");

    $valid = true;

    if (empty($name))
    {
        $message = "Name is required";
        $valid = false;
    }
    else if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $message = "A valid email is required";
        $valid = false;
    }
    else if (empty($password) || strlen($password) < 6)
    {
        $message = "Password must be at least 6 characters";
        $valid = false;
    }

    if ($valid)
    {
        $database = new db();
        $connection = $database->connection();

        $existing = $database->getCustomerByEmail($connection, $email);

        if ($existing)
        {
            $message = "An account with this email already exists";
        }
        else
        {
            $result = $database->registerCustomer($connection, $name, $email, $password);

            if ($result)
            {
                $success = true;
                $message = "Registration successful. You can now log in.";
                $name = "";
                $email = "";
            }
            else
            {
                $message = "Something went wrong. Please try again";
            }
        }
    }
}

?>
