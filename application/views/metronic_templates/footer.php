		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="<?= base_url('assets/themes/metronic10/assets/plugins/global/plugins.bundle.js'); ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/themes/metronic10/assets/js/scripts.bundle.js'); ?>" type="text/javascript"></script>
        <script src="<?php echo base_url('assets/vendors/jquery-validation/dist/jquery.validate.min.js'); ?>"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.2/b-html5-1.5.2/fc-3.2.5/fh-3.1.4/r-2.2.2/rg-1.0.3/datatables.min.js"></script>
		<!--end::Global Theme Bundle -->
		<!--end::Page Vendors -->


        <script>
         var base_url = '<?php echo base_url(); ?>';
        </script>


        <?php if(isset($jsSrc)){ ?>
            <?php foreach($jsSrc as $js): ?>
                <script src="<?= base_url(); ?><?= $js ?>"></script>
            <?php endforeach; ?>
        <?php } ?>


        <!--end::Page Scripts -->
