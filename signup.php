<?php
	
	include_once 'DBConnector.php';
	include_once 'user.php';

	$con = new DBConnector;

	if (isset($_POST['btn_save'])) {
		$username = $_POST['username'];
		$first_name = $_POST['first_name'];
		$second_name = $_POST['second_name'];
		$password = $_POST['password'];

		$user = new User($first_name, $second_name, $username, $password);

		if ($user->isUserExist($username)) {
			$user->createFormErrorSessions("Username already exists");
			header("Refresh:0");
			die();
		}

		if (!$user->validateForm()) {
			$user->createFormErrorSessions("All fields are required");
			header("Refresh:0");
			die();
		}
			
		$res = $user->save();

		if ($res) {
			echo "Welcome to The Good Food";
		} else {
			echo "An error occured!";
		}

		$con->closeDatabase();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Sign up</title>
	<link rel="stylesheet" type="text/css" href="signup.css">
	<script type="text/javascript" src="validate.js"></script>
</head>
<body>
	<div class="header">
		<h3>Sign Up</h3>
	</div>
	<form method="post" name="user_details" id="user_details" onsubmit="return validateForm()" action="<?=$_SERVER['PHP_SELF']?>">
		<table align="center">
			<tr>
				<td>
					<div id="form-errors">
						<?php
							session_start();
							if (!empty($_SESSION['form_errors'])) {
								echo " " . $_SESSION['form_errors'];
								unset($_SESSION['form_errors']);
							}
						?>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="username" placeholder="Username" required>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="first_name" placeholder="First Name" required>
				</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="second_name" placeholder="Second Name" required>
				</td>
			</tr>
			
			<tr>
				<td>
					<input type="password" name="password" placeholder="Password" required>
				</td>
			</tr>
			<tr>
				<td>
					<input type="password" name="repass" placeholder="Retype Password" required>
				</td>
			</tr>
			
				<td>
					<button type="submit" name="btn_save"><strong>Create Account</strong></button> 
				</td>
			</tr>
			<tr>
				<td>
					<button type="cancel" name="btn_cancel"><strong>Cancel</strong></button> 
				</td>
			</tr>
			<tr>
			<td><p> Have an account?</p></td>
			</tr>
			<tr>
				<td>
					<a href="login.php">Login</a>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
