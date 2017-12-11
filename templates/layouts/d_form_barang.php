<?php
    $db_connection = pg_connect("host=localhost dbname=siangbang user=postgres");
    $result = pg_query($db_connection, "INSERT INTO BARANG(kode_barang, nama_barang, jumlah_barang, jenis_barang, keterangan, foto, username_admin) VALUES (kode_barang, nama_barang, jumlah_barang, jenis_barang, keterangan, foto, username_admin);");
?>

<!DOCTYPE html>
<html>
<body>
<form action="/action_page.php">
  Kode Barang:<br>
  <input type="text" name="kode_barang">
  <br>
  Nama Barang:<br>
  <input type="text" name="nama_barang">
  <br>
  Jumlah Barang:<br>
  <input type="text" name="jumlah_barang">
  <br>
  Jenis Barang:<br>
  <input type="text" name="jenis_barang">
  <br>
  Keterangan:<br>
  <input type="text" name="keterangan">
  <br>
  URL Foto:<br>
  <input type="text" name="foto">
  <br>
  Username Admin:<br>
  <input type="text" name="username_admin">
  <br>
  <input type="submit" value="Submit">
</form>
</body>
</html>
