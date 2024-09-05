<div class="kt-portlet kt-portlet--height-fluid">
    <div class="kt-portlet__body">
        <div class="wrap-qrcode-scanner text-center">
                <div id="loadingMessage">Unable to access video stream (please make sure you have a webcam enabled)</div>
                <br><br>
                <canvas id="canvas" hidden></canvas>
                <div id="output" hidden>
                    <div id="outputMessage">No QR code detected.</div>
                    <div hidden><b>No :</b> <span id="outputData"></span>
                        <span id="outputdetail"></span>
                    </div>
                </div>
            <div>
            </div>
                <audio id="beepsound" controls>
                <source src="<?= base_url('assets/sound/scanner-beeps-barcode.mp3') ?>" type="audio/mpeg">
                Your browser does not support the audio tag.
                </audio>
                <img id="outputqrcode">
        </div>
    </div>

</div>
