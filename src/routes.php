<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/dashboard/[{function}]', function (Request $request, Response $response, array $args) {
    if (empty($_SESSION['username'])) {
		return $response->withRedirect('/');
    } else {
    	// Sample log message
	    $this->logger->info("Siangbang '/' dashboard");
	    
	    // Render index view
	    return $this->renderer->render($response, 'dashboard.phtml', $args);
    }
});

$app->get('/logout', function (Request $request, Response $response, array $args) {
	$_SESSION = [];

	// Render index view
	return $this->renderer->render($response, 'landing.phtml', $args);
});

$app->post('/login', function (Request $request, Response $response, array $args) {                            
    if (isset($_POST['sign-in'])) { 
        $sql = "SELECT username, password, nama, 'admin_barang' AS tablename
        	FROM siangbang.admin_barang
			WHERE username = '{$_POST['username']}'
			UNION ALL
			SELECT username, password, nama, 'admin_ruangan' AS tablename
			FROM siangbang.admin_ruangan
			WHERE username = '{$_POST['username']}'
			UNION ALL 
			SELECT username, password, nama, 'mahasiswa' AS tablename
			FROM siangbang.mahasiswa
			WHERE username = '{$_POST['username']}';";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $row = $stmt->fetch();

        if ($row['password'] == $_POST['password']) {
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['role'] = $row['tablename'];
			$_SESSION['name'] = $row['nama'];

			return $response->withRedirect('/dashboard/');
        } else {
        	$_SESSION['error'] = "Username atau password salah!";
        
        	// Render index view
	    	return $this->renderer->render($response, 'landing.phtml', $args);
        }
    } 
});

$app->post('/insert-room', function (Request $request, Response $response, array $args) {
	if (isset($_POST['simpan'])) {
		
		// $sql = "SELECT username_admin
		// 	FROM siangbang.barang
		// 	WHERE kode_barang = '{$_POST['kode_barang']}';";

		// $stmt = $this->db->prepare($sql);
  //       $stmt->execute();
  //       $item = $stmt->fetch();

  //       $today = date("Y-m-d");

		// $sql = "INSERT INTO siangbang.peminjaman_barang (tgl_mulai, username_mhs, tgl_selesai, tgl_req, waktu_mulai, waktu_selesai, nama_kegiatan, tujuan, status, denda, username_admin)
		// 	VALUES ('{$_POST['tgl_mulai']}', '{$_SESSION['username']}', '{$_POST['tgl_selesai']}', '{$today}', TIMESTAMP'{$_POST['tgl_mulai']} {$_POST['waktu_mulai']}', TIMESTAMP'{$_POST['tgl_selesai']} {$_POST['waktu_selesai']}', '{$_POST['nama_kegiatan']}', '{$_POST['tujuan']}', 0, 0, '{$item['username_admin']}');";
  //       $stmt = $this->db->prepare($sql);
  //       $result = $stmt->execute();
  //       print_r($result);
  //       return $response->withRedirect('/dashboard/pinjam-barang');
	}
});

$app->post('/insert-item', function (Request $request, Response $response, array $args) {
	if (isset($_POST['simpan'])) {
		
		$sql = "SELECT username_admin
			FROM siangbang.barang
			WHERE kode_barang = '{$_POST['kode_barang']}';";

		$stmt = $this->db->prepare($sql);
        $stmt->execute();
        $item = $stmt->fetch();

        $today = date("Y-m-d");

		$sql = "INSERT INTO siangbang.peminjaman_barang (tgl_mulai, username_mhs, tgl_selesai, tgl_req, waktu_mulai, waktu_selesai, nama_kegiatan, tujuan, status, denda, username_admin)
			VALUES ('{$_POST['tgl_mulai']}', '{$_SESSION['username']}', '{$_POST['tgl_selesai']}', '{$today}', TIMESTAMP'{$_POST['tgl_mulai']} {$_POST['waktu_mulai']}', TIMESTAMP'{$_POST['tgl_selesai']} {$_POST['waktu_selesai']}', '{$_POST['nama_kegiatan']}', '{$_POST['tujuan']}', 0, 0, '{$item['username_admin']}');";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        print_r($result);
        return $response->withRedirect('/dashboard/pinjam-barang');
	}
});

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'landing.phtml', $args);
});
