
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
                    <div class="filter-company-container">
                        <label>
                            <span>Nombre entityClass :</span>
                            <input autocomplete="off" name="entityclassInput" class="filter-company" type="text" id="entityclassInput" required placeholder="Nombre entityClass">
                        </label>
                        <select name="entityclassSelect" required class="menu-company hide" id="entityclassSelect" multiple="multiple">
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