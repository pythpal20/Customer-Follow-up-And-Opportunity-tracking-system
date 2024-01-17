<?php
    function judulBox($id)
    {
        if($id == '1') {
            $list = "Harga terlalu mahal";
        } elseif($id == '2') {
            $list = "Customer belum ada kebutuhan";
        } elseif($id == '3') {
            $list = "Salah sambung";
        } elseif($id == '4') {
            $list = "Tidak ada Respon";
        } elseif($id == '5') {
            $list = "Perlu visit ke customer";
        } elseif($id == '6') {
            $list = "Kendala metode bayar";
        } elseif($id == '7') {
            $list = "Barang yang diminta tidak tersedia";
        } elseif($id == '8') {
            $list = "Waktu pengadaan barang terlalu lama";
        } elseif($id == '9') {
            $list = "Toko sudah tutup";
        } elseif($id == '10') {
            $list = "Customer jadi belanja ke showroom";
        }
        
        return $list;
    }
    
    $key = "sifupass";
    $decryptedData = encrypt_data($type, $key);
?>
<input type="hidden" id="types" value="<?= $decryptedData; ?>">
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>
<style>
    .note-customer {
        font-size: 10px;
    }
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox animated fadeInRightBig">
                <div class="ibox-title">
                    <h5>Data <?= judulBox($type); ?></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="toolbar">
                    </div>
                    <table id="tb_close" 
                    data-toggle="tablemwk" 
                    data-auto-refresh="true" 
                    data-show-toggle="true" 
                    data-filter-control="true" 
                    data-show-refresh="true" 
                    data-show-columns="true" 
                    data-mobile-responsive="true" 
                    data-check-on-init="true" 
                    data-advanced-search="true" 
                    data-id-table="advancedTable" 
                    data-show-print="true" 
                    data-show-columns-toggle-all="true" 
                    data-pagination-pre-text="Previous"
                    data-pagination-next-text="Next"
                    data-show-pagination-switch="true"
                    data-buttons-align="left"
                    data-buttons-class="danger"
                    data-show-export="true"
                    data-show-search-clear-button="true"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $table = $("#tb_close")
        $table.bootstrapTable({
            url: "<?= base_url('master/dataclose/') ?>" + $("#types").val(),
            search: true,
            pagination: true,
            columns: [{
                field: 'tgl',
                title : 'Tanggal',
                width: 100,
                filterControl: 'input',
                sortable: true
            }, {
                field: 'nama',
                title: 'Nama Customer',
                filterControl: 'input'
            }, {
                field: 'bar',
                title: 'Progres terahir',
                width: 150
            }, {
                field: 'orang',
                title: 'User',
                width: 140,
                filterControl: 'input'
            }, {
                field: 'formatx',
                title: 'Bagian',
                filterControl: 'select',
                sortable: true
            }, {
                field: 'notes',
                title: 'Keterangan',
                class: 'note-customer'
            }]
        })
    })
</script>