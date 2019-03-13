<?php

require_once "conf.php";

$username = $password = $confirm_password = $name = $email = $gender = $mob_num = "" ;
$username_err = $password_err = $confirm_password_err = $name_err = $email_err = $gender_err = $mob_num_err = "" ;


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


	if(empty(trim($_POST["password"]))){
    	$password_err = "Please enter a password.";     
    } else if(strlen(trim($_POST["password"])) < 8) {
    	$password_err = "Password must have atleast 8 characters.";
    } else {
    	$password = sanitize_i($_POST["password"]);
    }
    
    if(empty(trim($_POST["confirm_password"]))) {
    	$confirm_password_err = "Please confirm password.";     
    } else {
	    $confirm_password = sanitize_i($_POST["confirm_password"]);
	    if(empty($password_err) && ($password != $confirm_password)) {
	 	   $confirm_password_err = "Password did not match.";
	    }
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

		$sql = "INSERT INTO radhika_user (username, name , password, email, gender, mob_num) VALUES (:username, :name , :password, :email, :gender, :mob_num)";

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

            	$sql2 = "SELECT id FROM radhika_user WHERE username = :username";

            	$stmt2 = $pdo->prepare($sql2);
            	$stmt2->bindParam(":username", $param_username, PDO::PARAM_STR);
            	$param_username = $username ;

            	$stmt2->execute();
            	$row = $stmt2->fetch();
            	$id = $row['id'];

            	$sql3 = "INSERT INTO radhika_img (id, status) VALUES (:id , false )" ;
            	$stmt3=$pdo->prepare($sql3);
				$stmt3->bindParam(":id", $param_id, PDO::PARAM_STR);
            	$param_id = $id ;

            	$stmt3->execute();

            	header("location: login.php");
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

<!DOCTYPE HTML>  
<html>
<head>
	
</head>
<body>  

<h2>Sign Up</h2>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

	<div>
		<label>Name</label>
		<input type="text" name="name" value="<?php echo $name;?>">
		<span class="error">* <?php echo $name_err; ?></span>
	</div>
	<div>
		<label>Username</label>
		<input type="text" name="username" id="username" value="<?php echo $username;?>" >
		<span id="uname" style="border-radius: 50%;"></span>
		<span class="error">* <?php echo $username_err; ?></span>
	</div>
	<div>
		<label>Password</label>
		<input type="password" name="password" value="<?php echo $password;?>">
		<span class="error">* <?php echo $password_err; ?></span>
	</div>
	<div>
		<label>Confirm Password</label>
		<input type="password" name="confirm_password" value="<?php echo $confirm_password;?>">
		<span class="error">* <?php echo $confirm_password_err; ?></span>
	</div>
	<div>
		<label>Email</label>
		<input type="text" name="email" value="<?php echo $email;?>">
		<span class="error">* <?php echo $email_err; ?></span>
	</div>
	<div>
		<label>Gender</label>
		<input type="radio" name="gender"
			<?php if (isset($gender) && $gender=="female") echo "checked";?>
			value="female">Female
		<input type="radio" name="gender"
			<?php if (isset($gender) && $gender=="male") echo "checked";?>
			value="male">Male
		<input type="radio" name="gender"
			<?php if (isset($gender) && $gender=="other") echo "checked";?>
			value="other">Other
		<span class="error">* <?php echo $gender_err; ?></span>
	</div>
	<div>
		<label>Mobile Number</label>
		<input type="text" name="mob_num" value="<?php echo $mob_num;?>">
		<span class="error"><?php echo $mob_num_err; ?></span>
	</div>
	<div>
		<input type="submit" value="SignUp">
	</div>
	
</form>
<script type="text/javascript" src="signup.js"></script>