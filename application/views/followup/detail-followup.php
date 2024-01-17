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
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="tanggal" id="tanggal" value="<?= date('m/d/Y') ?>" class="form-control" placeholder="dd/mm/yyyy" required>
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
                            <select name="kategori" id="kategori" class="form-control kategori" required>
                                <option value="">~ Pilih Katori ~</option>
                                <option value="0">Kontak</option>
                                <option value="1">Follow Up</option>
                                <option value="2">Penawaran</option>
                                <option value="3">Followup Penawaran</option>
                                <option value="4">Order/ PO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 d-none" id="fumethod">
                        <div class="form-group">
                            <label for="fmethod">Followup Method</label>
                            <select name="fmethod" id="fmethod" class="form-control">
                                <option value="">Choose</option>
                                <option value="Email">Email</option>
                                <option value="Marketplace">Chat on Marketplace apps</option>
                                <option value="Telp">Telp</option>
                                <option value="Visit">Visit</option>
                                <option value="Whatsapp">Whatsapp</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 d-none" id="jepe">
                        <div class="form-group">
                            <label for="jpew">Jenis Penawaran</label>
                            <select name="jpew" id="jpew" class="form-control">
                                <option value="">Choose</option>
                                <option value="Biasa">Penawaran Biasa</option>
                                <option value="Promo">Penawaran Promo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 d-none" id="prp">
                        <label for="prosepek">Prospek Penawaran</label>
                        <select name="prospek" id="prospek" class="form-control">
                            <option value="">~ Wajib Pilih ~</option>
                            <option value="cool">Cool</option>
                            <option value="warm">Warm</option>
                            <option value="hot">Hot</option>
                        </select>
                    </div>
                    <div class="col-sm-3 d-none" id="stp">
                        <label for="stpen">Status Penawaran</label>
                        <select name="stpen" id="stpen" class="form-control">
                            <option value="">~Wajib Isi~</option>
                            <option value="Penawaran">Penawaran</option>
                            <option value="Revisi 1">Revisi 1</option>
                            <option value="Revisi 2">Revisi 2</option>
                            <option value="Revisi 3">Revisi 3</option>
                            <option value="Revisi 4">Revisi 4</option>
                            <option value="Revisi 5">Revisi 5</option>
                        </select>
                    </div>
                    <div class="col-sm-3 d-none" id="jepo">
                        <div class="form-group">
                            <label for="jpo">Jenis PO</label>
                            <select name="jpo" id="jpo" class="form-control">
                                <option value="">Choose</option>
                                <option value="Biasa">PO Biasa</option>
                                <option value="Promo">PO Promo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 d-none" id="valfu">
                        <div class="form-group">
                            <label for="fuval">Values</label>
                            <select name="fuval" id="fuval" class="form-control">
                                <option value="">Choose</option>
                                <option value="Wa Blast">Wa Blast</option>
                                <option value="Wa Blast Promo">Wa Blast Promo</option>
                                <option value="Tanya Barang">Tanya Barang</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 d-none" id="iup">
                        <label for="inuppe">Info update penawaran</label>
                        <select name="inuppe" id="inuppe" class="form-control">
                            <option value="">~Wajib isi~</option>
                            <option value="Revisi">Revisi</option>
                            <option value="Nego">Nego</option>
                            <option value="Minta sample">Minta Sample</option>
                            <option value="Followup">Followup Biasa</option>
                        </select>
                    </div>
                    <div class="col-sm-3 d-none" id="pot">
                        <label for="poter">PO Termin</label>
                        <select name="poter" id="poter" class="form-control">
                            <option value="">~Wajib isi~</option>
                            <option value="CBD">Cash Before Delivery</option>
                            <option value="COD">Cash On Delivery</option>
                            <option value="Tempo 14 Hari">Tempo 14 Hari</option>
                            <option value="Tempo 30 Hari">Tempo 30 Hari</option>
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="notes">Note</label>
                            <textarea name="note" id="note" rows="4" class="form-control" required><?= set_value('note') ?></textarea>
                        </div>
                    </div>
                    <div id="form" class="col-lg-12 mb-2 row"></div>
                    <div class="col-sm-4" id="theReason">
                        <div class="form-group">
                            <label for="">Close Karena ?</label>
                            <select name="deReson" id="deReson" class="form-control deReson">
                                <option value="">~ Wajib Isi ~</option>
                                <option value="1">Harga terlalu mahal/ tinggi</option>
                                <option value="2">Belum ada kebutuhan</option>
                                <option value="3">Salah Sambung/ Kontak Salah</option>
                                <option value="4">Tidak Ada Respon</option>
                                <option value="5">Purchasing ingin dikunjungi terlebih dahulu</option>
                                <option value="6">Kendala metode pembayaran</option>
                                <option value="7">Barang yang diminta tidak ada</option>
                                <option value="8">Waktu pengadaan barang terlalu lama</option>
                                <option value="9">Toko sudah tutup</option>
                                <option value="10">Customer jadi belanja ke showroom</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="isactive" name="isactive" value="1">
                            <label class="form-check-label" for="isactive"><b>Close follow-up ini ?</b></label>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Batal">Batal</button>
                <button type="submit" class="btn btn-success btn-sm float-md-right" data-toggle="tooltip" title="Simpan data">Simpan</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#kategori").on('change', function() {
            const kategoris = $(this).val();

            if (kategoris === '0' || kategoris === '1') {
                $('#fumethod').removeClass("d-none");
                $('#fmethod').val('').prop("required", true);

                $('#valfu').removeClass("d-none");
                $("#fuval").val('');

                $('#jepe').addClass("d-none");
                $("#jpew").val('').prop("required", false);

                $('#jepo').addClass("d-none");
                $("#jpo").val('').prop("required", false);

                $('#prp').addClass('d-none');
                $('#prospek').val('').prop("required", false);

                $('#stp').addClass('d-none');
                $('#stpen').val('').prop("required", false);

                $('#iup').addClass('d-none');
                $('#inuppe').val('').prop("required", false);

                $('#pot').addClass('d-none');
                $('#poter').val('').prop("required", false);
            } else if (kategoris === '3') {
                // Kode khusus untuk kategori 3
                $('#fumethod').removeClass("d-none");
                $('#fmethod').val('').prop("required", true);

                $('#valfu').addClass("d-none");
                $("#fuval").val('');

                $('#jepe').addClass("d-none");
                $("#jpew").val('').prop("required", false);

                $('#jepo').addClass("d-none");
                $("#jpo").val('').prop("required", false);

                $('#prp').addClass('d-none');
                $('#prospek').val('').prop("required", false);

                $('#stp').addClass('d-none');
                $('#stpen').val('').prop("required", false);

                $('#iup').removeClass('d-none');
                $('#inuppe').val('').prop("required", true);

                $('#pot').addClass('d-none');
                $('#poter').val('').prop("required", false);
            } else if (kategoris === '2') {
                $('#fumethod').addClass("d-none");
                $('#fmethod').val('').prop("required", false);

                $('#valfu').addClass("d-none");
                $("#fuval").val('');

                $('#jepe').removeClass("d-none");
                $("#jpew").val('').prop("required", true);

                $('#jepo').addClass("d-none");
                $("#jpo").val('').prop("required", false);

                $('#prp').removeClass('d-none');
                $('#prospek').val('').prop("required", true);

                $('#stp').removeClass('d-none');
                $('#stpen').val('').prop("required", true);

                $('#iup').addClass('d-none');
                $('#inuppe').val('').prop("required", false);

                $('#pot').addClass('d-none');
                $('#poter').val('').prop("required", false);
            } else if (kategoris === '4') {
                $('#fumethod').addClass("d-none");
                $('#fmethod').val('').prop("required", false);

                $('#valfu').addClass("d-none");
                $("#fuval").val('');

                $('#jepe').addClass("d-none");
                $("#jpew").val('').prop("required", false);

                $('#jepo').removeClass("d-none");
                $("#jpo").val('').prop("required", true);

                $('#prp').addClass('d-none');
                $('#prospek').val('').prop("required", false);

                $('#stp').addClass('d-none');
                $('#stpen').val('').prop("required", false);

                $('#iup').addClass('d-none');
                $('#inuppe').val('').prop("required", false);

                $('#pot').removeClass('d-none');
                $('#poter').val('').prop("required", true);
            }
        });
    });
    $(function() {
        $("#theReason").hide();
        $("#isactive").prop('disabled', true);

        const checkbox = document.querySelector('input[type="checkbox"]');
        const theReason = document.querySelector('#theReason');
        const deReson = document.querySelector('#deReson');

        $(".kategori").change(() => {
            var ktr = $("#kategori").val();

            $("#isactive").prop('disabled', false);

            checkbox.addEventListener('change', function() {
                if (this.checked && ktr != '4') {
                    theReason.style.display = 'block'; // menampilkan elemen theReason
                    deReson.setAttribute('required', true);
                } else {
                    theReason.style.display = 'none'; // menyembunyikan elemen theReason
                    deReson.removeAttribute('required');
                }
            });

            if (ktr === '2') {
                var field1 = document.getElementById('noso');
                var field2 = document.getElementById('nominal');
                // Hapus elemen field jika sudah ada
                if (field1 && field2) {
                    field1.parentNode.parentNode.removeChild(field1.parentNode);
                    field2.parentNode.parentNode.removeChild(field2.parentNode);
                }
                // Buat elemen div baru untuk kedua field
                var div3 = document.createElement('div');
                div3.classList.add('col-sm-4');
                // Buat elemen div baru untuk kedua field
                var div4 = document.createElement('div');
                div4.classList.add('col-sm-4');
                // buat element div baru untuk field prospek penawaran
                // var div5 = document.createElement('div');
                // div5.classList.add('col-sm-')
                // Buat elemen label baru untuk field 1
                var label3 = document.createElement('label');
                label3.setAttribute('for', 'nopnw');
                label3.innerHTML = 'No Penawaran';
                // Buat elemen input baru untuk field 1
                var input3 = document.createElement('input');
                input3.setAttribute('type', 'text');
                input3.setAttribute('class', 'form-control');
                input3.setAttribute('name', 'nopnw');
                input3.setAttribute('id', 'nopnw');
                input3.setAttribute('placeholder', 'No Penawaran');
                input3.setAttribute('required', '');

                var label4 = document.createElement('label');
                label4.setAttribute('for', 'nominalpnw');
                label4.innerHTML = 'Nominal';
                // Buat elemen input baru untuk field 2
                var input4 = document.createElement('input');
                input4.setAttribute('type', 'number');
                input4.setAttribute('class', 'form-control');
                input4.setAttribute('name', 'nominalpnw');
                input4.setAttribute('id', 'nominalpnw');
                input4.setAttribute('placeholder', 'Nominal Penawaran');
                input4.setAttribute('required', '');
                // Tambahkan label dan input field baru ke dalam div untuk field 1
                div3.appendChild(label3);
                div3.appendChild(input3);
                // Tambahkan label dan input field baru ke dalam div untuk field 2
                div4.appendChild(label4);
                div4.appendChild(input4);
                // Ambil elemen form dengan ID "form"
                var form = document.getElementById('form');
                // Tambahkan div ke dalam form
                form.appendChild(div3);
                form.appendChild(div4);
            } else if (ktr === '4') {
                var field3 = document.getElementById('nopnw');
                var field4 = document.getElementById('nominalpnw');
                // Hapus elemen field jika sudah ada

                if (field3 && field4) {
                    field3.parentNode.parentNode.removeChild(field3.parentNode);
                    field4.parentNode.parentNode.removeChild(field4.parentNode);
                }

                // Buat elemen div baru untuk kedua field
                var div1 = document.createElement('div');
                div1.classList.add('col-sm-4');
                // Buat elemen div baru untuk kedua field
                var div2 = document.createElement('div');
                div2.classList.add('col-sm-4');
                // Buat elemen label baru untuk field 1
                var label1 = document.createElement('label');
                label1.setAttribute('for', 'noso');
                label1.innerHTML = 'No Transaksi/ No. SCO';
                // Buat elemen input baru untuk field 1
                var input1 = document.createElement('input');
                input1.setAttribute('type', 'text');
                input1.setAttribute('class', 'form-control noso');
                input1.setAttribute('name', 'noso');
                input1.setAttribute('id', 'noso');
                input1.setAttribute('placeholder', 'No Transaksi/ No. SCO');
                input1.setAttribute('required', '');
                // Buat elemen label baru untuk field 2
                var label2 = document.createElement('label');
                label2.setAttribute('for', 'nominal');
                label2.innerHTML = 'Nominal';
                // Buat elemen input baru untuk field 2
                var input2 = document.createElement('input');
                input2.setAttribute('type', 'number');
                input2.setAttribute('class', 'form-control');
                input2.setAttribute('name', 'nominal');
                input2.setAttribute('id', 'nominal');
                input2.setAttribute('placeholder', 'Nominal');
                input2.setAttribute('required', '');
                // Tambahkan label dan input field baru ke dalam div untuk field 1
                div1.appendChild(label1);
                div1.appendChild(input1);
                // Tambahkan label dan input field baru ke dalam div untuk field 2
                div2.appendChild(label2);
                div2.appendChild(input2);
                // Ambil elemen form dengan ID "form"
                var form = document.getElementById('form');
                // Tambahkan div ke dalam form
                form.appendChild(div1);
                form.appendChild(div2);
            } else {
                // Ambil elemen field yang telah ditambahkan sebelumnya
                var field1 = document.getElementById('noso');
                var field2 = document.getElementById('nominal');

                var field3 = document.getElementById('nopnw');
                var field4 = document.getElementById('nominalpnw');
                // Hapus elemen field jika sudah ada
                if (field1 && field2) {
                    field1.parentNode.parentNode.removeChild(field1.parentNode);
                    field2.parentNode.parentNode.removeChild(field2.parentNode);
                }

                if (field3 && field4) {
                    field3.parentNode.parentNode.removeChild(field3.parentNode);
                    field4.parentNode.parentNode.removeChild(field4.parentNode);
                }
            }
        })
        $(function() {
            $.get("<?= base_url('followup/cekMkits') ?>", function(data) {
                // console.log(data);
                setTimeout(function() {
                    $(".noso").typeahead({
                        source: data
                    });
                }, 200);
            }, 'json');
        })
    });

    $(document).ready(function() {
        $('body').on('click', '#noso', function() {
            $.get("<?= base_url('followup/cekMkits') ?>", function(data) {
                $(".noso").typeahead({
                    source: data
                });
            }, 'json');


            // $(".noso").change(()=> {
            //     alert('tralala')
            // })
        });
    })
</script>