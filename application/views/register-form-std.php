
    <div class="row">
        <div class="col-md" style="font-size: 1.5em;">
            <label for="student_id">รหัสนักศึกษา : </label>
            <?= $profile["STD_CODE"]; ?>
        </div>

    </div>  <!-- ./row -->
    <div class="row">
        <div class="col-md" style="font-size: 1.5em;">
            <label for="fullname">ชื่อ - นามสกุล : </label> <?= $profile["PREFIX_NAME_TH"];?> <?= $profile["FIRST_NAME_TH"];?> <?= $profile["LAST_NAME_TH"];?>
        </div>
    </div>  <!-- ./row -->

    <div class="row">
        <div class="col-md" style="font-size: 1.5em;">
            <label for="major">หลักสูตร : </label>
            <?= $profile["DEGREENAMETH"];?>
        </div>
    </div>  <!-- ./row -->


    <?php
        if(($profile["GRAD_CONFIRM_STATUS"] != "N" ) && ($profile["STD_CONFIRM_STATUS"] == "")){
    ?>

        <form id="FormRegister" class="kt-form kt-form--label-right" >
            <div class="kt-portlet__body">


                <div class="form-group mt-4" >
                    <label style="font-size: 1.5em;">แจ้งความประสงค์การเข้ารับปริญญา</label>
                    <div class="kt-radio-inline">
                        <label class="kt-radio kt-radio--bold kt-radio--brand">
                            <input type="radio" name="confirm_status" value="Y"> เข้ารับ
                            <span></span>
                        </label>
                        <label class="kt-radio kt-radio--bold kt-radio--brand">
                            <input type="radio" name="confirm_status" value="N"> ไม่เข้ารับ
                            <span></span>
                        </label>

                    </div>
                </div>

            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="hidden" name="std_code" id="std_code" value="<?= $profile["STD_CODE"] ?>" />
                            <button type="submit" id="register_save" name="register_save" class="btn btn-primary btn-lg">บันทึกข้อมูล</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>

    <?
        }else{
            if($profile["GRAD_CONFIRM_STATUS"] == "Y" && $profile["STD_CONFIRM_STATUS"] == "Y"){
                $icon_class = "kt-iconbox--success";
                $text_class = "text-success";
                $text_caption = "ยืนยันการเข้ารับพระราชทานปริญญาบัตรประจำปี 2560 – 2562";
            }

            if($profile["GRAD_CONFIRM_STATUS"] == "" && $profile["STD_CONFIRM_STATUS"] == "Y"){
                $icon_class = "kt-iconbox--warning";
                $text_class = "text-warning";
                $text_caption = "ติดต่อรายงานตัวที่ กองพัฒนานักศึกษา อาคาร 2 ชั้น 3  โทร 02-2445190-1 <br> ภายในวันที่ 2 สิงหาคม 2565";
            }

            if(($profile["GRAD_CONFIRM_STATUS"] == "N") || ($profile["STD_CONFIRM_STATUS"] == "N")){

                $icon_class = "kt-iconbox--secondary";
                $text_class = "text-gray";
                $text_caption = "ไม่เข้ารับพระราชทานปริญญาบัตรประจำปี 2560 – 2562";
            }

    ?>

        <form id="FormConfirm" class="kt-form kt-form--label-right">
            <div class="kt-portlet__body">

                <div class="kt-portlet kt-iconbox <?= $icon_class ?> kt-iconbox--animate-slow">
                    <div class="kt-portlet__body">
                        <div class="kt-iconbox__body">
                            <div class="kt-iconbox__icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"></path>
                                        <path d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z" fill="#000000"></path>
                                        <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"></path>
                                    </g>
                                </svg> </div>
                            <div class="kt-iconbox__desc">
                                <div class="kt-iconbox__content">
                                    <h2 class="<?= $text_class ?>">
                                        <?= $text_caption ?>
                                    </h2>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="kt-portlet__foot">

            </div>
        </form>

    <? } ?>





