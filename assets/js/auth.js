  /*-- Auth: Check Ldap --*/
  $(document).ready(function () {

    console.log(base_url);

      $("#FormLogin").on('submit', function(e) {
        //console.log('Form Submit');
        //console.log($(this).serialize());
        e.preventDefault();
            var formData = {
              'username': $("#input_username").val(),
              'passwd' : $("#input_password").val()
            }
            console.log(formData);


            $.ajax({
                  url: base_url+"auth/login",
                  type: 'POST',
                  dataType: 'text',
                  data: formData,
                  success: function (ReturnData)
                  {
                    if(ReturnData['uid'] == ""){

                      //  window.location.href = 'http://datacenter.dusit.ac.th/DW/success-flash';
                      console.log('Login Fail!!');

                    }else{

                      // console.log('LDAP Login Successfully');
                      window.location.href = base_url;

                    }

                  },
                  error: function (request, status, message) {
                      console.log('Ajax Error!! ' + status + ' : ' + message);
                  },
              });




      });

  });
