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
            id,
            code,
            name,
            identityclass,
            observation,
            identitysubclass
        FROM
            base.entitysubclass
        WHERE
            deleted = 'N'
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
    $code = $_POST['code'];
    $name = $_POST['name'];
    $observation = $_POST['observation'];
    $generator = $_POST['generator'];

    $com = "
        INSERT INTO base.entitysubClass(
            code, name, observation, generator, active, deleted)
        VALUES ('$code', '$name', '$observation', '$generator', 'Y', 'N');
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
    $id = $_GET['id'];

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
    $id = $_GET['id'];

    $com = "
    SELECT 
        -- assistantbank
        BE.id,
        BE.code,
        BE.name, 
        BE.observation,
        BE.generator
    FROM 
        base.entitysubclass BE
    WHERE
        BE.deleted = 'N'
    AND 
        BE.id = '$id'";

    $data = $dbl->executeReader($com);

    if ($data) {
        echo json_encode($data);
    } else {
        echo $util->showMessage('danger', 'Hubo un problema');
    }
}

// handle update data fetch request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $observation = $_POST['observation'];
    $generator = $_POST['generator'];

    $com = "
    UPDATE base.entitysubclass
    SET code='$code', name='$name', observation='$observation', generator='$generator'
    WHERE id='$id';
    ";
    $result = $dbl->executeCommand($com);
    if ($result) {
        echo $util->showMessage('success', 'Datos actualizados satisfactoriamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un Error');
    }
}
