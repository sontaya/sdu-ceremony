
$(document).ready(function() {
  console.log('!!request-index');

    $("#kt_photo_edit").click(function(){
        console.log('#kt_photo_edit:click');

        $(".control-file-upload").fadeIn("slow");
        // control-file-upload
        // var formData = {
        //     'register_id': $("#register_id").val(),
        //   }
        //   // console.log(formData);
        //   $.ajax({
        //         url: base_url+"register/form_confirm_delete",
        //         type: 'POST',
        //         dataType: 'json',
        //         data: formData,
        //         success: function (res)
        //         {
        //           window.location.href = base_url+'auth/logout';
        //         },
        //         error: function (request, status, message) {
        //             console.log('Ajax Error!! ' + status + ' : ' + message);
        //         },
        //     });
    });

    $("#request_cancel").click(function(){
        $(".control-file-upload").hide();
    });


    $("#export_pdf").click(function(){
        // var formData = {
        //     'register_id': $("#register_id").val(),
        //   }
        //   // console.log(formData);
        //   $.ajax({
        //         url: base_url+"register/form_confirm_delete",
        //         type: 'POST',
        //         dataType: 'json',
        //         data: formData,
        //         success: function (res)
        //         {
        //           window.location.href = base_url+'auth/logout';
        //         },
        //         error: function (request, status, message) {
        //             console.log('Ajax Error!! ' + status + ' : ' + message);
        //         },
        //     });
        var target_id = $("#hid_encrypt_code").val();
        window.open(base_url+"export/id/"+ target_id);
        // window.open(base_url+"export/id/"+ btoa(unescape(encodeURIComponent(target_id))));

    });

    $("#export_regulator").click(function(){
        window.open(base_url+"assets/pdf/regulations.pdf");
    });
});
