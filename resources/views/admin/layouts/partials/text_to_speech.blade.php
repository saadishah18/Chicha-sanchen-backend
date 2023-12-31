<script>
    // Forked from https://codepen.io/ElaMoscicka/pen/MQyVbp - added pause/resume, default faster.

    const msg = new SpeechSynthesisUtterance();
    let voices = []; //empty array for voices
    // const voicesDropdown = document.querySelector('[name="voice"]');
    // const options = document.querySelectorAll('[type="range"], [name="text"]');
    // const rate = document.querySelector('#rate');
    const speakButton = document.querySelector('#speech_play'); //start to speak
    const stopButton = document.querySelector('#speech_stop'); //stop
    const pauseButton = document.querySelector('#speech_pause'); //pause
    const resumeButton = document.querySelector('#speech_resume'); //resume
    msg.text = document.querySelector('#text_to_speech').textContent;
    // console.log(stopButton);
    // console.log(pauseButton);
    // console.log(resumeButton);
    // debugger;


    // function populateVoices() {
    //     voices = this.getVoices();
    //     voicesDropdown.innerHTML = voices
    //         .filter(voice => voice.lang.includes('en')) // showing only english voices
    //         .map(voice => `<option value="${voice.name}">${voice.name} (${voice.lang})</option>`) //all of the voices
    //         .join('');
    // }

    // function setVoice() {
    //     msg.voice = voices.find(voice => voice.name === this.value); //loop over every single voices in the array and find the one where it's name attribute is the same as the option that was currently selected
    //     toggle();
    // }

    function toggle(startOver = true) {
        // alert('working')
        speechSynthesis.cancel();
        speakButton.classList.remove('d-none');
        pauseButton.classList.add('d-none');
        resumeButton.classList.add('d-none')
        stopButton.classList.add('d-none')
        //restart speaking
        if (startOver) {
            speechSynthesis.speak(msg);
            speakButton.classList.add('d-none');
            pauseButton.classList.remove('d-none');
            stopButton.classList.remove('d-none');
            // resumeButton.classList.remove('d-none');
        }
    }

    function pause() {
        const userAgent = navigator.userAgent;
        const deviceType = userAgent.match(/Android/i) ? 'Android' : userAgent.match(/iOS/i) ? 'iOS' : 'Desktop';
        if(deviceType == 'Android'){
            speechSynthesis.cancel()
        }
        speechSynthesis.pause();
        pauseButton.classList.add('d-none');
        resumeButton.classList.remove('d-none');
    }

    function resume() {
        console.log(speechSynthesis);
        const userAgent = navigator.userAgent;
        const deviceType = userAgent.match(/Android/i) ? 'Android' : userAgent.match(/iOS/i) ? 'iOS' : 'Desktop';
        if(deviceType == 'Android'){
            // if (speechSynthesis.speaking) {
            //     speechSynthesis.cancel();
            // }
            toggle();
        }
        speechSynthesis.resume();

        pauseButton.classList.remove('d-none');
        resumeButton.classList.add('d-none');
    }

    function setOption() {
        console.log(this.name, this.value);
        msg[this.name] = this.value;
        toggle();
    }

    msg.onend = function(event) {
        console.log('Utterance has finished ' + event.elapsedTime + ' milliseconds.');
        speakButton.classList.remove('d-none');
        pauseButton.classList.add('d-none');
        resumeButton.classList.add('d-none');
    }

    msg.rate = 0.9; // default rate on load
    msg.pitch = 1.2; // default rate on load
    // speechSynthesis.addEventListener('voiceschanged', populateVoices);
    // voicesDropdown.addEventListener('change', setVoice);
    // options.forEach(option => option.addEventListener('change', setOption));
    speakButton.addEventListener('click', toggle);
    pauseButton.addEventListener('click', pause);
    resumeButton.addEventListener('click', resume);
    stopButton.addEventListener('click', () => toggle(false));

</script>
