<div class="modal" id="tableEntitySubClassEditModal">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="edit-entitySubClass-form">
                <input type="hidden" name="id">
                <header class="modal-header">
                    <h4 class="modal-title">Editar Registro Entity Sub Class</h4>
                    <button class="close-modal" type="button" id="modal3" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <?php
                    presentationLayerY::buildInput("code", "code", "", $code, "50", "", "", "required");
                    presentationLayerY::buildInput("name", "name", "", $name, "50", "", "", "required");
                    ?>
                    <div class="filter">
                        <div class="filter__containerInput">
                            <label>Nombre entityClass :</label>
                            <input class="filter__input" id="entityclassInputEdit" name="entityclassInput" type="text" required placeholder="Nombre entityClass" autocomplete="off">
                        </div>
                        <select class="filter__select hide" id="entityclassSelectEdit" name="entityclassSelect" required multiple="multiple">
                        </select>
                    </div>
                    <label>
                        <span>observation :</span>
                        <textarea class="form-control" name="observation" placeholder="Comentario..."></textarea>
                    </label>
                </aside>
                <footer class="modal-footer">
                    <button class="btn btn-default" type="button" aria-label="close modal" data-close>Cancelar</button>
                    <button class="btn btn-primary" id="btn-edit-data" type="submit">Editar</button>
                </footer>
            </form>
        </section>
    </div>
</div>