        <!--Begin::Row-->

        <div class="row">
            <!-- <div class="col-xl-4 col-lg-4">
            </div> -->


            <div class="col-xl-6 col-lg-6">


                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header">
                            <h3 class="kt-widget14__title">
                                สรุปจำนวนผู้ยืนยันข้อมูล
                            </h3>
                        </div>
                        <div class="kt-widget14__content">
                            <div class="kt-widget14__chart">
                                <div id="kt_chart_cds_summary" style="height: 150px; width: 150px;"></div>
                            </div>
                            <div class="kt-widget14__legends">
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-success"></span>
                                    <span class="kt-widget14__stats">เข้ารับ</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-warning"></span>
                                    <span class="kt-widget14__stats">ไม่เข้ารับ</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-primary"></span>
                                    <span class="kt-widget14__stats">n/a</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <!--End::Row-->


                                    <div class="kt-portlet kt-portlet--mobile">
										<div class="kt-portlet__head kt-portlet__head--lg">
											<div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="kt-font-brand flaticon2-line-chart"></i>
												</span>
												<h3 class="kt-portlet__head-title">
													ข้อมูลทั้งหมด
												</h3>
											</div>
										</div>
										<div class="kt-portlet__body">

											<!--begin: Search Form -->
											<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
                                                        <div class="form-group row">
															<div class="col-lg-4">
																<label class="">Search:</label>
																<div class="kt-input-icon kt-input-icon--left">
																	<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
																	<span class="kt-input-icon__icon kt-input-icon__icon--left">
																		<span><i class="la la-search"></i></span>
																	</span>
																</div>
															</div>

															<div class="col-lg-4">
																<label class="">สถานะยืนยัน:</label>
																<div class="kt-form__control">
                                                                    <select class="form-control" id="std_confirm_status">
                                                                        <option value="">ทั้งหมด</option>
                                                                        <option value="Y">เข้ารับ</option>
                                                                        <option value="N">ไม่เข้ารับ</option>
                                                                    </select>
                                                                </div>
															</div>

														</div>

											</div>

											<!--end: Search Form -->
										</div>
										<div class="kt-portlet__body kt-portlet__body--fit">

											<!--begin: Datatable -->
											<div class="kt-datatable" id="json_data"></div>

											<!--end: Datatable -->
										</div>
									</div>
