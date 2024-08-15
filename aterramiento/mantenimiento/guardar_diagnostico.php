<?php
include("../nuevos/conexion.php");

// Verificar si los datos necesarios están presentes
if (!isset($_POST['id_orden'], $_POST['Sintomaphp'], $_POST['Diagnosticophp'], $_POST['AccionesRealizadasphp'], $_POST['Conclusionesphp'])) {
    die("Error: Faltan datos en la solicitud.");
}

// Obtener y sanear los valores del formulario
$id_orden = mysqli_real_escape_string($conexion, $_POST['id_orden']);
$sintoma = mysqli_real_escape_string($conexion, $_POST['Sintomaphp']);
$diagnostico = mysqli_real_escape_string($conexion, $_POST['Diagnosticophp']);
$accionesRealizadas = mysqli_real_escape_string($conexion, $_POST['AccionesRealizadasphp']);
$conclusiones = mysqli_real_escape_string($conexion, $_POST['Conclusionesphp']);
$fechaInforme = date('Y-m-d H:i:s'); // Fecha y hora actuales
// Verificar si ya existe un registro con el $id_orden
$query = "SELECT IdMantDefectuoso FROM mantdefectuoso WHERE IdMantPrueba = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $id_orden);
$stmt->execute();
$result = $stmt->get_result();
$registro = $result->fetch_assoc();

if ($registro) {
    // Si el registro existe, actualizarlo
    $id_defectuoso = $registro['IdMantDefectuoso']; // Obtener el IdMantDefectuoso existente

    $query = "UPDATE mantdefectuoso SET Sintoma = ?, Diagnostico = ?, AccionesRealizadas = ?, Conclusiones = ?, FechaInforme = ? WHERE IdMantDefectuoso = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ssssss', $sintoma, $diagnostico, $accionesRealizadas, $conclusiones, $fechaInforme, $id_defectuoso);

    if ($stmt->execute()) {
        // Redirigir a otra página o mostrar un mensaje de éxito
        header("Location: InformeDefectuoso.php?id_orden=" . urlencode($id_orden));
    } else {
        die("Error: No se pudo actualizar el registro.");
    }
} else {
    // Si el registro no existe, crear uno nuevo

    // Obtener el año y el mes actuales
    $anio = date('y'); // Dos dígitos del año
    $mes = date('m');  // Dos dígitos del mes

    // Obtener el siguiente número secuencial
    $query = "SELECT MAX(IdMantDefectuoso) AS ultimo_id FROM mantdefectuoso WHERE IdMantDefectuoso LIKE CONCAT('DEF', ?, ?, '%')";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ss', $anio, $mes);
    $stmt->execute();
    $result = $stmt->get_result();
    $ultimo_id = $result->fetch_assoc()['ultimo_id'];

    if ($ultimo_id) {
        // Extraer el número secuencial del último ID
        $ultimo_correlativo = intval(substr($ultimo_id, -3));
        $nuevo_correlativo = str_pad($ultimo_correlativo + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $nuevo_correlativo = '001'; // Primer registro del mes/año
    }

    // Construir el nuevo ID
    $id_defectuoso = "DEF{$anio}{$mes}{$nuevo_correlativo}";

    // Insertar el nuevo registro en la tabla mantdefectuoso
    $query = "INSERT INTO mantdefectuoso (IdMantDefectuoso, IdMantPrueba, Sintoma, Diagnostico, AccionesRealizadas, Conclusiones, FechaInforme) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('sssssss', $id_defectuoso, $id_orden, $sintoma, $diagnostico, $accionesRealizadas, $conclusiones, $fechaInforme);

    if ($stmt->execute()) {
        // Redirigir a otra página o mostrar un mensaje de éxito
        header("Location: InformeDefectuoso.php?id_orden=" . urlencode($id_orden));
    } else {
        die("Error: No se pudo guardar el informe.");
    }
}

$stmt->close();
$conexion->close();
