<?php
// Establece la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_dielectricos2";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para manejar valores nulos o vacíos en consultas SQL
function prepareValue($value, $isNumeric = false, $defaultValue = '')
{
    global $conn;
    if ($value === null || $value === '') {
        if ($isNumeric) {
            return $defaultValue !== '' ? $defaultValue : 0; // Para valores numéricos, devolvemos el valor por defecto o 0 si están vacíos o son nulos
        } else {
            return $defaultValue !== '' ? "'" . $conn->real_escape_string($defaultValue) . "'" : "''"; // Para valores no numéricos, devolvemos el valor por defecto o cadena vacía
        }
    }
    if ($isNumeric) {
        return $value; // Asume que ya es un número
    }
    return "'" . $conn->real_escape_string($value) . "'";
}

// Asignar valores de los campos del formulario y usar valores por defecto si están vacíos
$idOrdAterra = $_POST['idOrdAterraphp'] ?? '';
$idCliente = $_POST['idClientephp'] ?? '';
$Cantidad = $_POST['Cantidadphp'] ?? 1; // Asumimos que la cantidad es al menos 1
$Vendedor = $_POST['Vendedorphp'] ?? '';
$aterra = $_POST['aterraphp'] ?? '';
$FechaSolicitud = $_POST['FechaSolicitudphp'] ?? '';
$FechaEntrega = $_POST['FechaEntregaphp'] ?? '';

$MLinea = $_POST['MLineaphp'] ?? ''; // Valor por defecto para MLinea
$LongitudA = $_POST['LongitudAphp'] ?? ''; // Valor por defecto para LongitudA
$SeccionA = $_POST['SeccionAphp'] ?? ''; // Valor por defecto para SeccionA
$MTierra = $_POST['MTierraphp'] ?? ''; // Valor por defecto para MTierra
$LongitudB = $_POST['LongitudBphp'] ?? ''; // Valor por defecto para LongitudB
$SeccionB = $_POST['SeccionBphp'] ?? ''; // Valor por defecto para SeccionB
$TLinea = $_POST['TLineaphp'] ?? ''; // Valor por defecto para TLinea
$LongitudX = $_POST['LongitudXphp'] ?? ''; // Valor por defecto para LongitudX
$SeccionX = $_POST['SeccionXphp'] ?? ''; // Valor por defecto para SeccionX
$TerminalX = $_POST['TerminalXphp'] ?? ''; // Valor por defecto para TerminalX
$TTierra = $_POST['TTierraphp'] ?? ''; // Valor por defecto para TTierra

$Pertiga = $_POST['Pertigaphp'] ?? ''; // Valor por defecto para Pertiga
$Varilla = $_POST['Varillaphp'] ?? ''; // Valor por defecto para Varilla
$Adaptador = $_POST['Adaptadorphp'] ?? ''; // Valor por defecto para Adaptador
$Trifurcacion = $_POST['Trifurcacionphp'] ?? ''; // Valor por defecto para Trifurcacion
$Otros = $_POST['Otrosphp'] ?? ''; // Valor por defecto para Otros

$EstChico = $_POST['EstChico'] ?? '';
$EstGrande = $_POST['EstGrande'] ?? '';
$EstMetalico = $_POST['EstMetalico'] ?? '';
$EstPertiga = $_POST['EstPertiga'] ?? '';

// Obtener el año y mes actual para la generación del código
$currentYear = date('y'); // Obtener los últimos dos dígitos del año actual
$currentMonth = date('m'); // Obtener el mes actual en formato numérico de dos dígitos (por ejemplo, "07" para julio)

// Separar Cliente y Ruc
if ($idCliente !== null && $idCliente !== '') {
    $clienteRuc = explode('|', $idCliente);
    $Cliente = trim($clienteRuc[0]);
    $Ruc = trim($clienteRuc[1]);
} else {
    $Cliente = 'N/A';
    $Ruc = 'N/A';
}

// Insertar datos en la tabla ordaterra
$sql = "INSERT INTO ordaterra (idOrdAterra, Cliente, Ruc, Cantidad, Vendedor, FechaSolicitud, FechaEntrega, EstChico, EstGrande, EstMetalico, EstPertiga, TipoAterra, Estado)
        VALUES (" . prepareValue($idOrdAterra) . ", " . prepareValue($Cliente) . ", " . prepareValue($Ruc) . ", " . prepareValue($Cantidad, true) . ", " . prepareValue($Vendedor) . ", " . prepareValue($FechaSolicitud) . ", " . prepareValue($FechaEntrega) . ", " . prepareValue($EstChico) . ", " . prepareValue($EstGrande) . ", " . prepareValue($EstMetalico) . ", " . prepareValue($EstPertiga) . ", " . prepareValue($aterra) . ", 'Pendiente')";

