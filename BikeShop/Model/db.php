<?php

class db
{
    function connection()
    {
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "sell_bike";

        $connection = new mysqli(
            $db_host,
            $db_user,
            $db_password,
            $db_name
        );

        if($connection->connect_error)
        {
            die("Please Connect the Database");
        }

        return $connection;
    }


    function addBike($connection, $tablename, $bike_name, $brand, $model, $price, $quantity, $description, $bike_image)
    {
        $sql = "INSERT INTO ".$tablename."
        (bike_name, brand, model, price, quantity, description, bike_image)
        VALUES
        ('".$bike_name."', '".$brand."', '".$model."', '".$price."', '".$quantity."', '".$description."', '".$bike_image."')";

        $result = $connection->query($sql);

        return $result;
    }


    function signin($connection, $tablename, $username, $password)
    {
        $sql = "SELECT * FROM ".$tablename. " WHERE username = '".$username."' AND password = '".$password."'";

        $result = $connection->query($sql);

        return $result;
    }


    function CheckBike($connection, $tablename, $bike_name)
    {
        $sql = "SELECT * FROM ".$tablename. "WHERE bike_name = '".$bike_name."'";

        $result = $connection->query($sql);

        return $result;
    }
}

?>