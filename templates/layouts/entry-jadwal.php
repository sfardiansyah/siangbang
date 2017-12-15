<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Entry Jadwal Ruangan
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
        <li class="active">Entry Jadwal Ruangan</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Entry Jadwal Ruangan</h3>
                </div>
                <form role="form" method="post" action="/insert-schedule">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="kode_jadwal">Kode Jadwal</label>
                            <input name="kode_jadwal" type="text" class="form-control" id="kode_jadwal" placeholder="Masukkan Kode Jadwal">
                        </div>
                        <div class="form-group">
                            <label>Tahun/Semester</label>
                            <select class="form-control" name="term">
                                <?php
                                    $sql = "SELECT * FROM siangbang.term";
                                    $stmt = $db->prepare($sql);
                                    $stmt->execute();
                                    $terms = array();

                                    while ($row = $stmt->fetch()) {
                                        array_push($terms, $row);
                                    }
                                    
                                    foreach ($terms as $term) {
                                        echo "<option value='".$term['tahun']."-".$term['semester']."'>".$term['tahun']."/".$term['semester']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_matkul">Nama Matkul</label>
                            <input name="nama_matkul" type="text" class="form-control" id="nama_matkul" placeholder="Masukkan Nama Matkul">
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input name="kelas" type="text" class="form-control" id="kelas" placeholder="Masukkan Kelas">
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
                                <label>Waktu Mulai</label>
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
                                <label>Waktu Selesai</label>
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
                            <label>Hari</label>
                            <select class="form-control" name="hari">
                                <option value="mon">Senin</option>
                                <option value="tue">Selasa</option>
                                <option value="wed">Rabu</option>
                                <option value="thu">Kamis</option>
                                <option value="fri">Jumat</option>
                                <option value="sat">Sabtu</option>
                                <option value="sun">Minggu</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode Ruangan</label>
                            <select class="form-control" name="kode_ruangan">
                                <?php
                                    foreach ($query as $ruangan) {
                                        echo "<option value='".explode(" ", $ruangan['no_ruangan'])[0]."'>".explode(" ", $ruangan['no_ruangan'])[0]."</option>";
                                    }
                                ?>
                            </select>
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