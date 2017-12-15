<?php
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

	$result = pg_query(connectDB(), "SELECT * FROM siangbang.jadwal")
?>

<html lang="en">
	<head>
		<title>
			Jadwal
		</title>

		<style type="text/css">

			div{
				border: 1px solid black;
				background-color: white;
			}	
			.grid{
				display: grid;
				grid-template-columns: 
				<?php 
					if(isset($_GET['view-option']) && $_GET['view-option'] == 'hari') echo ' 50px 1fr;';
					elseif(isset($_GET['view-option']) && $_GET['view-option'] == 'bulan') echo '0px repeat(7,1fr);';
					else echo '50px repeat(7,1fr);';
				?>
				
				grid-template-rows: 
				<?php 
					if(isset($_GET['view-option']) && $_GET['view-option'] == 'bulan') echo '[top] 25px repeat(6,"500px") [bottom]';
					else echo '[top] 25px repeat(calc(24*6),10px) [bottom]';
				?>;
				background-color: darkgrey;
				z-index: -1;
			}
			.grid>div{
				z-index: 1;
			}

		</style>
	</head>
	<body>
		<h1>Jadwal Ruangan</h1>
		<div>
			<form action="/jadwal-ruangan" id="pilih-ruang" method="get">
				Ruangan:
				<select name="select-ruangan" id="select-ruangan" form="pilih-ruang">
					<?php 
					$ruangan = pg_fetch_all(pg_query(connectDB(),"SELECT * FROM siangbang.ruangan"));
					foreach($ruangan as $ruang) {
						echo '<option value="'.$ruang['no_ruangan'];
						if(isset($_GET['select-ruangan'])&&$ruang['no_ruangan']==$_GET['select-ruangan']) {
								echo 'selected';	
						} 
						echo '">'.$ruang['nama_ruangan'].'</option>';
					}
					if(!isset($_GET['select-ruangan'])) $_GET['select-ruangan'] = $ruangan[0]['no_ruangan'];
					?>
				</select><br>
				View:<br>
				<input type="radio" name="view-option" value="hari"> hari<br>
  				<input type="radio" name="view-option" value="minggu"> minggu<br>
  				<input type="radio" name="view-option" value="bulan"> bulan<br>
				<input type="submit" value="Lihat">
			</form>
		</div><br>
		<div class="grid">
			<?php 
			if(isset($_GET['view-option']) && $_GET['view-option'] == 'hari') echo '<div style="grid-area: 1/2">'.date("D").'</div>';
			else echo'<div style="grid-area: 1/2">Senin</div>
			<div style="grid-area: 1/3">Selasa</div>
			<div style="grid-area: 1/4">Rabu</div>
			<div style="grid-area: 1/5">Kamis</div>
			<div style="grid-area: 1/6">Jumat</div>
			<div style="grid-area: 1/7">Sabtu</div>
			<div style="grid-area: 1/8">Minggu</div>
			<div style="grid-area: 1/3/bottom/span 1; z-index: 0; background-color: lightgrey;"></div>
			<div style="grid-area: 1/5/bottom/span 1; z-index: 0; background-color: lightgrey;"></div>
			<div style="grid-area: 1/7/bottom/span 1; z-index: 0; background-color: lightgrey;"></div>';
			?>
			
			<?php
			if($_GET['view-option']=='minggu'||$_GET['view-option']=='hari') {
				for ($i=0; $i < 24; $i++) { 
					echo '<div style="grid-area:'.(2+$i*6).'/1/span 6/span 1; text-align:center;">'.$i.':00</div>';
				}
			}
			if(isset($_GET['view-option'])&&$_GET['view-option']=='hari') $result = pg_query(connectDB(),"SELECT * FROM siangbang.jadwal WHERE kode_ruangan ="."'".$_GET['select-ruangan']."' AND hari = LOWER('".date("D")."')");
			else $result = pg_query(connectDB(),"SELECT * FROM siangbang.jadwal WHERE kode_ruangan ="."'".$_GET['select-ruangan']."'");
			$jadwalarr = pg_fetch_all($result);
			
			if(isset($jadwalarr)&&!empty($jadwalarr)){
				if(!isset($_GET['view-option'])||$_GET['view-option'] == 'minggu'){
					foreach ($jadwalarr as $jadwal) {
						echo '<div style="grid-area:'.(2+(int)substr($jadwal['jam_mulai'],11,2)*6+(int)substr($jadwal['jam_mulai'],14,2)/10).'/';
						if($jadwal['hari']=='mon') echo '2';
						elseif ($jadwal['hari']=='tue') echo '3';
						elseif ($jadwal['hari']=='wed') echo '4';
						elseif ($jadwal['hari']=='thu') echo '5';
						elseif ($jadwal['hari']=='fri') echo '6';
						elseif ($jadwal['hari']=='sat') echo '7';
						elseif ($jadwal['hari']=='sun') echo '8';
						echo '/'.(2+(int)substr($jadwal['jam_selesai'],11,2)*6+(int)substr($jadwal['jam_selesai'],14,2)/10).'">';
						echo substr($jadwal['jam_mulai'],11,5).':'.substr($jadwal['jam_selesai'],11,5)."<br>";
						echo $jadwal['nama_matkul']; 
						echo '</div>';
					}
				} elseif($_GET['view-option'] == 'bulan') {
					foreach ($jadwalarr as $jadwal) {
						for ($i=2; $i < 8; $i++) { 
							echo '<div style="grid-area:'.$i.'/';
							if($jadwal['hari']=='mon') echo '2';
							elseif ($jadwal['hari']=='tue') echo '3';
							elseif ($jadwal['hari']=='wed') echo '4';
							elseif ($jadwal['hari']=='thu') echo '5';
							elseif ($jadwal['hari']=='fri') echo '6';
							elseif ($jadwal['hari']=='sat') echo '7';
							elseif ($jadwal['hari']=='sun') echo '8';
							echo '">';
							echo substr($jadwal['jam_mulai'],11,5).':'.substr($jadwal['jam_selesai'],11,5)."<br>";
							echo $jadwal['nama_matkul']; 
							echo '</div>';
						}
					}
				} else {
					foreach ($jadwalarr as $jadwal) {
						echo '<div style="grid-area:'.(2+(int)substr($jadwal['jam_mulai'],11,2)*6+(int)substr($jadwal['jam_mulai'],14,2)/10).'/2';
						echo '/'.(2+(int)substr($jadwal['jam_selesai'],11,2)*6+(int)substr($jadwal['jam_selesai'],14,2)/10).'">';
						echo substr($jadwal['jam_mulai'],11,5).':'.substr($jadwal['jam_selesai'],11,5)."<br>";
						echo $jadwal['nama_matkul']; 
						echo '</div>';
					}
				}
			}
			?>
		</div>
	</body>
</html>