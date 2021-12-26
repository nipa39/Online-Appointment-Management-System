<!DOCTYPE html>
<html>
<head>
	<title>Book Appointment</title>
	<style type="text/css">
		h1,h2{
			text-align: center;
			background-color: powderblue;
		}
		table{
			border: 1px solid black;
			background-color: powderblue;
			position: relative;
			top: -200px;
		}
		tr:nth-child(even) {
  			background-color: #D6EEEE;
		}
		th,td{
			padding: 10px;
		}
		th{
			font-size: 20px;
		}
	</style>
</head>
<body>


<?php
require_once "pdo.php";
$sql = "SELECT doctor_schedule_table.doctor_schedule_id,doctor_table.doctor_id,doctor_name,doctor_expert_in,doctor_schedule_date,
doctor_schedule_day,doctor_schedule_start_time
FROM doctor_schedule_table JOIN doctor_table ON doctor_schedule_table.doctor_id=doctor_table.doctor_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
?>

<h2>Doctor Schedule List</h2>
<table style="width:100%" table-layout="fixed">
	<tr>
		<th>Doctor Name</th>
		<th>Speciality</th>
		<th>Appointment Date</th>
		<th>Appointment Day</th>
		<th>Available Time</th>
	</tr>


<?php
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
	echo "<tr><td>";
	echo $row['doctor_name'];
	echo "</td><td>";
	echo $row['doctor_expert_in'];
	echo "</td><td>";
	echo $row['doctor_schedule_date'];
	echo "</td><td>";
	echo $row['doctor_schedule_day'];
	echo "</td><td>";
	echo $row['doctor_schedule_start_time'];
	echo "</td><td>";
	echo ('<a href="appointment.php?doctor_id='.$row['doctor_id'].'&doctor_schedule_id='.$row['doctor_schedule_id'].'" >Add Appointment</a>');
	echo "</td></tr><br>";
}

?>
</table>
</body>
</html>