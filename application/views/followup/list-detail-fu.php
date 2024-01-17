<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="ibox animated fadeInRightBig">
        <div class="ibox-title">
            <h5>List Hasil Followup</h5>
            <div class="ibox-tools">
                <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <table id="tb_DetailCustomer" data-show-toggle="true" data-show-refresh="true" data-show-columns="true" data-mobile-responsive="true" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-print="true" data-show-columns-toggle-all="true"></table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $table = $('#tb_DetailCustomer')
        $table.bootstrapTable({
            url: "<?= base_url('followup/getDetailCustomer') ?>",
            pagination: true,
            search: true,
            rowStyle: rowStyle,
            filterControl: true,
            columns: [{
                field: 'no',
                title: 'No.'
            }, {
                field: 'customer_name',
                title: 'Nama Customer',
                sortable: true
            }, {
                field: 'comment',
                title: 'Status Followup',
                formatter: function(value) {

                    if (value == 0) {
                        return [
                            'Kontak'
                        ]
                    } else if (value == 1) {
                        return [
                            'Followup'
                        ]
                    } else if (value == 2) {
                        return [
                            'Penawaran'
                        ]
                    } else if (value == 3) {
                        return [
                            'Followup Penawaran'
                        ]
                    } else if (value == 4) {
                        return [
                            'PO'
                        ]
                    }
                }
            }, {
                field: 'add_by',
                title: 'Sales',
                filterControl: 'select'
            }, {
                field: 'followup_date',
                title: 'Tanggal FU',
                sorabtle: true
            }, {
                field: 'due_date',
                title: 'Due Date FU',
                sortable: true,
                formatter: dateFormatter
            }, {
                field: 'methode',
                title: 'FU. Methode',
                sortable: true,
                filterControl: 'select'
            }, {
                field: 'followup_id',
                title: 'ID Followup',
                visible: false
            }, {
                field: 'is_open',
                title: 'Opportunity',
                formatter: function(value) {
                    if (value == 0) {
                        return [
                            '<span class="label label-warning">Close</span>'
                        ]
                    } else if (value == 1) {
                        return [
                            '<span class="label label-info">Open</span>'
                        ]
                    }
                },
                align: 'center'
            }]
        });

        function dateFormatter(value, row, index) {
            // Ambil tanggal hari ini
            var today = new Date().toISOString().slice(0, 10);
            // Jika tanggal di kolom "followup_date" sama dengan tanggal hari ini, kembalikan TD dengan warna merah
            if (value.slice(0, 10) === today) {
                return '<div style="color: red;">' + value + '</div>';
            } else {
                return value;
            }
        }

        function rowStyle(row, index) {
            // Ambil tanggal hari ini
            var today = new Date().toISOString().slice(0, 10);
            // Jika tanggal di kolom "followup_date" sama dengan tanggal hari ini, kembalikan objek yang mengatur warna latar belakang menjadi merah
            if ((row.due_date.slice(0, 10) <= today) && (row.is_open == '1')) {
                return {
                    classes: 'table-danger'
                };
            }else if ((row.due_date.slice(0, 10) === today) && (row.is_open == '1')) {
                return {
                    classes: 'table-warning'
                };
            } else {
                return {};
            }
        }
    });
</script>