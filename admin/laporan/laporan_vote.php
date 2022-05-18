<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-table"></i> Laporan Daftar Voting
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <table id="example2" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Vote</th>
                        <th>Keterangan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Jumlah Calon</th>
                        <th>Jumlah Pemilih</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $no = 1;
                    $sql = $koneksi->query("
					select a.*, jumlah_calon, jumlah_pemilih, coalesce(sudah_memilih,0) sudah_memilih, 
					coalesce(belum_memilih,0) belum_memilih 
                    from tb_daftarvote a
                    left join					
					(select daftarvote_id, count(*) jumlah_calon 
					from tb_votekandidat where flag_id<>9 group by daftarvote_id) b
					on a.daftarvote_id=b.daftarvote_id
					left join (select daftarvote_id, count(*) jumlah_pemilih, 
					sum(case when status_id=2 then 1 else 0 end) sudah_memilih, 
					sum(case when status_id=1 then 1 else 0 end)  belum_memilih 
					from tb_votepemilih where flag_id<>9 group by daftarvote_id) c
                    on a.daftarvote_id=c.daftarvote_id
					where a.flag_id<>9");
                    while ($data = $sql->fetch_assoc()) {
                    ?>

                        <tr>
                            <td>
                                <?php echo $no++; ?>
                            </td>
                            <td>
                                <?php echo $data['nama']; ?>
                            </td>
                            <td>
                                <?php echo $data['keterangan']; ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y H:i a', strtotime($data['tanggal_mulai'])); ?>
                            </td>
                            <td>
                                <?php echo date('d-m-Y H:i a', strtotime($data['tanggal_selesai'])); ?>
                            </td>
                            <td align="right">
                                <?php echo $data['jumlah_calon']; ?>
                            </td>
                            <td>
                                <div>sudah memilih : <?php echo $data['sudah_memilih']  ?></div>
                                <div>belum memilih : <?php echo $data['belum_memilih']  ?></div>
                                <div>total pemilih : <?php echo $data['jumlah_pemilih'] ?> </div>

                            </td>
                            <td>
                                <?php $stt = $data['status_id']  ?>
                                <?php switch ($stt) {
                                    case '1':
                                ?>
                                        <?php echo 'Aktif';  ?>
                                    <?php
                                        break;
                                    case '0':
                                    ?>
                                        <?php echo 'Inaktif';  ?>
                                    <?php
                                        break;
                                    case '2':
                                    ?>
                                        <?php echo 'Tutup';  ?>
                            </td>
                    <?php
                                        break;
                                } ?>
                    </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card-body -->