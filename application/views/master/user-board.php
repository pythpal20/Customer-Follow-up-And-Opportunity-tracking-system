<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><?= $title ?></h2><b>Data Follow-up Customer (1 Bulan) <?= date('m-Y') ?></b>
        <button class="btn btn-xs btn-danger directLink pull-right mt-0 mb-0"><span class="fa fa-paper-plane"></span> Fullscreen</button>
    </div>
</div>
<style>
    .buatan {
        font-size: 12px;
        color: var(--color-text);
        width: 100%;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .buatan td,
    th {
        padding: 3px;
        font-weight: bold;
    }

    .table .table-borderless td,
    th {
        padding: 2px;
    }
    
    .card {
      opacity: 0; /* Atur opasitas awal menjadi 0 */
      animation: fadeInRight 0.5s forwards; /* Animasi fadeInRight selama 0.5 detik */
    }

    @keyframes fadeInRight {
      from {
        opacity: 0;
        transform: translateX(20px); /* Pindahkan 20 piksel ke kanan saat awal */
      }
      to {
        opacity: 1;
        transform: translateX(0); /* Pindahkan kembali ke posisi awal */
      }
    }
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <!-- <div class="col-md-12">
            <button class="btn btn-xs btn-dark float-right mb-2 seePerDay" id="seePerDay">Lihat Hari ini</button>
        </div> -->
        <div class="col-lg-12 mb-5">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Daily Progress Board</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Date Range View</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-3">Monthly Board</small></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body" style="background-color: #E5E7E9;">
                            <div class="row row-cols-lg-3 row-cols-1">
                                <div class="col-lg-12 mb-1">
                                    <div class="row">
                                        <div class="col-6">
                                            <form action="<?= base_url('master/board') ?>" method="post" class="ml-auto">
                                                <div class="form-group row">
                                                    <div class="col-lg-8 pull-right">
                                                        <div class="input-group">
                                                            <input type="date" name="tglpilih" id="tglpilih" class="form-control" value="<?= set_value('tglpilih') ?>">
                                                            <span class="input-group-append">
                                                                <button type="submit" class="btn btn-danger .lotak"><i class="fa fa-search"></i></button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-6" id="downloadSelection">
                                            <!-- <button class="btn btn-danger float-right"><span class="fa fa-download"></span> Download</button> -->
                                        </div>
                                    </div>
                                </div>

                                <?php foreach ($cras as $dy) : ?>
                                    <?php if ($dy["add_by"] != null) : ?>
                                        <?php
                                            $timestamp  = strtotime($tgldipili);
                                            $hari       = date("l", $timestamp);
                                            
                                            if($hari == "Saturday") {
                                                if($dy["format_customer"] == 'Telemarketing Horeka') {
                                                    $telp   = 40;
                                                    $twa    = 50;
                                                    $wb     = 20;
                                                    $wbp    = 30;
                                                } else if($dy["format_customer"] == 'Telemarketing Foodpack') {
                                                    $telp   = 20;
                                                    $wb     = 20;
                                                } else if($dy["format_customer"] == 'Website') {
                                                    $telp   = 10;
                                                    $visit  = 7;
                                                    $twa    = 40;
                                                    $wb     = 10;
                                                    $wbp    = 30;
                                                }
                                            } else {
                                                if($dy["format_customer"] == 'Telemarketing Horeka') {
                                                    $telp   = 80;
                                                    $twa    = 100;
                                                    $wb     = 40;
                                                    $wbp    = 60;
                                                } else if($dy["format_customer"] == 'Telemarketing Foodpack') {
                                                    $telp   = 40;
                                                    $wb     = 40;
                                                } else if($dy["format_customer"] == 'Website') {
                                                    $telp   = 20;
                                                    $visit  = 7;
                                                    $twa    = 40;
                                                    $wb     = 10;
                                                    $wbp    = 30;
                                                }
                                            }
                                        ?>
                                        <?php $gambar = $this->db->get_where('tb_user', ['user_nama' => $dy["add_by"]])->row_array(); ?>
                                        <div class="col-auto col-lg-4 mb-3">
                                            <div class="card ml-0 mr-0">
                                                <div class="card-header" style="display: flex; align-items: center; width: 100%; column-gap: 10px; overflow:visible; ">
                                                    <div class="card-header-img">
                                                        <img src="<?= base_url('assets/img/gallery/') . $gambar['photo'] ?>" style="width: 65px; border-radius:100%" class="mb-2">
                                                    </div>
                                                    <div>
                                                        <h5 style="font-weight: bold; text-transform: uppercase;" class="mb-2">
                                                            <?= $dy["add_by"] ?></h5>
                                                        <p><?= $dy["format_customer"] ?></p>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <table class="buatan">
                                                        <tr>
                                                            <td width="45%">Jlh Customer</td>
                                                            <td>:</td>
                                                            <td><?= $dy["count_all"] ?> Customer</td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-map-marker"></i> Visit</td>
                                                            <td>:</td>
                                                            <?php if ($dy["format_customer"] == 'Website' || $dy["format_customer"] == 'Sales Horeka') : ?>
                                                                <td>
                                                                    <small><?= number_format((($dy["count_visit"] / 7) * 100), 2, ".", ".") . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_visit"] ?>/ 7</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_visit"] / 7) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_visit"] / 7) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php else : ?>
                                                                <td><?= $dy["count_visit"] ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-paper-plane-o"></i> Total Whatsapp</td>
                                                            <td>:</td>
                                                            <td><?= $dy["wa_foodpack"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-phone"></i> Telp</td>
                                                            <td>:</td>
                                                            <?php if ($dy["format_customer"] == 'Telemarketing Horeka') : ?>
                                                                <td><small><?= number_format((($dy["count_telp"] / $telp) * 100), 2, ".", ".") . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_telp"] ?>/ <?= $telp ?></small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_telp"] / $telp) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_telp"] / $telp) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Telemarketing Foodpack') : ?>
                                                                <td><small><?= (($dy["count_telp"] / 40) * 100) . "%" ?> | <?= $dy["count_telp"] ?>/ 40</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_telp"] / 40) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_telp"] / $telp) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Website') : ?>
                                                                <td>
                                                                    <small><?= (($dy["count_telp"] / 20) * 100) . "%" ?> | <?= $dy["count_telp"] ?>/ 20</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_telp"] / 20) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_telp"] / $telp) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Sales Horeka') : ?>
                                                                <td>
                                                                    <small><?= (($dy["count_telp"] / 7) * 100) . "%" ?> | <?= $dy["count_telp"] ?>/ 7</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_telp"] / 7) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_telp"] / $telp) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Showroom') : ?>
                                                                <td>
                                                                    <small><?= number_format((($dy["count_telp"]/ 30) * 100), 2, ".", ".") . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_telp"] ?>/ 30</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_telp"]/ 30) * 100) . '%' ?>" class="progress-bar <?php if((($dy["count_telp"] / $telp) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php else : ?>
                                                                <td><?= $dy["count_telp"] ?> </td>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-envelope"></i> Email</td>
                                                            <td>:</td>
                                                            <td><?= $dy["count_email"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa-brands fa-gittip"></i> By Marketplace</td>
                                                            <td>:</td>
                                                            <td><?= $dy["count_marketplace"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-file-text-o"></i> Penawaran</td>
                                                            <td>:</td>
                                                            <td><?= $dy["count_penawaran"] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-shopping-cart"></i> PO</td>
                                                            <td>:</td>
                                                            <td><?= $dy["count_po"] ?></td>
                                                        </tr>
                                                    </table>
                                                    <hr class="hr-line-dashed mb-0" style="margin-top: 0px;" />
                                                    <table class="buatan">
                                                        <tr>
                                                            <td width="40%"><i class="fa fa-comments-o"></i> Tanya Barang</td>
                                                            <td>:</td>
                                                            <?php if ($dy["format_customer"] == 'Telemarketing Horeka' || $dy["format_customer"] == 'E-Commerce') : ?>
                                                                <td>
                                                                    <small><?= (($dy["count_tanyabarang"] / 10) * 100) . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_tanyabarang"] ?>/ 10</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_tanyabarang"] / 10) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_tanyabarang"] / 10) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Telemarketing Foodpack' || $dy["format_customer"] == 'Website' || $dy["format_customer"] == 'Sales Horeka') : ?>
                                                                <td>
                                                                    <small><?= (($dy["count_tanyabarang"] / 5) * 100) . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_tanyabarang"] ?>/ 5</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_tanyabarang"] / 5) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_tanyabarang"] / 5) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php else : ?>
                                                                <td><?= $dy["count_tanyabarang"] ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-bullhorn"></i> Wa Blast</td>
                                                            <td>:</td>
                                                            <?php if ($dy["format_customer"] == 'Telemarketing Horeka') : ?>
                                                                <td>
                                                                    <small><?= (($dy["count_whatsapp_blast"] / 40) * 100) . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_whatsapp_blast"] ?>/ 40</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_whatsapp_blast"] / 40) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_whatsapp_blast"] / 40) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Telemarketing Foodpack') : ?>
                                                                <td>
                                                                    <small><?= (($dy["wa_foodpack"] / 20) * 100) . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["wa_foodpack"] ?>/ 20</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["wa_foodpack"] / 40) * 100) . "%" ?>" class="progress-bar <?php if((($dy["wa_foodpack"] / 40) * 100) < 100) : ?> progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Website' || $dy["format_customer"] == 'Sales Horeka') : ?>
                                                                <td>
                                                                    <small><?= (($dy["count_whatsapp_blast"] / 30) * 100) . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_whatsapp_blast"] ?>/ 30</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_whatsapp_blast"] / 30) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_whatsapp_blast"] / 30) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php else : ?>
                                                                <td><?= $dy["count_whatsapp_blast"] ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fa fa-paper-plane-o"></i> Wa Blast Promo</td>
                                                            <td>:</td>
                                                            <?php if ($dy["format_customer"] == 'Telemarketing Horeka') : ?>
                                                                <td>
                                                                    <small><?= number_format((($dy["count_whatsapp_blast_promo"] / 60) * 100), 2, ".", ".") . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_whatsapp_blast_promo"] ?>/ 60</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_whatsapp_blast_promo"] / 60) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_whatsapp_blast_promo"] / 60) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php elseif ($dy["format_customer"] == 'Website' || $dy["format_customer"] == 'Sales Horeka') : ?>
                                                                <td>
                                                                    <small><?= number_format((($dy["count_whatsapp_blast_promo"] / 30) * 100), 2, ".", ".") . "%" ?> <i class="fa fa-arrow-circle-right"></i> <?= $dy["count_whatsapp_blast_promo"] ?>/ 30</small>
                                                                    <div class="progress progress-mini">
                                                                        <div style="width: <?= (($dy["count_whatsapp_blast_promo"] / 30) * 100) . "%" ?>" class="progress-bar <?php if((($dy["count_whatsapp_blast_promo"] / 60) * 100) < 100) : ?> progress-bar-animated progress-bar-striped progress-bar-danger <?php endif; ?>"></div>
                                                                    </div>
                                                                </td>
                                                            <?php else : ?>
                                                                <td><?= $dy["count_whatsapp_blast_promo"] ?></td>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="card-footer" style="padding: 0.5px;">
                                                    <table class="table table-bordered" width="100%" style="font-size: 9px;">
                                                        <thead>
                                                            <tr>
                                                                <th>Jenis</th>
                                                                <th>Qty</th>
                                                                <th>Nominal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th>Penawaran Biasa</th>
                                                                <th><?= $dy["PenawaranBiasa"] . " Lembar" ?></th>
                                                                <th><?= "Rp. " . number_format($dy["count_penawaran_biasa"], 0,".", ".") ?></th>
                                                            </tr>
                                                            <tr>
                                                                <th>Penawaran Promo</th>
                                                                <td><?= $dy["PenawaranPromo"] . " Lembar"?></td>
                                                                <td><?= "Rp. " . $dy["count_penawaran_promo"] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Po Biasa</th>
                                                                <td><?= $dy["PoBiasa"] . " Lembar"?></td>
                                                                <td><?= "Rp. " . number_format($dy["count_po_biasa"], 0, ",", ".") ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Po Promo</th>
                                                                <td><?= $dy["PoPromo"] . " Lembar"?></td>
                                                                <td><?= "Rp. " . number_format($dy["count_po_promo"], 0, ",", ".") ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <div class="pagination">
                                    <?= $links; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="panel panel-info">
                                        <div class="panel-header panel-title">
                                            <h5 class="py-2 m-2">Pilih rentang tanggal</h5>
                                        </div>
                                        <div class="panel-body">
                                            <form id="formRange">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tglawal">Tanggal Awal</label>
                                                            <input type="date" class="form-control" name="tglawal" id="tglawal">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tglakhr">Tanggal Akhir</label>
                                                            <input type="date" class="form-control" name="tglakhr" id="tglakhr">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <span class="btn btn-sm btn-danger tarik d-none" id="doxload"><i class="fa fa-download"></i> Download</span>
                                                        <span class="btn btn-sm btn-info float-right tampilkan"><i class="fa fa-eye"></i> Show</span>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div id="viewCard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-3" class="tab-pane ">
                        <div class="panel-body">
                            <div class="row">
                                <?php foreach ($sales->result() as $s) : ?>
                                    <?php $gambar = $this->db->get_where('tb_user', ['user_nama' => $s->add_by])->row_array(); ?>
                                    <?php $nama_user = $s->add_by;
                                    $sum = $this->m_dashboard->getFollowupByUser($nama_user)->row_array(); ?>
                                    <?php $noms = $this->m_master->nominalUser($s->add_by)->row_array(); ?>
                                    <div class="col-lg-4">
                                        <div class="contact-box .center-version">
                                            <div class="row" id="sortable-view">
                                                <div class="col-5">
                                                    <div class="text-center">
                                                        <img alt="image" style="width: 80px; border-radius: 100%" class="rounded-circle" src="<?= base_url('assets/img/gallery/') . $gambar['photo'] ?>">
                                                        <div class="m-t-xs font-bold" style="font-size: 10px">
                                                            <?= $s->format_customer; ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-7 no-padding">
                                                    <h3><strong><?= strtoupper($s->add_by); ?></strong></h3>
                                                    <ul class="list-group no-padding">
                                                        <li class="list-group-item"><span class="badge badge-primary"><?= $sum['opens'] ?></span>
                                                            On
                                                            Progress</li>
                                                        <li class="list-group-item"><span class="badge badge-danger"><?= $sum['jumlah_nonOrder'] ?></span>
                                                            Without PO</li>
                                                        <li class="list-group-item"><span class="badge badge-success"><?= $sum['jumlah_order'] ?></span>
                                                            With PO</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="contact-box-footer">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h5>Nominal PO Bulan ini : Rp.
                                                            <?= number_format($noms['nompo'], 0, ".", "."); ?></h5>
                                                    </div>
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
</div>

