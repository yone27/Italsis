<?php

/**
 * Class "assistantbankPL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2021-01-07 Elaboracion; 2021-01-07 Modificacion, [Parametro]"
 * Description: "" 
 * 
 * Others additions: assistantbankPL.php:
 * functions: 
 *           
 *
 */
$version = "1.00";
$msgversion = " Class assistantbankPL.PHP";
$msgversion .= " @author dba, ygonzalez@durthis.com";
$msgversion .= " @version V " . $version . ".- 2021-01-07";
$msgversion .= " ";
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
error_reporting(0);
session_start();
chdir(dirname(__FILE__));
include_once("assistantbankBL.php");
chdir(dirname(__FILE__));
include_once("../base/basePL.php");
chdir(dirname(__FILE__));
include_once("./presentationLayerY.php");

basePL::buildjs();
basePL::buildccs();

//Utilitario para desplegar menu de funciones
//utilities::trueUser();
?>

<html>

<head>
    <title>assistantbankPL.PHP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <!-- Custom css -->
    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/pagination.css">
    <link rel="stylesheet" href="assets/css/inputs.css">
    <link rel="stylesheet" href="assets/css/alerts.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>


<?php
// default
$active = "Y";
$deleted = "N";
$id = $code = $name = $idpartybankinfo = $idaccassistant = $idpartyuser = $dateregister = $idpartylocation = $identitysubclass = "";


$id = basePL::getReq($_REQUEST, "id");
$code = basePL::getReq($_REQUEST, "code");
$name = basePL::getReq($_REQUEST, "name");
$idpartybankinfo = basePL::getReq($_REQUEST, "idpartybankinfo");
$idaccassistant = basePL::getReq($_REQUEST, "idaccassistant");
$idpartyuser = basePL::getReq($_REQUEST, "idpartyuser");
$dateregister = basePL::getReq($_REQUEST, "dateregister");
$active = basePL::getReqCheck($_REQUEST, "active");
$deleted = basePL::getReqCheck($_REQUEST, "deleted");
$idpartylocation = basePL::getReq($_REQUEST, "idpartylocation");
$identitysubclass = basePL::getReq($_REQUEST, "identitysubclass");

$sbl = new assistantbankBL(
    $code,
    $name,
    $idpartybankinfo,
    $idaccassistant,
    $idpartyuser,
    $dateregister,
    $active,
    $deleted,
    $idpartylocation,
    $identitysubclass
);

$sbl->buildArray($arPar);

?>

<body class="container-custom">
    <main class="italsis">
        <h1 class="title title-a">assistantbankBL
            <button class="btn btn-success" aria-label="open modal" type="button" data-open="assistantBankModal">Agregar nuevo registro</button>
        </h1>
        <div id="showAlert"></div>
        <form method="post" name="assistantbankPL1" id="assistantbankPL1">
            <div class="grid grid-2">
                <?php
                presentationLayerY::buildInput("Nombre compañia", "idpartylocation", "idpartylocation", $idpartylocation, "50");
                $com = "select * from base.entitysubclass where identityclass in (select id from base.entityclass where code in ('Departamentos'))";
                presentationLayerY::buildSelectWithComEvent('Dept', 'identitysubclass', 'identitysubclass', $sbl, $com, "id", "name", $identitysubclass);
                ?>
            </div>
        </form>
        <div class="table-custom">
            <div id="table-pagination-header">
            </div>
            <table id="table-assistantBank" class="table table-striped table-bordered text-center" style="max-width: 100%;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Codigo</th>
                        <th>Cuenta</th>
                        <th>Fecha</th>
                        <th>Nombre Comp</th>
                        <th>Dept</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div id="table-pagination-footer">
                <div class="info"></div>
                <div class="buttons-pagination"></div>
            </div>
        </div>
        <?php include './modals/modal_assistantBank.php'; ?>
        <?php include './modals/modal_assistantBankEdit.php'; ?>
    </main>
    <script type="module" src="assets/js/assistantBank.js"></script>
    <!-- <script type="module" src="./js/app.js"></script> -->
</body>

</html>