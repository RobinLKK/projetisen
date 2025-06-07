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

function toggleEdition() {
    const panel = document.getElementById("edition-panel");
    const deleteButtons = document.querySelectorAll(".delete-button");

    // On toggle la classe .visible pour l'animation
    panel.classList.toggle("visible");

    // Affichage ou non des boutons ❌ en fonction de l’état du panneau
    const isVisible = panel.classList.contains("visible");
    deleteButtons.forEach(btn => {
        btn.style.display = isVisible ? "inline" : "none";
    });
}

