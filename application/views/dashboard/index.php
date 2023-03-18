<?php
$dt1 = [];
$label2 = [];

foreach ($onMonth->result() as $rw) {
    array_push($dt1, $rw->cprog);
    array_push($label2, $rw->prog);
}

$plabel = "'" . implode("','", $label2) . "'";
$pdata = implode(",", $dt1);

$dt = [];
$label = [];
foreach ($toDay as $td) {
    array_push($dt, $td['jumlah']);
    array_push($label, $td['nama_orang']);
}

$nama_label = "'" . implode("','", $label) . "'";
$urutan_data = implode(",", $dt);
?>
<div class="row  border-bottom white-bg dashboard-header">

    <div class="col-md-3">
        <h2>Welcome <?= explode(" ", $user['user_nama'])[0] ?></h2>
        <small>Ini adalah data dalam sebulan ini</small>
        <ul class="list-group clear-list m-t">
            <?php if (($user['role_id'] == '1') || ($user['role_id'] == '2') || ($user['role_id'] == '7') || ($user['role_id'] == '9')) { ?>
                <?php $no = 1;
                foreach ($onMonth->result() as $om) : ?>
                    <?php
                    if ($om->prog == 'Kontak') {
                        $labels = "label-danger";
                    } else if ($om->prog == 'Followup') {
                        $labels = "label-success";
                    } else if ($om->prog == 'Penawaran') {
                        $labels = "label-info";
                    } else if ($om->prog == 'FU Penawaran') {
                        $labels = "label-warning";
                    } else if ($om->prog == 'Jadi PO') {
                        $labels = "label-primary";
                    }
                    ?>
                    <li class="list-group-item fist-item">
                        <span class="float-right">
                            <?= $om->cprog ?> Customer
                        </span>
                        <span class="label <?= $labels ?>"><?= $no++ ?></span> <?= $om->prog; ?>
                    </li>
                <?php endforeach; ?>
            <?php } else { ?>
                <?php $no = 1;
                foreach ($onMonthuser->result() as $onu) : ?>
                    <?php
                    if ($onu->prog == 'Kontak') {
                        $labels = "label-danger";
                    } else if ($onu->prog == 'Followup') {
                        $labels = "label-success";
                    } else if ($onu->prog == 'Penawaran') {
                        $labels = "label-info";
                    } else if ($onu->prog == 'FU Penawaran') {
                        $labels = "label-warning";
                    } else if ($onu->prog == 'Jadi PO') {
                        $labels = "label-primary";
                    }
                    ?>
                    <li class="list-group-item fist-item">
                        <span class="float-right">
                            <?= $onu->cprog ?> Customer
                        </span>
                        <span class="label <?= $labels ?>"><?= $no++ ?></span> <?= $onu->prog; ?>
                    </li>
                <?php endforeach; ?>
            <?php } ?>
        </ul>
    </div>
    <div class="col-md-6">
        <div class="barchart dashboard-chart">
            <canvas class="barchart" id="barChart"></canvas>
        </div>

    </div>

</div>

<div class="wrapper wrapper-content">
    <?php if(($user['role_id'] == '1') || ($user['role_id'] == '2') || ($user['role_id'] == '7') || ($user['role_id'] == '9')) : ?>
    <div class="row">
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Close (With Order)</h5>
                </div>
                <div class="ibox-content">
                    <span class="h5 label label-primary"><?= $ClosePO; ?></span> <p class="float-right" style="font-weight: bolder;">Customer</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Close (without Order)</h5>
                </div>
                <div class="ibox-content">
                    <span class="h5 label label-danger"><?= $ClosenonPO; ?></span> <p class="float-right" style="font-weight: bolder;">Customer</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Project Open</h5>
                </div>
                <div class="ibox-content">
                    <span class="h5 label label-success"><?= $opens ?></span> <p class="float-right" style="font-weight: bolder;">Customer</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Opportunity Chart</h5>
                </div>
                <div class="ibox-content">
                    <canvas class="ct-chart-pie" id="opportunityChart"></canvas>
                </div>
                <div class="ibox-footer">
                    <small>Data bulan <?= date('m-Y') ?></small>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    $(function() {
        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?= $nama_label; ?>],
                datasets: [{
                    label: '# Jumlah customer follow-up hari ini',
                    data: [<?= $urutan_data; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'easeInQuad',
                        from: 1,
                        to: 0,
                        loop: true
                    }
                }
            }
        });
        
        const ctr = document.getElementById('opportunityChart').getContext('2d');
        const opportunityChart = new Chart(ctr, {
            type: 'pie',
            data: {
                labels: [<?= $plabel; ?>],
                datasets: [{
                    label: 'Kategori Followup',
                    data: [<?= $pdata ?>],
                    backgroundColor: [
                        'rgb(205, 92, 92, 1)',
                        'rgb(255, 165, 0, 0.8)',
                        'rgb(135, 206, 235, 0.8)',
                        'rgb(123, 104, 238, 0.8)',
                        '#00FA9A'
                    ],
                }]
            },
            option: {
                responsive: true,
                legend: {
                    display: true,
                    position: "left",
                    labels: {
                        fontSize: 10,
                        boxWidth: 20,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })
    });
</script>