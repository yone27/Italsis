<?php

/**
 * Class "entityclassBL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-16 Elaboracion; 2020-12-16 Modificacion, [Parametro]"
 * Description: ""  
 * 
 * Others additions: entityclassBL.php:
 * functions: 
 *           
 *
 */
chdir(dirname(__FILE__));

include_once("../base/baseBL.php");

class entityclassBL extends baseBL
{

      protected $observation;
      protected $generator;

      function __construct(
            $code,
            $name,
            $observation,
            $generator,
            $active,
            $deleted
      ) {

            $scheme = "base";
            $table = "entityclass";
            $this->observation  = $observation;
            $this->generator  = $generator;

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

            if (!utilities::valOk($this->observation)) {
                  $valid = false;
                  $msg = "A value must be given to field observation";
            } // validate observation

            if (!utilities::valOk($this->generator)) {
                  $valid = false;
                  $msg = "A value must be given to field generator";
            } // validate generator

            if ($msg != "") {
                  utilities::alert($msg);
            }
            return ($valid);
      }
      function buildArray(&$A)
      {
            $A[] = utilities::buildS($this->code);
            $A[] = utilities::buildS($this->name);
            $A[] = utilities::buildS($this->observation);
            $A[] = utilities::buildS($this->generator);
            $A[] = utilities::buildS($this->active);
            $A[] = utilities::buildS($this->deleted);
      }
      function execute($urloper, &$parAr, $name = "")
      {
            if ($urloper == "changeActive") {
                  $parAr[0] = $_GET['id'];
                  $parAr[1] = $_GET['active'];
                  $this->changeActiveById($parAr);
            }
            if ($urloper == "deleteRow") {
                  $parAr[0] = $_GET['id'];
                  $this->deleteRow($parAr);
            }

            parent::execute($urloper, $parAr, $name = "");
      }
      function changeActiveById($parAr)
      {
            $active = '';
            if ($parAr[1] == 'Y') {
                  $active = "N";
            } else {
                  $active = "Y";
            }
            $com = "select " . $this->scheme . ".isspupdbyid" . $this->table . "(" . $parAr[0] . ",'" . $active . "')";
            $this->dl->executeCommand($com);
      }
      function deleteRow($parAr)
      {
            $com = "select " . $this->scheme . ".isspupdbyid" . $this->table . "(" . $parAr[0] . ")";
            $this->dl->executeCommand($com);
      }
      function fillGridDisplayPaginator()
      {
            $com = "SELECT * FROM " . $this->scheme . ".isspget" . $this->table . "()";
            $dbl = new baseBL();
            $arr = $dbl->executeReader($com);
            $arrCol = array("id", "code", "name", "observation", "generator", "active", "Actions");
            $this->fillGridArrPaginator($arr, $arrCol);
      }
      function fillGridArrPaginator($arr, $arrCol, $pageNumber = 0)
      {
            $nr = count($arr);
            $nc = count($arrCol);
            echo '<table id="" class="display table table-center" width="100%">';
            echo '<thead>';
            for ($i = 0; $i < $nc; $i++) {
                  $name = $arrCol[$i];
                  echo "<th>" . $name . "</th>";
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
                              } elseif ($j == 6) {
                                    // href='?urloper=deleteRow&pn=" . $pageNumber . "&id=" . $reg['id'] . "'
                                    echo "<td class='table-actions'><a class='btn btn-delete'><img src='http://localhost:80/italsis/images/Delete.png' width='28' height='28' title='Delete'></a><a class='btn btn-edit' href='?urloper=find&pn=" . $pageNumber . "&id=" . $reg['id'] . "'>Edit</a>";
                              } elseif ($j == 5) {
                                    echo '<td>';
                                    echo '<input class="checkbox-primary" name="active" type="checkbox"';
                                    if ($col == "Y") {
                                          echo ' checked';
                                    }
                                    echo ' onchange="changeAction(document.entityclassPL,\'';
                                    echo 'entityclassPL.php?urloper=changeActive&id=' . $reg['pid'] . '&active=' . $col . '\'';
                                    echo ')"';
                                    echo ' placeholder="Internal Id">';
                                    echo ' </input>	';
                                    echo ' </td>	';
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
      }
      function showButtons($bpl, $save = "Y", $delete = "Y", $print = "Y", $clean = "Y", $find = "Y")
      {
            var_dump($bpl);
            die();
      }
}
