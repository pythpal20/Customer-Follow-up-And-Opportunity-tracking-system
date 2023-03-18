<style>
    #toolbar {
        margin: 0;
    }

    #toolbar2 {
        margin: 0;
    }
</style>
<!-- Modal -->
<div class="modal inmodal" id="insert" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-body">
                <label>Menyimpan Data . . . <small>Silahkan tunggu sampai proses selesai</small></label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated progress-bar-info" style="width: 100%" role="progressbar" aria-valuenow="100%" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- new menu -->
<div class="modal fade"  id="newMenu" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuLabel">Add Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormMenu">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nama Menu <small>(Isi nama menu akan jadi controller, jangan pakai spasi)</small></label>
                        <input type="text" class="form-control" name="namaMenu" id="namaMenu" placeholder="Isi nama menu">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary sippan" data-dismiss="modal">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- edit menu -->
<div class="modal fade"  id="editMenu" tabindex="-1" aria-labelledby="editMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormeditMenu">
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <label for="formGroupExampleInput">Nama Menu <small>(Isi nama menu akan jadi controller, jangan pakai spasi)</small></label>
                        <input type="text" class="form-control" name="xnamaMenu" id="xnamaMenu" placeholder="Isi nama menu">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary gattimai" data-dismiss="modal">Ubah</button>
            </div>
        </div>
    </div>
