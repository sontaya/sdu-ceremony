<!DOCTYPE html>
<html lang="en">

    <!-- begin::Head -->

	<?php echo $header; ?>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-page-content-white kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading">

		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="#">
					<img alt="Logo" src="<?= base_url('assets/images/sdu-logo-h29.png') ?>" />
				</a>

			</div>
			<div class="kt-header-mobile__toolbar">
				<button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
			</div>
		</div>

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper " id="kt_wrapper">

					<!-- begin:: Header -->
					<div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed " data-ktheader-minimize="on">
						<div class="kt-header__top">
							<div class="kt-container ">

								<!-- begin:: Brand -->
								<div class="kt-header__brand   kt-grid__item" id="kt_header_brand">
									<div class="kt-header__brand-logo">
										<a href="<?= site_url('admin/index'); ?>">
											<img alt="Logo" src="<?= base_url('assets/images/sdu-logo-full-h29.png') ?>" class="kt-header__brand-logo-default" />
										</a>
									</div>
								</div>

								<!-- end:: Brand -->

							</div>
						</div>
						<div class="kt-header__bottom">
							<div class="kt-container ">

								<!-- begin: Header Menu -->
								<button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
								<div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
									<div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile ">
										<ul class="kt-menu__nav ">

											<li class="kt-menu__item  kt-menu__item--open kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel" aria-haspopup="true">
                                                <a href="<?= site_url('admin/index'); ?>" class="kt-menu__link">
                                                    <span class="kt-menu__link-text">SUMMARY DASHBOARD</span></i>
                                                </a>

											</li>
                                            <li class="kt-menu__item  kt-menu__item--open kt-menu__item--here kt-menu__item--submenu kt-menu__item--rel" data-ktmenu-submenu-toggle="hover" aria-haspopup="true"><a href="#" class="kt-menu__link kt-menu__toggle"><span class="kt-menu__link-text">Scan</span><i class="kt-menu__ver-arrow la la-angle-right"></i></a>
												<div class="kt-menu__submenu kt-menu__submenu--classic kt-menu__submenu--left">
													<ul class="kt-menu__subnav">
														<li class="kt-menu__item " aria-haspopup="true"><a href="<?= site_url('admin/scan'); ?>" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-architecture-and-city"></i><span class="kt-menu__link-text">Camera Scan</span></a></li>
														<li class="kt-menu__item " aria-haspopup="true"><a href="<?= site_url('admin/scan_list'); ?>" class="kt-menu__link "><i class="kt-menu__link-icon flaticon2-crisp-icons"></i><span class="kt-menu__link-text">Scan Detail</span></a></li>
													</ul>
												</div>
											</li>

										</ul>
									</div>
								</div>

								<!-- end: Header Menu -->
							</div>
						</div>
					</div>

					<!-- end:: Header -->
					<div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
						<div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
							<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

								<!-- begin:: Content Head -->
								<div class="kt-subheader   kt-grid__item" id="kt_subheader">
									<div class="kt-container ">
										<div class="kt-subheader__main">
											<h3 class="kt-subheader__title">
                                                <?= $subheader_title; ?>
                                                <?php
                                                    if($active_tab == 'dashboard'){
                                                ?>
                                                    <a href="<?php echo site_url('admin/logout'); ?>" class="btn btn-label-primary btn-bold btn-icon-h kt-margin-l-10">
                                                        ออกจากระบบ
                                                    </a>
                                                <?php }  ?>
                                            </h3>
											<span class="kt-subheader__separator kt-subheader__separator--v"></span>
                                            <span class="kt-subheader__desc"><?= $subheader_desc; ?></span>

										</div>

									</div>
								</div>

								<!-- end:: Content Head -->

								<!-- begin:: Content -->
								<div class="kt-container  kt-grid__item kt-grid__item--fluid">

                                    <?php echo $content; ?>

								</div>

								<!-- end:: Content -->
							</div>
						</div>
					</div>

					<!-- begin:: Footer -->
					<div class="kt-footer kt-grid__item" id="kt_footer">
						<div class="kt-container ">
                            <div class="kt-footer__wrapper">
								<div class="kt-footer__copyright">
									2024&nbsp;&copy;&nbsp;<a href="http://www.dusit.ac.th" target="_blank" class="kt-link">มหาวิทยาลัยสวนดุสิต</a>
								</div>
                                <div class="kt-footer--fixed">
									ออกแบบและพัฒนาโดย ฝ่ายศูนย์ข้อมูลกลาง สำนักวิทยบริการและเทคโนโลยีสารสนเทศ
								</div>

							</div>
						</div>
					</div>

					<!-- end:: Footer -->
				</div>
			</div>
		</div>

		<!-- end:: Page -->



        <?php echo $footer; ?>

    </body>

	<!-- end::Body -->
</html>
