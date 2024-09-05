
<?php
    if($request["UPLOAD_STATUS"] == NULL || $request["UPLOAD_STATUS"] == ""){
        $action_control_class = "block";
        $image_control_class = "none";
        $info_class = "";
        $info_text = "";
        $practice_info_box = "hide";

    }else{

        $action_control_class = "none";
        $image_control_class = "block";
        $practice_info_box = "hide";

        switch ($request["UPLOAD_STATUS"]) {
            case 'approve':
                $info_class = 'btn-label-success';
                $callout_class = 'kt-callout--success';
                $info_text = "อนุมัติ";
                break;
            case 'pending':
                $info_class = 'btn-label-info';
                $callout_class = 'kt-callout--info';
                $info_text = "รอการอนุมัติ";
                break;
            case 'reject':
                $info_class = 'btn-label-warning';
                $callout_class = 'kt-callout--warning';
                $info_text = "ให้อัพโหลดใหม่ ".$request["REJECT_REASON"];
                break;

            default:
                $info_class = '';
                $info_text = '';
                break;
        }
    }



    if($request["UPLOAD_STATUS"]== "approve" && ($practice["REMARK_GET"] == 1)){
        $request_action_button = "hide";
        $practice_info_box = "show";
        $practice_info_export = "show";
    }elseif($request["UPLOAD_STATUS"]== "approve"){
        $request_action_button = "hide";
        $practice_info_box = "show";
        $practice_info_export = "hide";
    }else{
        $request_action_button = "show";
        $practice_info_box = "hide";
        $practice_info_export = "hide";
    }


