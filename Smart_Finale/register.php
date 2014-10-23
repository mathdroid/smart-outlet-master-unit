<?php 
	include_once("login2.php");
	include_once("psl-config.php");
?>

<?php if( !(isset( $_POST['register'] ) ) ) { ?>


<!DOCTYPE html>
<html>
    <head>        
        <link rel="stylesheet" type="text/css" href="css/login_style.css" />
    </head>
    
    <body>
        <div class="body"></div>
        <div class="grad"></div>
		<div class="header">
                <div>Smart<span> Monitoring</span></div>
		</div>
        <br>
        <div class="login">
        	<form method="post">
                <label for="usn">Username : </label>
                <input type="text" id="usn" maxlength="30" required autofocus name="username" />
                <label for="passwd">Password : </label>
                <input type="password" id="passwd" maxlength="30" required name="password" />
            	<label for="conpasswd">ConfPass : </label>
            	<input type="password" id="conpasswd" maxlength="30" required name="conpassword" />
            	<input type="submit" name="register" value="Register" />
                <input type="button" name="cancel" value="Cancel" onclick="location.href='index.php'" />
        	</form>
        </div>
    </body>
</html>

<?php 
} else {
	$usr = new login;
	$usr->storeFormValues( $_POST );
	
	if( $_POST['password'] == $_POST['conpassword'] ) {
		echo $usr->UserRegister($_POST);	
	} else {
		echo "Password and Confirm password not match";	
	}
}
?>
