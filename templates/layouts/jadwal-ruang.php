<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Lihat Jadwal
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
        <li class="active">Lihat Jadwal</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Pilih Ruangan</h3>
                </div>
                <div class="box-body">
                    <div class="box-tools">
                        <select name="room_select" aria-controls="room" class="form-control input-sm" id="room-select">
                            <?php 
                                $sql = "SELECT * FROM siangbang.ruangan;";

                                $stmt = $db->prepare($sql);
                                $stmt->execute();
                                $query = array();

                                while ($row = $stmt->fetch()) {
                                    $out = "<option value='".explode(" ", $row['no_ruangan'])[0]."'";
                                    if (($key+1) == date('n')) {
                                        $out .= " selected";
                                    }
                                    echo $out.">".ucwords($row['nama_ruangan'])."</option>\n";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar" class="fc fc-unthemed fc-ltr"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
    </div>
</section>
<!-- /.content -->