<?php
	//Placeholder, seharusnya di handle di login
	session_start();
	$_SESSION["username"] = "devinquenelle";
	$_SESSION["role"] = "admin_ruangan";
	$_SESSION['year'] = date('Y');


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

	if(isset($_POST['submit'])){
		$_SESSION['month'] = $_POST['month'];
	}

	if(!isset($_POST['month'])){
		$_SESSION['month'] = "Januari";
	}



?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Daftar Barang yang Tersedia
		</title>
	</head>
	<body>
		<center>
			<h1>
					Daftar Barang yang Tersedia	
			</h1>
			<form action='#' name='SelDate' method='post'>
				<select name="month">
					<option value="Januari">Januari</option>
					<option value="Februari">Februari</option>
					<option value="Maret">Maret</option>
					<option value="April">April</option>
					<option value="Mei">Mei</option>
					<option value="Juni">Juni</option>
					<option value="Juli">Juli</option>
					<option value="Agustus">Agustus</option>
					<option value="September">September</option>
					<option value="Oktober">Oktober</option>
					<option value="November">November</option>
					<option value="Desember">Desember</option>
				</select>
				<input type='submit' name="submit" value='Pilih'>
			</form>
			<style type="text/css">
				.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
				.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;border-top-width:1px;border-bottom-width:1px;}
				.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;border-top-width:1px;border-bottom-width:1px;}
				.tg .tg-yw4l{vertical-align:top}
			</style>
		<table class="tg" name=d_p_ruangan>
			<tr>
				<?php
				echo "<th colspan ='7'>",$_SESSION['month'],"</th>"
				?>
			</tr>
		  	<tr>
			    <th class="tg-yw4l">No</th>
			    <th class="tg-yw4l">Kode Barang</th>
			    <th class="tg-yw4l">Nama Barang</th>
			    <th class="tg-yw4l">Jenis Barang</th>
			    <th class="tg-yw4l">Jumlah</th>
			    <th class="tg-yw4l">Keterangan</th>
			    <th class="tg-yw4l">Foto</th>
		  	</tr>
		  	<?php
		  		$year = $_SESSION['year'];
				$month = $_SESSION['month'];
				$nMonth='';
				$nDay =0;
				switch($year){
					case "2016":
						switch($month){
							case "Januari":
							$startday = 5;
							$nDay =31;
							$nMonth ='01';
							break;

							case "Februari":
							$startday = 1;
							$nDay =29;
							$nMonth ='02';
							break;

							case "Maret":
							$startday = 2;
							$nDay =31;
							$nMonth ='03';
							break;

							case "April":
							$startday = 5;
							$nDay =30;
							$nMonth ='04';
							break;

							case "Mei":
							$startday = 7;
							$nDay =31;
							$nMonth ='05';
							break;

							case "Juni":
							$startday = 3;
							$nDay =30;
							$nMonth ='06';
							break;

							case "Juli":
							$startday = 5;
							$nDay =31;
							$nMonth ='07';
							break;

							case "Agustus":
							$startday = 1;
							$nDay =31;
							$nMonth ='08';
							break;

							case "September":
							$startday = 4;
							$nDay =30;
							$nMonth ='09';
							break;

							case "Oktober":
							$startday = 7;
							$nDay =31;
							$nMonth ='10';
							break;

							case "November":
							$startday = 3;
							$nDay =30;
							$nMonth ='11';
							break;

							case "Desember":
							$startday = 4;
							$nDay =31;
							$nMonth ='12';
							break;
						}
					break;

					case "2017":
					switch($month){
						case "Januari":
							$startday = 7;
							$nDay =31;
							$nMonth ='01';
							break;

							case "Februari":
							$startday = 3;
							$nDay =28;
							$nMonth ='02';
							break;

							case "Maret":
							$startday = 3;
							$nDay =31;
							$nMonth ='03';
							break;

							case "April":
							$startday = 6;
							$nDay =30;
							$nMonth ='04';
							break;

							case "Mei":
							$startday = 1;
							$nDay =31;
							$nMonth ='05';
							break;

							case "Juni":
							$startday = 5;
							$nDay =30;
							$nMonth ='06';
							break;

							case "Juli":
							$startday = 6;
							$nDay =31;
							$nMonth ='07';
							break;

							case "Agustus":
							$startday = 2;
							$nDay =31;
							$nMonth ='08';
							break;

							case "September":
							$startday = 5;
							$nDay =30;
							$nMonth ='09';
							break;

							case "Oktober":
							$startday = 7;
							$nDay =31;
							$nMonth ='10';
							break;

							case "November":
							$startday = 3;
							$nDay =30;
							$nMonth ='11';
							break;

							case "Desember":
							$startday = 5;
							$nDay =31;
							$nMonth ='12';
							break;
						}
					break;

					case "2018";
					switch($month){
						case "Januari":
							$startday = 1;
							$nDay =31;
							$nMonth ='01';
							break;

							case "Februari":
							$startday = 4;
							$nDay =28;
							$nMonth ='02';
							break;

							case "Maret":
							$startday = 4;
							$nDay =31;
							$nMonth ='03';
							break;

							case "April":
							$startday = 7;
							$nDay =30;
							$nMonth ='04';
							break;

							case "Mei":
							$startday = 2;
							$nDay =31;
							$nMonth ='05';
							break;

							case "Juni":
							$startday = 5;
							$nDay =30;
							$nMonth ='06';
							break;

							case "Juli":
							$startday = 7;
							$nDay =31;
							$nMonth ='07';
							break;

							case "Agustus":
							$startday = 3;
							$nDay =31;
							$nMonth ='08';
							break;

							case "September":
							$startday = 6;
							$nDay =30;
							$nMonth ='09';
							break;

							case "Oktober":
							$startday = 1;
							$nDay =31;
							$nMonth ='10';
							break;

							case "November":
							$startday = 4;
							$nDay =30;
							$nMonth ='11';
							break;

							case "Desember":
							$startday = 6;
							$nDay =31;
							$nMonth ='12';
							break;
						}
					break;
				}

				$conn = connectDB();
				$dateS = "$year-$nMonth-01";
				$dateF =  "$year-$nMonth-$nDay";
				$sql =  "select distinct b.kode_barang,b.nama_barang, b.jenis_barang, b.jumlah_barang, b.keterangan, b.foto
						from siangbang.barang b, siangbang.peminjaman_barang pb, siangbang.list_pinjam_barang lpb
						where lpb.kode_barang = b.kode_barang and pb.tgl_mulai = lpb.tgl_mulai and
						pb.username_mhs = lpb.username_mhs and 
						b.kode_barang not in (
						select b.kode_barang from siangbang.barang b, siangbang.peminjaman_barang pb, siangbang.list_pinjam_barang lpb
						where lpb.kode_barang = b.kode_barang and pb.tgl_mulai = lpb.tgl_mulai and
						pb.username_mhs = lpb.username_mhs and status != 3 and
						(pb.tgl_mulai,pb.tgl_selesai) overlaps ('$dateS'::DATE, '$dateF'::DATE)
						)order by b.kode_barang asc;";
				$result = pg_query($conn,$sql);
				$i = 1;
				while($row = pg_fetch_array($result)){
					echo "<tr>";
					echo "<td>",$i,"</td>";
					echo "<td>",$row['kode_barang'],"</td>";
					echo "<td>",$row['nama_barang'],"</td>";
					echo "<td>",$row['jenis_barang'],"</td>";
					echo "<td>",$row['jumlah_barang'],"</td>";
					echo "<td>",substr($row['keterangan'],0,100),"</td>";
					echo "<td><image src='",$row['foto'],"'></td>";
					echo "</tr>";
					$i++;
				}
		  	?>
		</table>
	</center>
	</body>
</html>

