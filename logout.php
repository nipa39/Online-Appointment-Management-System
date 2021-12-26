<!DOCTYPE html>
<html>
<head>
	<title>Logout.php</title>
</head>
<body>
<?php
session_start();
session_destroy();
header("Location:app.php");
?>
</body>
</html>