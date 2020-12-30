<?php

error_reporting(0);
chdir(dirname(__FILE__));
include_once("../base/basePL.php");
chdir(dirname(__FILE__));
include_once("../../../includes/presentationLayer.php");

basePL::buildjs();
basePL::buildccs();
?>

<html>

<head>
    <title>Tabla contenedora</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
    <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: 10px;">
        <li class="nav-item">
            <a class="nav-link active" id="dept-tab" data-toggle="tab" href="#dept" role="tab" aria-controls="dept" aria-selected="true">Departamentos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="subdept-tab" data-toggle="tab" href="#subdept" role="tab" aria-controls="subdept" aria-selected="false">Sub Departamentos</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane show active" id="dept" role="tabpanel" aria-labelledby="dept-tab">
            <?php require('entityclassPL.php'); ?>
        </div>
        <div class="tab-pane" id="subdept" role="tabpanel" aria-labelledby="subdept-tab">
            <?php require('entitysubclassPL.php'); ?>
        </div>
    </div>
</body>

</html>