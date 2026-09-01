<!DOCTYPE html>

<html>


<head>

<title>

BikeZone Login

</title>


<link rel="stylesheet" href="../Assets/css/style.css">


<style>


.auth-body{

height:100vh;

display:flex;

justify-content:center;

align-items:center;

background:#f3f4f6;

}



.auth-card{


width:400px;

background:white;

padding:40px;

border-radius:20px;

box-shadow:0 10px 30px rgba(0,0,0,0.15);


}



.auth-card h1{


text-align:center;

margin-bottom:30px;


}



.form-group{


margin-bottom:20px;


}



.form-group label{


display:block;

font-weight:bold;

margin-bottom:8px;


}



.form-group input{


width:100%;

padding:12px;

border-radius:8px;

border:1px solid #ccc;

font-size:15px;


}



.login-btn{


width:100%;

background:#2563eb;

color:white;

padding:12px;

border:none;

border-radius:8px;

font-size:16px;

cursor:pointer;


}



.login-btn:hover{


background:#1d4ed8;


}



.register-link{


text-align:center;

margin-top:20px;


}


.register-link a{


color:#2563eb;

text-decoration:none;


}



.logo-text{


text-align:center;

font-size:35px;

font-weight:bold;

color:#111827;

margin-bottom:10px;


}


</style>


</head>



<body class="auth-body">



<div class="auth-card">



<div class="logo-text">

🚲 BikeZone

</div>



<h1>

Login

</h1>




<form method="POST"

action="../Controller/loginValidation.php">





<div class="form-group">


<label>

Username

</label>


<input type="text"

name="username"

placeholder="Enter username"

required>


</div>





<div class="form-group">


<label>

Password

</label>


<input type="password"

name="password"

placeholder="Enter password"

required>


</div>




<input class="login-btn"

type="submit"

value="Login">





</form>




<div class="register-link">


Don't have an account?


<a href="registration.php">

Register

</a>



</div>



</div>



</body>


</html>