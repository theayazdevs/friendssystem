//canvas to draw the image on
var canvas = document.getElementById('myCanvas');
var context = canvas.getContext('2d');
//image object
var imageObj = new Image();
//this will hold the image preview
var preview = document.getElementById('previewImage');
//object to read files
var reader = new FileReader();
var imageFromCanvas = new Image();
//set the preview image
function previewFile() {
    //get the file that has been selected
    var file = document.getElementById('fileButton').files[0];
    //when the File is loaded the reader reads it
    reader.addEventListener("load", function () {
        //file has been read now it can be set to the preview element
        preview.src = reader.result;
    }, false);
    // if a file has been chosen
    if (file) {
        //start reading the file
        reader.readAsDataURL(file);
    }

}
//crop the uploaded image
function crop(){
        var getSrc = document.getElementById("previewImage").src;
        //axis to choose the crop area of the image
        var xAxis = preview.naturalWidth;
        var yAxis = preview.naturalHeight;
        //console.log("Image-Width-Height" +xAxis + "-" + yAxis);
        document.getElementById('x').setAttribute("max", xAxis);
        document.getElementById('y').setAttribute("max", yAxis);
        //when the image is loaded runs the function
        imageObj.onload = function() {
        //to clear the canvas from previous image
        context.clearRect(0, 0, canvas.width, canvas.height);
        //get the value from X and Y sliders to change the position of the image
        var getX = document.getElementById('x').value;
        var getY = document.getElementById('y').value;
        //to resize the image to draw on the canvas
        var resizeW = 200;
        var resizeH = 200;
        //the width and height to draw the image in
        var theWidth = resizeW;
        var theHeight = resizeH;
        //X and Y top-left corners in which to put the image
        var axisX = canvas.width / 2 - theWidth / 2;
        var axisY = canvas.height / 2 - theHeight / 2;
        //draw image on the canvas
        context.drawImage(imageObj, getX, getY, resizeW, resizeH, axisX, axisY, theWidth, theHeight);
        //set the image to the canvas element with default PNG format
        imageFromCanvas.src = canvas.toDataURL();
        //console.log(imageFromCanvas);
    };
    imageObj.src = getSrc;
}
//download the cropped image
function canvasDownload(){
    //create a link element
    var link = document.createElement('a');
    //file name
    link.download = 'filename.png';
    //image link to download from as a PNG file
    link.href = canvas.toDataURL("image/png");
    link.click();
}