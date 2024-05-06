function uploadImage() {
    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function(event) {
            var imageData = event.target.result;
            var image = new Image();
            image.src = imageData;
            document.getElementById('imagePreview').innerHTML = '';
            document.getElementById('imagePreview').appendChild(image);
            localStorage.setItem('uploadedImage', imageData);
        };
        reader.readAsDataURL(file);
    } else {
        alert('Please select an image to upload.');
    }
}