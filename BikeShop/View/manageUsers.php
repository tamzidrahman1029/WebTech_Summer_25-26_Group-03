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



// SEARCH

$search = "";


if(isset($_GET["search"]))
{
    $search = trim($_GET["search"]);
}



if($search != "")
{


$sql = "SELECT id, name, email, username, role

        FROM users

        WHERE name LIKE ?

        OR email LIKE ?

        OR username LIKE ?

        ORDER BY id DESC";



$stmt = $conn->prepare($sql);



$value = "%" . $search . "%";



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


$sql = "SELECT id, name, email, username, role

        FROM users

        ORDER BY id DESC";


$result = $conn->query($sql);


}



?>


<!DOCTYPE html>

<html>


<head>

<title>Manage Users</title>


<link rel="stylesheet" href="../Assets/css/style.css">


<style>


.badge{

padding:6px 12px;

border-radius:20px;

color:white;

font-size:13px;

}



.admin{

background:#dc2626;

}


.seller{

background:#2563eb;

}


.customer{

background:#16a34a;

}



.delete-btn{

background:#dc2626;

padding:8px 15px;

border-radius:8px;

color:white;

text-decoration:none;

}



.delete-btn:hover{

background:#991b1b;

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

Manage Users

</h1>


<br>




<form method="GET">


<input type="text"

name="search"

placeholder="Search user..."

value="<?php echo htmlspecialchars($search); ?>">



<input class="btn"

type="submit"

value="Search">


</form>



<br><br>




<div class="table-box">


<table>



<tr>


<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Username</th>

<th>Role</th>

<th>Action</th>


</tr>



<?php



if($result->num_rows > 0)

{


while($user=$result->fetch_assoc())

{


?>



<tr>


<td>

<?php echo $user["id"]; ?>

</td>



<td>

<?php echo htmlspecialchars($user["name"]); ?>

</td>



<td>

<?php echo htmlspecialchars($user["email"]); ?>

</td>



<td>

<?php echo htmlspecialchars($user["username"]); ?>

</td>




<td>



<?php


$role = $user["role"];


echo "<span class='badge $role'>";

echo ucfirst($role);

echo "</span>";



?>



</td>



<td>



<a class="delete-btn"

href="../Controller/delete.php?action=user&id=<?php echo $user["id"]; ?>"

onclick="return confirm('Delete this user?');">


Delete


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

<td colspan="6">

No Users Found

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


© 2026 BikeZone | User Management


</footer>



</body>


</html>