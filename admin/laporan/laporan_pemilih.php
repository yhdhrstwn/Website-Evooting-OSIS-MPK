<?php
$kode = 0;
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
}
?>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-table"></i> Laporan Daftar Pemilih
        </h3>
    </div>

    <p>
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fa fa-fa-vote-yea"></i> Daftar Vote
            </h3>
        </div>
        <select name="daftar_vote" id="daftar_vote" class="form-control" onchange="DaftarVote(this.value)">
            <option value="0">- Pilih -</option>
            <?php
            $sql1 = "select * from tb_daftarvote where status_id='1' and flag_id=1";
            $row = $koneksi->query($sql1);
            //echo $kode;
            while ($result = $row->fetch_assoc()) {
                if ($kode  != $result['daftarvote_id']) {
                    $selected = "";
                } else {
                    $selected = "selected";
                }
                echo '<option value="' . $result['daftarvote_id'] . '" ' . $selected . '>' . $result['nama'] . '</option>';
            }

            //include_once dirname(__FILE__) . '/../../inc/koneksi.php';
            $no = 1;

            ?>
        </select>
    </div>
    </p>

    <script>
        function DaftarVote(value) {
            var url = '?page=laporan-pemilih&kode=' + value;
            window.location = url;
        }
    </script>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemilih</th>
                        <th>Username</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    $sql = $koneksi->query("select a.*, b.status_id from tb_pengguna a 
                    join tb_votepemilih b on a.id_pengguna=b.id_pemilih
                    where b.flag_id<>9 and daftarvote_id=" . $kode . " order by nama_pengguna
                    ");
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $no++; ?>
                            </td>
                            <td>
                                <?php echo $data['nama_pengguna']; ?>
                            </td>
                            <td>
                                <?php echo $data['username']; ?>
                            </td>
                            <td>
                                <?php $stt = $data['status_id'];
                                if ($stt == '1') {
                                    echo 'Belum memilih';
                                } else {
                                    echo 'Sudah Memilih';
                                } ?>
                            </td>
                        <?php } ?>
                        </tr>
                </tbody>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card-body -->