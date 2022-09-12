<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title> Login | แบบสำรวจยืนยันการเข้ารับพระราชทาน ปริญญาบัตรประจำปี 2560 – 2562 มหาวิทยาลัยสวนดุสิต</title>
		<meta name="description" content="ระบบข้อมูลสารสนเทศของมหาวิทยาลัยสวนดุสิต">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500"> -->
        <link href="https://fonts.googleapis.com/css?family=Prompt:400,600&display=swap" rel="stylesheet">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="<?= base_url('assets/themes/metronic10/assets/css/pages/login/login-1.css'); ?>" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="<?= base_url('assets/themes/metronic10/assets/plugins/global/plugins.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/themes/metronic10/assets/css/style.bundle.css'); ?>" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

        <link href="<?= base_url('assets/css/custom-metronic.css'); ?>" rel="stylesheet" type="text/css" />

		<!--begin::Layout Skins(used by all pages) -->

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="<?php echo base_url('assets/images/logo-sdu-text-th.png'); ?>" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v1" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">

					<!--begin::Aside-->
                    <div class="kt-grid__item kt-grid__item--order-tablet-and-mobile-2 kt-grid kt-grid--hor kt-login__aside"
                            style="background-image: url(<?= base_url('assets/themes/metronic10/assets/media/bg/bg-5.jpg'); ?>);">
						<div class="kt-grid__item">
							<a href="#" class="kt-login__logo">
								<img src="<?= base_url('assets/images/sdu-logo-h120.png'); ?>">
							</a>
						</div>
						<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver">
							<div class="kt-grid__item kt-grid__item--middle">
								<h1 class="kt-login__title">แบบสำรวจยืนยันการเข้ารับพระราชทาน ปริญญาบัตรประจำปี 2560 – 2562 <br> มหาวิทยาลัยสวนดุสิต</h1>
								<!-- <h4 class="kt-login__subtitle">The ultimate Bootstrap & Angular 6 admin theme framework for next generation web apps.</h4> -->
							</div>
						</div>




						<div class="kt-grid__item">
							<div class="kt-login__info">
								<div class="kt-login__copyright">
									&copy 2022 มหาวิทยาลัยสวนดุสิต
								</div>

							</div>
						</div>
					</div>

					<!--begin::Aside-->

					<!--begin::Content-->
					<div class="kt-grid__item kt-grid__item--fluid  kt-grid__item--order-tablet-and-mobile-1  kt-login__wrapper">



						<!--begin::Body-->
						<div class="kt-login__body">

							<!--begin::Signin-->
							<div class="kt-login__form">
								<div class="kt-login__title">
									<h3>เข้าสู่ระบบ </h3>
								</div>

								<!--begin::Form-->
								<form class="kt-form" action="" novalidate="novalidate" id="kt_login_form">
									<div class="form-group">
										<input class="form-control" type="text" placeholder="รหัสนักศึกษา" name="username" id="input_username" autocomplete="off" value="5911011805045">
									</div>
									<div class="form-group">
										<input class="form-control" type="text" placeholder="หมายเลขบัตรประจำตัวประชาชน" name="password" id="input_password" autocomplete="off" value="1129700151309">
									</div>

									<!--begin::Action-->
									<div class="kt-login__actions">
										<button id="kt_login_signin_submit" class="btn btn-info btn-elevate kt-login__btn-info">เข้าสู่ระบบ</button>
									</div>

									<!--end::Action-->
								</form>

								<!--end::Form-->


							</div>
							<!--end::Signin-->
						</div>
						<!--end::Body-->

					</div>

					<!--end::Content-->
				</div>
			</div>
		</div>

		<!-- end:: Page -->

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

		<!--end::Global Theme Bundle -->

        <!--begin::Page Scripts(used by this page) -->
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
		<script src="<?= base_url('assets/js/metronic-login.js'); ?>" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>
