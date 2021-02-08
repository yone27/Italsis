<div class="modal" id="partyBankInfoModal">
    <div class="modal-dialog">
        <section class="modal-content">
            <form id="formPartyBankInfo">
                <header class="modal-header">
                    <h4 class="modal-title">Agregar cuenta</h4>
                    <button class="close-modal" type="button" id="modal4" aria-label="close modal" data-close>✕</button>
                </header>
                <aside class="modal-body">
                    <input type="hidden" name="idparty">
                    <label>
                        <span>Nombre banco</span>
                        <input name="bankName" type="text" required placeholder="Nombre banco">
                    </label>
                    <label>
                        <span>Numero de cuenta</span>
                        <input name="bankAccount" type="text" pattern="[0-9]{10}" required placeholder="Numero de cuenta">
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