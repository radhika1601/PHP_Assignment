<?php
	




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