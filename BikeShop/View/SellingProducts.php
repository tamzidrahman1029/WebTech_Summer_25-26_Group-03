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

        <script src="../JS/SearchBike.js"></script>

    </head>


    <body>

        <h1> Selling Products </h1>

        <input type="text" id="search" onkeyup="SearchBike()" placeholder="Search Bike">


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

                <th>
                    Update
                </th>

                <th>
                    Delete
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


                                <td>

                                    <a href="UpdateBike.php?id=<?php echo $bike["id"]; ?>">

                                        <input
                                            type="button"
                                            value="UPDATE"
                                        >

                                    </a>

                                </td>


                                <td>

                                    <a href="../Controller/SellerBikeController.php?id=<?php echo $bike["id"]; ?>">

                                        <input
                                            type="button"
                                            value="DELETE"
                                        >

                                    </a>

                                </td>

                            </tr>


            <?php

                        }

                }

            else
                {

            ?>

                    <tr>

                        <td colspan="9">
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