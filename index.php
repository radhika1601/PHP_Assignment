<?php

session_start();

if((!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)){
	header("location: login.php");
	exit;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<a href="profile.php">Update Profile</a>
		<a href="logout.php">LOG OUT</a>
	</div>
</body>
</html>