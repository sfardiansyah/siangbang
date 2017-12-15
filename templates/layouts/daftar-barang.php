<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Barang Tersedia
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
        <li class="active">Daftar Barang Tersedia</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Tabel Barang yang Tersedia</h3>
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
                                <th>No.</th>
                                <th>Kode barang</th>
                                <th>Nama Barang</th>
                                <th>Jenis Barang</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Foto</th>
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