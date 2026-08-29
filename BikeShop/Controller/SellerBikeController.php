<?php
include "../Model/db.php";

$name = "";
$brand = "";
$model = "";
$price = "";
$quantity = "";
$description = "";
$message = "";
$path = "";

$valid = true;

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $name = trim($_POST["bike_name"] ?? "");
    $brand = trim($_POST["brand"] ??"");
    $model = trim($_POST["model"] ??"");
    $price = trim($_POST["price"] ??"");
    $quantity = trim($_POST["quantity"] ??"");
    $description = trim($_POST["description"] ??"");
    $file = $_FILES["bike_image"] ?? [];

    if(empty($name))
        {
            $message = "Bike name is required";
            $valid = false;
        }
        
    if(empty($brand))
        {
            $message = "Brand is required";
            $valid = false;
        }

    if(empty($model))
        {
            $message = "Model is required";
            $valid = false;
        }

    if(empty($price) || $price <= 0)
        {
            $message = "Price must be greater than 0";
            $valid = false;
        }

    if(empty($quantity) || $quantity <= 0)
        {
            $message = "Quantity must be greater than 0";
            $valid = false;
        }

    if(empty($description))
        {
            $message = "description is required";
            $valid = false;
        }

    if(empty($file["name"]))
        {
            $message = "Please select a bike image";
            $valid = false;
        }


        if($valid)
            {
                $uploaddirectory = "../Uploads/";
                $path = $uploaddirectory.basename($file["name"]);
                move_uploaded_file($file["tmp_name"], $path);
            

            $database = new db();

            $connection = $database->connection();

            $result = $database->addBike($connection, "bikes", $name, $brand, $model, $price, $quantity, $description, $path);

            if($result)
                {
                    $message = "Bike Sold Successfully";
                }

                else
                    {
                        $message = "Please try again";
                    }
        }

}

?>
