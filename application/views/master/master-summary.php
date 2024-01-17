<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-8">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Monthly</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Daily <small>Default : Today</small></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="ibox animated bounceInUp">
                                <div class="ibox-title">
                                    <h5>Summary Follow-up <?= date('Y') ?></h5>
                                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                        <button class="btn btn-sm btn-white " name="options" id="lastmonth" autocomplete="off"> Last Month</button>
                                        <button class="btn btn-sm btn-white active" name="options" id="thismonth" autocomplete="off"> This Month</button>
                                        <button class="btn btn-sm btn-white" id="thisyear" autocomplete="off"> This Year</button>
                                    </div>
                                </div>
                                <div class="ibox-content">
                                    <div id="tbl_lastmonth">
                                        <table id="tb_lsum" class="table table-bordered" data-auto-refresh="true" data-show-export="true" data-sort-name="totals" data-sort-order="desc">
                                        </table>
                                    </div>
                                    <div id="tbl_thismonth">
                                        <table id="tb_sum" class="table table-bordered" data-auto-refresh="true" data-show-export="true" data-sort-name="totals" data-sort-order="desc">
                                        </table>
                                    </div>
                                    <div id="tbl_thisyear">
                                        <table id="tb_ysum" class="table table-bordered" data-auto-refresh="true" data-show-export="true" data-sort-name="totals" data-sort-order="desc">
                                        </table>
                                    </div>
                                </div>
                                <div class="ibox-footer">
                                    <ul>
                                        <li><small class="text-danger">Keberhasilan Followup 30% kebawah</small></li>
                                        <li><small class="text-warning">Keberhasilan Followup diatas 30% dan dibawah 50%</small></li>
                                        <li><small class="text-success">Keberhasilan Followup 50% keatas</small></li>
                                    </ul>
                                    <small>
                                        Persentase = (Jumlah Order/Total Followup)*100%
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="ibox animated bounceInUp" id="ibox-day">
                                <div class="ibox-title">
                                    <h5>Daily Followup</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="sk-spinner sk-spinner-double-bounce">
                                        <div class="sk-double-bounce1"></div>
                                        <div class="sk-double-bounce2"></div>
                                    </div>
                                    <div id="toolbar">
                                        <div class="input-group">
                                            <input type="date" class="form-control" name="dytgl" id="dytgl">
                                            <span class="input-group-append">
                                                <button type="button" id="cari" class="btn btn-primary">Go!</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="tbl_today">
                                        <table id="tb_sumdy" class="table table-bordered" data-auto-refresh="true" data-show-export="true" data-sort-name="totals" data-sort-order="desc"></table>
                                    </div>
                                    <div id="tbl_sday">
                                        <table id="tb_sday" class="table table-bordered" data-auto-refresh="true" data-show-export="true" data-sort-name="totals" data-sort-order="desc"></table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4" id="colAjax">
            <div class="ibox bounceInUp">
                <div class="ibox-title">
                    <h5>Detail Follow-up hari ini</h5>
                </div>
                <div class="ibox-content">
                    <div id="kontenAjax"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tbl_lastmonth').hide();
        $('#tbl_thismonth').show();
        $('#tbl_thisyear').hide();

        $("#lastmonth").click(() => {
            $('#tbl_lastmonth').show({
                duration: 300,
            });
            $('#tbl_thismonth').hide({
                duration: 300,
            });
            $('#tbl_thisyear').hide({
                duration: 300,
            });
        });

        $("#thismonth").click(() => {
            $('#tbl_lastmonth').hide({
                duration: 300,
            });
            $('#tbl_thismonth').show({
                duration: 300,
            });
            $('#tbl_thisyear').hide({
                duration: 300,
            });
        });

        $("#thisyear").click(() => {
            $('#tbl_lastmonth').hide({
                duration: 300,
            });
            $('#tbl_thismonth').hide({
                duration: 300,
            });
            $('#tbl_thisyear').show({
                duration: 300,
            });
        });
    });
    $(function() {
        $("#colAjax").hide();
        $table = $("#tb_sum")
        $table.bootstrapTable({
            url: "<?= base_url('master/getsummaryFollowup/thismonth') ?>",
            search: true,
            pagination: true,
            rowStyle: rowStyle,
            columns: [{
                field: 'user',
                title: 'User',
                sortable: true
            }, {
                field: 'totals',
                title: 'Total',
                sortable: true
            }, {
                field: 'user',
                title: 'cari_user',
                visible: false
            }, {
                field: 'kontak',
                title: 'Kontak',
            }, {
                field: 'followup',
                title: 'FU',
                sortable: true,
            }, {
                field: 'penawaran',
                title: 'Pnwrn',
                sortable: true,
            }, {
                field: 'followup_penawaran',
                title: 'F.Pnwrn',
                sortable: true,
            }, {
                field: 'order',
                title: 'Order',
                sortable: true,
            }, {
                field: 'user',
                title: 'Act.',
                align: 'center',
                formatter: detailToday
            }]
        });

        function rowStyle(row, index) {
            var a = row.order;
            var total = (parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order));
            var percen = (parseInt(a) / parseInt(total)) * 100;
            if (percen <= 30) {
                return {
                    classes: 'table-danger'
                };
            } else if (percen > 30 && percen < 50) {
                return {
                    classes: 'table-warning'
                };
            } else if (percen >= 50) {
                return {
                    classes: 'table-success'
                };
            }
        }

        function totalfu(value, row) {
            return [
                parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order)
            ]
        }

        function detailToday(value, row) {
            return [
                '<span class="btn btn-xs btn-info lihatDetail" data-id="' + value + '"><i class="fa fa-eye"></i></span>'
            ]
        }

        $('body').on('click', '#tb_sum .lihatDetail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('master/dataSumCustomer') ?>",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#colAjax").show({
                        duration: 750,
                    });
                    $("#kontenAjax").html(data);
                    $(".tbs").bootstrapTable();
                }
            });
        });
    });
    $(function() {
        $table = $("#tb_lsum")
        $table.bootstrapTable({
            url: "<?= base_url('master/getsummaryFollowup/lastmonth') ?>",
            search: true,
            pagination: true,
            rowStyle: rowStyle,
            toolbar: '#toolbar',
            columns: [{
                field: 'user',
                title: 'User',
                sortable: true
            }, {
                field: 'totals',
                title: 'Total',
                sortable: true
            }, {
                field: 'user',
                title: 'cari_user',
                visible: false
            }, {
                field: 'kontak',
                title: 'Kontak',
            }, {
                field: 'followup',
                title: 'FU',
                sortable: true,
            }, {
                field: 'penawaran',
                title: 'Pnwrn',
                sortable: true,
            }, {
                field: 'followup_penawaran',
                title: 'F.Pnwrn',
                sortable: true,
            }, {
                field: 'order',
                title: 'Order',
                sortable: true,
            }, {
                field: 'user',
                title: 'Act.',
                align: 'center',
                formatter: detailToday
            }]
        });

        function rowStyle(row, index) {
            var a = row.order;
            var total = (parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order));
            var percen = (parseInt(a) / parseInt(total)) * 100;
            if (percen <= 30) {
                return {
                    classes: 'table-danger'
                };
            } else if (percen > 30 && percen < 50) {
                return {
                    classes: 'table-warning'
                };
            } else if (percen >= 50) {
                return {
                    classes: 'table-success'
                };
            }
        }

        function totalfu(value, row) {
            return [
                parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order)
            ]
        }

        function detailToday(value, row) {
            return [
                '<span class="btn btn-xs btn-info lihatDetail" data-id="' + value + '"><i class="fa fa-eye"></i></span>'
            ]
        }

        $('body').on('click', '#tb_lsum .lihatDetail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('master/dataSumCustomer') ?>",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#colAjax").show({
                        duration: 750,
                    });
                    $("#kontenAjax").html(data);
                    $(".tbs").bootstrapTable();
                }
            });
        });
    });
    $(function() {
        $table = $("#tb_ysum")
        $table.bootstrapTable({
            url: "<?= base_url('master/getsummaryFollowup/thisyear') ?>",
            search: true,
            pagination: true,
            rowStyle: rowStyle,
            toolbar: '#toolbar',
            columns: [{
                field: 'user',
                title: 'User',
                sortable: true
            }, {
                field: 'totals',
                title: 'Total',
                sortable: true
            }, {
                field: 'user',
                title: 'cari_user',
                visible: false
            }, {
                field: 'kontak',
                title: 'Kontak',
            }, {
                field: 'followup',
                title: 'FU',
                sortable: true,
            }, {
                field: 'penawaran',
                title: 'Pnwrn',
                sortable: true,
            }, {
                field: 'followup_penawaran',
                title: 'F.Pnwrn',
                sortable: true,
            }, {
                field: 'order',
                title: 'Order',
                sortable: true,
            }, {
                field: 'user',
                title: 'Act.',
                align: 'center',
                formatter: detailToday
            }]
        });

        function rowStyle(row, index) {
            var a = row.order;
            var total = (parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order));
            var percen = (parseInt(a) / parseInt(total)) * 100;
            if (percen <= 30) {
                return {
                    classes: 'table-danger'
                };
            } else if (percen > 30 && percen < 50) {
                return {
                    classes: 'table-warning'
                };
            } else if (percen >= 50) {
                return {
                    classes: 'table-success'
                };
            }
        }

        function totalfu(value, row) {
            return [
                parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order)
            ]
        }

        function detailToday(value, row) {
            return [
                '<span class="btn btn-xs btn-info lihatDetail" data-id="' + value + '"><i class="fa fa-eye"></i></span>'
            ]
        }

        $('body').on('click', '#tb_ysum .lihatDetail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('master/dataSumCustomer') ?>",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#colAjax").show({
                        duration: 750,
                    });
                    $("#kontenAjax").html(data);
                    $(".tbs").bootstrapTable();
                }
            });
        });
    });

    $(function() {
        $table = $("#tb_sumdy")
        $table.bootstrapTable({
            url: "<?= base_url('master/sumTodays') ?>",
            search: true,
            pagination: true,
            toolbar: '#toolbar',
            columns: [{
                field: 'user',
                title: 'User',
                sortable: true
            }, {
                field: 'totals',
                title: 'Total',
                sortable: true
            }, {
                field: 'user',
                title: 'cari_user',
                visible: false
            }, {
                field: 'kontak',
                title: 'Kontak',
            }, {
                field: 'followup',
                title: 'FU',
                sortable: true,
            }, {
                field: 'penawaran',
                title: 'Pnwrn',
                sortable: true,
            }, {
                field: 'followup_penawaran',
                title: 'F.Pnwrn',
                sortable: true,
            }, {
                field: 'order',
                title: 'Order',
                sortable: true,
            }]
        });
    });


    $(document).ready(function() {
        $("#tbl_sday").hide();
        $("#cari").click(function() {
            var tgl = $("#dytgl").val();
            $.ajax({
                url: "<?= base_url('master/getDataDay') ?>",
                method: 'POST',
                data: {
                    tgl: tgl
                },
                beforeSend: function() {
                    $("#ibox-day").children('.ibox-content').toggleClass('sk-loading');
                },
                success: function(data) {
                    $("#tb_sday").bootstrapTable('destroy');
                    $("#tbl_sday").show({
                        duration: 750,
                    });
                    $("#tbl_today").hide({
                        duration: 750,
                    });
                    var obj = JSON.parse(data);
                    // $("#tb_sday").html(data);
                    $("#tb_sday").bootstrapTable({
                        search: true,
                        pagination: true,
                        rowStyle: rowStyle,
                        toolbar: '#toolbar',
                        data: obj,
                        columns: [{
                            field: 'user',
                            title: 'User',
                            sortable: true
                        }, {
                            field: 'totals',
                            title: 'Total',
                            sortable: true
                        }, {
                            field: 'user',
                            title: 'cari_user',
                            visible: false
                        }, {
                            field: 'kontak',
                            title: 'Kontak',
                        }, {
                            field: 'followup',
                            title: 'FU',
                            sortable: true,
                        }, {
                            field: 'penawaran',
                            title: 'Pnwrn',
                            sortable: true,
                        }, {
                            field: 'followup_penawaran',
                            title: 'F.Pnwrn',
                            sortable: true,
                        }, {
                            field: 'order',
                            title: 'Order',
                            sortable: true,
                        }]
                    });
                    
                    function rowStyle(row, index) {
                        var a = row.order;
                        var total = (parseInt(row.kontak) + parseInt(row.followup) + parseInt(row.penawaran) + parseInt(row.followup_penawaran) + parseInt(row.order));
                        var percen = (parseInt(a) / parseInt(total)) * 100;
                        if (percen <= 30) {
                            return {
                                classes: 'table-danger'
                            };
                        } else if (percen > 30 && percen < 50) {
                            return {
                                classes: 'table-warning'
                            };
                        } else if (percen >= 50) {
                            return {
                                classes: 'table-success'
                            };
                        }
                    }
                },
                complete: function() {
                    $("#ibox-day").children('.ibox-content').removeClass('sk-loading');
                }
            });
        });
    });
</script>