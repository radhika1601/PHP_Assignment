<?php

require_once "conf.php";

$usr = $HTTP_RAW_POST_DATA;
$usr = json_decode($usr);

$username = $usr->username ;

$sql = "SELECT id FROM radhika_user WHERE username = :username";

if($stmt = $pdo->prepare($sql)){
    
	$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
	$param_username = $username;
            
	if($stmt->execute()) {
		if($stmt->rowCount() == 1) {
			echo "Username not Available";
		}
		else
			echo "Username Available" ;
	}
}
unset($sql);
unset($stmt);

?>