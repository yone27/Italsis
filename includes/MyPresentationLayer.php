
<?php
session_start();

chdir(dirname(__FILE__));
include_once("../../../../includes/presentationLayer.php");

class MyPresentationLayer extends presentationLayer
{
	static function buildButtonsActions($bpl, $save = "Y", $delete = "Y", $print = "Y", $clean = "Y", $find = "Y")
	{
		$bpl->showButtons($save, $delete, $print, $clean, $find);
	}
}

?>