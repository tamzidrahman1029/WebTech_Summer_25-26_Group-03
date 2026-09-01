<?php
include "../Controller/SellerBikeController.php"
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Sell Bike </title>
        <link rel="stylesheet" href="../Style.css">

        <script>

            function collect_data()
            {
                let name = document.getElementById("bike_name").value.trim();

                let brand = document.getElementById("brand").value.trim();

                let model = document.getElementById("model").value.trim();

                let price = document.getElementById("price").value.trim();

                let quantity = document.getElementById("quantity").value.trim();

                let description = document.getElementById("description").value.trim();

                let image = document.getElementById("bike_image").value;


                let valid = true;

                let message = "";


                if(name.length == 0)
                {
                    message += "Bike Name is required\n";

                    valid = false;
                }


                if(brand.length == 0)
                {
                    message += "Brand is required\n";

                    valid = false;
                }


                if(model.length == 0)
                {
                    message += "Model is required\n";

                    valid = false;
                }


                if(price.length == 0 || Number(price) <= 0)
                {
                    message += "Enter a valid Price\n";

                    valid = false;
                }


                if(quantity.length == 0 || Number(quantity) <= 0)
                {
                    message += "Enter a valid Quantity\n";

                    valid = false;
                }


                if(description.length == 0)
                {
                    message += "Description is required\n";

                    valid = false;
                }


                if(image.length == 0)
                {
                    message += "Please select a Bike Image\n";

                    valid = false;
                }


                if(!valid)
                {
                    alert(message);
                }


                return valid;
            }

        </script>



    </head>

    <body>
        <h1> Sell Your Bike </h1>

        <form method="post" enctype="multipart/form-data" onsubmit="return collect_data()">
            <table>
                <tr>
                    <td><label for="bike_name"> Bike Name: </label></td>
                    <td>
                        <input type="text" id="bike_name" name="bike_name" onkeyup="CheckBike()">
                        <span id="bikeresponse"></span>
                    </td>
                </tr>

                <tr>
                    <td><label for="brand"> Brand: </label></td>
                    <td><input type="text" id="brand" name="brand"></td>
                </tr>

                <tr>
                    <td><label for="model"> Model: </label></td>
                    <td><input type="text" id="model" name="model"></td>
                </tr>

                <tr>
                    <td><label for="price"> Price: </label></td>
                    <td><input type="number" id="price" name="price"></td>
                </tr>

                <tr>
                    <td><label for="quantity"> Quantity: </label></td>
                    <td><input type="number" id="quantity" name="quantity"></td>
                </tr>

                <tr>
                    <td><label for="description"> Description: </label></td>
                    <td>
                        <textarea id="description" name="description" rows="10" cols="25" style="resize: none;"></textarea>
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td><label for="bike_image"> Bike Image: </label></td>
                    <td><input type="file" id="bike_image" name="bike_image"></td>
                    
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" id="submit" name="submit" value="SELL BIKE">

                        <a href="SellerDashboard.php">
                    <input type="button" value="BACK">
                    </a>
                    </td>
                </tr>

            </table>


        </form>

    </body>
</html>