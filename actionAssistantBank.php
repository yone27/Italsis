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
            LA.deleted = 'N'
        ";
    $data = $dbl->executeReader($q);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["nodata" => "<tr><td colspan='7'>No se encontro datos relacionados</td></tr>"]);
    }
}

// handle fetch filter by Departamento
if (isset($_GET['fetchDept'])) {
    $identitysubclass = $_GET['fetchDept'];
    if ($identitysubclass) {
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
            AND	
                LA.deleted = 'N'
            ";
        $data = $dbl->executeReader($com);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(["nodata" => "<tr><td colspan='7'>No se encontro datos relacionados</td></tr>"]);
        }
    }
}

// handle fetch filter by Company Name
if (isset($_GET['fetchNameCompany'])) {
    $nameCompany = $_GET['fetchNameCompany'];
    $nameCompany = strtoupper($nameCompany);
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
    UPPER(PP.name) LIKE '%$nameCompany%'
    AND	
        LA.identitysubclass = BES.id
    AND	
        LA.deleted = 'N'
        ";
    $data = $dbl->executeReader($com);

    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["nodata" => "<tr><td colspan='7'>No se encontro datos relacionados</td></tr>"]);
    }
}

// handle fetch add
if (isset($_POST['add'])) {
    $code = $_POST['scode'];
    $name = $_POST['sname'];
    $dateregister = date("Y-m-d");
    $idpartylocation = $_POST['infocompany'];
    $identitysubclass = $_POST['sidentitysubclass'];

    $com = "
        INSERT INTO libertyweb.assistantbank(
            code, name, dateregister, active, deleted, idpartylocation, identitysubclass)
        VALUES ('$code', '$name', '$dateregister', 'Y', 'N', '$idpartylocation', '$identitysubclass');
    ";

    $result = $dbl->executeCommand($com);
    print_r($result);
    if ($result) {
        echo $util->showMessage('success', 'Registro guardado exitosamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un problema');
    }
}

// handle fetch data company
if (isset($_GET['fetchCompany'])) {
    $nameCompany = $_GET['fetchCompany'];
    $nameCompany = strtoupper($nameCompany);

    $com = "
    SELECT 
        -- Nombre de la compañia
        PP.name,
        PP.id
    FROM 
        party.party  PP
    WHERE UPPER(PP.name) LIKE '%$nameCompany%'
        ";
    $data = $dbl->executeReader($com);

    if ($data) {
        echo json_encode($data);
    }else{
        echo json_encode(["error" => "data not match"]);
    }
}

// handle delete data fetch request
if (isset($_GET['delete'])) {
    $id = $_GET['id'];

    $com = "
    UPDATE libertyweb.assistantbank
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
        LA.id,
        LA.code,
        LA.name, 
        LA.dateregister,
        -- Nombre de la compañia
        PP.name AS companyname,
        -- Nombre del departamento
        LA.identitysubclass AS dept
    FROM 
        libertyweb.assistantbank  LA,
        party.party  PP,
        base.entitysubclass BES
    WHERE
        LA.idpartylocation = PP.id
    AND	
        LA.identitysubclass = BES.id
    AND	
        LA.deleted = 'N'
    AND 
        LA.id = '$id'";
    $data = $dbl->executeReader($com);

    if ($data) {
        echo json_encode($data);
    } else {
        echo $util->showMessage('danger', 'Tu te la tiras de hacker?!');
    }
}

// handle update data fetch request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $code = $_POST['code'];
    $name = $_POST['name'];
    $idpartylocation = $_POST['infocompany'];
    $identitysubclass = $_POST['identitysubclass'];

    $com = "
    UPDATE libertyweb.assistantbank
    SET code='$code', name='$name', idpartylocation='$idpartylocation', identitysubclass='$identitysubclass'
    WHERE id='$id';
    ";
    $result = $dbl->executeCommand($com);
    if ($result) {
        echo $util->showMessage('success', 'Datos actualizados satisfactoriamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un Error');
    }
}
