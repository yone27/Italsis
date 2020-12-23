<?php

/**
 * Class "partyentityrelationshipBL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-16 Elaboracion; 2020-12-16 Modificacion, [Parametro]"
 * Description: ""  
 * 
 * Others additions: partyentityrelationshipBL.php:
 * functions: 
 *           
 *
 */
chdir(dirname(__FILE__));

include_once("../base/baseBL.php");

class partyentityrelationshipBL extends baseBL
{

    protected $idparty;
    protected $identitysubclass;
    protected $identityclass;
    protected $observation;
    protected $nameparty;
    protected $partyDocumentId;

    function __construct($code, $name, $idparty, $identitysubclass, $identityclass, $observation, $active, $deleted, $nameparty, $partyDocumentId)
    {

        $scheme = "party";
        $table = "partyentityrelationship";
        $this->idparty = $idparty;
        $this->identitysubclass = $identitysubclass;
        $this->identityclass = $identityclass;
        $this->observation = $observation;
        $this->nameparty = $nameparty;
        $this->partyDocumentId = $partyDocumentId;

        parent::__construct($scheme, $table, $code, $name, $active, $deleted);
    }

    function validate()
    {
        $valid = true;
        $msg = "";


        if (!utilities::valOk($this->code)) {
            $valid = false;
            $msg = "A value must be given to field code";
        } // validate code

        if (!utilities::valOk($this->name)) {
            $valid = false;
            $msg = "A value must be given to field name";
        } // validate name

        if (!utilities::valOk($this->idparty)) {
            $valid = false;
            $msg = "A value must be given to field idparty";
        } // validate idparty

        if (!utilities::valOk($this->identitysubclass)) {
            $valid = false;
            $msg = "A value must be given to field identitysubclass";
        } // validate identitysubclass

        if (!utilities::valOk($this->identityclass)) {
            $valid = false;
            $msg = "A value must be given to field identityclass";
        } // validate identityclass

        if (!utilities::valOk($this->observation)) {
            $valid = false;
            $msg = "A value must be given to field observation";
        } // validate observation

        if (!utilities::valOk($this->nameparty)) {
            $valid = false;
            $msg = "A value must be given to field nameparty";
        } // validate observation

        if ($msg != "") {
            utilities::alert($msg);
        }
        return ($valid);
    }

    function buildArray(&$A)
    {
        $A[] = utilities::buildS($this->partyDocumentId);
        $A[] = utilities::buildS($this->nameparty);
        $A[] = utilities::buildS($this->identityclass);
        $A[] = utilities::buildS($this->identitysubclass);
        $A[] = utilities::buildS($this->observation);
        $A[] = utilities::buildS($this->active);
        $A[] = utilities::buildS($this->deleted);
    }

    function fillGridDisplay($pn = 0)
    {
        $arrCol = array("Id", "Cedula o Rif", "Nombre", "Departamento", "Sub departamento", "Observación", "Activo");
        return parent::fillGridDisplay($arrCol, "", $pn);
    }

    function buildLinks($pag, $pn, &$sLink, &$dLink, &$pLink, &$cLink, &$fLink, &$fbnLink, &$action, &$findByDocumentIdLink)
    {
        $findByDocumentIdLink = $pag . "?urloper=findByDocumentId&pn=" . $pn;
        parent::buildLinks($pag, $pn, $sLink, $dLink, $pLink, $cLink, $fLink, $fbnLink, $action);
    }

    function execute($urloper, &$parAr, $name = "")
    {
        if ($urloper == "findByDocumentId") {
            $nerr = $this->selectByDocumentId($parAr);
        }
        parent::execute($urloper, $parAr, $name = "");
    }

    function selectByDocumentId($partyDocumentId)
    {
        $nerr = false;
        $name = $this->scheme . ".isspget" . $this->table;
        $ne = count($parAr);
        for ($i = 1; $i < $ne; $i++) {
            $parAr[$i] = "";
        }

        $nerr = $this->dl->executeSPget($name, $parAr[0], $parAr);

        return ($nerr);
    }

    function fillGridDisplayPaginator($com = "", $arrCol = "")
    {
        if ($com == "") {
            $com = "select * from " . $this->scheme . ".isspget" . $this->table . "display()";
        }

        $dbl = new baseBL();
        $arr = $dbl->executeReader($com);
        if ($arrCol == "") {
            $arrCol = array("Id", "Cedula o Rif", "Nombre", "Departamento", "Sub departamento", "Observación", "Activo", "acciones");
        }
        $this->fillGridArrPaginator($arr, $arrCol);
    }

    static function fillGridArrPaginator($arr, $arrCol, $par = "", $pageSize = 10, $pageNumber = 0, $width = 900, $check = "0", $select = "0")
    {
        $nr = count($arr);
        $nc = count($arrCol);
        echo '<table id="" class="display" width="100%">';
        echo '<thead>';
        for ($i = 0; $i < $nc; $i++) {
            $name = $arrCol[$i];
            echo "<th style='text-align: center;'>" . $name . "</th>";
        }
        echo '  </thead>';
        echo '<tbody>';
        echo "</tr>";
        if (is_array($arr)) { // bring values
            for ($i = 0; $i < $nr; $i++) {
                echo "  <tr > ";
                $reg = $arr[$i];
                $reg['actions'] = 1;
                $j = 0; // assummes id, first column
                foreach ($reg as $col) {
                    if ($j == 0) {
                        echo "<td><a href='?urloper=find&pn=" . $pageNumber . "&id=" . $col . "'>" . $col . "</a></td>";
                    } elseif($j == 7) {
                        echo "<td style='display:flex;justify-content:center;align-items:center;'><a class='btn btn-delete'><img src='http://localhost:80/italsis/images/Delete.png' width='28' height='28' title='Delete'></a><a class='btn btn-edit'>Edit</a>";
                    }elseif($j == 6) {
                        echo "<td style='text-align: center;'><input onchange='atualizarReagente()' style='cursor:pointer;' name='active' type='checkbox' id='active'></td>";
                    }else {
                        echo "<td>" . $col . "</td>";
                    }
                    $j++;
                }
                die();
                echo '</tr>';
            }
        }

        echo '</tbody>';
        echo '</table>';
    }

    //select
}
