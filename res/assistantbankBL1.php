<?php

/**
 * Class "assistantbankBL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2021-01-07 Elaboracion; 2021-01-07 Modificacion, [Parametro]"
 * Description: ""  
 * 
 * Others additions: assistantbankBL.php:
 * functions: 
 *           
 *
 */
chdir(dirname(__FILE__));

include_once("../base/baseBL.php");

class assistantbankBL extends baseBL
{

      protected $idpartybankinfo;
      protected $idaccassistant;
      protected $idpartyuser;
      protected $dateregister;
      protected $idpartylocation;
      protected $identitysubclass;


      function __construct(
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
      ) {

            $scheme = "libertyweb";
            $table = "assistantbank";
            $this->idpartybankinfo  = $idpartybankinfo;
            $this->idaccassistant  = $idaccassistant;
            $this->idpartyuser  = $idpartyuser;
            $this->dateregister  = $dateregister;
            $this->idpartylocation  = $idpartylocation;
            $this->identitysubclass  = $identitysubclass;

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

            if (!utilities::valOk($this->idpartybankinfo)) {
                  $valid = false;
                  $msg = "A value must be given to field idpartybankinfo";
            } // validate idpartybankinfo

            if (!utilities::valOk($this->idaccassistant)) {
                  $valid = false;
                  $msg = "A value must be given to field idaccassistant";
            } // validate idaccassistant

            if (!utilities::valOk($this->idpartyuser)) {
                  $valid = false;
                  $msg = "A value must be given to field idpartyuser";
            } // validate idpartyuser

            if (!utilities::valOk($this->dateregister)) {
                  $valid = false;
                  $msg = "A value must be given to field dateregister";
            } // validate dateregister

            if (!utilities::valOk($this->idpartylocation)) {
                  $valid = false;
                  $msg = "A value must be given to field idpartylocation";
            } // validate idpartylocation

            if (!utilities::valOk($this->identitysubclass)) {
                  $valid = false;
                  $msg = "A value must be given to field identitysubclass";
            } // validate identitysubclass

            if ($msg != "") {
                  utilities::alert($msg);
            }
            return ($valid);
      }

      function buildArray(&$A)
      {
            $A[] = utilities::buildS($this->code);
            $A[] = utilities::buildS($this->name);
            $A[] = utilities::buildS($this->idpartybankinfo);
            $A[] = utilities::buildS($this->idaccassistant);
            $A[] = utilities::buildS($this->idpartyuser);
            $A[] = utilities::buildS($this->dateregister);
            $A[] = utilities::buildS($this->active);
            $A[] = utilities::buildS($this->deleted);
            $A[] = utilities::buildS($this->idpartylocation);
            $A[] = utilities::buildS($this->identitysubclass);
      }
      function fillGridDisplayPaginator($com = "", $arrCol = "")
      {
            if ($com == "") {
                  $com = "select * from " . $this->scheme . ".isspget" . $this->table . "display()";
                  /*$com = "
SELECT
LAB.id,
LAB.code AS cuenta,
LAB.name AS nombreBanco,
LAB.dateregister,
BEC.name AS nombreDept,
BES.name AS nombreSubDept,
PP.name AS nombre,
PP.documentid,
BRST.code,
BRST.name,
LAA.name as NameAA,
LAB.active,
LAB.deleted
FROM
libertyweb.assistantbank LAB,
libertyweb.accountassistant LAA,
base.entitysubclass BES,
base.entityclass BEC,
party.party PP,
party.partyrelationship PPR,
base.relationshiptype BRST
WHERE
-- departamento y subdepartamento
LAB.identitysubclass = BES.id
AND BEC.id = BES.identityclass
-- filtramos y buscamos los nombres y documentid de la persona poseedora  del ente
AND LAB.idpartylocation = PP.id
-- ahora filtramos sucursales
AND LAB.idpartylocation = PPR.idpartysrc
AND PPR.idrelationshiptype = BRST.id
-- compañia
AND LAB.idaccassistant = LAA.id
                  ";*/
            }

            $dbl = new baseBL();
            $arr = $dbl->executeReader($com);

            if ($arrCol == "") {
                  $arrCol = array("Id", "Cuenta", "Nombre banco", "dateregister", "nombreDept", "nombreSubDept", "partyname", "partydocumentid", "codigo sucursal", "nombre sucursal", "nombre compañia", "Status", "Eliminado");
            }
            $this->fillGridArrPaginator($arr, $arrCol);
      }

