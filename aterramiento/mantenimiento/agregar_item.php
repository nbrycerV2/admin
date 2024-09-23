<?php
include '../nuevos/conexion.php'; // Ensure your database connection is included

// Get current year and month
$currentYear = date('y'); // Two-digit year
$currentMonth = date('m'); // Two-digit month

// Collect other data from the form
$id_orden = $_POST['id_orden'];
$Aterramiento = $_POST['Aterramientophp'];
$Marca = $_POST['Marcaphp'];
$Cantidad = (int)$_POST['Cantidadphp'];
$FechaPrueba = isset($_POST['FechaPrueba']) ? $_POST['FechaPrueba'] : date('Y-m-d H:i:s'); // Default to current date and time if not provided

// Define the value of Tramo based on Aterramiento
if ($Aterramiento === 'ENA') {
    $Tramo = 'R-S|S-T|T-GND';
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $Tramo = 'R-GND';
} elseif (in_array($Aterramiento, ['P03', 'PEL'])) {
    $Tramo = 'R-N-GND|S-N-GND|T-N-GND';
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $Tramo = 'R-S-T|S-GND';
} elseif (in_array($Aterramiento, ['U03', 'UPF', 'USA', 'UMT'])) {
    $Tramo = 'R-GND|S-GND|T-GND';
} else {
    $Tramo = '';
}

// Definir el valor de LongitudTotal basado en TipoAterra
if ($Aterramiento === 'ENA') {
    $LongitudTotal = "||";
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $LongitudTotal = "";
} elseif (in_array($Aterramiento, ['P03'])) {
    $LongitudTotal = "||";
} elseif (in_array($Aterramiento, ['PEL'])) {
    $LongitudTotal = "||";
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $LongitudTotal = "|";
} elseif (in_array($Aterramiento, ['U03', 'UPF'])) {
    $LongitudTotal = "||";
} elseif (in_array($Aterramiento, ['USA'])) {
    $LongitudTotal = "||";
} elseif (in_array($Aterramiento, ['UMT'])) {
    $LongitudTotal = "||";
} else {
    $LongitudTotal = 0;
}

// Definir el valor de LongitudTotal basado en TipoAterra
if ($Aterramiento === 'ENA') {
    $Seccion = "||";
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $Seccion = "";
} elseif (in_array($Aterramiento, ['P03'])) {
    $Seccion = "||";
} elseif (in_array($Aterramiento, ['PEL'])) {
    $Seccion = "||";
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $Seccion = "|";
} elseif (in_array($Aterramiento, ['U03', 'UPF'])) {
    $Seccion = "||";
} elseif (in_array($Aterramiento, ['USA'])) {
    $Seccion = "||";
} elseif (in_array($Aterramiento, ['UMT'])) {
    $Seccion = "||";
} else {
    $Seccion = 0;
}

// Definir el valor de  MaxPermisible basado en TipoAterra
if ($Aterramiento === 'ENA') {
    $MaxPermisible = "||";
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $MaxPermisible = "";
} elseif (in_array($Aterramiento, ['P03', 'PEL'])) {
    $MaxPermisible = "||";
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $MaxPermisible = "|";
} elseif (in_array($Aterramiento, ['U03', 'UPF'])) {
    $MaxPermisible = "||";
} elseif (in_array($Aterramiento, ['USA'])) {
    $MaxPermisible = "||";
} elseif (in_array($Aterramiento, ['UMT'])) {
    $MaxPermisible = "||";
} else {
    $MaxPermisible = 0;
}


// Definir el valor de ValorMedido basado en TipoAterra
if ($Aterramiento === 'ENA') {
    $ValorMedido = "||";
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $ValorMedido = "";
} elseif (in_array($Aterramiento, ['P03', 'PEL'])) {
    $ValorMedido = "||";
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $ValorMedido = "|";
} elseif (in_array($Aterramiento, ['U03', 'UPF'])) {
    $ValorMedido = "||";
} elseif (in_array($Aterramiento, ['USA'])) {
    $ValorMedido = "||";
} elseif (in_array($Aterramiento, ['UMT'])) {
    $ValorMedido = "||";
} else {
    $ValorMedido = 0;
}

// Definir el valor del Estado basado en TipoAterra
if ($Aterramiento === 'ENA') {
    $Estado = "Pendiente|Pendiente|Pendiente";
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $Estado = "Pendiente";
} elseif (in_array($Aterramiento, ['P03', 'PEL'])) {
    $Estado = "Pendiente|Pendiente|Pendiente";
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $Estado = "Pendiente|Pendiente";
} elseif (in_array($Aterramiento, ['U03', 'UPF'])) {
    $Estado = "Pendiente|Pendiente|Pendiente";
} elseif (in_array($Aterramiento, ['USA'])) {
    $Estado = "Pendiente|Pendiente|Pendiente";
} elseif (in_array($Aterramiento, ['UMT'])) {
    $Estado = "Pendiente|Pendiente|Pendiente";
} else {
    $Estado = 0;
}

