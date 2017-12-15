<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Cetak Bukti Peminjaman Ruangan
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
        <li class="active">Cetak Bukti Peminjaman Ruangan</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tabel Bukti Peminjaman Ruangan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID Peminjaman</th>
                                <th>Nama Ruangan</th>
                                <th></th>
                            </tr>
                            <?php
                                foreach ($query as $key => $value) {
                                    echo "<tr>\n
                                            <td>
                                                <a href='#' data-toggle='modal' data-target='#modal-".$key."'>
                                                    ".str_replace("-", "", $value['tgl_mulai']).explode(" ", $value['kode_ruangan'])[0]."-".$value['username_mhs']."
                                                </a>
                                            </td>\n
                                            <td>".ucwords($value['nama_ruangan'])."</td>
                                            <td>
                                                <form role='form' action='/print-ruang' method='POST'>
                                                <input type='hidden' name='username' value='".$value['username_mhs']."'>
                                                <input type='hidden' name='tgl_mulai' value='".$value['tgl_mulai']."'>
                                                <input type='hidden' name='ruangan' value='".$value['kode_ruangan']."'>
                                                <button type='submit' class='btn btn-block btn-primary btn-sm print-room-button'>
                                                    Cetak Bukti
                                                </button>
                                                </form>
                                            </td>\n
                                        </tr>\n";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <?php
        foreach ($query as $key => $value) {
            echo "<div class='modal fade' id='modal-".$key."'>\n
                <div class='modal-dialog'>\n
                    <div class='modal-content'>\n
                        <div class='modal-header'>\n
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>\n
                                <span aria-hidden='true'>×</span>\n
                            </button>\n
                            <h4 class='modal-title'>Detail Peminjaman Ruangan</h4>\n
                        </div>\n
                        <div class='modal-body table-responsive no-padding'>\n
                            <table class='table table-hover'>\n
                                <tbody>\n
                                    <tr>\n
                                        <th>Tanggal Req.</th>\n
                                        <th>Kode Ruangan</th>\n
                                        <th>Username Mahasiswa</th>\n
                                        <th>Tgl. Mulai Penggunaan</th>\n
                                        <th>Tgl. Selesai Pengunaan</th>\n
                                        <th>Waktu Mulai</th>\n
                                        <th>Waktu Selesai</th>\n
                                        <th>Nama Kegiatan</th>\n
                                        <th>Tujuan</th>\n
                                        <th>Jumlah Peserta</th>\n
                                        <th>Status</th>\n
                                    </tr>\n
                                    <tr>\n
                                        <td>".$value['tgl_req']."</td>\n
                                        <td>".$value['kode_ruangan']."</td>\n
                                        <td>".$value['username_mhs']."</td>\n
                                        <td>".$value['tgl_mulai']."</td>\n
                                        <td>".$value['tgl_selesai']."</td>\n
                                        <td>".substr($value['waktu_mulai'], 11)."</td>\n
                                        <td>".substr($value['waktu_selesai'], 11)."</td>\n
                                        <td>".$value['nama_kegiatan']."</td>\n
                                        <td>".$value['tujuan']."</td>\n
                                        <td>".$value['jumlah_peserta']."</td>\n
                                        <td>".$value['status']."</td>\n
                                    </tr>\n
                                </tbody>\n
                            </table>\n
                        </div>\n
                        <div class='modal-footer'>\n
                            <button type='button' class='btn btn-outline pull-left' data-dismiss='modal'>Close</button>\n
                        </div>\n
                    </div>\n
                </div>\n
            </div>";
        }
    ?>
</section>
<!-- /.content -->