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
        <div class="col-md-8 col-md-offset-2">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tabel Bukti Peminjaman Ruangan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover" id="table-result">
                        <tbody>
                            <tr>
                                <th>Peminjaman</th>
                                <th>Nama Ruangan</th>
                                <th></th>
                            </tr>
                            <?php
                                foreach ($query as $key => $value) {
                                    $out = "<tr>\n<td>".($key + 1)."</td>\n<td>".$value['kode_barang']."</td>\n<td>".$value['nama_barang']."</td>\n<td>".ucwords(str_replace("-", " ", $value['jenis_barang']))."</td>\n<td>".$value['jumlah_barang']."</td>\n<td>".$value['keterangan']."</td>\n";

                                    if (!empty($value['foto'])) {
                                        $out .= "<td><img src='".$value['foto']."'></td>";
                                    } else {
                                        $out .= "<td></td>";
                                    }

                                    print_r($out);
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