<?php include_once (LIBRARY_PATH . "/user.php"); ?>
<?php if( !(isset( $_POST['register'] ) ) ) { ?>


	<div id="main-wrapper" style="margin-top:50px; ">
		<div id="register-wrapper">
			<form method="post" action="">
				<label for="usn">Username : </label> 
				<input type="text" id="usn" maxlength="30" required autofocus name="username" />
				<br>
				<label for="passwd">Password : </label> 
				<input type="password" id="passwd" maxlength="30" required name="password" />
				<br>
				<label for="conpasswd">Confirm Password : </label> 
				<input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
				<br>
				<button type="submit" name="register" value="Register">Register</button> |
				<button type="button" name="cancel" value="Cancel" onclick="location.href='index.php'">Cancel</button>
			</form>
		</div>
	</div>

	
<?php
}
else
{
	$usr = new User();
	$usr->storeFormValues($_POST);
	
	if ($_POST['password'] == $_POST['conpassword'])
	{
		echo $usr->register($_POST);
	}
	else
	{
		echo "Password and Confirm password not match";
	}
}
?>