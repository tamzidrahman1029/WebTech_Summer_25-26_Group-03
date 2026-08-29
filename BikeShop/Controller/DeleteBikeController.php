<?php

include "../Model/db.php";


if(isset($_GET["id"]))
    {
        $id = $_GET["id"];


        $database = new db();

        $connection = $database->connection();


        $sql = "DELETE FROM bikes WHERE id = '".$id."'";


        $result = $connection->query($sql);


        if($result)
            {
                header("Location: ../View/SellingProducts.php");
            }
        else
            {
                echo "Delete Failed";
            }
    }

?>