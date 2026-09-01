<?php

session_start();


// ADMIN SECURITY

if (!isset($_SESSION["logged_In"]) ||
    $_SESSION["role"] != "admin")
{
    header("Location: loginpage.php");
    exit;
}


include "../Model/db.php";



// GET BIKES


$sql = "SELECT 

        bikes.id,

        bikes.name,

        bikes.brand,

        bikes.model,

        bikes.price,

        bikes.quantity,

        bikes.description,

        bikes.image,

        users.username AS seller


        FROM bikes


        INNER JOIN users

        ON bikes.seller_id = users.id


        ORDER BY bikes.id DESC";



$result = $conn->query($sql);



?>


<!DOCTYPE html>

<html>


<head>


<title>Manage Bikes</title>


<link rel="stylesheet" href="../Assets/css/style.css">


<style>


.product-img{

width:120px;

height:90px;

object-fit:cover;

border-radius:10px;

}



.price{

font-weight:bold;

color:#16a34a;

}



.seller-badge{

background:#2563eb;

color:white;

padding:6px 12px;

border-radius:20px;

font-size:13px;

}




</style>


</head>



<body>




<header class="header">


<div class="logo">

🚲 BikeZone Admin

</div>



<div class="nav">


<a href="admin.php">

Dashboard

</a>


<a href="logout.php">

Logout

</a>


</div>



</header>






<div class="container">



<div class="card">



<h1>

Manage Bikes

</h1>



<br>



<div class="table-box">



<table>



<tr>


<th>ID</th>

<th>Image</th>

<th>Bike Name</th>

<th>Brand</th>

<th>Model</th>

<th>Price</th>

<th>Quantity</th>

<th>Description</th>

<th>Seller</th>


</tr>





<?php


if($result->num_rows > 0)

{


while($bike=$result->fetch_assoc())

{


?>



<tr>



<td>

<?php echo $bike["id"]; ?>

</td>




<td>


<img

class="product-img"

src="<?php echo htmlspecialchars($bike["image"]); ?>">



</td>




<td>

<?php

echo htmlspecialchars($bike["name"]);

?>

</td>




<td>

<?php

echo htmlspecialchars($bike["brand"]);

?>

</td>




<td>

<?php

echo htmlspecialchars($bike["model"]);

?>

</td>




<td class="price">

৳

<?php

echo number_format($bike["price"]);

?>

</td>




<td>

<?php

if($bike["quantity"] > 0)

{

    echo $bike["quantity"];

}

else

{

    echo "Out of Stock";

}

?>

</td>





<td>


<?php

echo htmlspecialchars($bike["description"]);

?>


</td>





<td>



<span class="seller-badge">


<?php

echo htmlspecialchars($bike["seller"]);

?>


</span>



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

No Bikes Found

</td>


</tr>


<?php


}


?>



</table>


</div>




<br>



<a class="btn"

href="admin.php">


Back To Dashboard


</a>




</div>


</div>






<footer class="footer">


© 2026 BikeZone | Bike Management


</footer>




</body>


</html>