<script>
    $(document).ready(function() {
        $("#seePerDay").on('click', function() {
            window.location.href = "<?= base_url('dashboard/userBoardList') ?>";
        })
    });

    var tanggals = $("#tglpilih").val();
    if (tanggals != '') {
        handlerDateChanges(tanggals);
    }
    document.getElementById('tglpilih').addEventListener('change', function() {
        var nilaiDate = $(this).val();
        handlerDateChanges(nilaiDate);
    });

    function handlerDateChanges(value) {
        var downloadSelection = document.getElementById('downloadSelection');

        downloadSelection.innerHTML = '';

        if (value) {
            var downloadButton = document.createElement('button');
            downloadButton.className = 'btn btn-danger float-right';
            downloadButton.setAttribute('data-id', value);
            downloadButton.setAttribute('id', 'tiniptip');
            downloadButton.innerHTML = '<span class="fa fa-download"></span> Export to .xls';

            downloadSelection.appendChild(downloadButton);
        }
    }

    $("#tiniptip").click(function() {
        var itu = $(this).data('id');
        window.open("<?= base_url('master/exportDaily/') ?>" + itu, "_blank");
    });
    $(".directLink").click(()=> {
        var newWindow = window.open("<?= base_url('master/fullscreenBoard') ?>", "_blank");
        
        if (newWindow && newWindow.document.documentElement.requestFullscreen) {
            newWindow.document.documentElement.requestFullscreen();
          } else if (newWindow && newWindow.document.documentElement.mozRequestFullScreen) { /* Firefox */
            newWindow.document.documentElement.mozRequestFullScreen();
          } else if (newWindow && newWindow.document.documentElement.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
            newWindow.document.documentElement.webkitRequestFullscreen();
          } else if (newWindow && newWindow.document.documentElement.msRequestFullscreen) { /* IE/Edge */
            newWindow.document.documentElement.msRequestFullscreen();
          }
    });
    
    $(document).ready(function() {
        function encryptData(data, key) {
            // Bangkitkan kunci enkripsi dari kunci acak dengan PBKDF2
            var salt = CryptoJS.lib.WordArray.random(128 / 8); // Salt acak
            var derivedKey = CryptoJS.PBKDF2(key, salt, {
                keySize: 256 / 32,
                iterations: 1000
            }); // Bangkitkan kunci acak

            // Enkripsi data dengan kunci acak dan vektor inisialisasi acak
            var iv = CryptoJS.lib.WordArray.random(128 / 8); // Vektor inisialisasi acak
            var encrypted = CryptoJS.AES.encrypt(data, derivedKey, {
                iv: iv
            });

            // Gabungkan salt, vektor inisialisasi, dan data terenkripsi menjadi satu string
            var saltHex = CryptoJS.enc.Hex.stringify(salt);
            var ivHex = CryptoJS.enc.Hex.stringify(iv);
            var encryptedHex = CryptoJS.enc.Hex.stringify(encrypted.ciphertext);
            return saltHex + ivHex + encryptedHex;
        }
        
        $(".tampilkan").click(()=>{
            
            var toms = $("#doxload");
            toms.removeClass("d-none");
            
            var formData = $("#formRange").serialize();
            
            fetch("<?= base_url('master/showRangeView') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                console.log(data);
                document.querySelector('#viewCard').innerHTML = data;
            })
            .catch(function(error) {
                console.log('Error:', error);
            }); 
        });
        
        $(".tarik").click(()=> {
            var strg = $("#tglawal").val() + "|" + $("#tglakhr").val();
            
            var key = "sifupass"; // Kunci enkripsi acak, dapat diganti dengan kunci lain
            var encryptedData = encryptData(strg, key);
            
            // var takhir = $("#tglakhr").val();
            window.location.href="<?= base_url('master/laporanFollowup/') ?>" + encryptedData;
        })
    });
</script>