?>

            <!--begin::Portlet-->
            <div class="kt-portlet">



                    <form id="FormRequest" class="kt-form" enctype="multipart/form-data" method="post" action="<?php echo base_url('process/do_upload'); ?>" >
                            <div class="kt-portlet__body">

                                <div class="row mb-2 d-block d-lg-none ">
                                    <div class="col-md text-center text-warning">
                                        <h5>อัพโหลดภาพชุดครุย</h5>
                                    </div>
                                </div>  <!-- ./row -->
                                <div class="row">
                                    <div class="col-md">
                                        <label style="font-weight:bold;" for="practice_fullname" >รหัสนักศึกษา</label>
                                        <span id="practice_std_code"><?= $request["STD_CODE"] ?></span>
                                    </div>
                                </div>  <!-- ./row -->

                                <div class="row">
                                    <div class="col-md">
                                        <label style="font-weight:bold;" for="practice_fullname" >ชื่อ – สกุล </label>
                                        <span id="practice_fullname"><?= $request["PREFIX_NAME_TH"] ?><?= $request["FIRST_NAME_TH"] ?>&nbsp;<?= $request["LAST_NAME_TH"] ?></span>
                                    </div>
                                </div>  <!-- ./row -->



                                <div class="kt-divider mt-4 mb-4">
                                    <span></span>
                                </div>

                                <?php if ($practice["REMARK_GET"] == 1){ ?>

                                    <?
                                        if($action_control_class == "none"){
                                    ?>

                                        <div class="row mt-4 control-image-preview" >
                                            <div class="col-md-2 text-center">
                                                <div class="kt-avatar kt-avatar--outline" id="kt_photo_preview">
                                                    <div class="kt-avatar__holder" style="width:150px; height:200px; background-image: url('<?= base_url('uploads/').$request["ID_PHOTO"] ?>')"></div>
                                                    <?php if($request_action_button == "show"){ ?>
                                                        <label class="kt-avatar__upload" id="kt_photo_edit" data-toggle="kt-tooltip" title="" data-original-title="แก้ไขรูปชุดครุย">
                                                            <i class="fa fa-pen"></i>
                                                        </label>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <div class="col-md-10">

                                            <div class="kt-portlet kt-callout-custom <?= $callout_class ?> kt-callout--diagonal-bg" style="box-shadow: none;">
                                                <div class="kt-portlet__body">
                                                    <div class="kt-callout__body">
                                                        <div class="kt-callout__content">
                                                            <h3 class="kt-callout__title">สถานะการอัพโหลดภาพ</h3>
                                                            <p class="kt-callout__desc">
                                                                <span style="width: 50px;">
                                                                    <span class="btn btn-bold btn-font <?= $info_class ?>">
                                                                        <?= $info_text ?>
                                                                    </span>
                                                                </span>
                                                                <div class="mt-2 small">บันทึกข้อมูลล่าสุด: <?= $request["LAST_MODIFY_DATE_TH"] ?></div>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>




                                            <? if($practice_info_box == "show"){ ?>
                                                <div class="kt-portlet kt-callout-custom kt-callout--info kt-callout--diagonal-bg" style="box-shadow: none;">
                                                    <div class="kt-portlet__body">
                                                        <div class="kt-callout__body">
                                                            <div class="kt-callout__content">
                                                                <p class="kt-callout__desc">
                                                                    <h3 class="kt-callout__title">กำหนดการ</h3>

                                                                        <!-- ระดับ ป.โท ป.เอก ไม่ต้องซ้อมย่อย -->
                                                                        <?php if($practice["PRACTICE_STATUS"]=="Y"){ ?>

                                                                            <div class="row ">
                                                                                <div class="col-md">
                                                                                    <label for="practice_predate" style="font-weight:bold;">วันซ้อมย่อย</label>
                                                                                    <span id="practice_pre_date" ><?= $practice["PRE_DATE"] ?></span>
                                                                                </div>
                                                                            </div>  <!-- ./row -->

                                                                            <div class="row">
                                                                                <div class="col-md">
                                                                                    <label>รอบ</label>
                                                                                    <span id="practice_precall" ><?= $practice["PRE_CALL"] ?>&nbsp;&nbsp;<?= $practice["CALL_PLACE"] ?>&nbsp;อาคารมหาวชิราลงกรณ ถนนสิรินธร</span>
                                                                                </div>
                                                                            </div>  <!-- ./row -->

                                                                            <div class=" mb-2 mt-4">
                                                                                <span></span>
                                                                            </div>

                                                                        <?php } ?>

                                                                        <div class="row ">
                                                                            <div class="col-md">
                                                                                <label style="font-weight:bold;">วันซ้อมใหญ่ (สวมครุย)</label>
                                                                                <span ><?= $practice["PRE_DATEROUND"] ?></span>
                                                                            </div>
                                                                        </div>  <!-- ./row -->
                                                                        <div class="row ">
                                                                            <div class="col-md">
                                                                                <span ><?= $practice["PRE_ROUND"] ?></span>
                                                                                <span >เรียกแถวเวลา <?= $practice["PRE_CALLROUND"] ?></span>
                                                                            </div>
                                                                        </div>  <!-- ./row -->
                                                                        <div class="row ">
                                                                            <div class="col-md">
                                                                                <span >สถานที่ <?= $practice["PRE_CALL_PLACE"] ?></span>
                                                                            </div>
                                                                        </div>  <!-- ./row -->

                                                                        <div class=" mb-2 mt-4">
                                                                            <span></span>
                                                                        </div>
                                                                        <div class="row ">
                                                                            <div class="col-md">
                                                                                <label style="font-weight:bold;">วันรับจริง</label>
                                                                                <span ><?= $practice["GET_DATE"] ?>&nbsp;&nbsp;<?= $practice['GET_ROUND'] ?></span>
                                                                            </div>
                                                                        </div>  <!-- ./row -->
                                                                        <div class="row ">
                                                                            <div class="col-md">
                                                                                <label style="font-weight:bold;">เรียกแถวเวลา</label>
                                                                                <span ><?= $practice["GET_CALL"] ?>&nbsp;&nbsp;สถานที่<?= $practice['GETCALL_PLACE'] ?></span>
                                                                            </div>
                                                                        </div>  <!-- ./row -->
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? } ?>

                                            </div>
                                        </div>

                                    <? } ?>


                                    <div class="form-group mt-4 control-file-upload" style="display:<?= $action_control_class ?>">
                                        <div class="row">
                                            <!-- Column for displaying the image, shown first on mobile -->
                                            <div class="col-12 col-md-6 order-1 order-md-2">
                                                <img src="<?php echo base_url('assets/images/example.jpg'); ?>" alt="" class="img-fluid">
                                            </div>
                                            <!-- Column for file upload, shown second on mobile -->
                                            <div class="col-12 col-md-6 order-2 order-md-1">
                                                <label style="font-size: 1.2em;">เลือกไฟล์ภาพที่ต้องการอัพโหลด</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="userfile" name="userfile">
                                                    <label class="custom-file-label" for="userfile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }else{ ?>
                                    <div class="alert alert-solid-warning alert-bold" role="alert">
                                        <div class="alert-text text-center"> ติดต่อ โทร. 02-2445190-1 กองพัฒนานักศึกษา อาคาร 2 ชั้น 3</div>
                                    </div>
                                <?php } ?>

                            </div>

                            <div class="kt-portlet__foot control-file-upload" >
                                <div class="kt-form__actions">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="hidden" name="hid_std_code" id="hid_std_code" value="<?= $request["STD_CODE"] ?>" />
                                            <input type="hidden" name="hid_encrypt_code" id="hid_encrypt_code" value="<?= encrypt_data($request["STD_CODE"]) ?>" />

                                            <?php if($request_action_button == "show"){ ?>
                                                <button type="button" id="request_cancel" name="request_cancel" class="btn btn-warning">ยกเลิก</button>
                                                <button type="submit" id="request_save" name="request_save" class="btn btn-primary">บันทึกข้อมูล</button>
                                            <?php } ?>

                                            <?php if($practice_info_export == "show"){ ?>
                                                <button type="button" class="btn btn-info" id="export_pdf">พิมพ์บัตรซ้อมย่อย</button>
                                                <button type="button" class="btn btn-warning" id="export_regulator">ดาวน์โหลดระเบียบการแต่งกาย</button>
                                            <?php } ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </form>



            </div>
            <!--end::Portlet-->



