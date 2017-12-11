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
		$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=dieuepreuve";
		$conn = pg_connect($conn_string);
		
		// Check connection
		if (!$conn) {
			die("Connection failed: Failed to connect to the database");
		}
		return $conn;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Buat Peminjaman</title>
</head>
<body>
	<center>
		<table>
			<thead>
				<tr>
					<td colspan="2">
						<center>
							<h1>Buat Peminjaman</h1>
						</center>
					</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<a href="">
							<button>Peminjaman Ruang</button>
						</a>
					</td>
					<td>
						<a href="">
							<button>Peminjaman Barang</button>
						</a>
					</td>
				</tr>
			</tbody>
		</table>
	</center>
</body>
</html>