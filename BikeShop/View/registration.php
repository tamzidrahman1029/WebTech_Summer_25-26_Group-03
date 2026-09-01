<!DOCTYPE html>

<html>


<head>


<title>

BikeZone Registration

</title>



<link rel="stylesheet" href="../Assets/css/style.css">



<style>


.auth-body{

min-height:100vh;

display:flex;

justify-content:center;

align-items:center;

background:#f3f4f6;

}



.auth-card{


width:450px;

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


margin-bottom:18px;


}



.form-group label{


display:block;

font-weight:bold;

margin-bottom:7px;


}



.form-group input,
.form-group select{


width:100%;

padding:12px;

border-radius:8px;

border:1px solid #ccc;


}



.register-btn{


width:100%;

background:#16a34a;

color:white;

padding:12px;

border:none;

border-radius:8px;

cursor:pointer;

font-size:16px;


}



.register-btn:hover{


background:#15803d;


}


.register-link{

    text-align:center;

    margin-top:20px;

    font-size:15px;

}


.register-link a{

    color:#2563eb;

    text-decoration:none;

    font-weight:bold;

}


.register-link a:hover{

    text-decoration:underline;

}

</style>



</head>




<body class="auth-body">




<div class="auth-card">



<h1>

🚲 Create Account

</h1>




<form method="POST"

action="../Controller/registrationValidation.php">





<div class="form-group">


<label>

Name

</label>


<input type="text"

name="name"

required>


</div>






<div class="form-group">


<label>

Email

</label>


<input type="email"

name="email"

required>


</div>





<div class="form-group">


<label>

Username

</label>


<input type="text"

name="username"

required>


</div>






<div class="form-group">


<label>

Password

</label>


<input type="password"

name="password"

required>


</div>






<div class="form-group">


<label>

Account Type

</label>



<select name="role">


<option value="customer">

Customer

</option>



<option value="seller">

Seller

</option>
</select>
</div>


<input class="register-btn"

type="submit"

value="Register">


</form>



<div class="register-link">


Already have an account?


<a href="loginPage.php">

Login
</a>
</div>
</div>



</body>


</html>