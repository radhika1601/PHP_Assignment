<?php

require_once "conf.php" ;

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$data = $HTTP_RAW_POST_DATA;
	$data = json_decode($data);
	
	$msg = $data->msg ;
	if(!empty(trim($msg))) {
		$msg = sanitize_i($msg);
	}
	$usr1 = $_COOKIE['user_name'];
	$usr2 = $data->usr2;


	if (!empty(trim($msg))) {
		
		$sql = "INSERT INTO radhika_chat (msg, from_usr, to_usr) VALUES (:msg, :usr1, :usr2)" ;

		$stmt = $pdo->prepare($sql);

		$stmt->bindParam(":usr1", $param_from_usr, PDO::PARAM_STR);
		$stmt->bindParam(":usr2", $param_to_usr, PDO::PARAM_STR);
		$stmt->bindParam(":msg", $param_msg, PDO::PARAM_STR);

		$param_msg = $msg;
		$param_to_usr = $usr2;
		$param_from_usr = $usr1 ;

		$stmt->execute();
	}
	unset($stmt);
	unset($pdo);

}


function sanitize_i($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
