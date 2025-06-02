document.addEventListener("DOMContentLoaded", () => {
    const desc = document.getElementById("dynamic-desc");
    const text = "Un jour, j'irais sur Saturne ";
    let i = 0;
    let adding = true;

    function animate() {
        if (adding) {
            desc.textContent = text.slice(0, i) + "|";
            i++;
            if (i > text.length) {
                adding = false;
                setTimeout(animate, 1500);
                return;
            }
        } else {
            desc.textContent = (i > 0 ? text.slice(0, i) + "|" : "_");
            i--;
            if (i < 0) {
                adding = true;
                i = 1; // redémarre avec le 1er caractère
                setTimeout(animate, 1000);
                return;
            }
        }
        setTimeout(animate, 100); // vitesse de l'effet
    }

    animate();
});
