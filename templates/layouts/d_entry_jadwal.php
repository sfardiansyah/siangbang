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

<html lang="en">
	<head>
		<title>
			Entry Jadwal
		</title>
	</head>
	<body>
		<center>
			<h1>
					Entry Jadwal
			</h1>
			<?php
				if(isset($_POST['command']) && $_POST['command'] == 'entry-jadwal') {
					$result = pg_query(connectDB(), "INSERT INTO siangbang.jadwal(kode_jadwal,tahun_term,semester_term,nama_matkul,kelas,jam_mulai,jam_selesai,hari,kode_ruangan,username_admin) VALUES ('".$_POST['kode-jadwal']."',".$_POST['tahun'].",".$_POST['semester'].",'".$_POST['matkul']."','".$_POST['kelas']."',TIMESTAMP'2016-09-02 ".$_POST['jam-mulai'].":".$_POST['menit-mulai'].":00',TIMESTAMP'2016-09-02 ".$_POST['jam-selesai'].":".$_POST['menit-selesai'].":00','".$_POST['hari']."','".$_POST['kode-ruangan']."','".$_POST['admin']."')");
					if(!$result) echo 'An error occurred<br>';
					else echo 'insert succeeded';
					unset($_POST['command']);
				}	
			?>
			<form action="d_entry_jadwal.php" method="post" id="entry-jadwal">
				<input type="hidden" name="command" value="entry-jadwal" required>
				<input type="hidden" name="admin" value="<?php echo $_SESSION['username']?>" required>
				Kode Jadwal:<input type="text" name="kode-jadwal" required><br>
				Tahun:<input type="number" name="tahun" min="2000" max="2100" required><br>
				Semester:<input type="number" name="semester" min="1" max="3" required><br>
				Nama Matkul:<input type="text" name="matkul" required><br>
				Kelas:<input type="text" name="kelas" required><br>
				Mulai:<input type="number" name="jam-mulai" min="0" max="23" required><input type="number" name="menit-mulai" min="0" max="59" required><br>
				Selesai:<input type="number" name="jam-selesai" min="0" max="23" required><input type="number" name="menit-selesai" min="0" max="59" required><br>
				Hari:<select name="hari" form="entry-jadwal" required>
					<option value="mon">Senin</option>
					<option value="tue">Selasa</option>
					<option value="wed">Rabu</option>
					<option value="thu">Kamis</option>
					<option value="fri">Jumat</option>
					<option value="sat">Sabtu</option>
					<option value="sun">Minggu</option>
				</select><br>
				Kode Ruangan:<input type="text" name="kode-ruangan"><br>
				<input type="submit" value="Submit">
			</form>

			<a href="index.php"><button> back </button> </a>
	</center>
	</body>
</html>
