
    // const music = document.getElementById("bg-music");
    // const btn = document.getElementById("toggle-music");
    // const welcome = document.getElementById("welcome-screen");
    // let playing = false;

    // function startExperience() {
    //     welcome.classList.add("hidden");

    //     // Attendre la fin de l’animation avant de retirer le DOM
    //     setTimeout(() => {
    //         welcome.remove();
    //     }, 1000);

    //     music.play().then(() => {
    //         playing = true;
    //         btn.textContent = "🔊";
    //     }).catch(err => {
    //         console.log("Erreur lecture :", err);
    //     });

    //     document.removeEventListener("click", startExperience);
    //     document.removeEventListener("keydown", startExperience);
    // }

    // document.addEventListener("click", startExperience);
    // document.addEventListener("keydown", startExperience);

    // btn.addEventListener("click", () => {
    //     if (playing) {
    //         music.pause();
    //         btn.textContent = "🔇";
    //     } else {
    //         music.play();
    //         btn.textContent = "🔊";
    //     }
    //     playing = !playing;
    // });
