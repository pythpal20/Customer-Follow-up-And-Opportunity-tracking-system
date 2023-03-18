<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
        <?= $this->session->flashdata('message'); ?>
        <?= form_error('name', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
        <?= form_error('code', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <div class="ibox-content animated fadeInRightBig" id="V_TABLE">
                <div id="toolbar">
                    <button class="btn btn-secondary addNew" data-toggle="tooltip" title="New Category"><span class="fa fa-plus-circle"></span> Category</button>
                </div>
                <table class="table bg-white" id="tb_category" data-show-toggle="true" data-page-size="5" data-mobile-responsive="true" >
                </table>
            </div>
            <div class="ibox animated bounceInUp" id="V_FORM">
                <div class="ibox-title">
                    Form Kategori Baru
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="tutup">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="<?= base_url('followup/cstCategory') ?>" method="POST">
                        <div class="form-row">
                            <div class="form-group col-sm-4">
                                <label for="">Nama Kategori</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nama kategori" value="<?= set_value('name') ?>">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="">Kode <sup class="text-info">(3 Karakter)</sup></label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="contoh : CWA" value="<?= set_value('code') ?>">
                            </div>
                            <div class="form-group col-sm-4">
                                <label for=""></label>
                                <button type="submit" class="btn btn-block btn-primary mt-2"><span class="fa fa-send"></span> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="ibox-footer">
                    <small class="text-info text-twiter">Field wajib diisi semua</small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- javaScript -->
<script>
    $(document).ready(function() {
        $("#V_FORM").hide();

        $(".tutup").click(function() {
            $("#V_TABLE").show({
                duration: 750,
            });
            $("#V_FORM").hide({
                duration: 750,
            });
        });
        $(".addNew").click(function() {
            $("#V_FORM").show({
                duration: 750,
            });
            $("#V_TABLE").hide({
                duration: 750,
            })
        });
    });
    $(document).ready(function() {
        $table = $("#tb_category")
        $table.bootstrapTable({
            url: "<?= base_url('followup/getCategory') ?>",
            search: true,
            pagination: true,
            toolbar: '#toolbar',
            columns: [{
                field: 'name',
                title: 'Nama Kategori',
                sortable: 'true'
            }, {
                field: 'kode',
                title: 'Kode Kategori',
                sortable: 'true'
            }, {
                field: 'bagian',
                title: 'Bagian',
                formatter: function(value, row) {
                    switch(value) {
                        case '1':
                            return 'IT ADMINISTRATOR';
                        case '3':
                            return 'Telemarketing 75';
                        case '4':
                            return 'Telemarketing 118';
                        case '5':
                            return 'E-Commerce';
                        case '6':
                            return 'Website';
                        case '8':
                            return 'Showroom';
                        default:
                            return '';
                    }
                }
            }]
        })
    });
</script>