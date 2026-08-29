<?php

include "../Controller/UpdateBikeController.php";

//include "../Model/db.php";


$id = $_GET["id"] ?? "";


$database = new db();

$connection = $database->connection();


$sql = "SELECT * FROM bikes WHERE id = '".$id."'";

$result = $connection->query($sql);


if($result->num_rows > 0)
{
    $bike = $result->fetch_assoc();
}
else
{
    echo "Bike Not Found";
    exit;
}

?>


<!DOCTYPE html>

<html>

    <head>

        <title> Update Bike </title>

        <link rel="stylesheet" href="style.css">

    </head>


    <body>

        <h1> Update Bike </h1>


        <form method="post" enctype="multipart/form-data">

            <table>

                <tr>

                    <td>
                        <label>Bike Name:</label>
                    </td>

                    <td>

                        <input
                            type="text"
                            name="bike_name"
                            value="<?php echo $bike["bike_name"]; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        <label>Brand:</label>
                    </td>

                    <td>

                        <input
                            type="text"
                            name="brand"
                            value="<?php echo $bike["brand"]; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        <label>Model:</label>
                    </td>

                    <td>

                        <input
                            type="text"
                            name="model"
                            value="<?php echo $bike["model"]; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        <label>Price:</label>
                    </td>

                    <td>

                        <input
                            type="number"
                            name="price"
                            value="<?php echo $bike["price"]; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        <label>Quantity:</label>
                    </td>

                    <td>

                        <input
                            type="number"
                            name="quantity"
                            value="<?php echo $bike["quantity"]; ?>"
                        >

                    </td>

                </tr>


                <tr>

                    <td>
                        <label>Description:</label>
                    </td>

                    <td>

                        <textarea
                            name="description"
                            rows="5"
                            cols="30"
                        ><?php echo $bike["description"]; ?></textarea>

                    </td>

                </tr>


                <tr>

                    <td>
                        <label>Bike Image:</label>
                    </td>

                    <td>

                        <input
                            type="file"
                            name="bike_image"
                        >

                    </td>

                </tr>


                <tr>

                    <td colspan="2">

                        <input
                            type="submit"
                            name="submit"
                            value="UPDATE BIKE"
                        >

                    </td>

                </tr>

            </table>

        </form>


        <br>


        <div class="back">

            <a href="SellingProducts.php">

                <input
                    type="button"
                    value="BACK"
                >

            </a>

        </div>


    </body>

</html>