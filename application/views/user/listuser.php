<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <?= form_error('namauser', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('email', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('nohp', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('bagian', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('role', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= form_error('password', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <div class="ibox">
                <div class="ibox-title">
                    <h5>All User <span class="label label-info">Active</span></h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="toolbar">
                        <button class="btn btn-sm btn-secondary tambah" data-toggle="tooltip" title="Tambah User Baru"><i class="fa fa-plus-circle"></i> Tambah User</button>
                    </div>
                    <table id="tb_user" data-show-toggle="true" data-page-size="5"  data-show-columns="true" data-mobile-responsive="true" data-check-on-init="true" data-advanced-search="true" data-id-table="advancedTable" data-show-columns-toggle-all="true"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-up -->
<div class="modal fade" id="detailUser" tabindex="-1" aria-labelledby="detailUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h3 class="modal-title" id="detailUserLabel">Detail User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="userHtml">
                <!-- isi modal -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLable" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="addUserLable">Form Input User Baru</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user'); ?>" method="POST">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-7">
                            <label for="namauser">Nama User</label>
                            <input type="text" name="namauser" id="namauser" class="form-control" placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label for="email">E-Mail</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="account@yourdomain.com">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control role">
                                <option value="">Pilih</option>
                                <?php foreach ($rolex->result() as $role) : ?>
                                    <option value="<?= $role->role_id ?>"><?= $role->role; ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password1">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="password">
                                <div class="input-group-append">
                                    <span id="mybutton" onclick="change()" class="input-group-text">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password2">Ulangi Password</label>
                            <div class="input-group">
                                <input type="password" name="password2" id="password2" class="form-control" placeholder="Ulangi Password">
                                <div class="input-group-append">
                                    <span id="mybutton2" class="input-group-text cange">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="simpan" class="btn btn-primary simpan">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('[rel="tooltip"]').tooltip()
        });
        // click tambah button will direct you to add new BOM page
        $(".tambah").click(function() {
            $("#addUser").modal('show');

        });
    })
    $(document).ready(function() {
        var role = "<?= $user['role_id']; ?>";
        // console.log(role)
        $table = $("#tb_user");
        $table.bootstrapTable({
            url: '<?= base_url('user/dataUser') ?>',
            toolbar: '#toolbar',
            pagination: true,
            search: true,
            columns: [{
                field: 'no',
                title: '#'
            }, {
                field: 'nama',
                title: 'Nama User'
            },  {
                field: 'role',
                title: 'Role'
            }, {
                field: 'email',
                title: 'Kontak'
            }, {
                field: 'id',
                title: 'Aksi',
                formatter: function(value, row) {
                    if (role == '1') { //Jika role nya adalah IT Administrator
                        return [
                            '<button class="btn btn-info btn-xs lihat" data-code="' + value + '" rel="tooltip" title="Lihat data"><i class="fa fa-eye"></i></button> ' +
                            '<button class="btn btn-danger btn-xs nonactive" data-code="' + value + '" rel="tooltip" title="Non-Activekan user"><i class="fa fa-eraser"></i></button> ' +
                            '<button class="btn btn-success btn-xs edit" data-code="' + value + '" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'
                        ]
                    } else {
                        if (role == row.role_id) {
                            return [
                                '<button class="btn btn-info btn-xs lihat" data-code="' + value + '" rel="tooltip" title="Lihat data"><i class="fa fa-eye"></i></button> ' +
                            '<button class="btn btn-danger btn-xs nonactive" data-code="' + value + '" rel="tooltip" title="Non-Activekan user"><i class="fa fa-eraser"></i></button> ' +
                            '<button class="btn btn-success btn-xs edit" data-code="' + value + '" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'
                            ]
                        } else if (role == '2' && row.role_id == '3') {
                            return [
                                '<button class="btn btn-info btn-xs lihat" data-code="' + value + '" rel="tooltip" title="Lihat data"><i class="fa fa-eye"></i></button> ' +
                            '<button class="btn btn-danger btn-xs nonactive" data-code="' + value + '" rel="tooltip" title="Non-Activekan user"><i class="fa fa-eraser"></i></button> ' +
                            '<button class="btn btn-success btn-xs edit" data-code="' + value + '" rel="tooltip" title="Edit"><i class="fa fa-edit"></i></button>'
                            ]
                        } else {
                            return [
                                '<button class="btn btn-info btn-xs lihat" data-code="' + value + '" rel="tooltip" title="Lihat data"><i class="fa fa-eye"></i></button>'
                            ]
                        }
                    }
                }
            }]
        });

        $('body').on('click', '#tb_user .lihat', function() {
            var id = $(this).data('code');
            // alert(id)
            $.ajax({
                url: "<?= base_url('user/dtlUser'); ?>",
                method: 'POST',
                data: {
                    id: id
                },
                success: function(data) {
                    $("#detailUser").modal('show');
                    $("#userHtml").html(data);
                }
            })

        });

    });
</script>
<script>
    function change() {
        var x = document.getElementById('password').type;
        if (x == 'password') {
            document.getElementById('password').type = 'text';
            document.getElementById('mybutton').innerHTML = `<i class="fa fa-eye-slash"></i>`;
        } else {
            document.getElementById('password').type = 'password';
            document.getElementById('mybutton').innerHTML = `<i class="fa fa-eye"></i>`;
        }
    }

    $(".cange").click(() => {
        var x = document.getElementById('password2').type;
        if (x == 'password') {
            document.getElementById('password2').type = 'text';
            document.getElementById('mybutton2').innerHTML = `<i class="fa fa-eye-slash"></i>`;
        } else {
            document.getElementById('password2').type = 'password';
            document.getElementById('mybutton2').innerHTML = `<i class="fa fa-eye"></i>`;
        }
    })
</script>