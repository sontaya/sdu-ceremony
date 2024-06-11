
$(document).ready(function() {
  console.log('!!register-form');

  $.extend( $.validator.messages, {
    required: "โปรดระบุ",
    remote: "โปรดแก้ไขให้ถูกต้อง",
    email: "โปรดระบุที่อยู่อีเมล์ที่ถูกต้อง",
    url: "โปรดระบุ URL ที่ถูกต้อง",
    date: "โปรดระบุวันที่ ที่ถูกต้อง",
    dateISO: "โปรดระบุวันที่ ที่ถูกต้อง (ระบบ ISO).",
    number: "โปรดระบุทศนิยมที่ถูกต้อง",
    digits: "โปรดระบุจำนวนเต็มที่ถูกต้อง",
    creditcard: "โปรดระบุรหัสบัตรเครดิตที่ถูกต้อง",
    equalTo: "โปรดระบุค่าเดิมอีกครั้ง",
    extension: "โปรดระบุค่าที่มีส่วนขยายที่ถูกต้อง",
    maxlength: $.validator.format( "โปรดอย่าระบุค่าที่ยาวกว่า {0} อักขระ" ),
    minlength: $.validator.format( "โปรดอย่าระบุค่าที่สั้นกว่า {0} อักขระ" ),
    rangelength: $.validator.format( "โปรดอย่าระบุค่าความยาวระหว่าง {0} ถึง {1} อักขระ" ),
    range: $.validator.format( "โปรดระบุค่าระหว่าง {0} และ {1}" ),
    max: $.validator.format( "โปรดระบุค่าน้อยกว่าหรือเท่ากับ {0}" ),
    min: $.validator.format( "โปรดระบุค่ามากกว่าหรือเท่ากับ {0}" )
  } );


  $("#FormRegister").validate({
    onkeyup: false,
    onclick: false,
    onfocusout: false,
    errorClass: 'custom-error',
    rules:{
        confirm_status: "required"
    },
    messages:{

    },
    invalidHandler: function(form, validator) {
      submitted = true;
    },
    errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
        $(placement).append(error)
        } else {
            error.insertAfter(element);
        }
    },
    submitHandler: function(form, event) {

      console.log("[debug] submitHandler");

      event.preventDefault();


        swal.fire({
            title: 'ยืนยันข้อมูล',
            text: "บันทึกข้อมูลความประสงค์การเข้ารับปริญญา",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยันข้อมูล',
            cancelButtonText: 'ยกเลิก',
        }).then(function(result) {
            if (result.value) {

                  var formData = {
                    'confirm_status': $('input[name=confirm_status]:checked', '#FormRegister').val(),
                    'std_code': $("#std_code").val()
                  };

                  console.log(formData);

                  $.ajax({
                        url: base_url+"register/form_store",
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        success: function (res)
                        {
                            window.location.href = base_url+'register/index';

                        },
                        error: function (request, status, message) {
                            console.log('Ajax Error!! ' + status + ' : ' + message);
                        },
                    });


            }
        });




    //   form.submit();

    }
  });



  $("#FormConfirm").on('submit', function(e) {
    //console.log('Form Submit');
    //console.log($(this).serialize());
    e.preventDefault();
        var formData = {
          'register_id': $("#register_id").val(),
        }
        // console.log(formData);


        $.ajax({
              url: base_url+"register/form_confirm_store",
              type: 'POST',
              dataType: 'json',
              data: formData,
              success: function (res)
              {

                window.location.href = base_url+'register/index';
                // console.log(res);
                // var resRegister = res[0];
                // $("#vc_register_date").html(resRegister.SLOT_DATE_TH);
                // $("#vc_register_desc").html(resRegister.SLOT_DESC);
                // $("#register_id").val(resRegister.REGISTER_ID);

                // $("#FormRegister").hide();
                // $("#FormConfirm").fadeIn("slow");

              },
              error: function (request, status, message) {
                  console.log('Ajax Error!! ' + status + ' : ' + message);
              },
          });
  });



    $("#register_cancel").click(function(){
        var formData = {
            'register_id': $("#register_id").val(),
          }
          // console.log(formData);
          $.ajax({
                url: base_url+"register/form_confirm_delete",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function (res)
                {
                  window.location.href = base_url+'auth/logout';
                },
                error: function (request, status, message) {
                    console.log('Ajax Error!! ' + status + ' : ' + message);
                },
            });
    });




});
