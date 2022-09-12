"use strict";

// Class Definition
var KTLoginV1 = function () {
	var login = $('#kt_login');

	var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-bold alert-solid-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">'+msg+'</div>\
			<div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        KTUtil.animateClass(alert[0], 'fadeIn animated');
    }

	// Private Functions
	var handleSignInFormSubmit = function () {
		$('#kt_login_signin_submit').click(function (e) {
			e.preventDefault();

            var formData = {
                'username': $("#input_username").val(),
                'passwd' : $("#input_password").val()
            }

            console.log(formData);
			var btn = $(this);
			var form = $('#kt_login_form');

			form.validate({
				rules: {
					username: {
						required: true
					},
					password: {
						required: true
					}
				}
			});

			if (!form.valid()) {
				return;
			}

			KTApp.progress(btn[0]);

			setTimeout(function () {
				KTApp.unprogress(btn[0]);
			}, 2000);

			// ajax form submit:  http://jquery.malsup.com/form/
			form.ajaxSubmit({
                url: base_url+"auth/login",
                type: 'POST',
                dataType: 'json',
                data: formData,
				success: function (response, status, xhr, $form) {

                    console.log(response);

                    if(response === false){
                        console.log('Login Fail!!');
                        setTimeout(function () {
                                    KTApp.unprogress(btn[0]);
                                    showErrorMsg(form, 'warning', 'ข้อมูลไม่ถูกต้อง กรุณาลองอีกครั้ง');
                        }, 500);
                    }else{
                        window.location.href = base_url+'practice';
                    }

                    // if(response.uid != ""){
                    //     window.location.href = base_url+'register';
                    // }else{
                    //     setTimeout(function () {
                    //         KTApp.unprogress(btn[0]);
                    //         showErrorMsg(form, 'warning', 'ข้อมูลไม่ถูกต้อง กรุณาลองอีกครั้ง');
                    //     }, 2000);
                    // }
                    // console.log(response);
				}
			});
		});
	}

	// Public Functions
	return {
		// public functions
		init: function () {
			handleSignInFormSubmit();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function () {
	KTLoginV1.init();
});
