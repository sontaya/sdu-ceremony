    <!-- footer content -->
        <footer>
          <div>

          </div>
          <div class="pull-right">
            Datacenter SDU
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>



    <!-- FastClick -->
    <script src="<?= base_url(); ?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url(); ?>assets/vendors/nprogress/nprogress.js"></script>

    <!-- Datatables -->
    <script src="<?= base_url(); ?>assets/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- PNotify -->
    <script src="<?= base_url(); ?>assets/vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?= base_url(); ?>assets/vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Chart.js -->
    <script src="<?= base_url(); ?>assets/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- jQuery Sparklines -->
    <script src="<?= base_url(); ?>assets/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>



    <?php foreach($jsSrc as $js): ?>
      <script src="<?= base_url(); ?><?= $js ?>"></script>
    <?php endforeach; ?>

  </body>
</html>
