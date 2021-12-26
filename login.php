<?php
require_once "pdo.php";
session_start();
if(isset($_POST['email']) && isset($_POST['password']))
{
	unset($_SESSION['account']);
	$sql = "SELECT patient_first_name,patient_id FROM patient_table WHERE patient_email_address=:email AND patient_password=:password";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array(':email'=>$_POST['email'],':password'=>$_POST['password']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($row !== false )
	{
		//$_SESSION['account'] = $_POST['account'];
		$_SESSION['account'] = $row['patient_first_name'];
		$_SESSION['patient_id']=$row['patient_id'];
		$_SESSION['success'] = 'Logged In.';
		header("Location:app.php");
		
		return;
	}
	else
	{
		$_SESSION['error']='Incorrect Password';
		header("Location:login.php");
		return;
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<style type="text/css">
		body{
			font-family: "Open Sans",Sans-serif;
		}
		form{
			width: 500px;
			font-size: 18px;
			margin: auto;
			
		}
		input{
			width: 400px;
			line-height: 1.6;
			margin-bottom: 10px;
			margin-left: 25px;
			
		}
		label{
			margin-left: 25px;
		}

		h2{
			text-align: center;
			background-color: powderblue;
		}

	</style>
</head>
<body>
<h2>Please Login</h2>
<?php
if(isset($_SESSION['error']))
{
	echo '<p style="color: red">'.$_SESSION['error'].'</p><br>';
	unset($_SESSION['error']);
}
if(isset($_SESSION['success']))
{
	echo '<p style="color: green">'.$_SESSION['success'].'</p><br>';
	unset($_SESSION['success']);
}

?>
<form method="post">
	<fieldset>
		<legend style="margin-top: 20px; margin-bottom: 20px; font-size: 20px;">Login Info:</legend>
		<label for="email">Email:</label><br>
		<input type="email" id="email" name="email" size="40" value=""><br>
		<label for="password">Password:</label><br>
		<input type="password" id="password" name="password" value=""><br>
		
		<input style="width: 100px; margin-left: 175px; margin-top: 20px; font-size: 20px;" type="submit" name="submit" value="Login"><br><br>
	</fieldset>
</form>
</body>
</html>