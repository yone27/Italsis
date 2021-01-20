<?php
/*
 * Class "entitysubclassPL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-29 Elaboracion; 2020-12-29 Modificacion, [Parametro]"
 * Description: "" 
 * 
 * Others additions: entitysubclassPL.php:
 * functions: 
 */
?>

<div id="showAlert"></div>
<h1 class="title title-a">
    entitysubclass
    <button class="btn btn-success" aria-label="open modal" type="button" data-open="entitySubClassModal">Agregar nuevo registro</button>
</h1>
<form method="post" name="entitysubclassPL">
    <div class="grid grid-2">
        <?php
        presentationLayer::buildInput("code", "code", "code", "", "50");

        presentationLayer::buildInput("name", "name", "name", "", "50");
        presentationLayer::buildInput("observation", "observation", "observation", "", "50");
        presentationLayer::buildInput("identitysubclass", "identitysubclass", "identitysubclass", "", "50");

        // presentationLayer::buildSelect("identityclass", "identityclass", "identityclass", "", "entityclass", "", "base", "");

        presentationLayer::buildInput("identityclass", "identityclass", "identityclass", "", "50");

        ?>
    </div>
</form>

<div class="table-custom">
    <table id="tableEntitySubClass" class="table table-striped table-bordered text-center" style="max-width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Codigo</th>
                <th>Name</th>
                <th>IdEntitySubClass</th>
                <th>Observation</th>
                <th>EntityClass</th>
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