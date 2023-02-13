URL = window.URL || window.webkitURL;

let gumStream;
let rec;
let input;

let AudioContext = window.AudioContext || window.webkitAudioContext;
let audioContext

let recordButton = document.getElementById("recordButton");
let stopButton = document.getElementById("stopButton");
let pauseButton = document.getElementById("pauseButton");

recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);
pauseButton.addEventListener("click", pauseRecording);

function startRecording() {
	let constraints = { audio: true, video:false }

	recordButton.disabled = true;
	stopButton.disabled = false;
	pauseButton.disabled = false

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {

		audioContext = new AudioContext();

		document.getElementById("formats").innerHTML="Format: 1 channel pcm @ "+audioContext.sampleRate/1000+"kHz"

		gumStream = stream;

		input = audioContext.createMediaStreamSource(stream);

		rec = new Recorder(input,{numChannels:1})

		rec.record()

	}).catch(function(err) {
		recordButton.disabled = false;
		stopButton.disabled = true;
		pauseButton.disabled = true
	});
}

function pauseRecording(){
	if (rec.recording){
		rec.stop();
		pauseButton.innerHTML="Resume";
	}else{
		rec.record()
		pauseButton.innerHTML="Pause";

	}
}

function stopRecording(validAudio=false) {
	stopButton.disabled = true;
	recordButton.disabled = false;
	pauseButton.disabled = true;

	pauseButton.innerHTML="Pause";

	rec.stop();

	gumStream.getAudioTracks()[0].stop();

	if (validAudio) {
		rec.exportWAV(createDownloadLink);
	}
}

function createDownloadLink(blob) {
	let url = URL.createObjectURL(blob);
	let au = document.createElement('audio');
	let li = document.createElement('b');
	let filename = new Date().toISOString();

	var xhr=new XMLHttpRequest();
	xhr.onload=function(e) {
		if(this.readyState === 4) {}
	};
	var fd=new FormData();
	fd.append("audio_data",blob, filename);
	fd.append("is_audio", true);

	axios.post($('#send').val(), fd).then(function (response){});

	au.controls = true;
	au.src = url;
	li.appendChild(au);
	$('#recordingsList').append(li);
	recordingsList.appendChild(li);

	let newMes = `
		<div class="col-9 ml-auto">
			<div class="row no-gutters justify-content-end">
				<div class="col-12">
					<p class="s-12 fw-400 text-gray-500 text-right mb-0">${new Date().toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true })}</p>
				</div>
				<div class="col-auto ml-auto p-2 bg-user-right rounded-10">
				<div id="formats" style="display: none;"></div>
					<p class="s-16 mb-0 text-dark">${recordingsList.innerHTML}</p>
				</div>
			</div>
		</div>
	`;
	$('.chat--data #chat-scroll').children().append(newMes);
	setTimeout(function(){
		let objDiv = document.getElementById("chat-scroll");
		objDiv.scrollTop = objDiv.scrollHeight;
	}, 600);
	recordingsList.innerHTML='';
}