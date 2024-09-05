"use strict";

// Class Definition
var KTLoginGeneral = function() {

    var login = $('#kt_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">'+msg+'</div>\
			<div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        KTUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }


    var displaySignInForm = function() {
        login.removeClass('kt-login--forgot');
        login.removeClass('kt-login--signup');

        login.addClass('kt-login--signin');
        KTUtil.animateClass(login.find('.kt-login__signin')[0], 'flipInX animated');
        //login.find('.kt-login__signin').animateClass('flipInX animated');
    }

    var formData = {
        'username': $("#login_name").val(),
        'passwd' : $("#login_password").val()
    }





    var handleSignInFormSubmit = function() {
        $('#kt_login_signin_submit').click(function(e) {
            console.log('kt_login_signin_submit:click');
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    login_name: {
                        required: true,
                    },
                    login_password: {
                        required: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: base_url+"admin/do_login",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function(response, status, xhr, $form) {
                    console.log(response);

                	// similate 2s delay
                	setTimeout(function() {

                        btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                        if(response === false){
                            console.log('Login Fail!!');
                            setTimeout(function () {
                                        showErrorMsg(form, 'warning', 'ข้อมูลไม่ถูกต้อง กรุณาลองอีกครั้ง');
                            }, 500);
                        }else{
                            window.location.href = base_url+'admin';
                        }



                    }, 2000);


                }
            });
        });
    }




    // Public Functions
    return {
        // public functions
        init: function() {
            handleSignInFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLoginGeneral.init();
});
