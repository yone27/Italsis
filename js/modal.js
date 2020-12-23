/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

export default function () {
    // Codigo del Modal
    const openEls = document.querySelectorAll("[data-open]");
    const closeEls = document.querySelectorAll("[data-close]");
    const isVisible = "is-visible";
    // abrir modales
    for (const el of openEls) {
        el.addEventListener("click", function () {
            const modalId = this.dataset.open;
            document.getElementById(modalId).classList.add(isVisible);
        });
        // cerrando modal en el boton
        for (const el of closeEls) {
            el.addEventListener("click", function () {
                this.parentElement.parentElement.parentElement.classList.remove(isVisible);
            });
            // cerrando modal por fuera
            document.addEventListener("click", e => {
                if (e.target == document.querySelector(".modal.is-visible")) {
                    document.querySelector(".modal.is-visible").classList.remove(isVisible);
                }
                //presionando escape
                document.addEventListener("keyup", e => {
                    if (e.key == "Escape" && document.querySelector(".modal.is-visible")) {
                        document.querySelector(".modal.is-visible").classList.remove(isVisible);
                    }
                });
            });
        }

    }
}