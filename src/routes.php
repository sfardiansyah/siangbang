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

$app->post('/change-date', function (Request $request, Response $response, array $args) {
    // Determine the query based on page
    switch ($_POST['page']) {
        case 'daftar-ruang':

            $start_week = date('w', strtotime($_POST['year']."-".$_POST['month']."-01"));
            $month_length = date('t', strtotime($_POST['year']."-".$_POST['month']."-01"));

            $out = "<tbody>\n
                        <tr>\n
                            <th>Minggu</th>\n
                            <th>Senin</th>\n
                            <th>Selasa</th>\n
                            <th>Rabu</th>\n
                            <th>Kamis</th>\n
                            <th>Jumat</th>\n
                            <th>Sabtu</th>\n
                        </tr>\n";

            for ($i=0; $i < ceil(($start_week + $month_length) / 7); $i++) { 
                $out .= "<tr>\n";

                for ($j = ($i*7); $j < (7 * ($i+1)); $j++) { 
                    $out .= "<td>\n";

                    if ($j >= $start_week && $j < ($start_week + $month_length)) {
                        $out .= "<b>".($j-$start_week+1)."</b><br>";

                        $date = date('Y')."-".date('m')."-".($j-$start_week+1);

                        $sql = "SELECT DISTINCT R.no_ruangan, R.nama_ruangan 
                            FROM siangbang.ruangan R, siangbang.peminjaman_ruang PR 
                            WHERE R.no_ruangan = PR.kode_ruangan
                            AND R.no_ruangan NOT IN (
                                SELECT R.no_ruangan from siangbang.ruangan R, siangbang.peminjaman_ruang PR 
                                where R.no_ruangan = PR.kode_ruangan
                                AND PR.status != 7
                                AND (PR.tgl_mulai, PR.tgl_selesai) OVERLAPS ('$date'::DATE, '$date'::DATE)
                            ) ORDER BY no_ruangan ASC;";

                        $stmt = $this->db->prepare($sql);
                        $stmt->execute();
                        $query = array();

                        while ($row = $stmt->fetch()) {
                            array_push($query, $row);
                        }

                        if (count($query) == 50) {
                            $out .= "Semua Ruangan";
                        } else {
                            foreach ($query as $key => $value) {
                                $out .= "R.".$value['no_ruangan']." - ".ucwords($value['nama_ruangan'])."<br>";
                            }
                        }
                    }

                    $out .= "</td>\n";
                }

                $out .= "</tr>\n";
            }                      

            $out .= "</tbody>";
            
            return $out;

            break;

        case 'daftar-barang':
            $days = date('t', strtotime($_POST['year'].'-'.$_POST['month'].'-01'));

            $sdate = date('Y-m-d', strtotime($_POST['year'].'-'.$_POST['month'].'-01'));
            $edate = date('Y-m-d', strtotime($_POST['year'].'-'.$_POST['month'].'-'.$days));

            $sql = "SELECT DISTINCT B.kode_barang, B.nama_barang, B.jenis_barang, B.jumlah_barang, B.keterangan, B.foto
                    FROM siangbang.barang B, siangbang.peminjaman_barang PB, siangbang.list_pinjam_barang LPB
                    WHERE LPB.kode_barang = B.kode_barang 
                    AND PB.tgl_mulai = LPB.tgl_mulai
                    AND PB.username_mhs = LPB.username_mhs
                    AND B.kode_barang NOT IN (
                        SELECT B.kode_barang
                        FROM siangbang.barang B, siangbang.peminjaman_barang PB, siangbang.list_pinjam_barang LPB
                        WHERE LPB.kode_barang = B.kode_barang
                        AND PB.tgl_mulai = LPB.tgl_mulai
                        AND PB.username_mhs = LPB.username_mhs
                        AND PB.status != 3
                        AND (PB.tgl_mulai, PB.tgl_selesai) OVERLAPS (DATE '{$sdate}', DATE '{$edate}')
                    )
                    ORDER BY B.kode_barang asc;";

                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                    $query = array();

                    while ($row = $stmt->fetch()) {
                        array_push($query, $row);
                    }

                    $out = "<tbody>\n
                                <tr>\n
                                    <th>No.</th>\n
                                    <th>Kode barang</th>\n
                                    <th>Nama Barang</th>\n
                                    <th>Jenis Barang</th>\n
                                    <th>Jumlah</th>\n
                                    <th>Keterangan</th>\n
                                    <th>Foto</th>\n
                                </tr>\n";

                    foreach ($query as $key => $value) {
                        $out .= "<tr>\n<td>".($key + 1)."</td>\n<td>".$value['kode_barang']."</td>\n<td>".$value['nama_barang']."</td>\n<td>".ucwords(str_replace("-", " ", $value['jenis_barang']))."</td>\n<td>".$value['jumlah_barang']."</td>\n<td>".$value['keterangan']."</td>\n";

                        if (!empty($value['foto'])) {
                            $out .= "<td><img src='".$value['foto']."'></td>";
                        } else {
                            $out .= "<td></td>";
                        }
                    }
                            
                    $out .= "</tbody>";
                    
                    return $out;
            break;
        
        default:
            # code...
            break;
    }
});

