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

class entityclassBL extends baseBL
{
      // entityclass
      protected $observation;
      protected $generator;

      // entitysubclass
      protected $tableSub;
      protected $codeSub;
      protected $nameSub;
      protected $identityclass;
      protected $observationSub;
      protected $activeSub;
      protected $deletedSub;


      function __construct(
            $code,
            $name,
            $observation,
            $generator,
            $active,
            $deleted,
            $codeSub,
            $nameSub,
            $identityclass,
            $observationSub,
            $activeSub,
            $deletedSub
      ) {

            $scheme = "base";
            $table = "entityclass";
            $this->observation  = $observation;
            $this->generator  = $generator;

            // entitysubclass
            $this->tableSub = "entitysubclass";;
            $this->codeSub = $codeSub;
            $this->nameSub = $nameSub;
            $this->identityclass = $identityclass;
            $this->observationSub  = $observationSub;
            $this->activeSub = $activeSub;
            $this->deletedSub = $deletedSub;

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
      // Entityclass
      {
            $A[] = utilities::buildS($this->code);
            $A[] = utilities::buildS($this->name);
            $A[] = utilities::buildS($this->observation);
            $A[] = utilities::buildS($this->generator);
            $A[] = utilities::buildS($this->active);
            $A[] = utilities::buildS($this->deleted);
            // Entitysubclass
            $A[] = utilities::buildS($this->codeSub);
            $A[] = utilities::buildS($this->nameSub);
            $A[] = utilities::buildS($this->observationSub);
            $A[] = utilities::buildS($this->identityclass);
            $A[] = utilities::buildS($this->activeSub);
            $A[] = utilities::buildS($this->deletedSub);
      }

      function fillGrid($pn = 0, $parname = "", $parvalue = "")
      {
            $par = "";
            $par = "";
            $arrCol = array("id", "code", "name", "observation", "generator", "active", "deleted");
            return parent::fillGrid($arrCol, $par, $pn, $pageSize = 10);
      }

      function execute($urloper, &$parAr, $name = "")
      {
            if ($urloper == "insert") {
                  var_dump($parAr);
                  die();
                  $nerr = $this->insert($parAr);
                  if ($nerr === true)
                        $msg = "Insert Operation OK. ";
                  else
                        $msg = "Insert Operation Failed. ";
                  utilities::alert($msg);
            }
            parent::execute($urloper, $parAr, $name = "");
      }
}
