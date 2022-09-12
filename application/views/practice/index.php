
            <!--begin::Portlet-->
            <div class="kt-portlet">

                <div class="kt-portlet__body">

                    <div class="row mb-2 d-block d-lg-none ">
                        <div class="col-md text-center text-warning">
                            <h5>กำหนดการซ้อมย่อย</h5>
                        </div>
                    </div>  <!-- ./row -->
                    <div class="row">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_fullname" >รหัสนักศึกษา</label>
                            <span id="practice_std_code"><?= $practice["STD_CODE"] ?></span>
                        </div>
                    </div>  <!-- ./row -->

                    <div class="row">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_fullname" >ชื่อ – สกุล </label>
                            <span id="practice_fullname"><?= $practice["PREFIX_NAME_TH"] ?><?= $practice["FIRST_NAME_TH"] ?>&nbsp;<?= $practice["LAST_NAME_TH"] ?></span>
                        </div>
                    </div>  <!-- ./row -->


                    <?php
                        if($practice["PRE_REMARK"] == ""){
                    ?>

                    <div class="row ">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_predate">วันซ้อมย่อย</label>
                            <span id="practice_pre_date"><?= $practice["PRE_DATE"] ?></span>
                        </div>
                    </div>  <!-- ./row -->



                    <div class="row">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_precall">เวลา</label>
                            <span id="practice_precall"><?= $practice["PRE_CALL"] ?></span>
                        </div>
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_precallplace">สถานที่ </label>
                            <span id="practice_callplace"> <?= $practice["CALL_PLACE"] ?></span>
                        </div>
                    </div>  <!-- ./row -->

                    <div class="row mt-3">
                        <div class="col-md">
                            <label style="font-weight:bold;" for="practice_precallplace">ห้องซ้อม</label>
                            <span id="practice_precallplace"><?= $practice["PRE_CALL_PLACE"] ?></span>
                        </div>
                    </div>  <!-- ./row -->


                    <?php } ?>

                    <div class="kt-divider mt-4 mb-4">
                        <span></span>
                    </div>

                    <h4 class="kt-section__title">หมายเหตุ</h4>

                    <div class="row">
                        <div class="col-md">
                            <span id="practice_preremark"><?= $practice["PRE_REMARK"] ?></span>
                        </div>
                    </div>



                </div>
                <?php
                        if($practice["PRE_REMARK"] == ""){
                ?>
                <div class="kt-portlet__foot">
                    <div class="row align-items-center">
                        <div class="col-lg-6 m--valign-middle">

                        </div>
                        <div class="col-lg-6 kt-align-right">
                            <button type="button" class="btn btn-warning" id="export_pdf">พิมพ์บัตรซ้อมย่อย</button>

                        </div>
                    </div>
                </div>
                <?php
                        }
                ?>
            </div>

            <!--end::Portlet-->
