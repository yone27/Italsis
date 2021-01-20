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

	// assummed id, first position
	// function select(&$parAr)
	// {
	// 	$nerr = false;
	// 	$name = $this->scheme . ".isspget" . $this->table;
	// 	$ne = count($parAr);
	// 	for ($i = 1; $i < $ne; $i++) {
	// 		$parAr[$i] = "";
	// 	}
	// 	$nerr = $this->dl->executeSPget($name, $parAr[0], $parAr);

	// 	return ($nerr);
	// }

	function selectByDept(&$parAr)
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

	// assummed id, first position
	function select(&$parAr)
	{
		$nerr = false;
		$ne = count($parAr);
		for ($i = 1; $i < $ne; $i++) {
			$parAr[$i] = "";
		}

		$com = "
		SELECT 
			LA.id,
			LA.code,
			LA.name, 
			LA.idaccassistant, 	
			PP.name AS companyname,
			BES.id AS dept
		FROM 	
			libertyweb.assistantbank  LA,
			party.party  PP,
			base.entitysubclass BES
		WHERE
			LA.id = '$parAr[0]'
		AND
			LA.idpartylocation = PP.id
		AND	
			LA.identitysubclass = BES.id
		";

		$nerr = $this->dl->executeReader($com);
		$res = $nerr[0];

		$parAr[0] = $res["id"];
		$parAr[1] = $res["code"];
		$parAr[2] = $res["name"];
		$parAr[4] = $res["idaccassistant"];
		$parAr[9] = $res["companyname"];
		$parAr[10] = $res["dept"];
		return ($nerr);
	}

	function selectByCompany(&$parAr)
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

	function execute($urloper, &$parAr, $name = "")
	{
		if ($urloper == "findByDept") {
			/*$identitysubclass = $_POST['identitysubclass'];
			$com = "
			SELECT 
				-- assistantbank
				LA.id,
				LA.code,
				LA.name, 
				LA.dateregister,
				-- Nombre de la compañia
				PP.name AS companyname,
				-- Nombre del departamento
				BES.name AS dept
			FROM 
				libertyweb.assistantbank  LA,
				party.party  PP,
				base.entitysubclass BES
			WHERE
				LA.idpartylocation = PP.id
			AND	
				LA.identitysubclass = BES.id
			AND	
				BES.id = '$identitysubclass'
			";
			//$nerr = $this->selectByDept($parAr);
			$dbl = new baseBL();
			$arr = $dbl->executeReader($com);
			$arrCol = array("Id", "Codigo", "Cuenta", "Fecha", "Nombre Comp", "Dept");


			$this->fillGridArrPaginator($arr, $arrCol);*/
		}

		if ($urloper == "findByCompany") {
			$nerr = $this->selectByCompany($parAr);
			var_dump($_POST['idpartylocation']);
			die();
		}

		if ($urloper == "find") {
			$nerr = $this->select($parAr);
		}
	}
	function fillGridDisplayPaginator($com = "", $arrCol = "")
	{
		if ($com == "") {
			// $com = "select * from " . $this->scheme . ".isspget" . $this->table . "display()";
			$com = "
				SELECT 
					-- assistantbank
					LA.id,
					LA.code,
					LA.name, 
					LA.dateregister,
					-- Nombre de la compañia
					PP.name AS companyname,
					-- Nombre del departamento
					BES.name AS dept
				FROM 
					libertyweb.assistantbank  LA,
					party.party  PP,
					base.entitysubclass BES
				WHERE
					LA.idpartylocation = PP.id
				AND	
					LA.identitysubclass = BES.id			
                ";
		}

		$dbl = new baseBL();
		$arr = $dbl->executeReader($com);

		if ($arrCol == "") {
			$arrCol = array("Id", "Codigo", "Cuenta", "Fecha", "Nombre Comp", "Dept");
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
}
