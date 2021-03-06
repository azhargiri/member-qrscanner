<!DOCTYPE html>
<html>
  <head>
    <title>QR Test</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&display=swap" rel="stylesheet"> 
    <style>
      body {
        font-family: "Roboto", sans;
     }
      #preview img {
        border: 1px solid black;
        float: left;
        margin: 0 1em 1em 0;
        width: 10em;
      }
      .camera-container {
            width: 100%;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <div class="camera-container">
        <h1>Scan QR Code</h1>

        <div id="loadingMessage"> Unable to access video stream (please make sure you have a webcam enabled)</div>
        <noscript>Javascript enabled browser needed</noscript>
        <canvas id="canvas" hidden></canvas>
	<div id="output" hidden>
		<div id="outputMessage">Arahkan kamera ke QR code untuk memindai</div>
		<div hidden><b>Data:</b> <span id="outputData"></span></div>
	</div>
    </div>

    <script type="text/javascript" src="node_modules/jsqr/dist/jsQR.js"></script>

    <script type="text/javascript">
      (function() {
        'use strict';
		const findMember = function(id)
		{
            const member_route = '<?= make_route_of_path('/member', ['id' => '']) ?>'
			location.assign(member_route + id);
		}

		var video = document.createElement("video");
		var canvasElement = document.getElementById("canvas");
		var canvas = canvasElement.getContext("2d");
		var loadingMessage = document.getElementById("loadingMessage");
		var outputContainer = document.getElementById("output");
		var outputMessage = document.getElementById("outputMessage");
		var outputData = document.getElementById("outputData");
		var qrFound = false
		var lastScanner = new Date;
		var scanDelay = 1000;

		function drawLine(begin, end, color) {
		  canvas.beginPath();
		  canvas.moveTo(begin.x, begin.y);
		  canvas.lineTo(end.x, end.y);
		  canvas.lineWidth = 4;
		  canvas.strokeStyle = color;
		  canvas.stroke();
		}


		if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
			// Use facingMode: environment to attemt to get the front camera on phones
			navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
			  video.srcObject = stream;
			  video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
			  video.play();
			  requestAnimationFrame(tick);
			})
		} else {
			loadingMessage.innerText = 'Unsupported browser. Try Firefox, Chrome, Safari, or Edge.'
		}
		

		function tick() {
		  if (qrFound) {
			  return true
		  }

		  loadingMessage.innerText = "??? Loading video..."
		  if (video.readyState === video.HAVE_ENOUGH_DATA) {
			loadingMessage.hidden = true;
			canvasElement.hidden = false;
			outputContainer.hidden = false;

			canvasElement.height = video.videoHeight;
			canvasElement.width = video.videoWidth;
			canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
			var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
			var code;

			if ((new Date) - lastScanner > scanDelay) {
				code = jsQR(imageData.data, imageData.width, imageData.height, {
				  inversionAttempts: "dontInvert",
				});

				lastScanner = new Date;
			}

			if (code) {
			  drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58");
			  drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58");
			  drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58");
			  drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58");
			  outputMessage.hidden = true;
			  outputData.parentElement.hidden = false;
			  outputData.innerText = code.data;

			  if (code.data) {
				qrFound = true;
				// video.pause();

				findMember(code.data);
			  }

			} else {
			  outputMessage.hidden = false;
			  outputData.parentElement.hidden = true;
			}
		  }
		  requestAnimationFrame(tick);
		}

      })();
    </script>
  </body>
</html>
