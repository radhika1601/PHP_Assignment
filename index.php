<?php

session_start();

if((!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)){
	header("location: login.php");
	exit;
} else {

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
	<div id="chat_display" style="height: 80%; overflow-y: scroll;">
		Conversation:
		
	</div>
	<div>
		<form method="post">
			<input type="text" name="msg">
			<input type="submit" value="Send">
		</form>
	</div>
</body>
</html>