<?php

require_once "conf.php" ;

$uid = $_COOKIE['user_id'];
$uname = $_COOKIE['user_name'];
if (isset($_POST['submit'])) {
	$pic = $_FILES['pic'];

	$fileName = $_FILES['pic']['name'];
	$fileTmpName = $_FILES['pic']['tmp_name'];
	$fileSize = $_FILES['pic']['size'];
	$fileError = $_FILES['pic']['error'];
	$fileType = $_FILES['pic']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('jpg' ,'jpeg', 'png');

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			if ($fileSize < 100000) {
				$fileNameNew = $uid. "." .$fileActualExt;
				$fileDestination = "./uploads/".$fileNameNew ;
				//var_dump($fileDestination);
				chmod($_FILES['pic']['tmp_name'], 0777);
				//chmod("./uploads/", 0777);
				move_uploaded_file($fileTmpName, $fileDestination);
				//

				$sql = "UPDATE radhika_img SET status=true WHERE id=:uid";
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(":uid", $param_id , PDO::PARAM_STR);
            	$param_id = $uid ;

            	$stmt->execute();
            	header("location: profile.php");

			} else {
				echo "Very large fileSize";
			}
		} else {
			echo "There was some error uploading the image." ;
		}	
	} else {
		echo "Profile picture should be in jpg, jpeg, png." ;
	}
}

?>