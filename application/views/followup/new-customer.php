<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>
<?php $dt = $this->db->get_where('user_role', ['role_id' => $user['role_id']])->row_array(); ?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <?= $this->session->flashdata('message'); ?>
            <div class="ibox animated fadeInRightBig">
                <div class="ibox-title">
                    <h5>Form customer follow-up baru</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="<?= base_url('followup/newCustomerFu') ?>" method="POST">
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Nama Customer</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="nama customer - followup" autocomplete="off">
                            </div>
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Kategori customer</label>
                            <div class="col-sm-6">
                                <select name="kategori" id="kategori" class="form-control">
                                    <option value="">~ Pilih Kategori ~</option>
                                    <?php foreach ($catgr->result() as $row) : ?>
                                        <option value="<?= $row->kode; ?>"><?= $row->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?= form_error('kategori', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">PIC</label>
                            <div class="col-sm-10">
                                <input type="text" name="pic" id="pic" class="form-control" placeholder="nama pic">
                            </div>
                            <?= form_error('pic', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Kontak</label>
                            <div class="col-sm-10">
                                <input type="text" name="kontak" id="kontak" class="form-control" placeholder="wajib numeric tanpa spasi, min 8 karakter">
                            </div>
                            <?= form_error('kontak', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Tanggal Follow-up</label>
                            <div class="col-sm-3" id="data_1">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="tanggal" id="tanggal" class="form-control" placeholder="tanggal">
                                </div>
                                <?= form_error('tanggal', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                            <div class="col-sm-2">
                                <div class="input-group clockpicker" data-autoclose="true">
                                    <input type="text" name="jam" id="jam" class="form-control" placeholder="jam">
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                    <?= form_error('jam', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea name="desc" id="desc" class="form-control"></textarea>
                            </div>
                            <?= form_error('desc', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Format-Customer</label>
                            <div class="col-sm-3">
                                <input type="text" name="format" id="format" class="form-control" value="<?= $dt['role'] ?>" readonly>
                            </div>
                            <?= form_error('format', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-3">
                                <select name="status" id="status" class="form-control">
                                    <option value="">Status Customer</option>
                                    <option value="0">Customer Lama</option>
                                    <option value="1">Customer Baru</option>
                                </select>
                            </div>
                            <?= form_error('status', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                        <hr class="hr-line-solid divider">
                        <button type="button" class="btn btn-warning mt-2">Batal</button>
                        <button type="submit" class="btn btn-info float-right mt-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $.get("<?= base_url('followup/dataFollowupku') ?>", function(data) {
            // console.log(data);
            $("#nama").typeahead({
                source: data
            });
        }, 'json');
    })
</script>