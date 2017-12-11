<?php
	//Placeholder, seharusnya di handle di login
	session_start();
	$_SESSION["username"] = "devinquenelle";
	$_SESSION["role"] = "admin_ruangan";

	if(isset($_SESSION['error'])) {
		echo "<script type='text/javascript'>window.alert(\"".$_SESSION['error']."\");</script>";
		unset($_SESSION['error']);
	}
	
	function connectDB() {
		$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=basdat";
		$conn = pg_connect($conn_string);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: Failed to connect to the database");
		}
		return $conn;
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Login
		</title>
	</head>
	<body>
		<center>
			<h1>
					Login
			</h1>
			<form>
				Username: <input type="text" name="username" required=""><br>
				Password: <input type="password" name="password" required=""><br>
				<input type="submit" value="Submit">
			</form>
	</center>
	</body>
</html>