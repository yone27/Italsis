<?php

error_reporting(0);
chdir(dirname(__FILE__));
include_once("../base/basePL.php");
chdir(dirname(__FILE__));
include_once("./presentationLayerY.php");

basePL::buildjs();
basePL::buildccs();
?>

<html>

<head>
    <title>Tabla maestra</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous"> -->

    <link rel="stylesheet" href="assets/css/modal.css">
    <link rel="stylesheet" href="assets/css/alerts.css">
    <link rel="stylesheet" href="assets/css/pagination.css">
    <link rel="stylesheet" href="assets/css/inputs.css">
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body class="container-custom">
    <div id="showAlert"></div>

    <header>
        <nav>
            <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-bottom: 10px;">
                <li class="nav-item">
                    <a class="nav-link active" id="dept-tab" data-toggle="tab" href="#dept" role="tab" aria-controls="dept" aria-selected="true">Departamentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="subdept-tab" data-toggle="tab" href="#subdept" role="tab" aria-controls="subdept" aria-selected="false">Sub Departamentos</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="tab-content" id="myTabContent">
            <section class="tab-pane italsis show active" id="dept" role="tabpanel" aria-labelledby="dept-tab">
                <?php require('./partials/entityclass.php'); ?>
            </section>
            <section class="tab-pane italsis" id="subdept" role="tabpanel" aria-labelledby="subdept-tab">
                <?php require('./partials/entitysubclass.php'); ?>
            </section>
        </div>
    </main>

    <?php include './modals/modal_entitySubClassEdit.php'; ?>
    <?php include './modals/modal_entitySubClass.php'; ?>

    <?php include './modals/modal_entityClassEdit.php'; ?>
    <?php include './modals/modal_entityClass.php'; ?>

    <script type="module" src="assets/js/entityClass.js"></script>
    <script type="module" src="assets/js/entitySubClass.js"></script>
</body>

</html>