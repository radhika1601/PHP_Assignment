<?php

require_once "conf.php" ;

$target_dir = "public_html/";

if ($_SERVER["REQUEST_METHOD"]=="POST") {
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;

	$imgFiletype = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


	if(isset($_POST["submit"])) {

		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

		if ($check !== false) {
			echo "File is an image" . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an Image." ;
			$uploadOk = 0;
		}
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Please upload JPG, JPEG, PNG or GIF file.";
	    $uploadOk = 0;
	}

	if ($uploadOk == 0) {
		echo "Image not uploaded.";
	} else {
		if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "Image has been Uploaded.";
		} else {
			echo "Sorry, there was some error uploading the image.";
		}
	}	
}

?>