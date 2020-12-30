
//import * as funciones from './funciones.js';

document.addEventListener('DOMContentLoaded', init)
function init() {
    document.querySelectorAll('.btn.btn-delete').forEach(element => {
        element.addEventListener('click', eliminar)
    });
    modal()
}
function modal() {
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
    }
    // cerrando modal en el boton
    for (const el of closeEls) {
        el.addEventListener("click", function (e) {
            e.preventDefault();
            this.parentElement.parentElement.parentElement.parentElement.parentElement.classList.remove(isVisible);
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
function eliminar(e){
    e.preventDefault();
    if (e.target.classList.contains('btn-delete')) {
        e.target.parentElement.parentElement.remove();
        let id = e.target.dataset.id;
        let data = {
            id
        };
        console.log(data);
        fetch(`/entityclassPL.php?urloper=find&pn=0&id=${id}`, {
            method: 'PUT',
            body: JSON.stringify(data),
            header: new Headers()
        })
            .then((res) => res.text())
            .then((data) => {
                if (data === 'eliminado') {
                    document.innerHTML =
                        `
                <div class="alert alert-success" role="alert">
                Registro Eliminado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span class="eliminar" aria-hidden="true">&times;</span>
                </button>
                </div>
                
                `;
                }
                //console.log(datos);
            })
            .catch((e) => console.error('Error al eliminar!'));
    };
}