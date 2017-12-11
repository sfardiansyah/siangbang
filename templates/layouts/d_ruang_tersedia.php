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

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			Daftar Ruangan yang Tersedia
		</title>
	</head>
	<body>
		<center>
			<h1>
					Daftar Ruangan yang Tersedia	
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
			<p>
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
				<th class="tg-yw4l">Senin</th>
				<th class="tg-yw4l">Selasa</th>
				<th class="tg-yw4l">Rabu</th>
				<th class="tg-yw4l">Kamis</th>
				<th class="tg-yw4l">Jumat</th>
				<th class="tg-yw4l">Sabtu</th>
				<th class="tg-yw4l">Minggu</th>
			</tr>
			<?php
				$startday=0;
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

				for($i=0,$day=0,$count=1; $day<$nDay;$i++){
					echo "<tr>";
					for($j = 0; $j<7;$j++){
						//echo "<td>test</td>";
						if($count==$startday and $day<$nDay){
							$count++;
							$day++;
							$startday++;
							echo "<td>",$day;

							$date = "$year-$nMonth-$day";
							$sql = "SELECT distinct no_ruangan,nama_ruangan from siangbang.ruangan r, siangbang.peminjaman_ruang pr 
									where r.no_ruangan = pr.kode_ruangan and no_ruangan not in
									(select no_ruangan from siangbang.ruangan r, siangbang.peminjaman_ruang pr 
									where r.no_ruangan = pr.kode_ruangan and status != 7 and
									(tgl_mulai,tgl_selesai) overlaps ('$date'::DATE, '$date'::DATE)) order by no_ruangan asc;";
							$result = pg_query($conn,$sql);
							while($row = pg_fetch_array($result)){
								echo "<br>";
								echo "R.";
								echo $row['no_ruangan'];
								echo "- ";
								echo $row['nama_ruangan'];
							} 

							echo "</td>";

						}else{
							$count++;
							echo "<td></td>";
						}
					}
					echo "</tr>";
				}
				
				//echo $startday;
			?>
		</table>
	</center>
	</body>
</html>