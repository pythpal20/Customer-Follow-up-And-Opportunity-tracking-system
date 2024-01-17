<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><?= $title ?></h2>
    </div>
</div>
<style>
    #longTextCell.collapsed {
        white-space: nowrap;
        overflow: scroll
        text-overflow: ellipsis;
    }
    
    .text-container {
        max-width: 150px; /* Sesuaikan dengan lebar maksimum yang Anda inginkan */
        overflow: scroll;
    }

    .text-container .collapsed {
        white-space: nowrap;
        overflow: scroll;
        text-overflow: ellipsis;
    }

    .text-container .expanded {
        display: none;
    }
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-header panel-title">
                    <h5 class="py-2 m-2">Pilih rentang tanggal</h5>
                </div>
                <div class="panel-body">
                    <form id="formRange">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tglawal">Tanggal Awal</label>
                                    <input type="date" class="form-control" name="tglawal" id="tglawal">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tglakhr">Tanggal Akhir</label>
                                    <input type="date" class="form-control" name="tglakhr" id="tglakhr">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pengguna">User</label>
                                    <select class="form-control" name="pengguna" id="pengguna">
                                        <option value="all">ALL</option>
                                        <?php foreach($pengguna->result() AS $p) : ?>
                                        <option value="<?= $p->add_by ?>"><?= $p->add_by ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <span class="btn btn-sm btn-danger tarik d-none" id="doxload"><i class="fa fa-download"></i> Download</span>
                                <span class="btn btn-sm btn-info float-right tampilkan"><i class="fa fa-eye"></i> Show</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 d-none" id="boxlist">
            <div class="ibox" id="ibox1">
                <div class="ibox-title">
                    <h5>List Penawaran Aktif</h5>
                </div>
                <div class="ibox-content">
                    <div class="project-list" id="project-list">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    

<script>
    $(document).ready(function() {
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
        $(".tampilkan").click(()=>{
            
            var box = $('#boxlist').removeClass('d-none');
            
            var formData = $("#formRange").serialize();
            
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            
            fetch("<?= base_url('master/listPenawaran') ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            .then(function(response) {
                return response.text();
            })
            .then(function(data) {
                // console.log(data);
                
                document.querySelector('#project-list').innerHTML = data;
                $(".tbPenawaran").bootstrapTable();
                
                function toggleText(span) {
                    var container = span.previousElementSibling;
                    var collapsedText = container.querySelector('.collapsed');
                    var expandedText = container.querySelector('.expanded');
            
                    if (collapsedText.style.display === 'none') {
                        collapsedText.style.display = 'inline';
                        expandedText.style.display = 'none';
                        // span.textContent = 'Tampilkan Seluruhnya';
                    } else {
                        collapsedText.style.display = 'none';
                        expandedText.style.display = 'inline';
                        // button.textContent = 'Sembunyikan';
                    }
                }
                
                var toms = $("#doxload");
                toms.removeClass("d-none");
                
                $('#ibox1').children('.ibox-content').removeClass('sk-loading');
            })
            .catch(function(error) {
                console.log('Error:', error);
            }); 
        });
        
        $("#doxload").click(()=> {
            var strg = $("#tglawal").val() + "|" + $("#tglakhr").val() + "|" + $("#pengguna").val();
            
            var key = "sifupass"; // Kunci enkripsi acak, dapat diganti dengan kunci lain
            var encryptedData = encryptData(strg, key);
            
            window.location.href="<?= base_url('master/downloadListPenawaran/') ?>" + encryptedData;
        });
        
    })
</script>