      static function fillGridArrPaginator($arr, $arrCol, $par = "", $pageSize = 10, $pageNumber = 0, $width = 900, $check = "0", $select = "0")
      {

            //echo "cambiamos todo";
            $nr = count($arr);
            //echo $nr;
            //print $arr;
            $nc = count($arrCol);
            //$pnc = $pageNumber;
            //echo '<section>';
            echo '<table id="" class="display" width="100%">';
            //$pnc = $pageNumber;
            echo '<thead>';
            for ($i = 0; $i < $nc; $i++) {
                  $name = $arrCol[$i];
                  echo "<th>" . $name . "</th>";
            }
            //  echo '<button onclick="window.location.href=../../datatables/fpdf/reportes.php" >FPDF</button>';
            echo '  </thead>';

            echo '<tbody>';
            $end = 0;
            echo "</tr>";
            //print_r($arr);
            if (is_array($arr)) { // bring values
                  for ($i = 0; $i < $nr; $i++) {
                        echo "  <tr > ";
                        $reg = $arr[$i];
                        $j = 0; // assummes id, first column
                        foreach ($reg as $col) {
                              if ($j == 0) {
                                    echo "<td><a href='?urloper=find&pn=" . $pageNumber . "&id=" . $col . "'>" . $col . "</a></td>";
                              } else {
                                    echo "<td>" . $col . "</td>";
                              }
                              $j++;
                        }
                        echo '</tr>';
                  }
            }

            echo '</tbody>';
            echo '</table>';

            //echo '</section>'; 
      }

      function insert($parAr)
      {
            $nerr = false;
            $dbl2 = new baseBL();
            // Buscamos el idparty con la cedula que traiga el registro

            // Id party user
            $comCIPartyUser = "select id from party.party where documentid =" . $parAr[4];
            $arr2 = $dbl2->executeReader($comCIPartyUser);
            $data2 = $arr2[0];
            $idPartyUser = $data2['id'];
            $parAr[4] = $idPartyUser;

            // Id Location
            $comCILocation = "select id from party.party where documentid =" . $parAr[8];
            $arr = $dbl2->executeReader($comCILocation);
            $data = $arr[0];
            $idLocation = $data['id'];
            $parAr[8] = $idLocation;

            // Si no encuentra idparty
            if (empty($parAr[4])) {
                  $nerr = false;
                  $msg = 'El ci party no existe, ingrese otro';
                  utilities::alert($msg);
            } else if (empty($parAr[8])) {
                  // Si no encuentra idparty - location
                  $nerr = false;
                  $msg = 'El ci location no existe, ingrese otro';
                  utilities::alert($msg);
            }
            if ($this->validate()) {
                  $name = $this->scheme . ".isspins" . $this->table;
                  $nerr = $this->dl->executeSP($name, $parAr);
            }


            // if ($this->validate()) {
            //       $name = $this->scheme . ".isspins" . $this->table;
            //       $nerr = $this->dl->executeSP($name, $parAr);
            // }

            return ($nerr);
      }

      function execute($urloper, &$parAr, $name = "")
      {
            if ($urloper == "insert") {
                  $nerr = $this->insert($parAr);
                  if ($nerr === true)
                        $msg = "Insert Operation OK. ";
                  else
                        $msg = "Insert Operation Failed. ";
                  utilities::alert($msg);
            }
      }
}
