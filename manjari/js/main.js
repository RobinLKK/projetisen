function changerJour(nouveauJour) {
    window.location.href = "index.php?jour=" + nouveauJour;
}

function toggleAjoutPage() {
    const form = document.getElementById("form-ajout");
    form.style.display = (form.style.display === "none") ? "block" : "none";
}

document.addEventListener("DOMContentLoaded", () => {
    const dropArea = document.getElementById('media-upload');
    const inputFile = document.getElementById('fichier');

    if (dropArea && inputFile) {
        dropArea.addEventListener('dragover', e => {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('dragover');
        });

        dropArea.addEventListener('drop', e => {
            e.preventDefault();
            dropArea.classList.remove('dragover');
            inputFile.files = e.dataTransfer.files;
        });
    }
});
