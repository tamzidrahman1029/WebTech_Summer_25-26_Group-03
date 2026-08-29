<?php

include "../Controller/SellerBikeController.php";

$jsonfile = "../Model/bikes.json";

$bikes = [];

if(file_exists($jsonfile))
    {
        $jsonData = file_get_contents($jsonfile);

        $bikes = json_decode($jsonData, true) ?? [];
    }

?>


<!DOCTYPE html>

<html>

    <head>

        <title> Selling Products </title>

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

            if(count($bikes) > 0)
                {

                    foreach($bikes as $bike)
                        {

            ?>

                            <tr>

                                <td>
                                    <?php echo $bike["id"]; ?>
                                </td>


                                <td>

                                    <img
                                        src="<?php echo $bike["image"]; ?>"
                                        width="100"
                                        height="80"
                                    >

                                </td>


                                <td>
                                    <?php echo $bike["name"]; ?>
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
            
            <a href="SellerDashboard.php">
            <input type="button" value="BACK">
            </a>


    </body>

</html>