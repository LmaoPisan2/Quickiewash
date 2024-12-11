// custom.js

const viewBuktiModal = document.getElementById('viewBuktiModal');

viewBuktiModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const buktiUrl = button.getAttribute('data-bukti'); // Get the URL from data-bukti attribute
    const buktiImage = document.getElementById('buktiImage'); // The image element inside the modal
    const buktiText = document.getElementById('buktiText'); // The text element in case of no image

    console.log("Bukti URL:", buktiUrl); // Log the bukti URL

    if (buktiUrl) {
        buktiImage.src = buktiUrl;
        buktiImage.classList.remove('d-none');  // Show the image
        buktiText.classList.add('d-none');      // Hide the text indicating no image
    } else {
        buktiImage.classList.add('d-none');    // Hide the image if no URL
        buktiText.classList.remove('d-none');  // Show the "No image" text
    }
});
