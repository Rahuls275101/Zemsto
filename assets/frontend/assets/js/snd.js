// JavaScript Document
function PlaySound(Path) {

  var audio = document.getElementById('audio');
  audio.setAttribute('src', Path);

 if (audio.paused) {
        audio.play();
    }else{
        audio.currentTime = 0
    }
	
  
  /*audioElement.volume = 9;
  audioElement.autoPlay = false;
  audioElement.preLoad = false;
  audioElement.controls = true;
  audioElement.loop = false;
  */
  
  
}
