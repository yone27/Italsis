<?php

/**
 * Class "partyentityrelationshipPL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-16 Elaboracion; 2020-12-16 Modificacion, [Parametro]"
 * Description: "" 
 * 
 * Others additions: partyentityrelationshipPL.php:
 * functions: 
 *           
 *
 */
$version = "1.00";
$msgversion = " Class partyentityrelationshipPL.PHP";
$msgversion .= " @author dba, ygonzalez@durthis.com";
$msgversion .= " @version V " . $version . ".- 2020-12-16";
$msgversion .= " ";
$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
error_reporting(0);
session_start();
chdir(dirname(__FILE__));
include_once("partyentityrelationshipBL.php");
chdir(dirname(__FILE__));
include_once("../base/basePL.php");
chdir(dirname(__FILE__));
include_once("../../../includes/presentationLayer.php");

basePL::buildjs();
basePL::buildccs();

//Utilitario para desplegar menu de funciones
//utilities::trueUser();
?>

<html>

<head>
    <title>partyentityrelationshipPL.PHP</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="./css/custom.css">
    <script src="./js/functions.js"></script>
</head>


<?php
//links
$sLink = $dLink = $pLink = $cLink = $flink = $fbnlink = $findByDocumentIdLink = "";

//actions
$action = "";
$urloper = "";

//For pagination
$pn = 0;
$urloper = basePL::getReq($_REQUEST, "urloper");
$pn = basePL::getReq($_REQUEST, "pn");

// default
$active = "Y";
$deleted = "N";
$id = $code = $name = $nameparty = $partyDocumentId = "";

$idparty = $identitysubclass = $identityclass = $observation = "";


$id = basePL::getReq($_REQUEST, "id");
$partyDocumentId = basePL::getReq($_REQUEST, "partyDocumentId");
$code = basePL::getReq($_REQUEST, "code");
$name = basePL::getReq($_REQUEST, "name");
$idparty = basePL::getReq($_REQUEST, "idparty");
$identitysubclass = basePL::getReq($_REQUEST, "identitysubclass");
$identityclass = basePL::getReq($_REQUEST, "identityclass");
$observation = basePL::getReq($_REQUEST, "observation");
$active = basePL::getReqCheck($_REQUEST, "active");
$deleted = basePL::getReqCheck($_REQUEST, "deleted");


$sbl = new partyentityrelationshipBL($code, $name, $idparty, $identitysubclass, $identityclass, $observation, $active, $deleted, $nameparty, $partyDocumentId);
$sbl->buildLinks("partyentityrelationshipPL.php", $pn, $sLink, $dLink, $pLink, $cLink, $fLink, $fbnLink, $action, $findByDocumentIdLink);
$bpl = new basePL("document.partyentityrelationshipPL", $sLink, $dLink, $pLink, $cLink, $fLink, $fbnLink);

/* if(isset($_GET["urloper"])){
      if ($_GET["urloper"] == "clear"){
      $id = $code = $name = "";
      $idclass = "{valor}";
      }
      } */

$oper = $urloper;
if ($urloper == "save" && $id == "") {
    $oper = "insert";
}
if ($urloper == "save" && $id != "") {
    $oper = "update";
}

if ($id != "") {
    print_r($id);
    $arPar[] = $id;
}

if (isset($_GET["V"])) {
    if ($_GET["V"] == "Y") {
        utilities::alert($msgversion);
    }
}

$sbl->buildArray($arPar);
$sbl->execute($oper, $arPar);

if ($oper == "find" || $oper == "findByName" || $oper == "findByDocumentId") {
    $id = $arPar[0];
    $partyDocumentId = $arPar[1];
    $nameparty = $arPar[2];
    $identityclass = $arPar[3];
    $identitysubclass = $arPar[4];
    $observation = $arPar[5];
    $active = $arPar[6];
    $deleted = $arPar[7];
}
?>
<body>
    <FORM action="<?php echo $action; ?>" method="post" name="partyentityrelationshipPL" class="italsis">
        <?php
        presentationLayer::buildFormTitle("party entity relationship", "Subtitle");
        presentationLayer::buildInitColumn();
        //presentationLayer::buildIdInput($id, "document.partyentityrelationshipPL", $fLink);
        //presentationLayer::buildInput("CI o RIF", "partyDocumentId", "partyDocumentId", $partyDocumentId, "50", "");
        // presentationLayer::buildInput("Nombre", "nombre", "nombre", $nameparty, "50");
        //presentationLayer::buildSelect("idparty", "idparty", "idparty", $sbl, "party", $idparty, "party", "");
        presentationLayer::buildSelect("Dept", "identityclass", "identityclass", $sbl, "entityclass", $identityclass, "base", "");
        presentationLayer::buildSelect("Sub Dept", "identitysubclass", "identitysubclass", $sbl, "entitysubclass", $identitysubclass, "base", "");
        presentationLayer::buildInput("Observación", "observation", "observation", $observation, "50");
        presentationLayer::buildCheck("Activo", "active", "active", $active);
        presentationLayer::buildCheck("deleted", "deleted", "deleted", $deleted);
        presentationLayer::buildEndColumn();

        //presentationLayer::buildFooterDisplay($bpl, $sbl, $pn, $parname = "", $parvalue = "", $save = "Y", $delete = "N", $print = "N", $clean = "Y", $find = "Y");
        presentationLayer::buildFooterNoGrid($bpl, $sbl, $pn, "Y", "Y", "Y", "Y", "Y");
        $sbl->fillGridDisplayPaginator('');
        ?>
    </form>
</body>

</html>