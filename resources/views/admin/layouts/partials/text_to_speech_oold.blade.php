<script>
    const textToSpeech = {
        isSpeaking: false,
        isPaused: false,
        isResumed: false,
        isStopped: true,
        utterance: null,
        textForSpeech:null,
        synthesis:null,
        voice:null,

        canStop: function(){
            return !this.isStopped;
        },

        speakText: async function() {
            // const textInput = 'Hello I am saad I am working on it';
            const textInput = $('#text_to_speech').text();
            // const textInput = document.getElementById('text_to_speech').value;

            if (!textInput) return;
            this.textForSpeech = textInput;
            // Create speech synthesis instance
            this.synthesis = window.speechSynthesis;
            // const voices = await this.synthesis.getVoices();
            // console.log(voices)
            // this.voice = voices[0];
            // console.log(voices[0])
            // Create a new SpeechSynthesisUtterance instance
            this.utterance = new SpeechSynthesisUtterance();
            // this.utterance.voice = this.voice;
            this.utterance.rate = 0.9; // Speech rate (0.1 to 1)
            this.utterance.pitch = 1.2; // Speech pitch (0 to 2)
            //start
            //resume
            //pause
            // await loadVoices();
            this.utterance.text = textInput;
            this.utterance.addEventListener('end', ()=> {
                this.stop();

            });
            this.utterance.addEventListener('error', (e)=> {
                console.log(e);
                if (e && e.error && e.error === 'synthesis-failed'){
                    alert("This device is not supported for audio play.");
                    this.stop();
                }
            });

            // Speak the text
            this.synthesis.speak(this.utterance);
            this.play();
        },
        play: function() {
            console.log('play');
            if (this.utterance) {
                // console.log(this.utterance);
                this.synthesis.resume();
                this.isSpeaking = true;
                this.isPaused = false;
                this.isResumed = false;
                this.isStopped = false;
                this.hidePlay();
                this.showPause();
                this.showStop();

            }
        },

        showStop: function (){
            if (this.utterance) {
                // this.isStopped = false;
                document.getElementById('speech_stop').classList.toggle('d-none');
            }
        },
        hideStop: function (){
            if (this.utterance) {
                // this.isStopped = true;
                document.getElementById('speech_stop').classList.toggle('d-none');
            }
        },
        showPause: function (){
            if (this.utterance) {
                // this.isPaused = false;
                document.getElementById('speech_pause').classList.toggle('d-none');
            }
        },
        hidePause: function (){
            if (this.utterance) {
                // this.isPaused = true;
                document.getElementById('speech_pause').classList.toggle('d-none');
            }
        },
        showPlay: function (){
            if (this.utterance) {
                // this.isSpeaking = false;
                document.getElementById('speech_play').classList.toggle('d-none');
            }
        },
        hidePlay: function (){
            if (this.utterance) {
                // this.isSpeaking = true;
                document.getElementById('speech_play').classList.toggle('d-none');
            }
        },
        pause: function() {
// Get the user agent string.

            const userAgent = navigator.userAgent;

            // Parse the user agent string and extract the browser type and device type.
            const browserType = userAgent.match(/Chrome/i) ? 'Chrome' : userAgent.match(/Firefox/i) ? 'Firefox' : userAgent.match(/Safari/i) ? 'Safari' : 'Unknown';
            const deviceType = userAgent.match(/Android/i) ? 'Android' : userAgent.match(/iOS/i) ? 'iOS' : 'Desktop';

            if (this.utterance) {
                if(deviceType == 'Android' || deviceType == 'iOS'){
                    this.synthesis.cancel()
                }
                this.synthesis.pause();
                this.isPaused = true;
                textToSpeech.hidePause();
                this.isStopped = false;
                textToSpeech.hideStop();
                this.isSpeaking = false;
                textToSpeech.showPlay();
            }
        },
        resume: function() {
            const userAgent = navigator.userAgent;

            // Parse the user agent string and extract the browser type and device type.
            const browserType = userAgent.match(/Chrome/i) ? 'Chrome' : userAgent.match(/Firefox/i) ? 'Firefox' : userAgent.match(/Safari/i) ? 'Safari' : 'Unknown';
            const deviceType = userAgent.match(/Android/i) ? 'Android' : userAgent.match(/iOS/i) ? 'iOS' : 'Desktop';
            if (this.utterance) {

                this.synthesis.resume();
                if(deviceType == 'Android' || deviceType == 'iOS'){
                    this.speakText();
                    this.play();
                }
                this.isPaused = false;
                this.isStopped = false;
                this.isSpeaking = true;
                this.isResumed = true;
                textToSpeech.hidePlay();
                textToSpeech.showPause();
                textToSpeech.showStop();
            }
        },

        stop: function() {
            if (this.utterance) {
                this.synthesis.cancel();
                this.isStopped = true;
                this.isSpeaking = false;
                this.isPaused = true;
                this.isResumed = false;
                this.textForSpeech = null;
                this.hideStop();
                this.showPlay();
                this.hidePause();
            }
        },

        bindEventListeners: function() {
            const playButton = document.getElementById('speech_play');
            const pauseButton = document.getElementById('speech_pause');
            const stopButton = document.getElementById('speech_stop');

            playButton.addEventListener('click', this.handlePlayClick);
            // playButton.addEventListener('touchstart', this.handlePlayClick);

            pauseButton.addEventListener('click', this.handlePauseClick);
            // pauseButton.addEventListener('touchstart', this.handlePauseClick);

            stopButton.addEventListener('click', this.handleStopClick);
            // stopButton.addEventListener('touchstart', this.handleStopClick);
        },

        handlePlayClick: function(event) {
            event.preventDefault();
            if (textToSpeech.utterance) {
                console.log('handle');
                console.log(textToSpeech);
                // if (textToSpeech.isStopped) {
                //     textToSpeech.speakText();
                // } else {
                //     console.log(textToSpeech);
                //     if (textToSpeech.isPaused) {
                //         textToSpeech.resume();
                //     } else if (textToSpeech.isStopped) {
                //         textToSpeech.speakText();
                //     } else {
                //         console.log(textToSpeech);s
                //         console.log('else play');
                //         textToSpeech.play();
                //     }
                // }
                if (textToSpeech.isPaused) {
                    textToSpeech.resume();
                } else if (textToSpeech.isStopped) {
                    textToSpeech.speakText();
                } else {
                    console.log('else play');
                    textToSpeech.play();
                }
            } else {
                textToSpeech.speakText();
            }
            console.log(textToSpeech.estimatePlaybackTime())
        },

        handlePauseClick: function(event) {
            event.preventDefault();
            if (textToSpeech.isSpeaking) {
                textToSpeech.pause();
            }
        },

        handleStopClick: function(event) {
            event.preventDefault();
            if (!textToSpeech.isStopped) {
                textToSpeech.stop();
            }
        },
        estimatePlaybackTime: function (speechRate = 100) {
            // Count the number of words in the text
            const text = this.textForSpeech;
            // console.log(text);
            const wordCount = text.trim().split(/\s+/).length;
            // const wordCount = text.length;

            // Calculate the estimated playback time in seconds
            const playbackTime = (wordCount / speechRate) * 60;

            // Format the playback time into minutes and seconds
            const minutes = Math.floor(playbackTime / 60);
            const seconds = Math.floor(playbackTime % 60);

            // Return the estimated playback time as a formatted string
            return `${minutes} minutes ${seconds} seconds`;
        }
    };

    if (!('speechSynthesis' in window) || !('SpeechSynthesisUtterance' in window)) {
        // The Web Speech API is not supported in this browser
        let playButton = document.getElementById('speech_play');
        playButton.style.display = 'none';
    }

    window.onbeforeunload = function() {
        console.log('stooped function')
        textToSpeech.stop();
    };

    // Bind the event listeners when the page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        textToSpeech.bindEventListeners();
    });

    async function loadVoices() {
        // Check if voices are supported
        if ('speechSynthesis' in window && 'onvoiceschanged' in speechSynthesis) {
            await new Promise(resolve => {
                console.log(resolve);
                // debugger;
                speechSynthesis.onvoiceschanged = resolve;
            });

            // Now you can access and set voices if needed
            // const voices = speechSynthesis.getVoices();
            // console.log(voices);
        }
    }
</script>