if ($conn->query($sql) !== TRUE) {
    $error = $conn->error;
    $conn->close();
    header("Location: error.php?error=" . urlencode($error));
    exit();
}

// Consultar el último número correlativo del mes actual y año actual para `idDetOrdAterra`
$sql = "SELECT MAX(SUBSTRING(idDetOrdAterra, 8, 3)) AS maxId 
        FROM det_ord_aterra 
        WHERE SUBSTRING(idDetOrdAterra, 4, 2) = '$currentYear' 
        AND SUBSTRING(idDetOrdAterra, 6, 2) = '$currentMonth'";
$result = $conn->query($sql);

$nextId = 1; // Si no hay registros previos, empezamos con 1
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $maxId = $row['maxId'];
    if ($maxId !== null) {
        $nextId = (int)$maxId + 1;
    }
}

// Consultar el último número correlativo del mes actual y año actual para `Serie`
$sqlSerie = "SELECT MAX(SUBSTRING(Serie, 5, 3)) AS maxSerie 
             FROM det_ord_aterra 
             WHERE SUBSTRING(Serie, 1, 2) = '$currentYear' 
             AND SUBSTRING(Serie, 3, 2) = '$currentMonth'";
$resultSerie = $conn->query($sqlSerie);

$nextSerie = 1; // Si no hay registros previos, empezamos con 1
if ($resultSerie && $resultSerie->num_rows > 0) {
    $rowSerie = $resultSerie->fetch_assoc();
    $maxSerie = $rowSerie['maxSerie'];
    if ($maxSerie !== null) {
        $nextSerie = (int)$maxSerie + 1;
    }
}

// Consultar el último número correlativo del mes actual y año actual para `idDetAcc`
$sqlAcc = "SELECT MAX(SUBSTRING(idDetAcc, 8, 3)) AS maxAcc 
           FROM acc_ord_aterra 
           WHERE SUBSTRING(idDetAcc, 4, 2) = '$currentYear' 
           AND SUBSTRING(idDetAcc, 6, 2) = '$currentMonth'";
$resultAcc = $conn->query($sqlAcc);

$nextAcc = 1; // Si no hay registros previos, empezamos con 1
if ($resultAcc && $resultAcc->num_rows > 0) {
    $rowAcc = $resultAcc->fetch_assoc();
    $maxAcc = $rowAcc['maxAcc'];
    if ($maxAcc !== null) {
        $nextAcc = (int)$maxAcc + 1;
    }
}

// Consultar el último número correlativo del mes actual y año actual para `IdPrueba`
$sqlPrueba = "SELECT MAX(SUBSTRING(IdPrueba, 8, 3)) AS maxPrueba 
              FROM ordprueba 
              WHERE SUBSTRING(IdPrueba, 4, 2) = '$currentYear' 
              AND SUBSTRING(IdPrueba, 6, 2) = '$currentMonth'";
$resultPrueba = $conn->query($sqlPrueba);

$nextPrueba = 1; // Si no hay registros previos, empezamos con 1
if ($resultPrueba && $resultPrueba->num_rows > 0) {
    $rowPrueba = $resultPrueba->fetch_assoc();
    $maxPrueba = $rowPrueba['maxPrueba'];
    if ($maxPrueba !== null) {
        $nextPrueba = (int)$maxPrueba + 1;
    }
}

