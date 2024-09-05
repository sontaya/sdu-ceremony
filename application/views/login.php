<!DOCTYPE html>
<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title> <?= $title ?></title>
		<meta name="description" content="ระบบข้อมูลสารสนเทศของมหาวิทยาลัยสวนดุสิต">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
        <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Asap+Condensed:500"> -->
        <link href="https://fonts.googleapis.com/css?family=Prompt:400,600&display=swap" rel="stylesheet">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="<?= base_url('assets/themes/metronic10/assets/css/pages/login/login-6.css'); ?>" rel="stylesheet" type="text/css" />

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
	<body class="kt-page-content-white kt-quick-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
					<div class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside">
						<div class="kt-login__wrapper">
							<div class="kt-login__container">
								<div class="kt-login__body">
									<div class="kt-login__logo">
										<a href="#">
											<img src="<?= base_url('assets/images/sdu-logo-h120.png'); ?>">
										</a>
									</div>

									<div class="kt-login__signin">
										<div class="kt-login__head">
											<h3 class="kt-login__title">เข้าสู่ระบบ</h3>
										</div>
										<div class="kt-login__form">
											<form class="kt-form" action="" id="kt_login_form">
												<div class="form-group">
													<input class="form-control" type="text" placeholder="รหัสนักศึกษา" name="username" id="input_username" autocomplete="off" value="6111080320014">
												</div>
												<div class="form-group">
													<input class="form-control form-control-last" type="text" placeholder="หมายเลขบัตรประจำตัวประชาชน" name="password" id="input_password" autocomplete="off" value="1329900946508">
												</div>

												<div class="kt-login__actions">
													<button id="kt_login_signin_submit" class="btn btn-brand btn-pill btn-elevate">เข้าสู่ระบบ</button>
												</div>
											</form>
										</div>
									</div>



								</div>
							</div>

						</div>
					</div>
					<div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content" style="background-image: url(<?= base_url('assets/themes/metronic10/assets/media/bg/bg-sdu.jpg'); ?>);">
						<div class="kt-login__section">
							<div class="kt-login__block">
								<h5 class="kt-login__title" style="text-align:center;">กำหนดการซ้อมใหญ่ และรับพระราชทานปริญญาบัตร <br /> ประจำปี 2567 </h5>
								<div class="kt-login__desc ml-5">

										 <ul style="list-style-type: none">
											<li> <a href="<?= base_url('assets/pdf/commencement-schedule.pdf'); ?>" target="_blank" class="override-link"><i class="la la-file-pdf-o"></i> กำหนดการซ้อมรับพระราชทานปริญญาบัตร</a> </li>
											<li> <a href="<?= base_url('assets/pdf/commencement-regulation.pdf'); ?>" target="_blank" class="override-link"><i class="la la-file-pdf-o"></i> ระเบียบการแต่งกายบัณฑิต มหาบัณฑิต และดุษฎีบัณฑิต</a></li>
										</ul>

                                       <h5><strong>หมายเหตุ</strong></h5>
                                        <ul>
                                            <li>
                                            บัณฑิตที่ยังไม่ได้รายงานตัวเข้ารับพระราชทานปริญญาบัตร มีความประสงค์จะเข้ารับฯ แจ้งความประสงค์ เพื่อรายงานตัวเข้ารับพระราชทานปริญญาบัตร
                                            ได้ที่ กองพัฒนานักศึกษา อาคาร 2 ชั้น 3 ห้อง 232 มหาวิทยาลัยสวนดุสิต โทร. 02-244-5190-1 (ในวันเวลาราชการ) <strong>หรือ inbox มาที่เพจ กองพัฒนานักศึกษา มหาวิทยาลัยสวนดุสิต </strong> ภายในวันที่ 6 กันยายน 2567
                                            </li>
                                            <li>บัณฑิตที่ไม่ได้รายงานตัวภายในวันเวลาที่กำหนด ถือว่าสละสิทธิ์ ในการเข้ารับพระราชทานปริญญาบัตร</li>
                                            <li>ติดต่อศูนย์ตรัง โทร. 075-500-888 ต่อ 6818 หรือ 081-172-9599 คุณสุชาดา ศรีปล้อง</li>
                                            <li>ติดต่อศูนย์ลำปาง โทร. 081-980-2422 คุณณัฏฐวรรธน์ สุภาจันทรสุข</li>
                                        </ul>

								</div>
							</div>
					</div>




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
		<script src="<?= base_url('assets/js/metronic-login-practice65.js'); ?>" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>
