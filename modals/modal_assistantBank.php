<div class="modal" id="assistantBankModal">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="assistantbankPL">
                <header class="modal-header">
                    <h4 class="modal-title">Agregar Registro</h4>
                    <button class="close-modal" type="button" id="modal2" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <?php
                    presentationLayerY::buildInput("code", "scode", "scode", $code, "50","", "","required");
                    presentationLayerY::buildInput("name", "sname", "sname", $name, "50","", "","required");
                    ?>
                    
                    <div class="filter-company-container">
                        <label>
                            <span>Nombre compañia :</span>
                            <input autocomplete="off" name="idpartylocation" class="filter-company" type="text" id="idpartylocation1" required placeholder="Nombre compañia">
                        </label>
                        <select name="infocompany" required class="menu-company hide" id="infocompany1" multiple="multiple">
                        </select>
                    </div>

                    <?php
                    $com = "select * from base.entitysubclass where identityclass in (select id from base.entityclass where code in ('Departamentos'))";
                    presentationLayer::buildSelectWithComEvent('Dept', 'sidentitysubclass', 'sidentitysubclass', $sbl, $com, "id", "name", $identitysubclass,"", "required");
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