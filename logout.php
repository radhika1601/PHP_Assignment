<?php

setcookie("logged_in", "", time()-3600);
setcookie("user_id", "", time()-3600);
setcookie("user_name", "", time()-3600);

header("location: login.php");
exit();
?>