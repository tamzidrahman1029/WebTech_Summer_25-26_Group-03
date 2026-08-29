<?php

include "../Model/db.php";


$database = new db();

$connection = $database->connection();


$sql = "SELECT * FROM bikes";

$result = $connection->query($sql);

?>


<!DOCTYPE html>

<html>

    <head>

        <title> Selling Products </title>

        <link rel="stylesheet" href="style.css">

    </head>


    <body>

        <h1> Selling Products </h1>


        <table border="1">

            <tr>

                <th>
                    ID
                </th>

                <th>
                    Bike Image
                </th>

                <th>
                    Bike Name
                </th>

                <th>
                    Brand
                </th>

                <th>
                    Model
                </th>

                <th>
                    Price
                </th>

                <th>
                    Quantity
                </th>

            </tr>


            <?php

            if($result->num_rows > 0)
                {

                    while($bike = $result->fetch_assoc())
                        {

            ?>

                            <tr>

                                <td>
                                    <?php echo $bike["id"]; ?>
                                </td>


                                <td>

                                    <img
                                        src="<?php echo $bike["bike_image"]; ?>"
                                        width="100"
                                        height="80"
                                    >

                                </td>


                                <td>
                                    <?php echo $bike["bike_name"]; ?>
                                </td>


                                <td>
                                    <?php echo $bike["brand"]; ?>
                                </td>


                                <td>
                                    <?php echo $bike["model"]; ?>
                                </td>


                                <td>
                                    <?php echo $bike["price"]; ?>
                                </td>


                                <td>
                                    <?php echo $bike["quantity"]; ?>
                                </td>

                            </tr>


            <?php

                        }

                }

            else
                {

            ?>

                    <tr>

                        <td colspan="7">
                            No Selling Products Found
                        </td>

                    </tr>


            <?php

                }

            ?>

        </table>


        <br><br>


        <div class="back">

            <a href="SellerDashboard.php">

                <input
                    type="button"
                    value="BACK"
                >

            </a>

        </div>


    </body>

</html>