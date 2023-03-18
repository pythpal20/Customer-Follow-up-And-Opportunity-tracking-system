<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>
<?php $dt = $this->db->get_where('user_role', ['role_id' => $user['role_id']])->row_array(); ?>
<input type="hidden" name="myname" id="myname" value="<?= $user['user_nama'] ?>">
<input type="hidden" name="myrole" id="myrole" value="<?= $user['role_id'] ?>">
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox animated fadeInRightBig">
                <div class="ibox-title">
                    <h5>Data customer follow-up</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="toolbar">
                        <button class="btn btn-secondary newCustomer" data-toggle="tooltip" title="Customer follow-up baru"><i class="fa fa-plus-circle"></i> Customer Follow-up</button>
                    </div>
                    <table id="tb_customer" data-toggle="tablemwk" data-show-toggle="true" data-show-refresh="true" data-show-columns="true" data-mobile-responsive="true" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-print="true" data-show-columns-toggle-all="true"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal fade" id="modalFollowup" tabindex="-1" aria-labelledby="modalFollowupLable" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFollowupLable">Detail Follow-up</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalFollowupData">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->
<!-- script -->
<script>
    $(function() {
        $(".newCustomer").click(() => {
            window.location.href = "<?= base_url('followup/newCustomerFu'); ?>";
        });
    });
    $(document).ready(function() {
        var myrole = $("#myrole").val();
        $table = $('#tb_customer')
        $table.bootstrapTable({
            url: "<?= base_url('followup/getmyCustomer') ?>",
            pagination: true,
            search: true,
            toolbar: '#toolbar',
            rowStyle: rowStyle,
            columns: [{
                field: 'date',
                title: 'Tanggal',
                sortable: true
            }, {
                field: 'name',
                title: 'Nama Customer',
                class: 'project-title',
                sortable: true
            }, {
                field : 'bar',
                title: 'Progres',
                align: 'center',
                class: 'project-completion'
            }, {
                field: 'add_by',
                title: 'FU By',
                formatter: function(value){
                    return [
                        value.split(" ")[0]
                    ]
                }
            }, {
                field: 'is_open',
                title: 'Status',
                align: 'center',
                formatter: function(value) {
                    if (value == 0) {
                        return [
                            '<span class="label label-warning">Closed</span>'
                        ]
                    } else {
                        return [
                            '<span class="label label-info">Open</span>'
                        ]
                    }
                }
            }, {
                field: 'id',
                title: 'Aksi',
                align: 'center',
                formatter: ombol,
                class: 'project-actions'
            }, {
                field: 'add_by',
                title: 'Follow-up By',
                visible: false
            }, {
                field: 'f_status',
                title: 'f_status',
                visible: false
            }]
        });

        function rowStyle(row, index) {
            // Jika tanggal di kolom "followup_date" sama dengan tanggal hari ini, kembalikan objek yang mengatur warna latar belakang menjadi merah
            if (row.is_open === '0' && row.bars === "100%") {
                return {
                    classes: 'table-info'
                };
            } else if(row.is_open === '0' && row.bars != "100%"){
                return {
                    classes: 'table-danger'
                };
            } else if(row.is_open === '1' && row.bars === "80%") {
                return {
                    classes: 'table-warning'
                };
            } else {
                return {
                    classes: ''
                };
            }
        }

        function ombol(value, row) {
            if (myrole != 1) {
                if (row.is_open == 0) {
                    return [
                        '<button title="Lihat detail" class="btn btn-xs btn-info view" data-id="' + value + '" data-toggle="tooltip"><span class="fa fa-eye"></span></button> ' +
                        '<button title="Followup this customer" class="btn btn-xs btn-success followups" disabled data-toggle="tooltip"><span class="fa fa-thumbs-up"></span></button>'
                    ]
                } else {
                    return [
                        '<button title="Lihat detail" class="btn btn-xs btn-info view" data-id="' + value + '" data-toggle="tooltip"><span class="fa fa-eye"></span></button> ' +
                        '<button title="Followup this customer" class="btn btn-xs btn-success followups" data-id="' + value + '" data-toggle="tooltip"><span class="fa fa-thumbs-up"></span></button>'
                    ]
                }

            } else {
                return [
                    '<button class="btn btn-xs btn-info view" data-id="' + value + '"><span class="fa fa-eye"></span></button>'
                ]
            }
        }

        $('body').on('click', '#tb_customer .view', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('followup/viewDetail'); ?>",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#modalFollowup').modal('show');
                    $("#modalFollowupData").html(data);
                }
            })
        });
        $('body').on('click', '#tb_customer .followups', function() {
            let str = $(this).data('id');

            var key = "sifupass"; // Kunci enkripsi acak, dapat diganti dengan kunci lain
            var encryptedData = encryptData(str, key);
            window.location.href = "<?= base_url('followup/newFollowup/'); ?>" + encryptedData;
        });

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

    });
</script>