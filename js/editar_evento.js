var listenerAdded = false;

function preparingForShowImage() {
    if (!listenerAdded) {
        const file = document.getElementById("file_image");
        file.onchange = function(imageFile) {
            if (imageFile) {
                imageAdded(imageFile.target.files[0]);
            }
        }
        listenerAdded = true;
    }
}

function imageAdded(imageFile) {
    var imageNode = document.getElementById("preview_image");
    var imagePreview = new FileReader();
    imagePreview.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(imageNode);
    imagePreview.readAsDataURL(imageFile);
}