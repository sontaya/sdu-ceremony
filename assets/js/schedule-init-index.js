
$(document).ready(function() {
  console.log('schedule-init-index');

    $("#export_pdf").click(function(){

        var target_std = $("#hid_std_code").val();
        window.open(base_url+"schedule/export/"+ btoa(unescape(encodeURIComponent(target_std))));
    });




});
