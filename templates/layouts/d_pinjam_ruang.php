<?php
	//Placeholder, seharusnya di handle di login
	session_start();
	$_SESSION["username"] = "devinquenelle";
	$_SESSION["role"] = "admin_ruangan";
	//$_POST['command'] = '';

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

	if(!isset($_SESSION['command'])){
		$_SESSION['command']='';
	}

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if($_POST['command'] === 'accept') {
			acceptRequest($_POST['tgl_mulai'],$_POST['kode_ruangan'],$_POST['username_mhs']);
		} else if($_POST['command'] === 'deny') {
			denyRequest($_POST['tgl_mulai'],$_POST['kode_ruangan'],$_POST['username_mhs']);
		}
	} 

	function acceptRequest($tgl_mulai, $kode_ruangan,$username_mhs){
		$conn = connectDB();
		$admin = $_SESSION['username'];
		$sql = "";
		switch($_SESSION["role"]){
				case "admin_ruangan":
				$sql = "UPDATE siangbang.peminjaman_ruang set status =2, username_admin ='$admin' where tgl_mulai='$tgl_mulai' and kode_ruangan = '$kode_ruangan' and username_mhs = '$username_mhs' ";
				break;
				case "manajer_akademik":
				$sql = "UPDATE siangbang.peminjaman_ruang set status =3 where tgl_mulai='$tgl_mulai' and kode_ruangan = '$kode_ruangan' and username_mhs = '$username_mhs' ";
				break;
				case "manajer_IT":
				$sql = "UPDATE siangbang.peminjaman_ruang set status =4 where tgl_mulai='$tgl_mulai' and kode_ruangan = '$kode_ruangan' and username_mhs = '$username_mhs' ";
				break;
			}
		pg_query($conn, $sql);
		//echo $tgl_mulai,", ",$kode_ruangan,", ",$username_mhs,", ",$_SESSION['username'],", ", $_SESSION['role'];
	}

	function denyRequest($tgl_mulai, $kode_ruangan,$username_mhs){
		$conn = connectDB();
		$admin = $_SESSION['username'];
		$sql = "";
		switch($_SESSION["role"]){
				case "admin_ruangan":
				$sql = "UPDATE siangbang.peminjaman_ruang set status =5, username_admin ='$admin' where tgl_mulai='$tgl_mulai' and kode_ruangan = '$kode_ruangan' and username_mhs = '$username_mhs' ";
				break;
				case "manajer_akademik":
				$sql = "UPDATE siangbang.peminjaman_ruang set status =6 where tgl_mulai='$tgl_mulai' and kode_ruangan = '$kode_ruangan' and username_mhs = '$username_mhs' ";
				break;
				case "manajer_IT":
				$sql = "UPDATE siangbang.peminjaman_ruang set status =7 where tgl_mulai='$tgl_mulai' and kode_ruangan = '$kode_ruangan' and username_mhs = '$username_mhs' ";
				break;
			}
		pg_query($conn, $sql);
		//echo $tgl_mulai,", ",$kode_ruangan,", ",$username_mhs,", ",$_SESSION['username'],", ", $_SESSION['role'];
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Daftar Peminjaman Ruangan
		</title>
	</head>
	<body>
		<center>
			<h1>
					Daftar Peminjaman Ruangan	
			</h1>
			<style type="text/css">
				.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
				.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;border-top-width:1px;border-bottom-width:1px;}
				.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;border-top-width:1px;border-bottom-width:1px;}
				.tg .tg-yw4l{vertical-align:top}
			</style>
		<table class="tg" name=d_p_ruangan>
		  <tr>
		    <th class="tg-yw4l">Tanggal Request</th>
		    <th class="tg-yw4l">Kode Ruangan</th>
		    <th class="tg-yw4l">Username Mahasiswa</th>
		    <th class="tg-yw4l">Tanggal Mulai Penggunaan</th>
		    <th class="tg-yw4l">Tanggal Selesai Penggunaan</th>
		    <th class="tg-yw4l">Waktu Mulai</th>
		    <th class="tg-yw4l">Waktu Selesai</th>
		    <th class="tg-yw4l">Nama Kegiatan</th>
		    <th class="tg-yw4l">Tujuan</th>
		    <th class="tg-yw4l">Jumlah Peserta</th>
		    <th class="tg-yw4l">Status</th>
		    <th class="tg-yw4l"></th>
		  </tr>
		  <?php 
			  	$conn = connectDB();
				$sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 0;";
				switch($_SESSION["role"]){
					case "admin_ruangan":
					$sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 1;";
					break;
					case "manajer_akademik":
					$sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 2;";
					break;
					case "manajer_IT":
					$sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 3 ;";
					break;
				}
				$result = pg_query($conn, $sql);
				while($row = pg_fetch_array($result)){
					$status = "";
					switch($row['status']){
								case "1": 
								$status = "Menunggu persetujuan admin";
								break;
								case "2": 
								$status = "Menunggu persetujuan manajer pendidikan dan kemahasiswaan";
								break;
								case "3": 
								$status = "menunggu persetujuan manajer IT";
								break;
								case "4": 
								$status = "disetujui";
								break;
								case "5": 
								$status = "ditolak admin";
								break;
								case "6": 
								$status = "ditolak manajer pendidikan dan kemahasiswaan";
								break;
								case "7": 
								$status = "ditolak manajer IT";
								break;
							}
					echo "
					<tr>
						<td>
							",$row['tgl_req'],"
						</td>
						<td>
							",$row['kode_ruangan'],"
						</td>
						<td>
							",$row['username_mhs'],"
						</td>
						<td>
							",$row['tgl_mulai'],"
						</td>
						<td>
							",$row['tgl_selesai'],"
						</td>
						<td>
							",$row['waktu_mulai'],"
						</td>
						<td>
							",$row['waktu_selesai'],"
						</td>
						<td>
							",$row['nama_kegiatan'],"
						</td>
						<td>
							",$row['tujuan'],"
						</td>
						<td>
							",$row['jumlah_peserta'],"
						</td>
						<td>
							",$status,"
						</td>
						<td>
							<form action='d_pinjam_ruang.php' name='Accept' method='post'>
							<input type='hidden' name='tgl_mulai' value='".$row['tgl_mulai']."'>
							<input type='hidden' name='kode_ruangan' value='".$row['kode_ruangan']."'>
							<input type='hidden' name='username_mhs' value='".$row['username_mhs']."'>
							<input type='hidden' name='command' value='accept'>
							<input type='submit' value='Setujui'><br>
							</form>
							<form action='d_pinjam_ruang.php' name='Deny' method='post'>
							<input type='hidden' name='tgl_mulai' value='".$row['tgl_mulai']."'>
							<input type='hidden' name='kode_ruangan' value='".$row['kode_ruangan']."'>
							<input type='hidden' name='username_mhs' value='".$row['username_mhs']."'>
							<input type='hidden' name='command' value='deny'>
							<input type='submit' value='Tolak'>
							</form>
						</td>
					</tr>
					";
				}
				pg_close($conn);
		  		?>
		</table>
	</center>
	</body>
</html>

