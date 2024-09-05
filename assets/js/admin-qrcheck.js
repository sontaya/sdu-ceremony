
var video = document.createElement("video");
var canvasElement = document.getElementById("canvas");
var canvas = canvasElement.getContext("2d");
var loadingMessage = document.getElementById("loadingMessage");
var outputContainer = document.getElementById("output");
var outputMessage = document.getElementById("outputMessage");
var outputData = document.getElementById("outputData");
var outputdetail = document.getElementById("outputdetail");
var beepsound = document.getElementById("beepsound");
var outputQrcode = document.getElementById('outputqrcode');
var TLR,TRR,BRL,BLL;
var code;
var waiting;

function drawLine(begin, end, color) {
    canvas.beginPath();
    canvas.moveTo(begin.x, begin.y);
    canvas.lineTo(end.x, end.y);
    canvas.lineWidth = 3;
    canvas.strokeStyle = color;
    canvas.stroke();
    return true;
}
// Use facingMode: environment to attemt to get the front camera on phones
navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
    video.srcObject = stream;
    video.setAttribute("playsinline", true);
    video.play();
    requestAnimationFrame(tick);
});

function tick() {
  loadingMessage.innerText = "Loading video..."
  if (video.readyState === video.HAVE_ENOUGH_DATA) {
    loadingMessage.hidden = true;
    canvasElement.hidden = false;
    outputContainer.hidden = false;

    canvasElement.height = video.videoHeight;
    canvasElement.width = video.videoWidth;
    canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
    if(!video.paused){
        var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
         code = jsQR(imageData.data, imageData.width, imageData.height, {
          inversionAttempts: "dontInvert",
        });
    }
    if (code) {
      TLR = drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
      TRR = drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
      BRL = drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
      BLL = drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
      outputMessage.hidden = true;
      outputData.parentElement.hidden = false;
      outputData.innerText = code.data;

      if(code.data!="" && !waiting && TLR==true && TRR==true && BRL==true && BLL==true ){
          console.log(code.data);

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": true,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };



        var formData = {
            'enc_target': code.data,
        }
          // console.log(formData);
          $.ajax({
                url: base_url+"admin/do_scan",
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function (res)
                {
                    // console.log(res);
                    toastr.success(res.FULLNAME, "บันทึกเวลา");
                },
                error: function (request, status, message) {
                    console.log('Ajax Error!! ' + status + ' : ' + message);
                },
            });

        video.pause();
        beepsound.play();
        beepsound.onended = function() {
            beepsound.muted = true;
        };

        // ให้เริ่มเล่นวิดีโอก่อนล็กน้อย เพื่อล้างค่ารูป qrcod ล่าสุด เป็นการใช้รูปจากกล้องแทน
        setTimeout(function(){
            video.play();
        },4500);
        // ให้รอ 5 วินาทีสำหรับการ สแกนในครั้งจ่อไป
         waiting = setTimeout(function(){
             TLR,TRR,BRL,BLL = null;
            beepsound.muted = false;
            if(waiting){
                clearTimeout(waiting);
                waiting = null;
            }
          },5000);
      }
    } else {
      outputMessage.hidden = false;
      outputData.parentElement.hidden = true;
    }
  }
  requestAnimationFrame(tick);
}
