<?php


require_once "conf.php" ;

if(isset($_COOKIE['logged_in'])) {

	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$usr1 = $_COOKIE['user_name'];
		$usr2 = $_POST["usr2"];

		$sql = "SELECT from_usr, msg FROM radhika_chat WHERE ( from_usr = :usr1 AND to_usr = :usr2 ) OR ( from_usr= :usr2 AND to_usr= :usr1)";

		if($stmt = $pdo->prepare($sql)) {

			$stmt->bindParam(":usr1", $param_from_usr, PDO::PARAM_STR);
			$stmt->bindParam(":usr2", $param_to_usr, PDO::PARAM_STR);

			$param_to_usr = $usr2;
			$param_from_usr = $usr1 ;


			$chat = array();

			if ($stmt->execute()) {
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$chat[] = $row;
				}
			}	
		}
		unset($sql);
		unset($stmt);

	}

	$msg="";
} else {
	header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<header><a href="./logout.php">LogOut</a> &nbsp; <a href="./profile.php">Update Profile</a></header>
	<h2>Conversation with <?php echo $usr2; ?></h2>
	<?php foreach ($chat as $key => $value): ?>
		<div>
			<?php echo $value['from_usr']; ?> : <?php echo $value['msg']; ?>
		</div>
	<?php endforeach; ?>

	<div>
		<form method="post">
			<input type="text" name="msg" value="<?php echo $msg; ?>" id="msg">
			<input type="button" value="Send" name="<?php echo $usr2; ?>" id="send">
		</form>
	</div>
</body>

	<script type="text/javascript" src="./sendmsg.js"></script>
</html>