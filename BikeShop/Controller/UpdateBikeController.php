<?php

include "../Model/db.php";


$id = $_GET["id"] ?? "";

$name = "";
$brand = "";
$model = "";
$price = "";
$quantity = "";
$description = "";
$message = "";
$path = "";


$database = new db();

$connection = $database->connection();


if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $id = $_POST["id"] ?? "";

        $name = trim($_POST["bike_name"] ?? "");
        $brand = trim($_POST["brand"] ?? "");
        $model = trim($_POST["model"] ?? "");
        $price = trim($_POST["price"] ?? "");
        $quantity = trim($_POST["quantity"] ?? "");
        $description = trim($_POST["description"] ?? "");


        $valid = true;


        if(empty($name))
            {
                $message = "Bike Name is required";
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
                $message = "Description is required";
                $valid = false;
            }


        if($valid)
            {
                $file = $_FILES["bike_image"] ?? [];


                if(!empty($file["name"]))
                    {
                        $uploaddirectory = "../uploads/bikes/";

                        $path = $uploaddirectory.basename($file["name"]);

                        move_uploaded_file(
                            $file["tmp_name"],
                            $path
                        );


                        $sql = "UPDATE bikes SET
                        bike_name='".$name."',
                        brand='".$brand."',
                        model='".$model."',
                        price='".$price."',
                        quantity='".$quantity."',
                        description='".$description."',
                        bike_image='".$path."'
                        WHERE id='".$id."'";


                        $result = $connection->query($sql);
                    }
                else
                    {
                        $sql = "UPDATE bikes SET
                        bike_name='".$name."',
                        brand='".$brand."',
                        model='".$model."',
                        price='".$price."',
                        quantity='".$quantity."',
                        description='".$description."'
                        WHERE id='".$id."'";


                        $result = $connection->query($sql);
                    }


                if($result)
                    {
                        header("Location: ../View/SellingProducts.php");
                    }
                else
                    {
                        echo "Update Failed";
                    }
            }
    }

?>