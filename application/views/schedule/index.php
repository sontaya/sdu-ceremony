
            <!--begin::Portlet-->
            <div class="kt-portlet">

                <div class="kt-portlet__body">

                    <div class="row mb-2 d-block d-lg-none ">
                        <div class="col-md text-center text-success">
                            <h5>กำหนดการรับพระราชทานปริญญาบัตร ประจำปี 2560 - 2562</h5>
                        </div>
                    </div>  <!-- ./row -->
                    <div class="row">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_fullname" >รหัสนักศึกษา</label>
                            <span id="practice_std_code"><?= $schedule["STD_CODE"] ?></span>
                        </div>
                    </div>  <!-- ./row -->

                    <div class="row">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_fullname" >ชื่อ – สกุล </label>
                            <span id="practice_fullname"><?= $schedule["PREFIX_NAME_TH"] ?><?= $schedule["FIRST_NAME_TH"] ?>&nbsp;<?= $schedule["LAST_NAME_TH"] ?></span>
                        </div>
                    </div>  <!-- ./row -->

                    <div class="row">
                        <div class="col-md">
                            <label style="font-weight:bold;"  >สาขาวิชา </label>
                            <span ><?= $schedule["DEGREENAMETH"] ?></span>
                        </div>
                        <div class="col-md">
                            <label style="font-weight:bold;"  >เกรดเฉลี่ย </label>
                            <span ><?= $schedule["GPA"] ?></span>
                        </div>
                    </div>  <!-- ./row -->

                    <div class="kt-divider mt-4 mb-4">
                        <span></span>
                    </div>

                    <label style="font-weight:bold;" >หมายเหตุ</label>

                    <div class="row">
                        <div class="col-md">
                            <span id="practice_preremark"><?= $schedule["PRE_REMARK"] ?></span>
                        </div>
                    </div>

                </div>
                <?php
                        if($schedule["PRE_REMARK"] == ""){
                ?>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-6 m--valign-middle">

                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <input type="hidden" name="hid_std_code" id="hid_std_code" value="<?= $schedule["STD_CODE"] ?>">
                            <button type="button" class="btn btn-success" id="export_pdf">พิมพ์รายละเอียดการรับ</button>

                        </div>
                    </div>
                </div>
                <?php
                        }
                ?>
            </div>

            <!--end::Portlet-->
