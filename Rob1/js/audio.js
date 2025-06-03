document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("bg-music");
    const volumeSlider = document.getElementById("volume-slider");
    const sliderWrapper = document.getElementById("volume-slider-wrapper");
    const btn = document.getElementById("toggle-music");

    if (!music || !volumeSlider || !sliderWrapper || !btn) return;

    music.volume = parseFloat(volumeSlider.value);

    const startPlayback = () => {
        music.play().catch((e) => {
            console.warn("Lecture refusée :", e);
        });
        document.removeEventListener("click", startPlayback);
        document.removeEventListener("keydown", startPlayback);
    };

    document.addEventListener("click", startPlayback);
    document.addEventListener("keydown", startPlayback);

    volumeSlider.addEventListener("input", () => {
        music.volume = parseFloat(volumeSlider.value);
    });

    // Toggle visibilité du slider fluo
    btn.addEventListener("click", () => {
        sliderWrapper.classList.toggle("show");
    });
});
