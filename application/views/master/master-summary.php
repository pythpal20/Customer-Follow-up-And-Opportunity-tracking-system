<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-4">
        <h2><?= $title ?></h2>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-7">
            <div class="ibox animated bounceInUp">
                <div class="ibox-title">
                    <h5>Summary Follow-up <?= date('Y') ?></h5>
                </div>
                <div class="ibox-content">
                    <table id="tb_sum" class="table table-bordered">

                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-5" id="colAjax">
            <div class="ibox bounceInUp">
                <div class="ibox-title">
                    <h5>Detail Follow-up hari ini</h5>
                </div>
                <div class="ibox-content">
                    <div id="kontenAjax"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#colAjax").hide();
        $table = $("#tb_sum")
        $table.bootstrapTable({
            url: "<?= base_url('master/getsummaryFollowup') ?>",
            search: true,
            pagination: true,
            columns: [{
                field: 'user',
                title: 'User',
                sortable: true,
                formatter: detailToday
            }, {
                field: 'user',
                title: 'cari_user',
                visible: false
            }, {
                field: 'kontak',
                title: 'Kontak',
            }, {
                field: 'followup',
                title: 'Follow-up',
                sortable: true,
            }, {
                field: 'followup_penawaran',
                title: 'FU Penawaran',
                sortable: true,
            }, {
                field: 'order',
                title: 'Order',
                sortable: true,
            }]
        });

        function detailToday(value, row) {
            return [
                '<span class="lihatDetail" data-id="' + value + '">' + value + '</span>'
            ]
        }

        $('body').on('click', '#tb_sum .lihatDetail', function() {
            var id = $(this).data('id');
            $.ajax({
                url: "<?= base_url('master/dataSumCustomer') ?>",
                type: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    $("#colAjax").show({
                        duration: 750,
                    });
                    $("#kontenAjax").html(data);
                    $(".tbs").bootstrapTable();
                }
            });
        });
        
        swal.fire({
            title: 'INFO PENTING',
            text: 'Klik nama user pada table untuk melihat detail hari ini',
            icon: 'info',
            showCancelButton: false
        });
    })
</script>