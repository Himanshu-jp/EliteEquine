const fileInput = document.getElementById('fileInput');
const uploadImage = document.getElementById('uploadTrigger');

uploadImage.addEventListener('click', () => fileInput.click());

fileInput.addEventListener('change', (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      uploadImage.src = e.target.result; // Replace image with uploaded preview
    };
    reader.readAsDataURL(file);
  }
});


 document.querySelectorAll('.select2-selection__rendered').forEach(function (el) {
    el.addEventListener('wheel', function (e) {
      if (e.deltaY !== 0) {
        e.preventDefault();
        el.scrollLeft += e.deltaY;
      }
    });
  });