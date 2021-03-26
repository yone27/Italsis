<div class="modal" id="assistantBankModal">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="assistantbankPL">
                <header class="modal-header">
                    <h4 class="modal-title">Agregar Registro</h4>
                    <button class="close-modal" type="button" id="modal2" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <input type="hidden" name="scode">
                    <input type="hidden" name="sname">
                    
                    <div class="filter">
                        <div class="filter__containerInput">
                            <label>Nombre compañia</label>
                            <input class="filter__input" name="idpartylocation" type="text" id="idpartylocation1" required placeholder="Nombre compañia" autocomplete="off">
                        </div>
                        <select class="filter__select hide" name="infocompany" id="infocompany1" multiple="multiple" required>
                        </select>
                    </div>

                    <!-- filter account by idpartylocation -->
                    <div class="filter">
                        <label>Cuentas</label>
                        <select class="filter__select" name="idpartybankinfo" id="select3" required  multiple="multiple">
                        </select>
                    </div>
                    <!-- /filter account by idpartylocation -->
                    
                    <?php
                    $com = "select * from base.entitysubclass where identityclass in (select id from base.entityclass where code in ('Departamentos'))";
                    presentationLayerY::buildSelectWithComEvent('Dept', 'sidentitysubclass', 'sidentitysubclass', $sbl, $com, "id", "name", $identitysubclass, "", "required");
                    ?>
                </aside>
                <footer class="modal-footer">
                    <button class="btn btn-default" type="button" aria-label="close modal" data-close>Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </footer>
            </form>
        </section>
    </div>
</div>