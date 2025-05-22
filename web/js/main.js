// Ajout de l'effet de portail
document.addEventListener("DOMContentLoaded", () => {
    const playButton = document.querySelector(".play-button");
    const portal = document.createElement("div");
    portal.classList.add("page-transition");
    document.body.appendChild(portal);

    playButton.addEventListener("click", (event) => {
        event.preventDefault();
        portal.classList.add("active");
        setTimeout(() => {
            window.location.href = playButton.getAttribute("href");
        }, 800); // Durée de la transition
    });
});



function goBackSkippingEdit() {
            const historyEntriesToSkip = 2; 
            const forbiddenRef = "edit_profile.php";

            if (document.referrer.includes(forbiddenRef)) {
                window.history.go(-2);
            } else {
                window.history.back();
            }
        }