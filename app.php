<!DOCTYPE html>
<html>
<head>
	<title>Book Appointment</title>
	<style type="text/css">
		h1{
			text-align: center;
			background-color: powderblue;
		}
		h3,p{
			text-align: center;
		}
		h3{
			margin-top: 100px;
		}
	</style>
</head>
<body>
<h1>Online Appointment Mangement System</h1>

<?php


session_start();
if(isset($_SESSION['success']))
{
	echo '<p style="color: DodgerBlue; text-align:center;">'.$_SESSION['success'].'</p><br>';
	unset($_SESSION['success']);
}

if( ! isset($_SESSION['account']) )
{
	echo '<h3>Welcome To Online Appointment Management System</h2>';
	echo '<p>For using the system you have to register first</p>';
	echo '<p>If you are here for the first time you can <a href="register.php">Register</a> here.</p>';
	echo '<p>Or you can <a href="login.php">Login</a> here.</p>';

}
else
{
	echo '<p>You are logged in as '.$_SESSION['account'].'</p>';
	require_once "first-page.php";
	echo '<p>Please <a href="logout.php">log out</a> when you are done.</p>';
}


?>
</body>
</html>