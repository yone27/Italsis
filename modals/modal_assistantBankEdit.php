<div class="modal" id="tableAssistantBankEditModal">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="edit-assistantBank-form">
                <input type="hidden" name="id" id="idEdit">
                <header class="modal-header">
                    <h4 class="modal-title">Editar Registro</h4>
                    <button class="close-modal" type="button" id="modal3" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <input type="hidden" name="code">
                    <input type="hidden" name="name">

                    <?php
                    // presentationLayerY::buildInput("code", "code", "editCode", $code, "50", "", "", "required");
                    // presentationLayerY::buildInput("name", "name", "editName", $name, "50", "", "", "required");
                    ?>

                    <div class="filter">
                        <div class="filter__containerInput">
                            <label>Nombre compañia :</label>
                            <input style="text-transform: uppercase;" autocomplete="off" name="idpartylocation" class="filter__input" type="text" required id="idpartylocation2" placeholder="Nombre compañia">
                        </div>
                        <select style="text-transform: uppercase;" required name="infocompany" class="filter__select hide" id="infocompany2" multiple="multiple">
                        </select>
                    </div>

                    <!-- filter account by idpartylocation -->
                    <div class="filter">
                        <label>Cuentas</label>
                        <select class="filter__select" name="idpartybankinfo" id="select4" required  multiple="multiple">
                        </select>
                    </div>
                    <!-- /filter account by idpartylocation -->

                    <?php
                    $com = "select * from base.entitysubclass where identityclass in (select id from base.entityclass where code in ('Departamentos'))";
                    presentationLayerY::buildSelectWithComEvent('Dept', 'identitysubclass', 'editidentitysubclass', $sbl, $com, "id", "name", $identitysubclass, "", "required");
                    ?>
                </aside>
                <footer class="modal-footer">
                    <button class="btn btn-default" type="button" aria-label="close modal" data-close>Cancelar</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit-data">Editar</button>
                </footer>
            </form>
        </section>
    </div>
</div>