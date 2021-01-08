<?php
/**
* Class "entitysubclassPL.PHP"
* @author "dba, ygonzalez@durthis.com"
* @version "1.00 2020-12-29 Elaboracion; 2020-12-29 Modificacion, [Parametro]"
* Description: "" 
* 
* Others additions: entitysubclassPL.php:
* functions: 
*           
*
*/
    $version = "1.00";
    $msgversion = " Class entitysubclassPL.PHP";
    $msgversion .= " @author dba, ygonzalez@durthis.com";
    $msgversion .= " @version V ".$version.".- 2020-12-29";
    $msgversion .= " ";
    $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    error_reporting(0);  
    session_start();
    chdir(dirname(__FILE__));
    include_once("entitysubclassBL.php");
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

  <title>entitysubclassPL.PHP</title>

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

    $urloper = basePL::getReq($_REQUEST,"urloper");
    $pn = basePL::getReq($_REQUEST,"pn");
    $parS = "";

    // default
    $active = "Y";
    $deleted = "N";
    $id = $code = $name = "";

$identityclass = $observation = $identitysubclass = "";


    $id = basePL::getReq($_REQUEST,"id");
    $code = basePL::getReq($_REQUEST,"code");
    $name = basePL::getReq($_REQUEST,"name");
    $identityclass = basePL::getReq($_REQUEST,"identityclass");
    $observation = basePL::getReq($_REQUEST,"observation");
    $identitysubclass = basePL::getReq($_REQUEST,"identitysubclass");
    $active = basePL::getReqCheck($_REQUEST,"active");
    $deleted = basePL::getReqCheck($_REQUEST,"deleted");


          $sbl = new entitysubclassBL($code,$name,$identityclass,$observation,$identitysubclass,
$active,$deleted);


    $sbl-> buildLinks("entitysubclassPL.php",$pn,$sLink,$dLink,$pLink,
            $cLink,$fLink,$fbnLink,$action,$parS);	
    $bpl = new basePL("document.entitysubclassPL",$sLink,$dLink,$pLink,
            $cLink,$fLink,$fbnLink);

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

    if(isset($_GET["V"])){
        if($_GET["V"] =="Y"){
            utilities::alert($msgversion);
        }
    }
   
    $sbl->buildArray($arPar);
   
    $sbl->execute($oper,$arPar);
    
    if ($oper == "find" || $oper == "findByName") {
                $id = $arPar[0];
                $code = $arPar[1];
                $name = $arPar[2];
                $identityclass = $arPar[3];
                $observation = $arPar[4];
                $identitysubclass = $arPar[5];
                $active = $arPar[6];
                $deleted = $arPar[7];
    }

?>
<!-- 
<body oncontextmenu="return false;">
-->
<body>
<FORM action="<?php echo $action;?>" method="post" name="entitysubclassPL" 
      class="italsis">
	
<?php

    presentationLayer::buildFormTitle("entitysubclassBL","");
    
    presentationLayer::buildInitColumn();
    
    presentationLayer::buildIdInput($id,"document.entitysubclassPL",$fLink); 

    presentationLayer::buildInput("code","code","code",$code,"50");

    presentationLayer::buildInput("name","name","name",$name,"50");

    presentationLayer::buildSelect("identityclass","identityclass","identityclass",$sbl,"entityclass",$identityclass,"base","");

    presentationLayer::buildInput("observation","observation","observation",$observation,"50");

    presentationLayer::buildInput("identitysubclass","identitysubclass","identitysubclass",$identitysubclass,"50");


    presentationLayer::buildEndColumn();
    presentationLayer::buildInitColumn();
    presentationLayer::buildCheck("active","active","active",$active);
    presentationLayer::buildCheck("deleted","deleted","deleted",$deleted);

    presentationLayer::buildEndColumn();

    presentationLayer::buildFooter($bpl,$sbl,$pn);

    ?>
    </form>
    </body>
</html>
