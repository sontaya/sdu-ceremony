        <!--Begin::Row-->

        <div class="row">
            <!-- <div class="col-xl-4 col-lg-4">
            </div> -->


            <div class="col-xl-6 col-lg-6">


                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header">
                            <h3 class="kt-widget14__title">
                                สถานะการเข้ารับปริญญา
                            </h3>
                        </div>

                        <div class="kt-widget14__content">
                            <div class="kt-widget14__chart">
                                <div id="kt_chart_grad_status" style="height: 150px; width: 150px;"></div>
                            </div>
                            <div class="kt-widget14__legends">
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-success"></span>
                                    <span class="kt-widget14__stats">ปกติ</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-primary"></span>
                                    <span class="kt-widget14__stats">เข้ารับ ไม่ชำระเงินรายตัว</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-warning"></span>
                                    <span class="kt-widget14__stats">ไม่เข้ารับ</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-info"></span>
                                    <span class="kt-widget14__stats">ไม่เข้ารับ ไม่ชำระเงินค่ารายงานตัว</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-danger"></span>
                                    <span class="kt-widget14__stats">ไม่รายงานตัว</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-xl-6 col-lg-6">


                <div class="kt-portlet kt-portlet--height-fluid">
                    <div class="kt-widget14">
                        <div class="kt-widget14__header">
                            <h3 class="kt-widget14__title">
                                สถานะการอัพโหลดข้อมูล
                            </h3>
                        </div>
                        <div class="kt-widget14__content">
                            <div class="kt-widget14__chart">
                                <div id="kt_chart_cds_summary" style="height: 150px; width: 150px;"></div>
                            </div>
                            <div class="kt-widget14__legends">
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-success"></span>
                                    <span class="kt-widget14__stats">ยืนยัน</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-primary"></span>
                                    <span class="kt-widget14__stats">รอการยืนยัน</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-warning"></span>
                                    <span class="kt-widget14__stats">ปฏิเสธ</span>
                                </div>
                                <div class="kt-widget14__legend">
                                    <span class="kt-widget14__bullet kt-bg-info"></span>
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
																<label class="">สถานะการเข้ารับปริญญา:</label>
																<div class="kt-form__control">
                                                                    <select class="form-control" id="get_remark_status">
                                                                        <option value="1">1:ปกติ</option>
                                                                        <option value="2">2:เข้ารับ ไม่ชำระเงินรายตัว</option>
                                                                        <option value="3">3:ไม่เข้ารับ</option>
                                                                        <option value="4">4:ไม่เข้ารับ ไม่ชำระเงินค่ารายงานตัว</option>
                                                                        <option value="5">5:ไม่รายงานตัว</option>
                                                                    </select>
                                                                </div>
															</div>
															<div class="col-lg-4">
																<label class="">สถานะยืนยัน:</label>
																<div class="kt-form__control">
                                                                    <select class="form-control" id="request_upload_status">
                                                                        <option value="">ทั้งหมด</option>
                                                                        <option value="approve">ยืนยัน (Approve)</option>
                                                                        <option value="pending">รอการยืนยัน (Pending)</option>
                                                                        <option value="reject">ปฏิเสธ (Reject)</option>
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


    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Reason</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="rejectForm">
                        <div class="form-group">
                            <label for="rejectReason">Reason</label>
                            <textarea class="form-control" id="rejectReason" rows="3" required></textarea>
                        </div>
                        <input type="hidden" id="rejectUserId">
                        <button type="submit" class="btn btn-danger">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- GradRemark Modal -->
    <div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="remarkModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="remarkModalLabel">สถานะการเข้ารับปริญญา</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="remarkForm">
                            <div class="form-group">
                                <div class="kt-form__control">
                                    <select class="form-control" id="remarkGet">
                                        <option value="1">1:ปกติ</option>
                                        <option value="2">2:เข้ารับ ไม่ชำระเงินรายตัว</option>
                                        <option value="3">3:ไม่เข้ารับ</option>
                                        <option value="4">4:ไม่เข้ารับ ไม่ชำระเงินค่ารายงานตัว</option>
                                        <option value="5">5:ไม่รายงานตัว</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="remarkUserId">
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PracticeInfo Modal -->
    <div class="modal fade" id="practiceInfoModal" tabindex="-1" role="dialog" aria-labelledby="practiceInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="practiceInfoModalLabel">รายละเอียด</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="practice-info-body"></div>
                </div>
            </div>
        </div>
    </div>
