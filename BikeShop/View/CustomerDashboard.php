<?php

session_start();


if (!isset($_SESSION["logged_In"]) ||
    $_SESSION["role"] != "customer")
{
    header("Location: loginpage.php");
    exit;
}


include "../Model/db.php";



$search = "";



if(isset($_GET["search"]))
{
    $search = trim($_GET["search"]);
}



if($search != "")
{

    $sql = "SELECT *

            FROM bikes

            WHERE name LIKE ?

            OR brand LIKE ?

            OR model LIKE ?

            ORDER BY id DESC";


    $stmt = $conn->prepare($sql);


    $value = "%".$search."%";


    $stmt->bind_param(
        "sss",
        $value,
        $value,
        $value
    );


    $stmt->execute();


    $result = $stmt->get_result();


}

else

{

    $sql = "SELECT *

            FROM bikes

            ORDER BY id DESC";


    $result = $conn->query($sql);

}



?>


<!DOCTYPE html>

<html>


<head>


<title>Customer Dashboard</title>


<link rel="stylesheet" href="../Assets/css/style.css">



<style>


.search-box{

text-align:center;

margin-bottom:40px;

}



.search-box input[type=text]{


width:350px;

padding:12px;

border-radius:8px;

border:1px solid #ccc;


}



.bike-container{


display:grid;

grid-template-columns:

repeat(auto-fit,minmax(280px,1fr));

gap:25px;


}



.bike-card{


background:white;

border-radius:15px;

overflow:hidden;

box-shadow:0 5px 20px rgba(0,0,0,0.1);

transition:.3s;


}



.bike-card:hover{


transform:translateY(-5px);


}



.bike-card img{


width:100%;

height:220px;

object-fit:cover;


}



.bike-info{


padding:20px;


}



.bike-info h2{


color:#111827;

margin-bottom:10px;


}



.price{


font-size:20px;

font-weight:bold;

color:#16a34a;


}



.stock{


margin-top:10px;

}



.details-btn{


display:inline-block;

margin-top:15px;

background:#2563eb;

color:white;

padding:10px 20px;

border-radius:8px;

text-decoration:none;


}



.details-btn:hover{


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





<h1>

Welcome,

<?php

echo htmlspecialchars($_SESSION["username"]);

?>

</h1>



<br>





<div class="search-box">



<form method="GET">


<input type="text"

name="search"

placeholder="Search bike name, brand or model"

value="<?php echo htmlspecialchars($search); ?>">



<input class="btn"

type="submit"

value="Search">


</form>



<br>



<a class="btn"

href="CustomerDashboard.php">

Home Page

</a>



</div>







<div class="bike-container">



<?php



if($result->num_rows > 0)

{


while($bike=$result->fetch_assoc())

{


?>



<div class="bike-card">



<img src="<?php echo htmlspecialchars($bike["image"]); ?>">





<div class="bike-info">



<h2>

<?php

echo htmlspecialchars($bike["name"]);

?>

</h2>




<p>

Brand:

<?php

echo htmlspecialchars($bike["brand"]);

?>

</p>




<p>

Model:

<?php

echo htmlspecialchars($bike["model"]);

?>

</p>





<p class="price">

৳

<?php

echo number_format($bike["price"]);

?>

</p>




<p class="stock">

Available:

<?php

echo $bike["quantity"];

?>

</p>




<a class="details-btn"

href="BikeDetails.php?id=<?php echo $bike["id"]; ?>">


View Details


</a>




</div>


</div>



<?php


}


}

else

{


?>


<h2>

No Bike Found

</h2>


<?php


}



?>



</div>




</div>







<footer class="footer">


© 2026 BikeZone | Customer Panel


</footer>





</body>


</html>