// Insertar datos en la tabla det_ord_aterra y acc_ord_aterra según la cantidad especificada
for ($i = 0; $i < $Cantidad; $i++) {
    // Generar el código `idDetOrdAterra` con el formato especificado
    $idDetOrdAterra = "DET$currentYear$currentMonth" . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    $Serie = "$currentYear$currentMonth" . str_pad($nextSerie, 3, '0', STR_PAD_LEFT);

 // Insertar el registro en det_ord_aterra
 $sqlInsertDetOrdAterra = "INSERT INTO det_ord_aterra (idDetOrdAterra, idOrdAterra, Serie, MLinea, LongitudA, SeccionA, MTierra, LongitudB, SeccionB, TLinea, LongitudX, SeccionX, TerminalX, TTierra, FechaSolicitud)
 VALUES ('$idDetOrdAterra', " . prepareValue($idOrdAterra) . ", '$Serie', " . prepareValue($MLinea) . ", " . prepareValue($LongitudA) . ", " . prepareValue($SeccionA) . ", " . prepareValue($MTierra) . ", " . prepareValue($LongitudB) . ", " . prepareValue($SeccionB) . ", " . prepareValue($TLinea) . ", " . prepareValue($LongitudX) . ", " . prepareValue($SeccionX) . ", " . prepareValue($TerminalX) . ", " . prepareValue($TTierra) . ", " . prepareValue($FechaSolicitud) . ")";
if ($conn->query($sqlInsertDetOrdAterra) !== TRUE) {
    $error = $conn->error;
    $conn->close();
    header("Location: error.php?error=" . urlencode($error));
    exit();
}

    // Generar el código `idDetAcc` con el formato especificado
    $idDetAcc = "ACC$currentYear$currentMonth" . str_pad($nextAcc, 3, '0', STR_PAD_LEFT);

    // Insertar el registro en acc_ord_aterra
    $sqlInsertAccOrdAterra = "INSERT INTO acc_ord_aterra (idDetAcc, idDetOrdAterra, Pertiga, Varilla, Adaptador, Otros, Trifurcacion, FechaSolicitud)
    VALUES ('$idDetAcc', '$idDetOrdAterra', " . prepareValue($Pertiga) . ", " . prepareValue($Varilla) . ", " . prepareValue($Adaptador) . ", " . prepareValue($Otros) . ", " . prepareValue($Trifurcacion) . ", " . prepareValue($FechaSolicitud) . ")";

if ($conn->query($sqlInsertAccOrdAterra) !== TRUE) {
    $error = $conn->error;
    $conn->close();
    header("Location: error.php?error=" . urlencode($error));
    exit();
}

    // Generar el código `IdPrueba` con el formato especificado
    $IdPrueba = "PRU$currentYear$currentMonth" . str_pad($nextPrueba, 3, '0', STR_PAD_LEFT);

    // Definir el valor de Tramo basado en TipoAterra
    if ($aterra === 'ENA') {
        $Tramo = 'R-S|S-T|T-GND';
    } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
        $Tramo = 'R-GND';
    } elseif (in_array($aterra, ['P03', 'PEL'])) {
        $Tramo = 'R-N-GND|S-N-GND|T-N-GND';
    } elseif (in_array($aterra, ['TRA', 'TPF'])) {
        $Tramo = 'R-S-T|S-GND';
    } elseif (in_array($aterra, ['U03', 'UPF', 'USA', 'UMT'])) {
        $Tramo = 'R-GND|S-GND|T-GND';
    } else {
        $Tramo = '';
    }

    // Definir el valor de LongitudTotal basado en TipoAterra
    if ($aterra === 'ENA') {
        $LongitudTotal = "$LongitudA|$LongitudA|$LongitudB";
    } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
        $LongitudTotal = "$LongitudA";
    } elseif (in_array($aterra, ['P03'])) {
        $LongitudTotal = ($LongitudA + $LongitudB) . '|' . ($LongitudA + $LongitudB) . '|' . ($LongitudA + $LongitudB);
    } elseif (in_array($aterra, ['PEL'])) {
        $LongitudTotal = "$LongitudB|$LongitudB|$LongitudB";
    } elseif (in_array($aterra, ['TRA', 'TPF'])) {
        $LongitudTotal = "$LongitudA|$LongitudB";
    } elseif (in_array($aterra, ['U03', 'UPF'])) {
        $LongitudTotal = "$LongitudA|$LongitudA|$LongitudA";
    } elseif (in_array($aterra, ['USA'])) {
        $LongitudTotal = "$LongitudA|$LongitudB|$LongitudX";
    } elseif (in_array($aterra, ['UMT'])) {
        $LongitudTotal = "$LongitudA|$LongitudA|$LongitudB";
    } else {
        $LongitudTotal = 0;
    }

    // Definir el valor de ValorMedido basado en TipoAterra
    if ($aterra === 'ENA') {
        $ValorMedido = "||";
    } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
        $ValorMedido = "";
    } elseif (in_array($aterra, ['P03', 'PEL'])) {
        $ValorMedido = "||";
    } elseif (in_array($aterra, ['TRA', 'TPF'])) {
        $ValorMedido = "|";
    } elseif (in_array($aterra, ['U03', 'UPF'])) {
        $ValorMedido = "||";
    } elseif (in_array($aterra, ['USA'])) {
        $ValorMedido = "||";
    } elseif (in_array($aterra, ['UMT'])) {
        $ValorMedido = "||";
    } else {
        $ValorMedido = 0;
    }


    // Definir el valor de  MaxPermisible basado en TipoAterra
    if ($aterra === 'ENA') {
        $MaxPermisible = "||";
    } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
        $MaxPermisible = "";
    } elseif (in_array($aterra, ['P03', 'PEL'])) {
        $MaxPermisible = "||";
    } elseif (in_array($aterra, ['TRA', 'TPF'])) {
        $MaxPermisible = "|";
    } elseif (in_array($aterra, ['U03', 'UPF'])) {
        $MaxPermisible = "||";
    } elseif (in_array($aterra, ['USA'])) {
        $MaxPermisible = "||";
    } elseif (in_array($aterra, ['UMT'])) {
        $MaxPermisible = "||";
    } else {
        $MaxPermisible = 0;
    }

    // Definir el valor del Resultado basado en TipoAterra
    if ($aterra === 'ENA') {
        $Resultado = "Pendiente|Pendiente|Pendiente";
    } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
        $Resultado = "Pendiente";
    } elseif (in_array($aterra, ['P03', 'PEL'])) {
        $Resultado = "Pendiente|Pendiente|Pendiente";
    } elseif (in_array($aterra, ['TRA', 'TPF'])) {
        $Resultado = "Pendiente|Pendiente";
    } elseif (in_array($aterra, ['U03', 'UPF'])) {
        $Resultado = "Pendiente|Pendiente|Pendiente";
    } elseif (in_array($aterra, ['USA'])) {
        $Resultado = "Pendiente|Pendiente|Pendiente";
    } elseif (in_array($aterra, ['UMT'])) {
        $Resultado = "Pendiente|Pendiente|Pendiente";
    } else {
        $Resultado = 0;
    }

    // Definir el valor de CorrienteAplicada basado en TipoAterra y SeccionA y SeccionB
    $corrienteMap = [
        25 => 150,
        35 => 200,
        50 => 250,
        70 => 300,
        95 => 400,
    ];

    if ($aterra === 'ENA') {
        $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
        $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaA|$CorrienteAplicadaB"; // Selecciona el valor más alto
    } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
        $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaA";
    } elseif (in_array($aterra, ['P03', 'PEL'])) {
        $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaB|$CorrienteAplicadaB|$CorrienteAplicadaB";
    } elseif (in_array($aterra, ['TRA', 'TPF'])) {
        $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
        $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaB";
    } elseif (in_array($aterra, ['U03', 'UPF'])) {
        $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaA|$CorrienteAplicadaA";
    } elseif (in_array($aterra, ['USA'])) {
        $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
        $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
        $CorrienteAplicadaX = isset($corrienteMap[$SeccionX]) ? $corrienteMap[$SeccionX] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaB|$CorrienteAplicadaX";
    } elseif (in_array($aterra, ['UMT'])) {
        $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
        $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
        $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaA|$CorrienteAplicadaB";
    } else {
        $CorrienteAplicada = 0;
    }


    // Insertar el registro en ordprueba
    $sqlInsertOrdPrueba = "INSERT INTO ordprueba (IdPrueba, Serie, Tramo, LongitudTotal, CorrienteAplicada, ValorMedido, MaxPermisible, Resultado, FechaPrueba)
    VALUES ('$IdPrueba', '$Serie', '$Tramo', '$LongitudTotal', '$CorrienteAplicada', '$ValorMedido', '$MaxPermisible', '$Resultado', '')";

if ($conn->query($sqlInsertOrdPrueba) !== TRUE) {
    $error = $conn->error;
    $conn->close();
    header("Location: error.php?error=" . urlencode($error));
    exit();
}

    // Incrementar los números para los siguientes códigos
    $nextId++;
    $nextSerie++;
    $nextAcc++;
    $nextPrueba++;
}

// Cerrar la conexión
$conn->close();
// Redirige al index.php después de la inserción exitosa
header("Location: index.php");
exit();