// Definir el valor de la Corriente Aplicada basado en TipoAterra
if ($Aterramiento === 'ENA') {
    $CorrienteAplicada = "||";
} elseif (in_array($Aterramiento, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
    $CorrienteAplicada = "";
} elseif (in_array($Aterramiento, ['P03', 'PEL'])) {
    $CorrienteAplicada = "||";
} elseif (in_array($Aterramiento, ['TRA', 'TPF'])) {
    $CorrienteAplicada = "|";
} elseif (in_array($Aterramiento, ['U03', 'UPF'])) {
    $CorrienteAplicada = "||";
} elseif (in_array($Aterramiento, ['USA'])) {
    $CorrienteAplicada = "||";
} elseif (in_array($Aterramiento, ['UMT'])) {
    $CorrienteAplicada = "||";
} else {
    $CorrienteAplicada = 0;
}

// Get the maximum current sequence number
$sqlPrueba = "SELECT MAX(CAST(SUBSTRING(IdMantPrueba, 8, 3) AS UNSIGNED)) AS maxPrueba 
              FROM mantprueba 
              WHERE SUBSTRING(IdMantPrueba, 4, 2) = '$currentYear' 
              AND SUBSTRING(IdMantPrueba, 6, 2) = '$currentMonth'";
$resultPrueba = $conexion->query($sqlPrueba);

$nextPrueba = 1; // Start with 1 if no previous records
if ($resultPrueba && $resultPrueba->num_rows > 0) {
    $rowPrueba = $resultPrueba->fetch_assoc();
    $maxPrueba = $rowPrueba['maxPrueba'];
    if ($maxPrueba !== null) {
        $nextPrueba = (int)$maxPrueba + 1;
    }
}

// Insert multiple records based on Cantidad
for ($i = 0; $i < $Cantidad; $i++) {
    // Format the nextPrueba to ensure it has leading zeros if necessary
    $nextPruebaFormatted = str_pad($nextPrueba, 3, '0', STR_PAD_LEFT);

    // Generate the IdMantPrueba with the specified format
    $IdMantPrueba = "PRU$currentYear$currentMonth$nextPruebaFormatted";

    // Insert data into the database
    $sql = "INSERT INTO mantprueba (IdMantPrueba, IdOrdMant, Serie, Aterramiento, Marca, Tramo, LongitudTotal, Seccion, CorrienteAplicada, ValorMedido, MaxPermisible, Estado, FechaPrueba)
            VALUES ('$IdMantPrueba', '$id_orden', '', '$Aterramiento', '$Marca', '$Tramo', '$LongitudTotal', '$Seccion','$CorrienteAplicada', '$ValorMedido', '$MaxPermisible', '$Estado', '$FechaPrueba')";

    if (!$conexion->query($sql)) {
        echo "Error: " . $sql . "<br>" . $conexion->error;
        $conexion->close();
        exit();
    }

    $nextPrueba++; // Increment for the next record
}

// Update or insert the Cantidad in the ordaterramiento table
$sqlCheckCantidad = "SELECT Cantidad FROM ordmantenimiento WHERE IdOrdMant = '$id_orden'";
$resultCantidad = $conexion->query($sqlCheckCantidad);

if ($resultCantidad && $resultCantidad->num_rows > 0) {
    // If there's an existing Cantidad, add the new value to it
    $rowCantidad = $resultCantidad->fetch_assoc();
    $newCantidad = $rowCantidad['Cantidad'] + $Cantidad;
    $sqlUpdateCantidad = "UPDATE ordmantenimiento SET Cantidad = '$newCantidad' WHERE IdOrdMant = '$id_orden'";
} else {
    // If no Cantidad exists, insert a new record with the Cantidad
    $sqlUpdateCantidad = "INSERT INTO ordmantenimiento (IdOrdMant, Cantidad) VALUES ('$id_orden', '$Cantidad')";
}

if (!$conexion->query($sqlUpdateCantidad)) {
    echo "Error: " . $sqlUpdateCantidad . "<br>" . $conexion->error;
    $conexion->close();
    exit();
}

// Redirect after successful insertion of all records
header("Location: orden.php?IdOrdMant=" . urlencode($id_orden));

$conexion->close();
