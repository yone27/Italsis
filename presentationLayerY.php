<?php
include_once("../../../includes/presentationLayer.php");

session_start();

/*==========================================================================  
     Class: presentationLayerY
     Description: MVC View. Helper Methods
     Version: 1.0
     Remarks:
     ========================================================================*/

class presentationLayerY extends presentationLayer
{
    static function buildInput($title, $name, $id, $val, $maxlength = "50", $readonly = "", $onblur = "", $required = "")
    {
        echo '<LABEL>';
        echo '<SPAN>' . $title . '</SPAN>';

        $ID = $id ? 'id="' . $id . '"' : '';

        if ($onblur != "")
            $onblur = ' onBlur="' . $onblur . '" ';
        echo '<INPUT ' . $readonly . ' name = "' . $name . '" type="text"  ' . $ID . ' value = "' . $val . '" required = "' . $required . '" ';

        echo $onblur;
        echo 'maxlength="' . $maxlength . '" placeholder="' . $title . '"></INPUT>';
        echo '</LABEL>';
    }

    static function buildSelectWithComEvent(
        $title,
        $name,
        $id,
        $mod,
        $com,
        $valCol,
        $showCol,
        $curVal,
        $event = "",
        $required = ""
    ) {

        echo '<LABEL>';
        echo '<SPAN>' . $title . ' :</SPAN>';
        $event = 'onchange="' . $event . '"';

        echo '<SELECT name="' . $name . '"  required="' . $required . '" id="' . $id . '" ' . $event . ' >';
        $mod->fillComboCom($com, $valCol, $showCol, $curVal);

        echo '</SELECT>';
        echo '</LABEL>';
    }
}
