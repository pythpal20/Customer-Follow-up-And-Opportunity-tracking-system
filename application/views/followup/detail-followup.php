<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>
<div class="wrapper wrapper-content">
    <div class="ibox animated fadeInRightBig">
        <div class="ibox-title">
            <h5>Form follow-up customer</h5>
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
            <form action="<?= base_url('followup/savehasilFu') ?>" method="POST">
                <div class="form-row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="">ID Followup</label>
                            <input type="text" name="idfollowup" id="idfollowup" class="form-control" value="<?= $follows['followup_id'] ?>" readonly required>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Nama Customer</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= $follows['customer_name'] ?>" readonly required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Follow-up By</label>
                            <input type="text" name="users" id="users" readonly value="<?= $user['user_nama'] ?>" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-sm-3" id="data_1">
                        <div class="form-group">
                            <label>Tanggal Follow-up</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="tanggal" id="tanggal" value="<?= date('d-m-Y') ?>" class="form-control" placeholder="dd-mm-yyyy" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="">Jam</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span><input type="text" name="jam" id="jam" class="form-control" value="<?= date('H:i') ?>" placeholder="HH:ii" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control" required>
                                <option value="">~ Pilih Katori ~</option>
                                <option value="0">Kontak</option>
                                <option value="1">Follow Up</option>
                                <option value="2">Penawaran</option>
                                <option value="3">Followup Penawaran</option>
                                <option value="4">Order/ PO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="notes">Note</label>
                            <textarea name="note" id="note" rows="4" class="form-control"><?= set_value('note') ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="isactive" name="isactive" value="1">
                            <label class="form-check-label" for="isactive">Close follow-up ini ?</label>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Batal">Batal</button>
                <button type="submit" class="btn btn-success btn-sm float-md-right" data-toggle="tooltip" title="Simpan data">Simpan</button>
            </form>
        </div>
    </div>
</div>