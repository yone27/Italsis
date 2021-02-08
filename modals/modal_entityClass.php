
<div class="modal" id="formEntityClass">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="entityClass">
                <header class="modal-header">
                    <h4 class="modal-title">Agregar Registro Entity Class</h4>
                    <button class="close-modal" type="button" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <?php
                    presentationLayerY::buildInput("code", "code", "", "", "50", "", "", "required");
                    presentationLayerY::buildInput("name", "name", "", "", "50", "", "", "required");
                    ?>
                     <label>
                        <span>observation :</span>
                        <textarea class="form-control" name="observation" placeholder="Comentario..."></textarea>
                    </label>
                    <div class="toggle-button-cover">
                        <label>Generador</label>
                        <div class="button-cover d-flex align-items-center">
                            <div class="button r button-1">
                                <input class="checkbox" name="generator" type="checkbox" checked>
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                        </div>
                    </div>
                </aside>
                <footer class="modal-footer">
                    <button class="btn btn-default" type="button" aria-label="close modal" data-close>Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </footer>
            </form>
        </section>
    </div>
</div>