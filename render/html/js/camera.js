var video = document.querySelector("#videoElement");

navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia || navigator.oGetUserMedia;

if (navigator.getUserMedia) {
    navigator.getUserMedia({video: true}, handleVideo, videoError);
    document.getElementById('imgtag').style.cssText='display: none; visibility: hidden;';
  	document.getElementById('videoElement').style.cssText='display: block; visibility: show;';
    document.getElementById('save').style.cssText='display: block; visibility: show;';
}
else{

  document.getElementById('save').style.cssText='display: none; visibility: hidden;';
  document.getElementById('fileselect').style.cssText='display: block; visibility: show;';
    document.getElementById('imgtag').style.cssText='display: block; visibility: show;';
  	document.getElementById('videoElement').style.cssText='display: none; visibility: hidden;';
}

function handleVideo(stream) {
    video.src = window.URL.createObjectURL(stream);
}

function videoError(e) {
    // do something
}
var v,canvas,context,w,h;
var imgtag = document.getElementById('imgtag');
var sel = document.getElementById('fileselect');

document.addEventListener('DOMContentLoaded', function(){
    v = document.getElementById('videoElement');
    canvas = document.getElementById('canvas');
    context = canvas.getContext('2d');
  w = canvas.width;
    h = canvas.height;

},false);

function draw(v,c,w,h) {
    if(v.paused || v.ended) return false;
    context.drawImage(v,0,0,w,h);

   var uri = canvas.toDataURL("image/png");

  // console.log(uri);

   imgtag.src = uri;
}

document.getElementById('save').addEventListener('click',function(e){

  document.getElementById('save').value='Camera !';

  draw(v,context,w,h);

});
var fr;

sel.addEventListener('change',function(e){
  var f = sel.files[0];

  fr = new FileReader();
  fr.onload = receivedText;
  fr.readAsDataURL(f);
})

function receivedText() {
  imgtag.src = fr.result;
}
