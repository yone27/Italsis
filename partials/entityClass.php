<?php
/*
 * Class "entityclassPL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-29 Elaboracion; 2020-12-29 Modificacion, [Parametro]"
 * Description: "" 
 * 
 * Others additions: entityclassPL.php:
 * functions: 
 */
?>

<div id="showAlert"></div>
<h1 class="title title-a">
    entityclass
    <button class="btn btn-success" aria-label="open modal" type="button" data-open="formEntityClass">Agregar nuevo registro</button>
</h1>
<form method="post" name="entityclassPL">
    <div class="grid grid-2">
    </div>
</form>

<div class="table-custom">
    <table id="tableEntityClass" class="table table-striped table-bordered text-center" style="max-width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Name</th>
                <th>Observation</th>
                <th>Generator</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div id="table-pagination-footer">
        <div class="info">
        </div>
        <div class="buttons-pagination">
        </div>
    </div>
</div>

<?php include './modals/modal_entityClassEdit.php'; ?>
<?php include './modals/modal_entityClass.php'; ?>

<script type="module" src="assets/js/entityClass.js"></script>