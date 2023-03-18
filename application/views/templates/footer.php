<div class="footer">
    <div class="float-right">
        <strong>Copyright</strong> PT. Mutli Wahana Kencana &copy; <?= date('Y') ?>
    </div>
</div>
</div>
</div>

<!-- Mainly scripts -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/popper.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/bootstrap.js"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?= base_url('assets/'); ?>js/inspinia.js"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/pace/pace.min.js"></script>
<!-- ChartJS-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/clockpicker/clockpicker.js"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/fullcalendar/moment.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
<!-- encrypt -->
<script src="<?= base_url('node_modules/');?>crypto-js/crypto-js.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js" integrity="sha512-E8QSvWZ0eCLGk4km3hxSsNmGWbLtSCSUcewDQPQWZF6pEU8GlT8a5fF32wOl1i8ftdMhssTrF/OhyGWwonTcXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/aes.min.js" integrity="sha512-4b1zfeOuJCy8B/suCMGNcEkMcQkQ+/jQ6HlJIaYVGvg2ZydPvdp7GY0CuRVbNpSxNVFqwTAmls2ftKSkDI9vtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/enc-base64.min.js" integrity="sha512-IKpu1GFk/bQ+2fOc4sXuA6lm7Rct4P7611iDBxY9LReOZ2PpwoDWWqj6GSYejUce1FLxo/d4lxAnKqGWJuBw7g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.js" integrity="sha512-NQVmLzNy4Lr5QTrmXvq/WzTMUnRHmv7nyIT/M6LyGPBS+TIeRxZ+YQaqWxjpRpvRMQSuYPQURZz/+pLi81xXeA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- table-bootstrap -->
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/bootstrap-table.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/fixed-columns/bootstrap-table-fixed-columns.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.20.2/dist/extensions/export/bootstrap-table-export.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/print/bootstrap-table-print.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.21.0/dist/extensions/toolbar/bootstrap-table-toolbar.min.js"></script>
<!-- typeahead-->
<script src="<?= base_url('assets/'); ?>js/plugins/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('[rel="tooltip"]').tooltip()
        });

        $(".logout").click(()=> {
            swal.fire({
                title: 'Yakin Log out ?',
                text: 'Klik Ok untuk keluar',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((gasstross)=> {
                if(gasstross.isConfirmed) {
                    // kelogout
                    window.location.href="<?= base_url('auth/logout') ?>";
                }
            })
        });
    });
</script>
<script>
    $(function() {
        var mem = $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        var yearsAgo = new Date();
        yearsAgo.setFullYear(yearsAgo.getFullYear() - 20);

        $('.clockpicker').clockpicker();
    })
</script>
</body>

</html>