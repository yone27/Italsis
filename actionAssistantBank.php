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
        ORDER BY id DESC
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
    $identitysubclass = $util->testInput($_GET['fetchDept']);
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
    $nameCompany = $util->testInput($_GET['fetchNameCompany']);
    $nameCompany = strtoupper($util->testInput($nameCompany));
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
    $code = $util->testInput($_POST['scode']);
    $name = $util->testInput($_POST['sname']);
    $idpartybankinfo = $util->testInput($_POST['idpartybankinfo']);
    $dateregister = date("Y-m-d");
    $idpartylocation = $util->testInput($_POST['infocompany']);
    $identitysubclass = $util->testInput($_POST['sidentitysubclass']);

    // Agregar registro
    $com = "
    INSERT INTO libertyweb.assistantbank(
        code, name,idpartybankinfo, dateregister, active, deleted, idpartylocation, identitysubclass)
        VALUES ('$code', '$name','$idpartybankinfo', '$dateregister', 'Y', 'N', '$idpartylocation', '$identitysubclass');
        ";
    $result = $dbl->executeCommand($com);

    // Actualizar registro para que no salga la cuenta agregada nuevamenet
    $comBankInfo = "
    UPDATE party.partybankinfo
    SET deleted='Y'
    WHERE id='$idpartybankinfo';
    ";
    $bankInfo = $dbl->executeCommand($comBankInfo);


    if ($result && $bankInfo) {
        echo $util->showMessage('success', 'Registro guardado exitosamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un problema');
    }
}

// handle fetch add acccount
if (isset($_POST['addAccount'])) {
    $bankaccount = $util->testInput($_POST['bankAccount']);
    $bankname = $util->testInput($_POST['bankName']);
    $idparty = $util->testInput($_POST['idparty']);

    $com = "
        INSERT INTO party.partybankinfo(
            idparty, bankname, bankaccount)
        VALUES ('$idparty', '$bankname','$bankaccount');
    ";

    $result = $dbl->executeCommand($com);
    if ($result) {
        echo $util->showMessage('success', 'Registro guardado exitosamente');
    } else {
        echo $util->showMessage('danger', 'Hubo un problema');
    }
}

// handle fetch data company
if (isset($_GET['fetchCompany'])) {
    $nameCompany = $util->testInput($_GET['fetchCompany']);
    $nameCompany = strtoupper($util->testInput($nameCompany));

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
    } else {
        echo json_encode(["error" => "data not match"]);
    }
}

// handle delete data fetch request
if (isset($_GET['delete'])) {
    $id = $util->testInput($_GET['id']);

    $qGetAsistantBank = "
    SELECT 
        -- assistantbank
        LA.id,
        LA.code,
        LA.idpartybankinfo
    FROM 
        libertyweb.assistantbank  LA
    WHERE
        LA.id = '$id'";

    $resAssistantBank = $dbl->executeReader($qGetAsistantBank);

    $test = $resAssistantBank[0];
    $idpartybankinfo = $test['idpartybankinfo'];

    // activamos nuevamente la cuenta en party
    $qUpdateBankInfo = "
    UPDATE party.partybankinfo
    SET deleted='N'
    WHERE id = '$idpartybankinfo'";

    $dbl->executeReader($qUpdateBankInfo);

    // eliminar registro de assistantbank
    $qDeleteAsistantBank = "
    DELETE FROM libertyweb.assistantbank
    WHERE id = '$id'";

    if ($dbl->executeCommand($qDeleteAsistantBank)) {
        echo $util->showMessage('info', 'Registro eliminado satisfactoriamente!');
    } else {
        echo $util->showMessage('danger', 'Hubo un error!');
    }
}

// handle edit data fetch request
if (isset($_GET['edit'])) {
    $id = $util->testInput($_GET['id']);

    $com = "
    SELECT 
        -- assistantbank
        LA.id,
        LA.code,
        LA.name, 
        LA.idpartybankinfo, 
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
    $id = $util->testInput($_POST['id']);
    $code = $util->testInput($_POST['code']);
    $name = $util->testInput($_POST['name']);
    $idpartylocation = $util->testInput($_POST['infocompany']);
    $identitysubclass = $util->testInput($_POST['identitysubclass']);

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

// Handle fetch accounts by company
if (isset($_GET['accountByIdparty'])) {
    $idpartylocation = $util->testInput($_GET['accountByIdparty']);
    $cond = $util->testInput($_GET['cond']);

    if($cond) {
        $test = "AND deleted = 'N';";
    }
    $test = 

    // TODAS LAS CUENTAS QUE TIENE EN PARTYBANKINFO
    $com = "
    SELECT id,bankname, bankaccount
    FROM party.partybankinfo
    WHERE idparty = '$idpartylocation'
    '$test'";
    
    $data = $dbl->executeReader($com);
    if ($data) {
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Ya agrego todas sus cuentas"]);
    }
}
