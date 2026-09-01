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


// TOTAL USERS

$userQuery = "SELECT COUNT(*) AS total FROM users";

$userResult = $conn->query($userQuery);

$totalUsers = $userResult->fetch_assoc()["total"];




// TOTAL BIKES

$bikeQuery = "SELECT COUNT(*) AS total FROM bikes";

$bikeResult = $conn->query($bikeQuery);

$totalBikes = $bikeResult->fetch_assoc()["total"];




// TOTAL SALES

$saleQuery = "SELECT COUNT(*) AS total FROM activity";

$saleResult = $conn->query($saleQuery);

$totalSales = $saleResult->fetch_assoc()["total"];



?>


<!DOCTYPE html>

<html>


<head>

<title>Admin Dashboard</title>


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



<h1>

Welcome,

<?php

echo htmlspecialchars($_SESSION["username"]);

?>

</h1>


<br>




<div class="dashboard">



<div class="dashboard-card">

<h2>

<?php echo $totalUsers; ?>

</h2>


<p>

Total Users

</p>


</div>




<div class="dashboard-card">


<h2>

<?php echo $totalBikes; ?>

</h2>


<p>

Total Bikes

</p>


</div>




<div class="dashboard-card">


<h2>

<?php echo $totalSales; ?>

</h2>


<p>

Total Sales

</p>


</div>




</div>




<br><br>




<div class="card">


<h2>

Admin Management

</h2>


<br>



<a class="btn"

href="manageUsers.php">

Manage Users

</a>



&nbsp;



<a class="btn"

href="manageBikes.php">

Manage Bikes

</a>




&nbsp;



<a class="btn"

href="activity.php">

Buy & Sell Activity

</a>



</div>




</div>





<footer class="footer">


© 2026 BikeZone | Admin Panel


</footer>




</body>


</html>