$app->get('/dashboard/{function}', function (Request $request, Response $response, array $args) {
    if (empty($_SESSION['username'])) {
        return $response->withRedirect('/');
    } else {
        $func = explode("/", $_SERVER['REQUEST_URI']);

        switch ($func[2]) {
            case 'list-pinjam-barang':
                $sql = "SELECT * FROM siangbang.barang;";
                break;
            
            case 'list-pinjam-ruang':
                switch($_SESSION["role"]){
                    case "admin_ruangan":
                    $sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 1 and username_admin = '{$_SESSION['username']}';";
                    break;
                    case "manajer_akademik":
                    $sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 2;";
                    break;
                    case "manajer_IT":
                    $sql = "SELECT * FROM siangbang.peminjaman_ruang where status = 3 ;";
                    break;
                }
                break;

            case 'pinjam-barang':
                $sql = "SELECT * FROM siangbang.barang;";
                break;
            
            case 'pinjam-ruang':
                $sql = "SELECT * FROM siangbang.ruangan;";
                break;
            
            case 'daftar-ruang':
                $sql = "SELECT 1";
                break;
            
            case 'daftar-barang':
                $year = date('Y');
                $month = date('m');
                $days = date('t');

                $sdate = date('Y-m-d', strtotime($year.'-'.$month.'-01'));
                $edate = date('Y-m-d', strtotime($year.'-'.$month.'-'.$days));

                $sql = "SELECT DISTINCT B.kode_barang, B.nama_barang, B.jenis_barang, B.jumlah_barang, B.keterangan, B.foto
                        FROM siangbang.barang B, siangbang.peminjaman_barang PB, siangbang.list_pinjam_barang LPB
                        WHERE LPB.kode_barang = B.kode_barang 
                        AND PB.tgl_mulai = LPB.tgl_mulai
                        AND PB.username_mhs = LPB.username_mhs
                        AND B.kode_barang NOT IN (
                            SELECT B.kode_barang
                            FROM siangbang.barang B, siangbang.peminjaman_barang PB, siangbang.list_pinjam_barang LPB
                            WHERE LPB.kode_barang = B.kode_barang
                            AND PB.tgl_mulai = LPB.tgl_mulai
                            AND PB.username_mhs = LPB.username_mhs
                            AND PB.status != 3
                            AND (PB.tgl_mulai, PB.tgl_selesai) OVERLAPS (DATE '{$sdate}', DATE '{$edate}')
                        )
                        ORDER BY B.kode_barang asc;";
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

            case 'cetak-barang':
                $sql = "SELECT *
                    FROM siangbang.list_pinjam_barang LB, siangbang.barang B, siangbang.peminjaman_barang PB
                    WHERE LB.username_mhs = '{$_SESSION['username']}'
                    AND LB.username_mhs = PB.username_mhs
                    AND B.kode_barang = LB.kode_barang
                    AND LB.tgl_mulai = Pb.tgl_mulai
                    ORDER BY LB.tgl_mulai DESC;";
                break;
            
            case 'cetak-ruang':
                $sql = "SELECT *
                    FROM siangbang.peminjaman_ruang, siangbang.ruangan
                    WHERE username_mhs = '{$_SESSION['username']}'
                    AND kode_ruangan = no_ruangan
                    ORDER BY tgl_mulai DESC;";
                break;
            
            case 'entry-jadwal':
                $sql = "SELECT * FROM siangbang.ruangan;";
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
            'query' => $query,
            'db' => $this->db
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

$app->post('/insert-schedule', function (Request $request, Response $response, array $args) {
    if (isset($_POST['simpan'])) {
        
        $sql = "SELECT username_admin
            FROM siangbang.ruangan
            WHERE no_ruangan = '{$_POST['kode_ruangan']}';";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $item = $stmt->fetch();

        $today = date("Y-m-d");
        $term = explode("-", $_POST['term']);

        $sql = "INSERT INTO siangbang.jadwal (kode_jadwal, tahun_term, semester_term, nama_matkul, kelas, jam_mulai, jam_selesai, hari, kode_ruangan, username_admin)
            VALUES ('{$_POST['kode_jadwal']}', '{$term['0']}', '{$term['1']}', '{$_POST['nama_matkul']}', '{$_POST['kelas']}', TIMESTAMP '{$today} {$_POST['waktu_mulai']}', TIMESTAMP '{$today} {$_POST['waktu_selesai']}', '{$_POST['hari']}', '{$_POST['kode_ruangan']}', '{$item['username_admin']}');";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();

        return $response->withRedirect('/dashboard/entry-jadwal');
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

$app->post('/accept-ruang', function (Request $request, Response $response, array $args) {
    switch($_SESSION["role"]){
        case "admin_ruangan":
        $sql = "UPDATE siangbang.peminjaman_ruang set status = 2 where tgl_mulai='{$_POST['tgl_mulai']}' and kode_ruangan = '{$_POST['ruangan']}' and username_mhs = '{$_POST['username']}';";
        break;
        case "manajer_akademik":
        $sql = "UPDATE siangbang.peminjaman_ruang set status = 3 where tgl_mulai='{$_POST['tgl_mulai']}' and kode_ruangan = '{$_POST['ruangan']}' and username_mhs = '{$_POST['username']}';";
        break;
        case "manajer_IT":
        $sql = "UPDATE siangbang.peminjaman_ruang set status = 4 where tgl_mulai='{$_POST['tgl_mulai']}' and kode_ruangan = '{$_POST['ruangan']}' and username_mhs = '{$_POST['username']}';";
        break;
    }
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return true;
});

$app->post('/deny-ruang', function (Request $request, Response $response, array $args) {
    switch($_SESSION["role"]){
        case "admin_ruangan":
        $sql = "UPDATE siangbang.peminjaman_ruang set status = 5 where tgl_mulai='{$_POST['tgl_mulai']}' and kode_ruangan = '{$_POST['ruangan']}' and username_mhs = '{$_POST['username']}';";
        break;
        case "manajer_akademik":
        $sql = "UPDATE siangbang.peminjaman_ruang set status = 6 where tgl_mulai='{$_POST['tgl_mulai']}' and kode_ruangan = '{$_POST['ruangan']}' and username_mhs = '{$_POST['username']}';";
        break;
        case "manajer_IT":
        $sql = "UPDATE siangbang.peminjaman_ruang set status = 7 where tgl_mulai='{$_POST['tgl_mulai']}' and kode_ruangan = '{$_POST['ruangan']}' and username_mhs = '{$_POST['username']}';";
        break;
    }
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return true;
});

$app->post('/print-barang', function (Request $request, Response $response, array $args) {
    $sql = "SELECT *
        FROM siangbang.list_pinjam_barang LB, siangbang.barang B, siangbang.peminjaman_barang PB
        WHERE LB.username_mhs = '{$_SESSION['username']}'
        AND LB.tgl_mulai = '{$_POST['tgl_mulai']}'
        AND LB.kode_barang = '{$_POST['barang']}'
        AND LB.username_mhs = PB.username_mhs
        AND B.kode_barang = LB.kode_barang
        AND LB.tgl_mulai = Pb.tgl_mulai
        ORDER BY LB.tgl_mulai DESC;";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $item = $stmt->fetch();

    switch ($item['status']) {
        case "1": 
        $item['status'] = "Menunggu persetujuan admin";
        break;
        case "2": 
        $item['status'] = "Menunggu persetujuan manajer pendidikan dan kemahasiswaan";
        break;
        case "3": 
        $item['status'] = "Menunggu persetujuan manajer IT";
        break;
        case "4": 
        $item['status'] = "Disetujui";
        break;
        case "5": 
        $item['status'] = "Ditolak admin";
        break;
        case "6": 
        $item['status'] = "Ditolak manajer pendidikan dan kemahasiswaan";
        break;
        case "7": 
        $item['status'] = "Ditolak manajer IT";
        break;
    }

    $this->pdf->AddPage();
    $this->pdf->SetFont('Arial','B',16);
    $this->pdf->Cell(180,20,"Bukti Peminjaman Barang",0,0,'C',false);
    $this->pdf->Ln();
    // Colors, line width and bold font
    // Header
    $w = array(35, 45, 30, 35, 50, 50);
    $header = array('Tanggal Request', 'Username Mahasiswa', 'Kode Barang', 'Nama Barang', "Tgl. Mulai Penggunaan", "Tgl. Selesai Penggunaan", 'Waktu Mulai', 'Waktu Selesai', 'Nama Kegiatan', 'Tujuan', 'Jumlah', 'Status', 'Denda');
    $content = array(': '.$item['tgl_req'], ': '.$item['username_mhs'], ': '.$item['kode_barang'], ': '.$item['nama_barang'], ': '.$item['tgl_mulai'], ': '.$item['tgl_selesai'], ': '.$item['waktu_mulai'], ': '.$item['waktu_selesai'], ': '.ucwords($item['nama_kegiatan']), ': '.$item['tujuan'], ': '.$item['jumlah'], ': '.$item['status'], ': Rp '.$item['denda']);

    for($i=0;$i<count($header);$i++) {
        if ($header[$i] == 'Nama Kegiatan' || $header[$i] == 'Tujuan' || strlen($item['status']) > 35) {
            $this->pdf->SetFont('Arial','B',16);
            $this->pdf->Cell(90,8,$header[$i],0,0,'L',false);
            $this->pdf->SetFont('', '',16);
            $this->pdf->MultiCell(90,10,$content[$i]);
            $this->pdf->Ln();
        } else {
            $this->pdf->SetFont('Arial','B',16);
            $this->pdf->Cell(90,8,$header[$i],0,0,'L',false);
            $this->pdf->SetFont('', '',16);
            $this->pdf->Cell(90,8,$content[$i],0,0,'L',false);
            $this->pdf->Ln();
        }
    }

    $this->pdf->Ln();

    $name = "BUKTI_".str_replace("-", "", $item['tgl_mulai'])."-".$item['username_mhs'].".pdf";

    $this->pdf->Output('D', $name);
});

$app->post('/print-ruang', function (Request $request, Response $response, array $args) {
    $sql = "SELECT *
        FROM siangbang.peminjaman_ruang, siangbang.ruangan
        WHERE username_mhs = '{$_SESSION['username']}'
        AND kode_ruangan = no_ruangan
        AND tgl_mulai = '{$_POST['tgl_mulai']}'
        AND kode_ruangan = '{$_POST['ruangan']}'
        ORDER BY tgl_mulai DESC;";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $item = $stmt->fetch();

    switch ($item['status']) {
        case "1": 
        $item['status'] = "Menunggu persetujuan admin";
        break;
        case "2": 
        $item['status'] = "Menunggu persetujuan manajer pendidikan dan kemahasiswaan";
        break;
        case "3": 
        $item['status'] = "Menunggu persetujuan manajer IT";
        break;
        case "4": 
        $item['status'] = "Disetujui";
        break;
        case "5": 
        $item['status'] = "Ditolak admin";
        break;
        case "6": 
        $item['status'] = "Ditolak manajer pendidikan dan kemahasiswaan";
        break;
        case "7": 
        $item['status'] = "Ditolak manajer IT";
        break;
    }

    $this->pdf->AddPage();
    $this->pdf->SetFont('Arial','B',16);
    $this->pdf->Cell(180,20,"Bukti Peminjaman Ruangan",0,0,'C',false);
    $this->pdf->Ln();
    // Colors, line width and bold font
    // Header
    $w = array(35, 45, 30, 35, 50, 50);
    
    $header = array(
        'Tanggal Request', 
        'Kode Ruangan', 
        'Username Mahasiswa',
        "Tgl. Mulai Penggunaan", 
        "Tgl. Selesai Penggunaan", 
        'Waktu Mulai', 
        'Waktu Selesai', 
        'Nama Kegiatan', 
        'Tujuan', 
        'Jumlah Peserta', 
        'Status'
    );

    $content = array(
        ': '.$item['tgl_req'], 
        ': '.$item['kode_ruangan'], 
        ': '.$item['username_mhs'],  
        ': '.$item['tgl_mulai'], 
        ': '.$item['tgl_selesai'], 
        ': '.$item['waktu_mulai'], 
        ': '.$item['waktu_selesai'], 
        ': '.ucwords($item['nama_kegiatan']), 
        ': '.$item['tujuan'], 
        ': '.$item['jumlah_peserta'], 
        ': '.$item['status']
    );

    for($i=0;$i<count($header);$i++) {
        if ($header[$i] == 'Tujuan' || strlen($item['status']) > 35) {
            $this->pdf->SetFont('Arial','B',16);
            $this->pdf->Cell(90,8,$header[$i],0,0,'L',false);
            $this->pdf->SetFont('', '',16);
            $this->pdf->MultiCell(90,10,$content[$i]);
            $this->pdf->Ln();
        } else {
            $this->pdf->SetFont('Arial','B',16);
            $this->pdf->Cell(90,8,$header[$i],0,0,'L',false);
            $this->pdf->SetFont('', '',16);
            $this->pdf->Cell(90,8,$content[$i],0,0,'L',false);
            $this->pdf->Ln();
        }
    }

    $this->pdf->Ln();

    $name = "BUKTI_".str_replace("-", "", $item['tgl_mulai'])."-".$item['username_mhs'].".pdf";

    $this->pdf->Output('D', $name);
});

$app->get('/jadwal-ruangan', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    
    return $this->renderer->render($response, 'd_jadwal_ruangan.php', $args);
});

$app->get('/', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'landing.phtml', $args);
});