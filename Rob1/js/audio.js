document.addEventListener("DOMContentLoaded", () => {
    const music = document.getElementById("bg-music");
    const btn = document.getElementById("toggle-music");

    if (music && btn) {
        let playing = false;

        const toast = document.createElement("div");
        toast.textContent = "🎵 Musique activée";
        toast.id = "music-toast";
        document.body.appendChild(toast);

        function showToast() {
            toast.classList.add("show");
            setTimeout(() => toast.classList.remove("show"), 3000);
        }

        function playMusic() {
            if (!playing) {
                music.play().then(() => {
                    playing = true;
                    btn.textContent = "🔊";
                    showToast();
                }).catch((e) => {
                    console.log("Lecture bloquée par le navigateur :", e);
                });
            }
            document.removeEventListener("click", playMusic);
            document.removeEventListener("keydown", playMusic);
        }

        document.addEventListener("click", playMusic);
        document.addEventListener("keydown", playMusic);
        music.muted = false;

        btn.addEventListener("click", () => {
            if (playing) {
                music.pause();
                btn.textContent = "🔇";
            } else {
                music.play();
                btn.textContent = "🔊";
                showToast();
            }
            playing = !playing;
        });
    }
});


