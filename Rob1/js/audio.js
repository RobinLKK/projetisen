document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("bg-music");
    const volumeSlider = document.getElementById("volume-slider");

    if (!music || !volumeSlider) return;

    // Volume initial
    music.volume = parseFloat(volumeSlider.value);

    // Lecture automatique au clic ou touche clavier
    const startPlayback = () => {
        music.play().catch((e) => {
            console.warn("Lecture refusée :", e);
        });
        document.removeEventListener("click", startPlayback);
        document.removeEventListener("keydown", startPlayback);
    };

    document.addEventListener("click", startPlayback);
    document.addEventListener("keydown", startPlayback);

    // Réglage du volume
    volumeSlider.addEventListener("input", () => {
        music.volume = parseFloat(volumeSlider.value);
    });
});
