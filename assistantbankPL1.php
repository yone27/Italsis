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
include_once("../../../includes/presentationLayer.php");

basePL::buildjs();
basePL::buildccs();

//Utilitario para desplegar menu de funciones
//utilities::trueUser();

?>

<html>

<head>

    <title>assistantbankPL.PHP</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>


<?php
//links
$sLink = $dLink = $pLink = $cLink = $flink = $fbnlink = "";

//actions
$action = "";
$urloper = "";

//For pagination
$pn = 0;

$urloper = basePL::getReq($_REQUEST, "urloper");
$pn = basePL::getReq($_REQUEST, "pn");
$parS = "";

// default
$active = "Y";
$deleted = "N";
$id = $code = $name = "";

$idpartybankinfo = $idaccassistant = $idpartyuser = $dateregister = $idpartylocation = "";
$identitysubclass = "";


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


$sbl->buildLinks(
    "assistantbankPL.php",
    $pn,
    $sLink,
    $dLink,
    $pLink,
    $cLink,
    $fLink,
    $fbnLink,
    $action,
    $parS
);
$bpl = new basePL(
    "document.assistantbankPL",
    $sLink,
    $dLink,
    $pLink,
    $cLink,
    $fLink,
    $fbnLink
);

/*if(isset($_GET["urloper"])){
        if ($_GET["urloper"] == "clear"){
            $id = $code = $name = "";
            $idclass = "{valor}";
        }
    }*/

$oper = $urloper;
if ($urloper == "save" && $id == "") {
    $oper = "insert";
}
if ($urloper == "save" && $id != "") {
    $oper = "update";
}

if ($id != "") {
    $arPar[] = $id;
}

if (isset($_GET["V"])) {
    if ($_GET["V"] == "Y") {
        utilities::alert($msgversion);
    }
}

$sbl->buildArray($arPar);

$sbl->execute($oper, $arPar);

if ($oper == "find" || $oper == "findByName") {

    $id = $arPar[0];
    $code = $arPar[1];
    $name = $arPar[2];
    $idpartybankinfo = $arPar[3];
    $idaccassistant = $arPar[4];
    $idpartyuser = $arPar[5];
    $dateregister = $arPar[6];
    $active = $arPar[7];
    $deleted = $arPar[8];
    $idpartylocation = $arPar[9];
    $identitysubclass = $arPar[10];
}

?>
<!-- 
<body oncontextmenu="return false;">
-->
<style>
    .italsis table {
        max-width: none;
    }
</style>

<body>
    <FORM action="<?php echo $action; ?>" method="post" name="assistantbankPL" class="italsis">

        <?php

        presentationLayer::buildFormTitle("Tabla maestra Assistant Bank");

        presentationLayer::buildInitColumn();

        presentationLayer::buildIdInput($id, "document.assistantbankPL", $fLink);

        presentationLayer::buildInput("code", "code", "code", $code, "50");

        presentationLayer::buildInput("name", "name", "name", $name, "50");
        //presentationLayer::buildInput("idpartybankinfo", "idpartybankinfo", "idpartybankinfo", $idpartybankinfo, "50");

        presentationLayer::buildSelect("idpartybankinfo","idpartybankinfo","idpartybankinfo",$sbl,"partybankinfo",$idpartybankinfo,"party","");

        presentationLayer::buildSelect("idaccassistant","idaccassistant","idaccassistant",$sbl,"accountassistant",$idaccassistant,"libertyweb","");
        presentationLayer::buildInput("Cedula partyUser", "idpartyuser", "idpartyuser", $idpartyuser, "50");

        //presentationLayer::buildSelect("idpartyuser","idpartyuser","idpartyuser",$sbl,"party",$idpartyuser,"party","");

        presentationLayer::buildInput("dateregister", "dateregister", "dateregister", $dateregister, "50");

        presentationLayer::buildInput("Cedula location", "idpartylocation", "idpartylocation", $idpartylocation, "50");

        //presentationLayer::buildSelect("idpartylocation","idpartylocation","idpartylocation",$sbl,"party",$idpartylocation,"party","");

        presentationLayer::buildSelect("identitysubclass", "identitysubclass", "identitysubclass", $sbl, "entitysubclass", $identitysubclass, "base", "");
        
        $com = "select * from base.entitysubclass where identityclass in (select id from base.entityclass where code in ('Departamentos'))";
        presentationLayer::buildSelectWithComEvent('prueba', 'prueba', 'prueba', $sbl, $com, "id", "name",$prueba, '');

        //presentationLayer::buildSelect("identityclass", "identityclass", "identityclass", $sbl, "entityclass", $identityclass, "base", "");

        presentationLayer::buildEndColumn();
        presentationLayer::buildInitColumn();

        presentationLayer::buildCheck("active", "active", "active", $active);
        presentationLayer::buildCheck("deleted", "deleted", "deleted", $deleted);

        presentationLayer::buildEndColumn();

        //presentationLayer::buildFooter($bpl,$sbl,$pn);
        presentationLayer::buildFooterNoGrid($bpl, $sbl, $pn, "Y", "Y", "Y", "Y", "Y");
        $sbl->fillGridDisplayPaginator('');
        ?>
    </form>
</body>

</html>