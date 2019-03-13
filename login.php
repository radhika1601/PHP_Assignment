<?php

if(isset($_COOKIE['loggedin']) ) {
	header("location: index.php");
	exit;
}

require_once "conf.php";
include 'hash.php';

$username = $passwd = "";
$username_err = $passwd_err = "" ;

if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty(trim($_POST["username"]))) {
		$username_err = "Please enter username" ;
	} else {
		$username = sanitize_i($_POST["username"]);
	}

	if(empty(trim($_POST["passwd"]))) {
		$passwd_err = "Please enter the password." ;
	} else {
		$passwd = sanitize_i($_POST["passwd"]);
	}

	if (empty($username_err) && empty($passwd_err)) {
		
		$sql = "SELECT id, username, password FROM radhika_user WHERE username = :username" ;

		if($stmt = $pdo->prepare($sql)) {

			//$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

			$param_username = $username;

			if ($stmt->execute()) {

				if($stmt->rowCount() == 1) {
					if($row = $stmt->fetch()) {
						$id = $row["id"];
						$username = $row["username"];
						$hashed_passwd = $row["password"] ;
						if(password_verify($passwd, $hashed_passwd)) {

							setcookie('logged_in', $cook, time()+86400*30);
							
							setcookie('user_id', $id, time()+86400*30);
							setcookie('user_name', $username, time()+86400*30);

							header("location: index.php");
						} else {
							$passwd_err = "Invalid password.";
						}
					}
				} else {
					$username_err = "No account exists with the above Username.";
				}
			} else {
				echo "Something went wrong. Please try again later." ;
			}
		}
		unset($stmt);
	}
	unset($pdo);
}

function sanitize_i($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h2>Login</h2>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

		<div>
			<label>Username</label>
			<input type="text" name="username" value="<?php echo $username; ?>">
			<span><?php echo $username_err; ?></span>
		</div>
		<div>
			<label>Password</label>
			<input type="password" name="passwd" value="<?php echo $passwd; ?>">
			<span><?php echo $passwd_err; ?></span>
		</div>
		<div>
			<input type="submit" value="Login">
		</div>
		<p>Don't have an account? <a href="signup.php">Sign Up</a></p>
	</form>
</body>
</html>