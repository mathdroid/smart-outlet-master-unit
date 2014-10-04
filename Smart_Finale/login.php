<?php 
    include_once("login2.php" );
?>

<?php if( !(isset( $_POST['login'] ) ) ) { ?>

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
            <form method="POST" action="">                        
                <label for="usn">Username : </label>
                <input type="text" maxlength="30" required autofocus name="username" />
                <label for="passwd">Password : </label>
                <input type="password" maxlength="30" required name="password" />
                <input type="submit" name="login" value="login" />
                <input type="button" name="register" value="Register" onclick="location.href='register.php'" />                        
            </form>  
        </div>    
    </body>
</html>

<?php 
} else {
	$usr = new login;
	$usr->storeFormValues( $_POST );
	
	if( $usr->userLogin() ) {
		header('Location: index.php') ;	
	} else {
		echo "Incorrect Username/Password";	
	}
}
?>