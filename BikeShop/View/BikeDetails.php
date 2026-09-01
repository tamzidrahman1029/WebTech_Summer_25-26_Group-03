<?php

session_start();


if (!isset($_SESSION["logged_In"]) ||
    $_SESSION["role"] != "customer")
{
    header("Location: loginpage.php");
    exit;
}


include "../Model/db.php";



// CHECK BIKE ID

if(!isset($_GET["id"]))
{
    echo "Bike not found";
    exit;
}



$bike_id = $_GET["id"];




// GET BIKE DETAILS


$sql = "SELECT 

        bikes.*,

        users.username AS seller


        FROM bikes


        INNER JOIN users


        ON bikes.seller_id = users.id


        WHERE bikes.id=?";




$stmt = $conn->prepare($sql);



$stmt->bind_param(
    "i",
    $bike_id
);



$stmt->execute();



$result = $stmt->get_result();



if($result->num_rows == 0)
{
    echo "Bike not found";
    exit;
}



$bike = $result->fetch_assoc();



?>



<!DOCTYPE html>

<html>


<head>


<title>
Bike Details
</title>


<link rel="stylesheet" href="../Assets/css/style.css">



<style>


.product-container{


display:flex;

gap:40px;

background:white;

padding:35px;

border-radius:20px;

box-shadow:0 5px 20px rgba(0,0,0,0.1);


}



.product-image{


width:45%;


}



.product-image img{


width:100%;

height:400px;

object-fit:cover;

border-radius:15px;


}




.product-info{


width:55%;


}



.product-info h1{


font-size:35px;

margin-bottom:20px;


}



.price{


font-size:28px;

font-weight:bold;

color:#16a34a;

margin:20px 0;


}



.info{


font-size:18px;

line-height:2;


}



.quantity-box{


margin-top:25px;


}



.quantity-box input{


width:80px;

padding:10px;

font-size:16px;

border-radius:8px;

border:1px solid #ccc;


}



.cart-btn{


margin-top:20px;

background:#2563eb;

color:white;

padding:12px 25px;

border:none;

border-radius:8px;

cursor:pointer;

font-size:16px;


}



.cart-btn:hover{


background:#1d4ed8;


}



</style>



</head>



<body>




<header class="header">


<div class="logo">

🚲 BikeZone

</div>



<div class="nav">


<a href="CustomerDashboard.php">

Home

</a>



<a href="BuyingCart.php">

My Cart

</a>



<a href="logout.php">

Logout

</a>


</div>



</header>







<div class="container">



<div class="product-container">





<div class="product-image">


<img src="<?php echo htmlspecialchars($bike["image"]); ?>">


</div>






<div class="product-info">



<h1>

<?php echo htmlspecialchars($bike["name"]); ?>

</h1>




<div class="price">

৳

<?php echo number_format($bike["price"]); ?>

</div>





<div class="info">


<p>

<b>Brand:</b>

<?php echo htmlspecialchars($bike["brand"]); ?>

</p>



<p>

<b>Model:</b>

<?php echo htmlspecialchars($bike["model"]); ?>

</p>



<p>

<b>Available Quantity:</b>

<?php echo $bike["quantity"]; ?>

</p>



<p>

<b>Seller:</b>

<?php echo htmlspecialchars($bike["seller"]); ?>

</p>



<p>

<b>Description:</b>

<?php echo htmlspecialchars($bike["description"]); ?>

</p>



</div>





<form method="POST"

action="../Controller/addToCart.php">



<input type="hidden"

name="bike_id"

value="<?php echo $bike["id"]; ?>">





<div class="quantity-box">


<label>

Select Quantity:

</label>



<br>



<input type="number"

name="quantity"

value="1"

min="1"

max="<?php echo $bike["quantity"]; ?>">



</div>






<input class="cart-btn"

type="submit"

value="Add To Buying Cart">



</form>



<br>



<a class="btn"

href="CustomerDashboard.php">


Back To Bikes


</a>



</div>



</div>



</div>







<footer class="footer">


© 2026 BikeZone | Customer Panel


</footer>



</body>


</html>