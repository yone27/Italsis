<?php

include_once("../base/baseBL.php");
require_once 'util.php';

$dbl = new baseBL();
$util = new Util;
$errors = [];

// handle fetch all
if (isset($_GET['fetchAll'])) {
    $q = "
    SELECT
        BESC.id,
        BESC.code,
        BESC.name,
        BEC.name as entityclass,
        BESC.observation
    FROM
        base.entitysubclass BESC,
        base.entityclass BEC
    WHERE
        BESC.deleted = 'N'
    AND
        BESC.identityclass= BEC.id
    ORDER BY BESC.id DESC
        ";
    $data = $dbl->executeReader($q);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["nodata" => "<tr><td colspan='7'>No se encontro datos relacionados</td></tr>"]);
    }
}

// handle fetch add
if (isset($_POST['add'])) {
    $code = $util->testInput($_POST['code']);
    $name = $util->testInput($_POST['name']);
    $identityclass = $util->testInput($_POST['entityclassSelect']);
    $observation = $util->testInput($_POST['observation']);

    $com = "
        INSERT INTO base.entitysubClass(
            code, name,identityclass, observation, active, deleted)
        VALUES ('$code', '$name','$identityclass', '$observation', 'Y', 'N');
    ";
    $result = $dbl->executeCommand($com);
    if ($result) {
        echo $util->showMessage('success', 'Registro guardado exitosamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un problema');
    }
}

// handle delete data fetch request
if (isset($_GET['delete'])) {
    $id =  $util->testInput($_GET['id']);

    $com = "
    UPDATE base.entitysubclass
    SET deleted='Y'
    WHERE id = '$id'";
    $result = $dbl->executeCommand($com);

    if ($result) {
        echo $util->showMessage('info', 'Registro eliminado satisfactoriamente!');
    } else {
        echo $util->showMessage('danger', 'Hubo un error!');
    }
}

// handle edit data fetch request
if (isset($_GET['edit'])) {
    $id =  $util->testInput($_GET['id']);

    $com = "
    SELECT
        BESC.id,
        BESC.code,
        BESC.name,
        BEC.name as entityclass,
        BESC.observation
    FROM
        base.entitysubclass BESC,
        base.entityclass BEC
    WHERE
        BESC.id = '$id'
    AND
        BESC.deleted = 'N'
    AND
        BESC.identityclass= BEC.id";

    $data = $dbl->executeReader($com);

    if ($data) {
        echo json_encode($data);
    } else {
        echo $util->showMessage('danger', 'Hubo un problema');
    }
}

// handle update data fetch request
if (isset($_POST['update'])) {
    $id =  $util->testInput($_POST['id']);
    $code =  $util->testInput($_POST['code']);
    $name =  $util->testInput($_POST['name']);
    $observation =  $util->testInput($_POST['observation']);
    $identityclass =  $util->testInput($_POST['entityclassSelect']);

    $com = "
    UPDATE base.entitysubclass
    SET code='$code', name='$name', observation='$observation', identityclass='$identityclass'
    WHERE id='$id';
    ";

    $result = $dbl->executeCommand($com);
    if ($result) {
        echo $util->showMessage('success', 'Datos actualizados satisfactoriamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un Error');
    }
}

// handle fetch data entityclass
if (isset($_GET['fetchEntityClass'])) {
    $entityclass =  $util->testInput($_GET['fetchEntityClass']);
    $entityclass = strtoupper($util->testInput($entityclass));

    $com = "
    SELECT 
        -- Nombre de la compañia
        BEC.name,
        BEC.id
    FROM 
        base.entityclass  BEC
    WHERE UPPER(BEC.name) LIKE '%$entityclass%'
        ";
    $data = $dbl->executeReader($com);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "data not match"]);
    }
}
