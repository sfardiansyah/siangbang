<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Daftar Peminjaman Ruangan
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
        <li class="active">Daftar Peminjaman Ruangan</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tabel Daftar Peminjaman Ruangan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table-result">
                        <tbody>
                            <tr>
                                <th>Tanggal request</th>
                                <th>Kode Ruangan</th>
                                <th>Username Mahasiswa</th>
                                <th>Tgl. Mulai Penggunaan</th>
                                <th>Tgl. Selesai Penggunaan</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Nama Kegiatan</th>
                                <th>Tujuan</th>
                                <th>Jumlah Peserta</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            <?php
                                foreach ($query as $key => $value) {
                                    $out = "<tr>\n<td>".$value['tgl_req']."</td>\n<td>".explode(" ", $value['kode_ruangan'])[0]."</td>\n<td>".$value['username_mhs']."</td>\n<td>".$value['tgl_mulai']."</td>\n<td>".$value['tgl_selesai']."</td>\n<td>".$value['waktu_mulai']."</td>\n<td>".$value['waktu_selesai']."</td>\n<td>".$value['nama_kegiatan']."</td>\n<td>".$value['tujuan']."</td>\n<td>".$value['jumlah_peserta']."</td>\n";
                                    
                                    switch($_SESSION["role"]){
                                        case "admin_ruangan":
                                        $out .= "<td>Menunggu Persetujuan Admin</td>\n";
                                        break;
                                        case "manajer_akademik":
                                        $out .= "<td>Menunggu Persetujuan Manajer Pendidikan dan Kemahasiswaan</td>\n";
                                        break;
                                        case "manajer_IT":
                                        $out .= "<td>Menunggu Persetujuan Manajer IT</td>\n";
                                        break;
                                    }

                                    $out .= "<td>\n<button type='button' class='btn btn-block btn-success btn-sm accept-button' username='".$value['username_mhs']."' tgl_mulai='".$value['tgl_mulai']."' ruangan='".explode(" ", $value['kode_ruangan'])[0]."'>Setujui</button>\n<button type='button' class='btn btn-block btn-danger btn-sm deny-button' username='".$value['username_mhs']."' tgl_mulai='".$value['tgl_mulai']."' ruangan='".explode(" ", $value['kode_ruangan'])[0]."'>Tolak</button>\n";

                                    echo($out);
                                }
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