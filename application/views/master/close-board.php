<?php
function closeWith($id)
{
    if ($id == '1') {
        $list = "Harga terlalu mahal";
    } elseif ($id == '2') {
        $list = "Customer belum ada kebutuhan";
    } elseif ($id == '3') {
        $list = "Salah sambung";
    } elseif ($id == '4') {
        $list = "Tidak ada Respon";
    } elseif ($id == '5') {
        $list = "Perlu visit ke customer";
    } elseif ($id == '6') {
        $list = "Kendala metode bayar";
    } elseif ($id == '7') {
        $list = "Barang yang diminta tidak tersedia";
    } elseif ($id == '8') {
        $list = "Waktu pengadaan barang terlalu lama";
    } elseif ($id == '9') {
        $list = "Toko sudah tutup";
    } elseif ($id == '10') {
        $list = "Customer jadi belanja ke showroom";
    }

    return $list;
}

$da = [];
$label = [];

foreach ($clwith->result() as $r) {
    array_push($da, $r->jumlah);
    array_push($label, closeWith($r->close_with));
}

$nama_label = "'" . implode("','", $label) . "'";
$data = implode(",", $da);
?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2><small>Data alasan close tanpa PO dalam bulan ini (<?= date('m-Y') ?>)</small>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container animated bounceIn">
                <ul class="nav nav-tabs">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Close Opportunities</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"> Open Opportunities</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-3"> Achievements</small></a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 animated fadeInLeft">
                                    <canvas class="" id="chartKu"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <?php $delay = 0;
                                        foreach ($clwith->result() as $c) : ?>
                                            <?php
                                            $key = "sifupass";
                                            $decryptedData = encrypt_data($c->close_with, $key);
                                            ?>
                                            <div class="col-lg-6">
                                                <div class="contact-box center-version animated fadeInRight">
                                                    <a href="<?= base_url('master/detailClose/') .  $decryptedData; ?>">
                                                        <!--<img alt="image" class="rounded-circle" src="img/a1.jpg">-->
                                                        <h3 class="m-b-xs"><strong><?= closeWith($c->close_with); ?></strong></h3>
                                                        <hr class="hr-line-solid">
                                                        <div class="font-bold"><?= $c->jumlah ?></div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php $delay += 0.5;
                                        endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-6">
                                    <div id="tableOpens" class="animated fadeInLeft">
                                        <table id="tbRoles" data-toggle="true">
                                            <tr>
                                                <th colspan="3">Open opportunity by user Roles</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div id="tableOpenProses" class="animated fadeInRight">
                                        <table id="tbProgress" data-toggle="true">

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <div id="tableDefault" class="animated bounceInUp">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Bagian</th>
                                            <th>Nominal</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($nompo->result() as $n) : ?>
                                            <tr>
                                                <td><?= $n->format_customer ?></td>
                                                <td>Rp. <?= number_format($n->nompo, 0, ".", ".") ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-xs btn-danger tekanMuncul" data-id="<?= $n->format_customer ?>"><i class="fa fa-info"></i> Detail</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div id="tableShow" class="d-none">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-footer">
                    <h6>Data bulan <?= date('M-Y'); ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        fetch("<?php echo base_url('master/oportunity'); ?>")
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(dataJson => {

                $table = $("#tbRoles")
                $table.bootstrapTable({
                    data: Object.entries(dataJson.countByRole).map(([Role, Count]) => ({
                        Role,
                        Count
                    })),
                    columns: [{
                        field: 'Role',
                        title: 'Nama Devisi'
                    }, {
                        field: "Count",
                        title: 'Open Opportunity'
                    }, {
                        field: "Action",
                        title: 'Act.',
                        formatter: function(value, row) {
                            return [
                                '<button class="btn btn-xs btn-info lihat1" data-id="' + row.Role + '"><i class="fa fa-eye"></i> Detail</button>'
                            ]
                        }
                    }]
                });

                $tableDua = $("#tbProgress")
                $tableDua.bootstrapTable({
                    data: Object.entries(dataJson.countByProgress).map(([Progress, Count]) => ({
                        Progress,
                        Count
                    })),
                    columns: [{
                        field: 'Progress',
                        title: 'Progress Followup'
                    }, {
                        field: "Count",
                        title: 'Open Opportunity'
                    }, {
                        field: "Action",
                        title: 'Act.',
                        formatter: function(value, row) {
                            return [
                                '<button class="btn btn-xs btn-info lihat1" data-id="' + row.Role + '"><i class="fa fa-eye"></i> Detail</button>'
                            ]
                        }
                    }]
                })
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });
    });
</script>
<script>
    // Jalankan fungsi setelah halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua elemen dengan kelas 'bounceInUp'
        var elements = document.querySelectorAll('.bounceInUp');

        // Loop melalui setiap elemen dan atur opacity setelah penundaan
        elements.forEach(function(element, index) {
            setTimeout(function() {
                element.style.opacity = '1';
            }, index * 500); // Ubah penundaan sesuai kebutuhan
        });
    });

    $(document).ready(function() {
        $('.tekanMuncul').on('click', function() {
            var formatCustomer = $(this).data('id');

            // Create a FormData object to send data via POST
            var formData = new FormData();
            formData.append('formatCustomer', formatCustomer);

            fetch("<?= base_url('master/detailFormat') ?>", {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text(); // assuming the response is HTML content
                })
                .then(htmlContent => {
                    // Display the table content in the #tableShow div
                    $('#tableShow').html(htmlContent);
                    // $('#tableShow').hide().html(htmlContent).fadeIn('slow');
                    $('#tableShow').removeClass('d-none'); // Show the div

                    // console.log(htmlContent)
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    });
</script>
<script>
    $(function() {

        const ctx = document.getElementById('chartKu').getContext('2d');
        const chartKu = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?= $nama_label; ?>],
                datasets: [{
                    label: '# Alasan Close',
                    data: [<?= $data; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgb(255, 160, 122, 0.5)',
                        'rgb(216, 191, 216, 0..5)',
                        'rgb(102, 51, 153, 0.5)'
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
                responsive: true,
                indexAxis: 'y',
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: "rgba(255,99,132,0.2)"
                        }
                    }
                },
                animations: {
                    tension: {
                        duration: 1000,
                        easing: 'linear',
                        from: 1,
                        to: 0,
                        loop: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        align: 'center',
                        anchor: 'end',
                        formatter: (value, context) => {

                            const datapoints = context.chart.data.datasets[0].data;
                            const labels = context.chart.data.labels;

                            const lable = labels.map((label, index) => {
                                return label;
                            });

                            function totalSum(total, datapoint) {
                                return total + datapoint;
                            }
                            const totalValue = datapoints.reduce(totalSum, 0);
                            const percentageValue = (value / totalValue * 100).toFixed(1);
                            const display = [`${percentageValue}%`]
                            return display;

                            console.log(display);
                        }
                    }
                },
                barThickness: 15, // ketebalan bar dalam pixel
                maxBarThickness: 50 // maksimum ketebalan bar dalam pixel
            },
            plugins: [ChartDataLabels]
        });
    });
</script>