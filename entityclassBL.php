<?php

/**
 * Class "entityclassBL.PHP"
 * @author "dba, ygonzalez@durthis.com"
 * @version "1.00 2020-12-29 Elaboracion; 2020-12-29 Modificacion, [Parametro]"
 * Description: ""  
 * 
 * Others additions: entityclassBL.php:
 * functions: 
 *           
 *
 */
chdir(dirname(__FILE__));
include_once("../base/baseBL.php");
chdir(dirname(__FILE__));
include_once("../../../includes/utilities.php");
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

            if ($urloper == "update") {
                  $nerr = $this->update($parAr);
                  if ($nerr === true)
                        $msg = "Operacion de Actualizacion OK. ";
                  else
                        $msg = "Operacion de Actualizacion Fallo. ";

                  header("Location:departamentos.php");
                  utilities::alert($msg);
            } // update

            if ($urloper == "insert") {
                  $nerr = $this->insert($parAr);
                  if ($nerr === true)
                        $msg = "Operacion de Registro OK. ";
                  else
                        $msg = "Operacion de Registro Fallo. ";

                  header("Location:departamentos.php");
                  utilities::alert($msg);
            } // update

            if ($urloper == "find") {
                  $nerr = $this->select($parAr);
            }
            if ($urloper == "findByName") {
                  $nerr = $this->selectByName($parAr, $name);
            }
            if ($urloper == "update" || $urloper == "insert" || $urloper == "find" || $urloper == "findByName") {
                  header("Location:departamentos.php");
            }
      }

      function fillGrid($pn = 0, $parname = "", $parvalue = "")
      {
            $par = "";
            $par = "";
            $arrCol = array("id", "code", "name", "observation", "generator", "
active", "deleted");
            return parent::fillGrid($arrCol, $par, $pn, $pageSize = 10);
      }
}
