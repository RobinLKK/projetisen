document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("bg-music");
    const btn = document.getElementById("toggle-music");
    const welcome = document.getElementById("welcome-screen");

    if (!music || !btn || !welcome) {
        console.error("Un ou plusieurs éléments introuvables dans le DOM.");
        return;
    }

    let playing = false;

    function startExperience() {
        // Cache l'écran de bienvenue
        welcome.classList.add("hidden");

        // Le retire complètement après 1s
        setTimeout(() => {
            welcome.remove();
        }, 1000);

        // Lance la musique
        music.play().then(() => {
            playing = true;
            btn.textContent = "🔊";
        }).catch(err => {
            console.warn("Lecture bloquée par le navigateur :", err);
        });

        // Retire les écouteurs après la première interaction
        document.removeEventListener("click", startExperience);
        document.removeEventListener("keydown", startExperience);
    }

    document.addEventListener("click", startExperience);
    document.addEventListener("keydown", startExperience);

    // Bouton de mute / unmute
    btn.addEventListener("click", () => {
        if (playing) {
            music.pause();
            btn.textContent = "🔇";
        } else {
            music.play();
            btn.textContent = "🔊";
        }
        playing = !playing;
    });

    console.log("welcome.js chargé avec succès.");
});
