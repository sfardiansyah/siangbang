<?php
    $db_connection = pg_connect("host=localhost dbname=siangbang user=postgres");
    $result = pg_query($db_connection, "INSERT INTO PENGEMBALIAN_BARANG(tgl_mulai, username_mhs, kode_barang, tgl_kembali) VALUES (tgl_mulai, username_mhs, kode_barang, tgl_kembali);");
?>

<!DOCTYPE html>
<html>
<body>
<form action="/action_page.php">
  Tanggal Mulai:<br>
  <input type="text" name="tgl_mulai">
  <br>
  Username Mahasiswa:<br>
  <input type="text" name="username_mhs">
  <br>
  Kode Barang:<br>
  <input type="text" name="kode_barang">
  <br>
  Tanggal Kembali:<br>
  <input type="text" name="tgl_kembali">
  <br>
  <input type="submit" value="Submit">
</form>
</body>
</html>
