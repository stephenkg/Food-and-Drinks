<?php

	include_once 'DBConnector.php';
	include_once 'user.php';

	$con = new DBConnector;

	if (isset($_POST['btn-login'])) {
	
		$username = $_POST['username'];
		$password = $_POST['password'];

		$instance = User::create();

		$instance->setPassword($password);
		$instance->setUsername($username);

		if ($instance->isPasswordCorrect()) {

			$instance->login();

			$con->closeDatabase();

			$instance->createUserSession();



		} else {
			$con->closeDatabase();
			 header("Location:login.php");
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="signup.css">
</head>
<body>
	<div class="header">
		<h3>Login</h3>
	</div> 
	<form method="post" name="login" id="login" action="<?=$_SERVER['PHP_SELF']?>">
		<table align="center">
			<tr>
				<td>
					<input type="text" name="username" placeholder="Username" required>
				</td>
			</tr>
			<tr>
				<td>
					<input type="password" name="password" placeholder="password" required>
				</td>
			</tr>
			<tr>
				<td>
					<button type="submit" name="btn-login"><strong>LOGIN</strong></button> 
				</td>
			</tr>
		</table>
	</form>
</body>
</html>