<?php
	/*
	session_start();

	if(isset($_SESSION['error'])) {
		echo "<script type='text/javascript'>window.alert(\"".$_SESSION['error']."\");</script>";
		unset($_SESSION['error']);
	}
	*/
	
	function connectDB() {
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "personal_library";
		
		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: " + mysqli_connect_error());
		}
		return $conn;
	}

	function showDaftarPinjamRuangan(){
		$conn = connectDB();
		//mysqli_close($conn);
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Daftar Pinjam Ruangan
		</title>
	</head>
	<body>
		asdfasdf
	</body>
</html>

