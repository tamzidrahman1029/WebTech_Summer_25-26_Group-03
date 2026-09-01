<?php

include "../Model/db.php";

$bike_name = $_POST["bike_name"] ?? "";

if(!$bike_name)
{
    echo "Bike Name Required";
}
else
{
    $database = new db();
    $connection = $database->connection();

    $result = $database->CheckBike($connection, "bikes", $bike_name);

    if($result->num_rows > 0)
    {
        echo "Bike Name Taken";
    }
    else
    {
        echo "Bike Name Available";
    }
}

?>