</div>
<!-- modal sub menu -->
<div class="modal fade" data-backdrop="static" data-keyboard="false" id="newsubMenu" tabindex="-1" aria-labelledby="newsubMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsubMenuLabel">Add Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="FormsubMenu">
                    <div class="form-group">
                        <label for="formGroupExampleInput">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Isi nama sub menu">
                        <input type="hidden" name="nuser" id="nuser" value="<?= $user['user_nama'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="menu">Pilih Root Menu</label>
                        <select name="menu_root" id="menu_root" class="form-control menu_roots">
                            <option value=""></option>
                            <?php foreach ($menux as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="urls">Url</label>
                        <input type="text" class="form-control" name="urls" id="urls" placeholder="Isi urls">
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" class="form-control" name="icon" id="icon" placeholder="exp: fas fa-fw fa-check">
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="isactive" name="isactive" value="1" checked>
                        <label class="form-check-label" for="isactive">Aktifkan Menu ini ?</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary pamasuk">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-4">
            <?= $this->session->flashdata('message'); ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>User menu</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="toolbar">
                        <button class="btn btn-secondary tambah_a" data-toggle="tooltip" rel="tooltip" title="Tambah user menu"><i class="fa fa-plus"></i> Menu</button>
                    </div>
                    <table class="table table-hover" id="table_a" data-show-toggle="true" data-page-size="5" data-show-pagination-switch="true" data-show-columns="true" data-mobile-responsive="true" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-columns-toggle-all="true"></table>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Sub menu</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="toolbar2">
                        <button class="btn btn-secondary tambah_b" data-toggle="tooltip" rel="tooltip" title="Tambah user menu"><i class="fa fa-plus"></i> Sub Menu</button>
                    </div>
                    <table id="table_b" class="table table-hover" data-show-toggle="true" data-show-pagination-switch="true" data-page-size="5" data-show-columns="true" data-mobile-responsive="true" data-advanced-search="true" data-id-table="advancedTable" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-columns-toggle-all="true"></table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
    script
 -->
<script>
    $(document).ready(function() {
        $(".tambah_a").click(() => {
            $("#newMenu").modal("show");
            $(".sippan").click(function() {
                var form = $("#FormMenu").serializeArray();
                var namaMenu = $("#namaMenu").val();
                if (namaMenu == '') {
                    swal.fire(
                        'Tidak Bisa',
                        'Field Tidak Bisa Kosong',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: '<?= base_url("administrator/simpanMenu"); ?>',
                        method: 'POST',
                        data: form,
                        success: function(data) {
                            swal.fire({
                                title: 'Data disimpan',
                                text: 'Menu Baru ditambahkan',
                                icon: 'success',
                                allowOutsideClick: false,
                                showCancelButton: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.assign("<?= base_url('administrator') ?>");
                                }
                            });
                        },
                        error: function() {
                            alert('Error tidak terdefenisi');
                        }
                    });
                }
            });
        });

        $(".tambah_b").click(() => {
            $("#newsubMenu").modal("show");
            // $("#menu_root").select2({
            //     placeholder: "~ Pilih Menu Roots ~",
            //     dropdownAutoWidth: 'true',
            //     width: '460',
            //     allowClear: 'true'
            // });
            $(".pamasuk").click(() => {
                var forms = $("#FormsubMenu").serializeArray();
                var title = $("#title").val();
                var menu_root = $("#menu_root").val();
                var icon = $("#icon").val();
                var urls = $("#urls").val();
                if (title == '' || menu_root == '' || icon == '' || urls == '') {
                    swal.fire(
                        'Error',
                        'Form harus terisi semua, ulangi!',
                        'warning'
                    );
                    $("#newsubMenu").modal("hide");
                } else {
                    $("#newsubMenu").modal("hide");
                    $.ajax({
                        url: "<?= base_url('administrator/simpansubMenu'); ?>",
                        method: 'POST',
                        data: forms,
                        success: function(data) {
                            console.log(data);
                            swal.fire({
                                title: 'Data disimpan',
                                text: 'Menu Baru ditambahkan',
                                icon: 'success',
                                allowOutsideClick: false,
                                showCancelButton: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.assign("<?= base_url('administrator') ?>");
                                }
                            });
                        },
                        error: function() {
                            alert('Error tidak terdefenisi');
                        }
                    });
                }
            });
        });
    });
    $(document).ready(function() {
        $table = $("#table_a")
        $table.bootstrapTable({
            url: '<?= base_url('administrator/user_menu') ?>',
            toolbar: '#toolbar',
            pagination: true,
            search: false,
            columns: [{
                field: 'no',
                title: '#'
            }, {
                field: 'menu',
                title: 'Nama Menu',
                sortable: 'true'
            }, {
                field: 'id',
                title: 'Act',
                align: 'center',
                formatter: tombol
            }]
        });

        function tombol(value, row) {
            return [
                '<button class="btn btn-primary btn-xs edit_a" id-menu ="' + value + '" data-nama="' + row.menu + '"><span class="fa fa-edit"></span></button> ' +
                '<button class="btn btn-xs btn-danger nonaktif_a" data-menu="' + value + '"><span class="fa fa-trash"></span></button>'
            ]
        }
        $('body').on('click', '#table_a .edit_a', function() {
            var id = $(this).attr('id-menu');
            var nama = $(this).data('nama');
            $("#editMenu").modal('show');
            $("#xnamaMenu").val(nama);
            $("#id").val(id);

            $(".gattimai").click(() => {
                var newForm = $("#FormeditMenu").serializeArray();
                var xnamaMenu = $("#xnamaMenu").val();
                if (xnamaMenu == '') {
                    swal.fire(
                        'Galat',
                        'Nama menu belum diisi',
                        'warning'
                    );
                } else {
                    swal.fire({
                        title: 'Yakin ubah nama menu ?',
                        imageUrl: "<?= base_url('assets') ?>/img/icon/question.svg",
                        imageHeight: 150,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Ubah'
                    }).then((resl) => {
                        if (resl.isConfirmed) {
                            $.ajax({
                                url: "<?= base_url('administrator/ubahMenu') ?>",
                                method: 'post',
                                data: newForm,
                                success: function() {
                                    document.location.href = "<?= base_url('administrator'); ?>";
                                }
                            });
                        }
                    });
                }
            });
        });
        $('body').on('click', '#table_a .nonaktif_a', function() {
            var id = $(this).data('menu');
            swal.fire({
                title: 'Yakin hapus ?',
                text: 'Anda tidak akan dapat melihat menu dan submenu yang terikat pada menu ini lagi',
                imageUrl: "<?= base_url('assets/img/icon/') ?>question.svg",
                imageHeight: 150,
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Tidak, Batalkan'
            }).then((rsl) => {
                if (rsl.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('administrator/hapusMenu') ?>",
                        method: 'post',
                        data: {
                            id: id
                        },
                        success: function() {
                            document.location.href = "<?= base_url('administrator'); ?>";
                        }
                    });
                }
            });
        });
    });
    $(document).ready(() => {
        $table_b = $("#table_b")
        $table_b.bootstrapTable({
            url: '<?= base_url('administrator/user_submenu') ?>',
            toolbar: '#toolbar2',
            pagination: true,
            search: true,
            columns: [{
                field: 'no',
                title: '#'
            }, {
                field: 'title',
                title: 'Title',
                sortable: 'true'
            }, {
                field: 'menu',
                title: 'Menu',
                sortable: 'true'
            }, {
                field: 'url',
                title: 'Url',
                sortable: 'true'
            }, {
                field: 'icon',
                title: 'Icon',
                formatter: icon_b
            }, {
                field: 'active',
                title: 'Status',
                sortabel: 'true',
                formatter: status_b
            }, {
                field: 'id',
                title: 'Act',
                align: 'center',
                formatter: tombol_b
            }]
        });

        function status_b(value, row) {
            if (value == '0') {
                return [
                    'Non-aktif'
                ]
            } else {
                return [
                    'Aktif'
                ]
            }
        }

        function icon_b(value) {
            return [
                '<span class="' + value + '"></span>'
            ]
        }

        function tombol_b(value, row) {
            if (row.active == '1') {
                return [
                    '<button class="btn btn-xs btn-warning matikan" id-sub="' + value + '" rel="tooltip" title="Non aktifkan Sub-menu"><span class="fa fa-eraser"></span></button>'
                ]
            } else {
                return [
                    '<button class="btn btn-xs btn-success hidupkan" id-sub="' + value + '" rel="tooltip" title="Aktifkan Sub-menu"><span class="fa fa-check"></span></button>'
                ]
            }
        }
    });
    $(document).ajaxStart(function() {
        $("#insert").modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        });
    }).ajaxStop(function() {
        $("#insert").modal('hide');
    });
</script>