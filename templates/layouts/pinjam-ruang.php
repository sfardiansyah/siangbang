<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Peminjaman Ruangan
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/"><i class="fa fa-dashboard"></i> Home</a>
        </li>
        <li>
            <a href="/dashboard/">
                </i> Dashboard</a>
        </li>
        <li class="active">Peminjaman Ruangan</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Peminjaman Ruangan</h3>
                </div>
                <form role="form" method="post" action="/insert-room">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Nama Ruangan</label>
                            <select class="form-control">
                                <?php
                                    foreach ($query as $ruangan) {
                                        echo "<option value='".$ruangan['no_ruangan']."'>".ucwords($ruangan['nama_ruangan'])."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input name="tgl_mulai" type="text" class="form-control pull-right datepicker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input name="tgl_selesai" type="text" class="form-control pull-right datepicker">
                            </div>
                        </div>
                        <div class="bootstrap-timepicker">
                            <div class="bootstrap-timepicker-widget dropdown-menu">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td>
                                                <a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td class="meridian-column">
                                                <a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bootstrap-timepicker-hour">12</span>
                                            </td>
                                            <td class="separator">:</td>
                                            <td>
                                                <span class="bootstrap-timepicker-minute">30</span>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td>
                                                <span class="bootstrap-timepicker-meridian">PM</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </td>
                                            <td class="separator"></td>
                                            <td>
                                                <a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td>
                                                <a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>Time picker:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input name="waktu_mulai" type="text" class="form-control timepicker">
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div>
                        <div class="bootstrap-timepicker">
                            <div class="bootstrap-timepicker-widget dropdown-menu">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#" data-action="incrementHour"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td>
                                                <a href="#" data-action="incrementMinute"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td class="meridian-column">
                                                <a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bootstrap-timepicker-hour">12</span>
                                            </td>
                                            <td class="separator">:</td>
                                            <td>
                                                <span class="bootstrap-timepicker-minute">30</span>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td>
                                                <span class="bootstrap-timepicker-meridian">PM</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" data-action="decrementHour"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </td>
                                            <td class="separator"></td>
                                            <td>
                                                <a href="#" data-action="decrementMinute"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </td>
                                            <td class="separator">&nbsp;</td>
                                            <td>
                                                <a href="#" data-action="toggleMeridian"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>Time picker:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input name="waktu_selesai" type="text" class="form-control timepicker">
                                </div>
                            </div>
                            <!-- /.form group -->
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Nama Kegiatan</label>
                            <input name="nama_kegiatan" type="text" class="form-control" id="tujuan" placeholder="Masukkan Nama Kegiatan">
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan</label>
                            <input name="tujuan" type="text" class="form-control" id="tujuan" placeholder="Masukkan Tujuan">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Peserta</label>
                            <input name="jumlah" type="number" class="form-control" id="jumlah" placeholder="Masukkan Jumlah">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->