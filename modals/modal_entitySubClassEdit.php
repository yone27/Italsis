<?php include_once("../../../includes/presentationLayer.php");
include_once("./presentationLayerY.php");
?>

<div class="modal" id="tableEntitySubClassEditModal">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="edit-entitySubClass-form">
                <input type="hidden" name="id" id="idEdit">
                <header class="modal-header">
                    <h4 class="modal-title">Editar Registro</h4>
                    <button class="close-modal" type="button" id="modal3" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <?php
                    presentationLayer::buildInput("code", "code", "editCode", $code, "50", "", "", "required");
                    presentationLayer::buildInput("name", "name", "editName", $name, "50", "", "", "required");
                    presentationLayer::buildInput("observation", "observation", "editObservation", $observation, "50", "required");
                    ?>
                    <div class="toggle-button-cover">
                        <label>Generador</label>
                        <div class="button-cover d-flex align-items-center">
                            <div class="button r button-1">
                                <input type="checkbox" class="checkbox" id="editGenerator">
                                <div class="knobs"></div>
                                <div class="layer"></div>
                            </div>
                        </div>
                    </div>
                </aside>
                <footer class="modal-footer">
                    <button class="btn btn-default" type="button" aria-label="close modal" data-close>Cancelar</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit-data">Editar</button>
                </footer>
            </form>
        </section>
    </div>
</div>