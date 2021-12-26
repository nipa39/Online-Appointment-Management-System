

<!DOCTYPE html>
<html>
<head>
	<title>Appointment</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<style type="text/css">
		body{
			font-family: "Open Sans",Sans-serif;
		}
		form{
			width: 500px;
			margin: auto;
			font-size: 18px;
			
		}
		label{
			width: 300px;
			line-height: 1.6;
			height: 28px;
			margin-bottom: 10px;
			padding: 5px;
			
		}
		.lbl{
			margin-left: 10px;
		}
		textarea{
			margin-left: 20px;
		}
		input{

		}
		h2{
			text-align: center;
			background-color: powderblue;
		}
	</style>
</head>
<body>
<?php
session_start();
require_once "pdo.php";
if(isset($_GET['doctor_id']) && isset($_GET['doctor_schedule_id'])){
$sql = "SELECT patient_first_name,patient_last_name,patient_address,patient_phone_no,patient_id FROM patient_table WHERE patient_first_name=:fname";
$stmt= $pdo->prepare($sql);
$stmt->execute(array(':fname'=>$_SESSION['account']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['patient_first_name'] = $row['patient_first_name'];
$_SESSION['patient_last_name'] = $row['patient_last_name'];
$_SESSION['patient_address'] = $row['patient_address'];
$_SESSION['patient_phone_no'] = $row['patient_phone_no'];
$sql2 = "SELECT doctor_name FROM doctor_table WHERE doctor_id=:doctor_id";
$stmt2= $pdo->prepare($sql2);
$stmt2->execute(array(':doctor_id'=>$_GET['doctor_id']));
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$_SESSION['doctor_name']=$row2['doctor_name'];
$sql3 = "SELECT doctor_schedule_date,doctor_schedule_day,doctor_schedule_start_time,doctor_schedule_end_time FROM `doctor_schedule_table` WHERE doctor_schedule_id=:doctor_schedule_id";
$stmt3= $pdo->prepare($sql3);
$stmt3->execute(array(':doctor_schedule_id'=>$_GET['doctor_schedule_id']));
$row3 = $stmt3->fetch(PDO::FETCH_ASSOC);
$_SESSION['doctor_schedule_date']=$row3['doctor_schedule_date'];
$_SESSION['doctor_schedule_day']=$row3['doctor_schedule_day'];
$_SESSION['doctor_schedule_start_time']=$row3['doctor_schedule_start_time'];
$_SESSION['doctor_schedule_end_time']=$row3['doctor_schedule_end_time'];
}
if(isset($_POST['submit']))
{

	$sql5 = "SELECT MAX(appointment_number) FROM appointment_table";
	$stmt5 = $pdo->query($sql5);
	$row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
	$_SESSION['appointment_number']=$row5['MAX(appointment_number)']+1;
	$sql4 = "INSERT INTO appointment_table (doctor_id,patient_id,doctor_schedule_id,reason_for_appointment,appointment_time,appointment_number)
VALUES(:doctor_id,:patient_id,:doctor_schedule_id,:reason_for_appointment,:appointment_time,:appointment_number)";
	$stmt4 = $pdo->prepare($sql4);
	$doctor_id_ = (int)$_GET['doctor_id'];
	$doctor_schedule_id_ = (int)$_GET['doctor_schedule_id'];
	$stmt4->execute(array(':doctor_id'=>$doctor_id_,':patient_id'=>$row['patient_id'],
	':doctor_schedule_id'=>$doctor_schedule_id_,':appointment_time'=>$row3['doctor_schedule_start_time'],
':reason_for_appointment'=>$_POST['reason'],':appointment_number'=>$row5['MAX(appointment_number)']+1));
	$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
	$num=$_SESSION['appointment_number']-1000;
	$_SESSION['success']="Your Appointment is confirmed.Your Serial Number is 00".$num.".";
	header("Location:appointment.php");
	return;
}

?>	
<h2>Confirm Your Appointment</h2>
<?php

if(isset($_SESSION['success']))
{
	echo '<p style="color: DodgerBlue; text-align:center;">'.$_SESSION['success'].'</p><br>';
	unset($_SESSION['success']);
}

?>


<form method="post">
	<fieldset>
		<legend style="margin-top: 20px; margin-bottom: 20px; font-size: 20px;">Patient Info:</legend>
		<label class="lbl">Name : </label><label><?php echo ''.$_SESSION['patient_first_name'].' '.$_SESSION['patient_last_name'].''; ?>	
		</label><br>
		<label class="lbl">Address : </label><label><?php echo ''.$_SESSION['patient_address'].' ' ?></label><br>
		<label class="lbl">Contact No : </label><label><?php echo $_SESSION['patient_phone_no']; ?></label><br>
	</fieldset>
	<fieldset>
		<legend style="margin-top: 30px; margin-bottom: 20px; font-size: 20px;">Appointment Info:</legend>
		<label class="lbl">Doctor Name : </label><label><?php echo $_SESSION['doctor_name']; ?></label><br>
		<label class="lbl">Appointment Date : </label><label><?php echo $_SESSION['doctor_schedule_date']; ?></label><br>
		<label class="lbl">Appointment Day : </label><label><?php echo $_SESSION['doctor_schedule_day']; ?></label><br>
		<label class="lbl">Available Time : </label><label><?php echo $_SESSION['doctor_schedule_start_time'].'-'.$_SESSION['doctor_schedule_end_time']; ?></label><br>
		<label class="lbl" id="reason">Reason for Appointment : </label><br>
		<textarea id="reason" name="reason" rows="4" cols="50"></textarea><br>
		<input style="width: 100px; margin-left: 175px; margin-top: 20px; font-size: 18px;" type="submit" name="submit" value="Confirm"><br>

	</fieldset>
</form>
</body>
</html>