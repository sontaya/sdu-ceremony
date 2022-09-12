
$(document).ready(function() {
  console.log('!!register-index');

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
