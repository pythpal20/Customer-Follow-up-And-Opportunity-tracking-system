<div class="wrapper border-bottom white-bg page-heading">
    <div class="row">
        <!-- <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3><?= $title; ?></h3>
                </div>
            </div>
        </div> -->
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php foreach ($prog->result() as $r) : ?>
                                <?php $gambar = $this->db->get_where('tb_user', ['user_nama' => $r->nama_orang])->row_array(); ?>
                                <?php
                                if (($r->jumlah) < 50) {
                                    $kelas = 'style="background-color:#F8AEAE"';
                                    $label = "label-danger";
                                } elseif (($r->jumlah) >= 50 && ($r->jumlah) < 80) {
                                    $kelas = 'style="background-color:#F8F4AE"';
                                    $label = "label-warning";
                                } else {
                                    $kelas = "";
                                    $label = "label-info";
                                }

                                $tgl = date('Y-m-d');
                                $sql = "SELECT b.add_by,
                                COUNT(IF(max_com = '0', max_com, NULL)) AS kontak,
                                COUNT(IF(max_com = '1', max_com, NULL)) AS followup,
                                COUNT(IF(max_com = '2', max_com, NULL)) AS penawaran,
                                COUNT(IF(max_com = '3', max_com, NULL)) AS followup_penawaran,
                                COUNT(IF(max_com = '4', max_com, NULL)) AS orders
                                FROM (SELECT followup_id, MAX(`comment`) AS max_com, followup_date FROM tb_followup_detail WHERE DATE_FORMAT(FROM_UNIXTIME(followup_date), '%Y-%m-%d') = '" . $tgl . "' GROUP BY followup_id) AS tb_a
                                JOIN tb_followup b ON tb_a.followup_id = b.followup_id
                                WHERE b.add_by = '" . $r->nama_orang . "'
                                GROUP BY b.add_by";

                                $row = $this->db->query($sql)->row_array();
                                ?>
                                <div class="vote-item text-dark" <?= $kelas; ?>>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="vote-actions">
                                                <a href="#">
                                                    <i class="fa fa-chevron-up"> </i>
                                                </a>
                                                <div><?= $r->jumlah ?></div>
                                                <a href="#">
                                                    <i class="fa fa-chevron-down"> </i>
                                                </a>
                                            </div>
                                            <a href="#" class="vote-title text-uppercase">
                                                <?= $r->nama_orang; ?>
                                            </a>
                                            <div class="vote-info text-dark">
                                                <i class="fa fa-phone"></i> Kontak <?= $row['kontak'] ?> | 
                                                <i class="fa fa-puzzle-piece"></i> Followup <?= $row['followup'] ?> | 
                                                <i class="fa fa-rocket"></i> Penawaran <?= $row['penawaran'] ?> | 
                                                <i class="fa fa-star-half-empty"></i> FU. Penawran <?= $row['followup_penawaran'] ?> | 
                                                <i class="fa fa-star"></i> Orders <?= $row['orders'] ?>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <large>Jumlah Kontak hari ini: <label class="badge-info"><?= $r->jumlah ?>/80</label></large>
                                            <div class="progress progress-mini">
                                                <div style="width: <?= (($r->jumlah) / 80) * 100 ?>%;" class="progress-bar bg-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="vote-icon">
                                                <img alt="image" width="25%" class="rounded-circle m-t-xs img-fluid" src="<?= base_url('assets/img/gallery/') . $gambar['photo'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Fungsi untuk memuat ulang halaman setelah 30 detik
    function refreshPage() {
        setTimeout(function() {
            location.reload();
        }, 30000); // Waktu dalam milidetik (30 detik = 30000 milidetik)
    }
        
    // Memanggil fungsi refreshPage saat halaman selesai dimuat
    window.onload = refreshPage;
</script>