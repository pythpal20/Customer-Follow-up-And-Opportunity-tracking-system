<div id="">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2 class="ml-2"><?= $title ?></h2>
        </div>
    </div>
    <div id="inSlider" class="carousel slide mt-1 ml-2" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#inSlider" data-slide-to="0" class="active"></li>
            <li data-target="#inSlider" data-slide-to="1"></li>
            <li data-target="#inSlider" data-slide-to="2"></li>
            <li data-target="#inSlider" data-slide-to="3"></li>
            <li data-target="#inSlider" data-slide-to="4"></li>
            <li data-target="#inSlider" data-slide-to="5"></li>
            <li data-target="#inSlider" data-slide-to="6"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="ibox-content">
                            <canvas id="chart" class="d-block w-100"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="ibox-content">
                            <canvas id="charts" class="d-block w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="header-back one"></div>
            </div>
            <div class="carousel-item">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox-content">
                            <canvas id="dogh1" class="d-block w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="header-back two"></div>
            </div>
            <div class="carousel-item">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox-content">
                            <canvas id="linegOne" class="d-block w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="header-back three"></div>
            </div>
            <div class="carousel-item">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox-content">
                            <canvas id="linegTwo" class="d-block w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="header-back four"></div>
            </div>
            <div class="carousel-item">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox-content">
                            <canvas id="kontax" class="d-block w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="header-back five"></div>
            </div>
            <div class="carousel-item">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox-content">
                            <canvas id="followupx" class="d-block w-100"></canvas>
                        </div>
                    </div>
                </div>
                <div class="header-back six"></div>
            </div>
        </div>
    </div>
