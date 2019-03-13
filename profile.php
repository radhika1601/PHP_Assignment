<?php
	
require_once 'conf.php';



if($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty(trim($_POST["name"]))) {
		$name_err = "Name is required";
	} else {
		$name = sanitize_i($_POST["name"]);

		if(!preg_match("/^[a-zA-Z]+([\.\s']?[a-zA-Z])*[a-zA-Z\.]*$/", $name)) {
			$name_err = "Enter name in write Format";
		}
	}

	if(empty(trim($_POST["username"]))) {
		$username_err = "Username is required";
	} else {
		$username = sanitize_i($_POST["username"]);

		$sql = "SELECT id FROM radhika_user WHERE username = :username";

		if($stmt = $pdo->prepare($sql)){
	        
			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
		            
			$param_username = $_POST["username"];
		            
			if($stmt->execute()) {
				if($stmt->rowCount() == 1) {
					$username_err = "This username is already taken.";
				}
			} else {
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		unset($stmt);
	}

	if(empty(trim($_POST["email"]))) {
		$email_err = "Email is required";
	} else {
		$email = sanitize_i($_POST["email"]);

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_err = "Invalid email format";
		}
	}

	if(empty($_POST["gender"])) {
		$gender_err = "Gender is required";
	} else {
		$gender = sanitize_i($_POST["gender"]);
	}

	if(empty(trim($_POST["mob_num"]))) {
		$mob_num_err = "";
	} else {
		$mob_num = sanitize_i($_POST["mob_num"]);

		if(!preg_match("/^(?:(?:\+|0{0,1})91(\s*[\-]\s*)?|[0]?)?[6-9]\d{4}[-]?\d{5}$/", $mob_num)) {
			$mob_num_err = "Enter Mobile Number in write Format";
		}
	}

	if(empty($name_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($gender_err) && empty($mob_num_err)) {

		$sql = "UPDATE radhika_user (username, name , password, email, gender, mob_num) VALUES (:username, :name , :password, :email, :gender, :mob_num)";

		if($stmt = $pdo->prepare($sql)) {

			$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
			$stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
			$stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
			$stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
			$stmt->bindParam(":gender", $param_gender, PDO::PARAM_STR);
			$stmt->bindParam(":mob_num", $param_mob_num, PDO::PARAM_STR);

			$param_username = $username ;
			$param_name = $name ;
            $param_password = password_hash($password, PASSWORD_DEFAULT) ;
            $param_email = $email ;
            $param_gender = $gender ;
            $param_mob_num = $mob_num;

            if($stmt->execute()) {

            } else {
            	echo "Something went wrong. Please try again later.";
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
	<title></title>
</head>
<body>

	<form action="./upload.php" method="POST" enctype="multipart/form-data">
		<div>
			<label>Profile Picture</label>
			<input type="file" name="pic">
		</div>	
		<div>
			<label>Upload</label>
			<input type="submit" name="submit" value="upload">
		</div>
	</form>
</body>
</html>