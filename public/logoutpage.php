<?php
include_once ("../config/config.php");
include_once (TEMPLATES_PATH . "/header.php");
?>

<?php 

session_destroy();
echo "You are logged out.";
header("Location:main.php");
?>



<?php include_once (TEMPLATES_PATH . "/footer.php"); ?>