</div>
<a class="carousel-control-prev" href="#inSlider" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#inSlider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>
<script>
    $(document).ready(function() {
        var pieGraph;

        showChart();
        setInterval(showChart, 3000); // update chart every 3 seconds

        var pieGraps;

        tampilChart();
        setInterval(tampilChart, 3000);

        doghSatu();
        setInterval(doghSatu, 3000);
        
        lineSevenDays();
        setInterval(lineSevenDays, 3000);
        
        linePo7Days();
        setInterval(linePo7Days, 5000);
        
        konta7Days();
        setInterval(konta7Days, 5000);
        
        followups3Days();
        setInterval(followups3Days, 5000);

        function showChart() {
            $.ajax({
                url: "<?= base_url('dashboard/getdataGrafik'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var labels = [];
                    var values = [];

                    for (var i in data) {
                        labels.push(data[i].label);
                        values.push(data[i].value);
                    }

                    var chartdata = {
                        labels: labels,
                        datasets: [{
                            label: 'Kategori Followup',
                            data: values,
                            backgroundColor: [
                                'rgb(205, 92, 92, 1)',
                                'rgb(255, 165, 0, 0.8)',
                                'rgb(135, 206, 235, 0.8)',
                                'rgb(123, 104, 238, 0.8)',
                                '#00FA9A'
                            ] // set different colors for each pie
                        }],
                        borderWidth: 1
                    };

                    var chartOpt = {
                        maintainAspectRatio: false,
                        responsive: true,
                        width: 500,
                        height: 500,
                        legend: {
                            display: true,
                            position: 'left',
                            align: 'start',
                        },
                        plugins: {
                            tooltip: {
                                enabled: false
                            },
                            title: {
                                display: true,
                                text: 'Grafik per progress followup Bulan ini'
                            },
                            datalabels: {
                                align: 'center',
                                formatter: (value, context) => {
                                    // console.log(context);
                                    const datapoints = context.chart.data.datasets[0].data;
                                    const labels = context.chart.data.labels;

                                    const lable = labels.map((label, index) => {
                                        return label;
                                    });

                                    function totalSum(total, datapoint) {
                                        return parseInt(total) + parseInt(datapoint);
                                    }

                                    const totalValue = datapoints.reduce(totalSum, 0);
                                    const percentageValue = (value / totalValue * 100).toFixed(1);
                                    const display = [`${lable[context.dataIndex]}`, `${percentageValue}%`];
                                    return display;
                                },
                                color: '#000000',
                                font: {
                                    size: 14 // mengubah ukuran font
                                }
                            }
                        },
                    }

                    var ctx = $("#chart");
                    // const ctx = document.getElementById('chart').getContext('2d');

                    if (pieGraph) {
                        pieGraph.data.labels = chartdata.labels;
                        pieGraph.data.datasets[0].data = chartdata.datasets[0].data;
                        pieGraph.options = chartOpt;
                        pieGraph.update(); // update chart data
                    } else {
                        pieGraph = new Chart(ctx, {
                            type: 'pie',
                            data: chartdata,
                            options: chartOpt,
                            plugins: [ChartDataLabels]
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function tampilChart() {
            $.ajax({
                url: "<?= base_url('dashboard/perBagians'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var labels = [];
                    var values = [];

                    for (var i in data) {
                        labels.push(data[i].label);
                        values.push(data[i].value);
                    }

                    var chartdata = {
                        labels: labels,
                        datasets: [{
                            label: 'Kategori Devisi',
                            data: values,
                            backgroundColor: [
                                'rgb(205, 92, 92, 0.7)',
                                'rgb(255, 165, 0, 0.8)',
                                'rgb(135, 206, 235, 0.8)',
                                'rgb(123, 104, 238, 0.8)',
                                'rgb(255, 105, 180, 0.8)',
                                '#00FA9A'
                            ] // set different colors for each pie
                        }],
                        borderWidth: 1
                    };

                    var chartOpt = {
                        maintainAspectRatio: false,
                        responsive: true,
                        width: 500,
                        height: 500,
                        legend: {
                            labels: {
                                display: false,
                                position: 'left',
                                align: 'start'
                            }
                        },
                        plugins: {
                            tooltip: {
                                enabled: false
                            },
                            title: {
                                display: true,
                                text: 'Grafik jumlah followup perbagian bulan ini'
                            },
                            datalabels: {
                                align: 'right',
                                anchor: 'center',
                                formatter: (value, context) => {
                                    // console.log(context);
                                    const datapoints = context.chart.data.datasets[0].data;
                                    const labels = context.chart.data.labels;

                                    const lable = labels.map((label, index) => {
                                        return label;
                                    });

                                    function totalSum(total, datapoint) {
                                        return parseInt(total) + parseInt(datapoint);
                                    }

                                    const totalValue = datapoints.reduce(totalSum, 0);
                                    const percentageValue = (value / totalValue * 100).toFixed(1);
                                    const display = [`${lable[context.dataIndex]}`, `${percentageValue}%`];
                                    return display;
                                },
                                color: '#000000',
                                font: {
                                    size: 16 // mengubah ukuran font
                                }
                            }
                        },
                    }

                    var ctr = $("#charts");
                    // const ctx = document.getElementById('chart').getContext('2d');

                    if (pieGraps) {
                        pieGraps.data.labels = chartdata.labels;
                        pieGraps.data.datasets[0].data = chartdata.datasets[0].data;
                        pieGraps.options = chartOpt;
                        pieGraps.update(); // update chart data
                    } else {
                        pieGraps = new Chart(ctr, {
                            type: 'pie',
                            data: chartdata,
                            options: chartOpt,
                            plugins: [ChartDataLabels]
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function doghSatu() {
            $.ajax({
                url: "<?= base_url('dashboard/grafikPerSales') ?>",
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    // console.log(data);
                    var uname = [];
                    var orders = [];
                    var nonOrder = [];
                    var opens = [];

                    for (var i in data) {
                        uname.push(data[i].nama_user);
                        orders.push(data[i].persen_order);
                        nonOrder.push(data[i].persen_nonorder);
                        opens.push(data[i].persen_open);
                    }

                    var tcx = document.getElementById('dogh1').getContext('2d');
                    var existingChart = window.chart_dogh1;
                    if (existingChart) {
                        existingChart.destroy();
                    }
                    window.chart_dogh1 = new Chart(tcx, {
                        type: 'bar',
                        data: {
                          labels: uname,
                          datasets: [{
                            label: 'Close With PO',
                            data: orders,
                            backgroundColor: 'rgba(143, 188, 139, 0.7)'
                          }, {
                            label: 'Close without PO',
                            data: nonOrder,
                            backgroundColor: 'rgba(220, 20, 60, 0.7)'
                          }, {
                            label: 'On Progress',
                            data: opens,
                            backgroundColor: 'rgba(72, 209, 204, 0.7)'
                          }]
                        },
                        options: {
                          responsive: true,
                          plugins: {
                            title: {
                              display: true,
                              text: 'GRAFIK PERBANDINGAN FOLLOWUP DENGAN PO, TANPA PO DAN YANG MASIH OPEN (PER-BULAN)'
                            },
                            datalabels: {
                                align: 'center',
                                anchor: 'end',
                                formatter: (value, context) => {
                                    const nilai = value.toFixed(1);
                                    return [`${nilai}%`];
                                },
                                color: '#000000'
                            }
                          }
                        },
                        plugins: [ChartDataLabels] // add the ChartDataLabels plugin here

                    });
                }
            });
        }
        
        function lineSevenDays() {
            $.ajax({
                url: "<?= base_url('dashboard/perBagianSevenDays') ?>",
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    var chart_data = data;

                    var xtc = document.getElementById('linegOne').getContext('2d');
                    var existingChart = window.chart_linegOne;
                    if (existingChart) {
                        existingChart.destroy();
                    }
                    window.chart_linegOne = new Chart(xtc, {
                        type: 'line',
                        data: chart_data,
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Followup Per Bagian for the Past Seven Days'
                                },
                            }
                        }
                    });
                }
            });
        }
        
        function linePo7Days() {
            $.ajax({
                url: "<?= base_url('dashboard/perOrang7Days') ?>",
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    var chart_data = data;

                    var xtr = document.getElementById('linegTwo').getContext('2d');
                    var existingChart = window.chart_linegTwo;
                    if (existingChart) {
                        existingChart.destroy();
                    }
                    window.chart_linegTwo = new Chart(xtr, {
                        type: 'bar',
                        data: chart_data,
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'PO Per Bagian for the Past Seven Days'
                                },
                                datalabels: {
                                    align: 'center',
                                    anchor: 'center',
                                    color: '#333333',
                                    font: {
                                        weight: 'bold'
                                    },
                                    formatter: (value, context) => {
                                        const nilai = value;
                                        return [`${nilai} PO`];
                                    },
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }
            });
        }
        
        function konta7Days() {
            $.ajax({
                url: "<?= base_url('dashboard/chartsRadar') ?>",
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    var chart_data = data;

                    var gtr = document.getElementById('kontax').getContext('2d');
                    var existingChart = window.chart_kontax;
                    if (existingChart) {
                        existingChart.destroy();
                    }
                    window.chart_kontax = new Chart(gtr, {
                        type: 'bar',
                        data: chart_data,
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Qty Kontak/Orang for the Past 3 Days'
                                },
                                datalabels: {
                                    align: 'center',
                                    anchor: 'end',
                                    color: '#333333',
                                    font: {
                                        weight: 'bold'
                                    },
                                    formatter: (value, context) => {
                                        const nilai = value;
                                        // return [`${nilai} FU`];
                                    },
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }
            });
        }
        
        function followups3Days(){
            $.ajax({
                url: "<?= base_url('dashboard/followup3Days') ?>",
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    var chart_data = data;

                    var pod = document.getElementById('followupx').getContext('2d');
                    var existingChart = window.chart_followupx;
                    if (existingChart) {
                        existingChart.destroy();
                    }
                    window.chart_followupx = new Chart(pod, {
                        type: 'bar',
                        data: chart_data,
                        options: {
                            responsive: true,
                            plugins: {
                                title: {
                                    display: true,
                                    text: 'Qty Followup/ Orang for the Past 3 Days'
                                },
                                datalabels: {
                                    align: 'center',
                                    anchor: 'center',
                                    color: '#333333',
                                    font: {
                                        weight: 'bold'
                                    },
                                    formatter: (value, context) => {
                                        const datapoints = context.chart.data.datasets[context.datasetIndex].label;
                                        console.log(datapoints);
                                        // const label = context.chart.data.labels[context.dataIndex];
                                        return `${datapoints}`;
                                    },
                                }
                            },
                            legends: {
                                display: false,
                            }
                        },
                        plugins: [ChartDataLabels]
                    });
                }
            });
        }
    });
</script>