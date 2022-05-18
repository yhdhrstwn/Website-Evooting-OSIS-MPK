<?php
$kode = 0;
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
}
?>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-table"></i> Laporan Daftar Kandidat
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
            var url = '?page=laporan-calon&kode=' + value;
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
                        <th>Foto Kandidat</th>
                        <th>Nama Kandidat</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    $sql = $koneksi->query("select a.* from tb_calon a 
                    join tb_votekandidat b on a.id_calon=b.id_calon
                    where b.flag_id<>9 and daftarvote_id=" . $kode);
                    while ($data = $sql->fetch_assoc()) {
                    ?>
                        <tr>
                            <td>
                                <?php echo $no++; ?>
                            </td>
                            <td align="center">
                                <img src="foto/<?php echo $data['foto_calon']; ?>" width="50px" />
                            </td>
                            <td>
                                <?php echo $data['nama_calon']; ?>
                            </td>
                            <td style="white-space:pre-line">
                                <?php echo $data['keterangan']; ?>
                            </td>
                            <td>
                                <?php $stt = $data['status'];
                                if ($stt == '1') {
                                    echo 'Aktif';
                                } else {
                                    echo 'Inaktif';
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