
<div class="modal" id="formEntitySubClass">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="entitySubClass">
                <header class="modal-header">
                    <h4 class="modal-title">Agregar Registro Entity Sub Class</h4>
                    <button class="close-modal" id="modal2" type="button" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <?php
                    presentationLayerY::buildInput("code", "code", "", "", "50","","","required");
                    presentationLayerY::buildInput("name", "name", "", "", "50","","","required");
                    ?>
                    <div class="filter">
                        <div class="filter__containerInput">
                            <label>Nombre entityClass :</label>
                            <input  class="filter__input" name="entityclassInput" id="entityclassInput" type="text" required placeholder="Nombre entityClass" autocomplete="off">
                        </div>
                        <select class="filter__select hide" name="entityclassSelect" id="entityclassSelect" required  multiple="multiple">
                        </select>
                    </div>
                    <label>
                        <span>observation :</span>
                        <textarea class="form-control" name="observation" placeholder="Comentario..."></textarea>
                    </label>
                </aside>
                <footer class="modal-footer">
                    <button class="btn btn-default" type="button" aria-label="close modal" data-close>Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </footer>
            </form>
        </section>
    </div>
</div>