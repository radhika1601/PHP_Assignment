<?php
require_once "conf.php" ;
session_start();

if((!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)) {
	header("location: login.php");
	exit;
} else {
	$usr = $_COOKIE['user_name'];
	$stmt = $pdo->prepare("SELECT id,username FROM radhika_user WHERE username != :usr");

	$stmt->bindParam(":usr", $param_username, PDO::PARAM_STR);
	$param_username = $usr;

	$users = array();
	if ($stmt->execute()) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$users[] = $row;
		}
		// print_r($users);
	}

	unset($stmt);
	unset($pdo);
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
	<div id="users_display" style="height: 80%; overflow-y: scroll;">
		<?php foreach ($users as $key => $value): ?>
			<form action="./chat.php" method= "POST">
				<input type="submit" name="usr2" value="<?php echo $value['username'] ?>">	
			</form>
			
		<?php endforeach; ?>
	</div>
	<div>
		<form method="post">
			<input type="text" name="msg">
			<input type="submit" value="Send">
		</form>
	</div>
</body>
</html>