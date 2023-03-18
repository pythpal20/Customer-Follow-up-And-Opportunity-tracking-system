<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="col-lg-6">
        <?= $this->session->flashdata('message'); ?>
        <div class="ibox">
            <div class="ibox-title">
                <h5>Role : <?= $role['role']; ?></h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($menu as $m) : ?>
                            <tr>
                                <td scope="row"><?= $i; ?></td>
                                <td scope="row"><?= $m['menu'] ?></td>
                                <td scope="row">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" <?= check_access($role['role_id'], $m['id']); ?> data-role="<?= $role['role_id']; ?>" data-menu="<?= $m['id']; ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php $i++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="ibox-footer">
                <button class="btn btn-info btn-md back"><span class="fa fa-arrow-circle-left"></span> Kembali</button>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?= $jumlah; ?>" id="jumlah">
<!-- JavaScript -->
<script>
    $(document).ready(function() {
        $(".form-check-input").on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');

            $.ajax({
                url: "<?= base_url('administrator/changeaccess'); ?>",
                type: 'post',
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('administrator/setAccess/') ?>" + roleId;
                }
            });
        });
    });

    $(document).ready(function() {
        $(".back").click(()=> {
            window.history.back();
        })
    })
</script>