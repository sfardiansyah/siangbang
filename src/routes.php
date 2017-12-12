<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/dashboard', function (Request $request, Response $response, array $args) {
    if (empty($_SESSION['username'])) {
		return $response->withRedirect('/');
    } else {
    	
    	// Sample log message
	    $this->logger->info("Siangbang '/' dashboard");
	    
	    // Render index view
	    return $this->renderer->render($response, 'dashboard.phtml', $args);
    }
});

$app->get('/dashboard/{function}', function (Request $request, Response $response, array $args) {
    if (empty($_SESSION['username'])) {
		return $response->withRedirect('/');
    } else {
    	$func = explode("/", $_SERVER['REQUEST_URI']);

    	switch ($func[2]) {
    		case 'pinjam-barang':
    			$sql = "SELECT * FROM siangbang.barang;";
    			break;
    		
    		case 'pinjam-ruang':
    			$sql = "SELECT * FROM siangbang.ruangan;";
    			break;

            case 'riwayat-barang':
                $sql = "SELECT *
                    FROM siangbang.list_pinjam_barang LB, siangbang.barang B, siangbang.peminjaman_barang PB
                    WHERE LB.username_mhs = '{$_SESSION['username']}'
                    AND LB.username_mhs = PB.username_mhs
                    AND B.kode_barang = LB.kode_barang
                    AND LB.tgl_mulai = Pb.tgl_mulai
                    ORDER BY LB.tgl_mulai DESC;";
                break;
            
            case 'riwayat-ruang':
                $sql = "SELECT *
                    FROM siangbang.peminjaman_ruang, siangbang.ruangan
                    WHERE username_mhs = '{$_SESSION['username']}'
                    AND kode_ruangan = no_ruangan
                    ORDER BY tgl_mulai DESC;";
                break;
    		
    		default:
    			# code...
    			break;
    	}

    	$stmt = $this->db->prepare($sql);
        $stmt->execute();
        $query = array();

        while ($row = $stmt->fetch()) {
        	array_push($query, $row);
        }

    	// Sample log message
	    $this->logger->info("Siangbang '/' dashboard");
	    
	    // Render index view
	    return $this->renderer->render($response, 'dashboard.phtml', [
	        'function' => $args['function'],
	    	'query' => $query
	    ]);
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

			return $response->withRedirect('/dashboard');
        } else {
        	$_SESSION['error'] = "Username atau password salah!";
        
        	// Render index view
	    	return $this->renderer->render($response, 'landing.phtml', $args);
        }
    } 
});

$app->post('/insert-room', function (Request $request, Response $response, array $args) {
	if (isset($_POST['simpan'])) {
		
		$sql = "SELECT username_admin
			FROM siangbang.ruangan
			WHERE kode_barang = '{$_POST['kode_ruang']}';";

		$stmt = $this->db->prepare($sql);
        $stmt->execute();
        $item = $stmt->fetch();

        $today = date("Y-m-d");

		$sql = "INSERT INTO siangbang.peminjaman_ruang (tgl_mulai, kode_ruangan, username_mhs, tgl_selesai, tgl_req, waktu_mulai, waktu_selesai, nama_kegiatan, tujuan, jumlah_peserta, status, username_admin)
			VALUES ('{$_POST['tgl_mulai']}', '{$_POST['kode_ruang']}', '{$_SESSION['username']}', '{$_POST['tgl_selesai']}', '{$today}', TIMESTAMP'{$_POST['tgl_mulai']} {$_POST['waktu_mulai']}', TIMESTAMP'{$_POST['tgl_selesai']} {$_POST['waktu_selesai']}', '{$_POST['nama_kegiatan']}', '{$_POST['tujuan']}', '{$_POST['jumlah']}', 1, '{$item['username_admin']}');";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        return $response->withRedirect('/dashboard/pinjam-barang');
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
			VALUES ('{$_POST['tgl_mulai']}', '{$_SESSION['username']}', '{$_POST['tgl_selesai']}', '{$today}', TIMESTAMP'{$_POST['tgl_mulai']} {$_POST['waktu_mulai']}', TIMESTAMP'{$_POST['tgl_selesai']} {$_POST['waktu_selesai']}', '{$_POST['nama_kegiatan']}', '{$_POST['tujuan']}', 1, 0, '{$item['username_admin']}');";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        $sql = "INSERT INTO siangbang.list_pinjam_barang (tgl_mulai, username_mhs, kode_barang, jumlah)
            VALUES ('{$_POST['tgl_mulai']}', '{$_SESSION['username']}', '{$_POST['kode_barang']}', '{$_POST['jumlah']}');";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        return $response->withRedirect('/dashboard/pinjam-barang');
	}
});

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'landing.phtml', $args);
});
