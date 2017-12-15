<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Cetak Bukti Peminjaman Barang
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
        <li class="active">Cetak Bukti Peminjaman Barang</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tabel Bukti Peminjaman Barang</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>ID Peminjaman</th>
                                <th>Nama Barang</th>
                                <th></th>
                            </tr>
                            <?php
                                foreach ($query as $key => $value) {
                                    echo "<tr>\n
                                            <td>
                                                <a href='#' data-toggle='modal' data-target='#modal-".$key."'>
                                                    ".str_replace("-", "", $value['tgl_mulai'])."-".$value['username_mhs']."
                                                </a>
                                            </td>\n
                                            <td>".$value['nama_barang']."</td>\n
                                            <td>
                                                <form role='form' action='/print-barang' method='POST'>
                                                <input type='hidden' name='username' value='".$value['username_mhs']."'>
                                                <input type='hidden' name='tgl_mulai' value='".$value['tgl_mulai']."'>
                                                <input type='hidden' name='barang' value='".$value['kode_barang']."'>
                                                <button type='submit' class='btn btn-block btn-primary btn-sm print-item-button'>
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
                            <h4 class='modal-title'>Detail Peminjaman Barang</h4>\n
                        </div>\n
                        <div class='modal-body table-responsive no-padding'>\n
                            <table class='table table-hover'>\n
                                <tbody>\n
                                    <tr>\n
                                        <th>Tanggal Req.</th>\n
                                        <th>Username Mahasiswa</th>\n
                                        <th>Kode Barang</th>\n
                                        <th>Nama Barang</th>\n
                                        <th>Tgl. Mulai Penggunaan</th>\n
                                        <th>Tgl. Selesai Pengunaan</th>\n
                                        <th>Waktu Mulai</th>\n
                                        <th>Waktu Selesai</th>\n
                                        <th>Nama Kegiatan</th>\n
                                        <th>Tujuan</th>\n
                                        <th>Jumlah</th>\n
                                        <th>Status</th>\n
                                        <th>Denda</th>\n
                                    </tr>\n
                                    <tr>\n
                                        <td>".$value['tgl_req']."</td>\n
                                        <td>".$value['username_mhs']."</td>\n
                                        <td>".$value['kode_barang']."</td>\n
                                        <td>".$value['nama_barang']."</td>\n
                                        <td>".$value['tgl_mulai']."</td>\n
                                        <td>".$value['tgl_selesai']."</td>\n
                                        <td>".substr($value['waktu_mulai'], 11)."</td>\n
                                        <td>".substr($value['waktu_selesai'], 11)."</td>\n
                                        <td>".$value['nama_kegiatan']."</td>\n
                                        <td>".$value['tujuan']."</td>\n
                                        <td>".$value['jumlah_barang']."</td>\n
                                        <td>".$value['status']."</td>\n
                                        <td>Rp ".$value['denda']."</td>\n
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