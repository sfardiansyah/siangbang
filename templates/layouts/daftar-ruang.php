<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Ruangan Tersedia
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/"><i class="fa fa-dashboard"></i> Home</a>
        </li>
        <li>
            <a href="/dashboard">
                </i> Dashboard</a>
        </li>
        <li class="active">Daftar Ruangan Tersedia</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tabel Ruangan yang Tersedia</h3>
                    <div class="box-tools"><label>Bulan: 
                        <select name="month_select" aria-controls="month" class="form-control input-sm date-selector" id="month-select">
                            <?php 
                                $bulan = array();
                                array_push($bulan, "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

                                foreach ($bulan as $key => $value) {
                                    $out = "<option value='".($key+1)."'";
                                    if (($key+1) == date('n')) {
                                        $out .= " selected";
                                    }
                                    echo $out.">".$value."</option>\n";
                                }
                            ?>
                        </select>
                        <select name="year_select" aria-controls="year" class="form-control input-sm date-selector" id="year-select">
                            <?php 
                                $tahun = array();
                                array_push($tahun, "2016", "2017", "2018");

                                foreach ($tahun as $key => $value) {
                                    $out = "<option value='".$value."'";
                                    if ($value == date('Y')) {
                                        $out .= " selected";
                                    }
                                    echo $out.">".$value."</option>\n";
                                }
                            ?>
                        </select></label>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table-result">
                        <tbody>
                            <tr>
                                <th>Minggu</th>
                                <th>Senin</th>
                                <th>Selasa</th>
                                <th>Rabu</th>
                                <th>Kamis</th>
                                <th>Jumat</th>
                                <th>Sabtu</th>
                            </tr>
                            <?php
                                $start_week = date('w', strtotime(date('Y')."-".date("m")."-01"));
                                $month_length = date('t');

                                $out = "";

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
                                                    AND (tgl_mulai,tgl_selesai) OVERLAPS ('$date'::DATE, '$date'::DATE)
                                                ) ORDER BY no_ruangan ASC;";

                                            $stmt = $db->prepare($sql);
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

                                echo $out;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>
<!-- /.content -->