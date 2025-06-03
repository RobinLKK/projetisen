document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("bg-music");
    const volumeSlider = document.getElementById("volume-slider");
    const sliderWrapper = document.getElementById("volume-slider-wrapper");
    const btn = document.getElementById("toggle-music");

    if (!music || !volumeSlider || !sliderWrapper || !btn) return;

    music.volume = parseFloat(volumeSlider.value);
    let autoHideTimeout;

    const updateIcon = () => {
        btn.textContent = music.volume === 0 ? "🔇" : "🔊";
    };

    const showSlider = () => {
        sliderWrapper.classList.add("show");
        clearTimeout(autoHideTimeout);
        autoHideTimeout = setTimeout(() => {
            sliderWrapper.classList.remove("show");
        }, 4000); // 4 secondes visibles
    };

    btn.addEventListener("click", () => {
        showSlider();
    });

    volumeSlider.addEventListener("input", () => {
        music.volume = parseFloat(volumeSlider.value);
        updateIcon();
        showSlider(); // prolonge la visibilité à chaque mouvement
    });

    const startPlayback = () => {
        music.play().catch((e) => {
            console.warn("Lecture refusée :", e);
        });
        document.removeEventListener("click", startPlayback);
        document.removeEventListener("keydown", startPlayback);
    };

    document.addEventListener("click", startPlayback);
    document.addEventListener("keydown", startPlayback);

    updateIcon(); // pour l'état initial
});
