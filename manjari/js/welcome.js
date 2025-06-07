document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("bg-music");
    const welcome = document.getElementById("welcome-screen");

    if (!music || !welcome) {
        console.error("Éléments manquants : #bg-music ou #welcome-screen");
        return;
    }

    let playing = false;

    function startExperience() {
        welcome.classList.add("hidden");
        setTimeout(() => welcome.remove(), 1000);

        music.play().then(() => {
            playing = true;
        }).catch(err => {
            console.warn("Lecture bloquée :", err);
        });

        document.removeEventListener("click", startExperience);
        document.removeEventListener("keydown", startExperience);
    }

    document.addEventListener("click", startExperience);
    document.addEventListener("keydown", startExperience);
});
