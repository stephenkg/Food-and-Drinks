<?php 
	
	include 'Crud.php';
	include 'authenticator.php';
	include_once 'DBConnector.php';
	/**
	* 
	*/
	class User implements Crud, Authenticator
	{
		private $con;
		private $user_id;
		private $username;
		private $first_name;
		private $second_name;
		private $password;
				

		function __construct($username, $first_name, $second_name, $password)
		{
			$this->username = $username;
			$this->first_name = $first_name;
			$this->second_name = $second_name;			
			$this->password = $password;
		}

		public static function create()
		{
			// $instance = new self();
			// return $instance;

			$reflection = new ReflectionClass(__CLASS__);
			$instance = $reflection->newInstanceWithoutConstructor();

			return $instance;
		}

		public function setUsername($username)
		{
			$this->username = $username;
		}

		public function getUsername()
		{
			return $this->username;
		}

		public function setPassword($password)
		{
			$this->password = $password;
		}

		public function getPassword()
		{
			return $this->password;
		}

		public function setUserId($user_id)
		{
			$this->user_id = $user_id;
		}

		public function getUserId()
		{
			return $this->user_id;
		}

		public function save()
		{
			$this->DBConnect();
			$uname = $this->username;
			$fn = $this->first_name;
			$ln = $this->second_name;
			$this->hashPassword();
			$pass = $this->password;

			$res = mysqli_query($this->con->conn, "INSERT INTO users(username, firstName, secondName, password) VALUES('$uname', '$fn', '$ln', '$pass')") or die("Error " . mysqli_error($this->con->conn));

			$this->DBClose();
			return $res;
		}

		public function readAll(){
			/*$this->DBConnect();

			$res = mysqli_query($this->con->conn, "SELECT * FROM users") or die("Error " . mysqli_error($this->con->conn));

			$this->DBClose();

			return $res;
			*/
			return null;
		}

		public function readUnique(){return null;}
		public function search(){return null;}
		public function update(){return null;}
		public function removeOne(){return null;}
		public function removeAll(){return null;}


		public function validateForm()
		{	$uname = $this->username;
			$fn = $this->first_name;
			$ln = $this->second_name;
			$pass = $this->password;
			if ($uname == "" || $fn == "" || $ln == "" || $pass == "") {
				return false;
			}
			return true;
		}

		public function createFormErrorSessions($message)
		{
			session_start();
			$_SESSION['form_errors'] = $message;
		}


		public function hashPassword()
		{
			$this->password = password_hash($this->password, PASSWORD_DEFAULT);
		}

		public function isPasswordCorrect()
		{ 
			$con = new DBConnector;
			$found = false;
			$res = mysqli_query($con->conn, "SELECT * FROM users") or die("Error" . mysqli_error($con));

			while ($row = mysqli_fetch_array($res)) {
				if (password_verify($this->getPassword(), $row['password']) && $this->getUsername() == $row['username']) {
					$found = true;
				}
			}

			$con->closeDatabase();
			
			return $found;
		}

		public function login()
		{
			if ($this->isPasswordCorrect()) {
				header("Location:home.html");
			}
		}

		public function logout()
		{
			session_start();
			unset($_SESSION['username']);
			session_destroy();
			header("Location:signup.php");
		}

		public function createUserSession()
		{
			session_start();
			$_SESSION['username'] = $this->getUsername();
		}


		public function isUserExist($username)
		{
			$con = new DBConnector;
			$exists = false;
			$res = mysqli_query($con->conn, "SELECT * FROM users WHERE username = '" . $username . "'") or die("Error" . mysqli_error($con->conn));

			if (mysqli_num_rows($res) !== 0 ) {
				$exists = true;	
			}
			// while ($row = mysqli_fetch_array($res)) {
			// 	if (password_verify($this->getPassword(), $row['password']) && $this->getUsername() == $row['username']) {
			// 		$found = true;
			// 	}
			// }

			$con->closeDatabase();
			return $exists;	
		}

		public function DBConnect() {
			$this->con = new DBConnector;
		}

		public function DBClose() {
			$this->con->closeDatabase();
		}
	}
?>
