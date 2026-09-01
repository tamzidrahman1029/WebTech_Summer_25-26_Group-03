<?php

session_start();


if (!isset($_SESSION["logged_In"]) ||
    $_SESSION["role"] != "admin")
{
    header("Location: loginpage.php");
    exit;
}


include "../Model/db.php";


$sql = "SELECT 

        activity.id,

        bikes.name AS bike_name,

        seller.username AS seller_name,

        customer.username AS customer_name,

        activity.quantity,

        activity.total_price,

        activity.status,

        activity.created_at


        FROM activity


        INNER JOIN bikes

        ON activity.bike_id = bikes.id


        INNER JOIN users AS seller

        ON activity.seller_id = seller.id


        INNER JOIN users AS customer

        ON activity.customer_id = customer.id


        ORDER BY activity.id DESC";


$result = $conn->query($sql);

?>


<!DOCTYPE html>

<html>

<head>

<title>Activity</title>


<link rel="stylesheet" href="../Assets/css/style.css">


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
Buy & Sell Activity
</h1>


<br>



<div class="table-box">


<table>


<tr>

<th>ID</th>

<th>Bike</th>

<th>Seller</th>

<th>Customer</th>

<th>Quantity</th>

<th>Total Price</th>

<th>Status</th>

<th>Date</th>


</tr>




<?php


if($result->num_rows > 0)

{


while($activity=$result->fetch_assoc())

{


?>


<tr>


<td>
<?php echo $activity["id"]; ?>
</td>


<td>
<?php echo htmlspecialchars($activity["bike_name"]); ?>
</td>


<td>
<?php echo htmlspecialchars($activity["seller_name"]); ?>
</td>


<td>
<?php echo htmlspecialchars($activity["customer_name"]); ?>
</td>


<td>
<?php echo $activity["quantity"]; ?>
</td>


<td>
<?php echo $activity["total_price"]; ?>
</td>


<td>
<?php echo htmlspecialchars($activity["status"]); ?>
</td>


<td>
<?php echo $activity["created_at"]; ?>
</td>


</tr>


<?php


}


}

else

{


?>


<tr>

<td colspan="8">

No Activity Found

</td>

</tr>


<?php

}


?>


</table>


</div>


<br>


<a class="btn" href="admin.php">

Back To Dashboard

</a>



</div>


</div>




<footer class="footer">

© 2026 BikeZone | Admin Panel

</footer>



</body>

</html>