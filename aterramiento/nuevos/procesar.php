<?php
include("conexion.php");

if (isset($_GET['funcion']) && $_GET['funcion'] == 'edito_orden') {
    // Obtener los datos del formulario
    $id_orden = $_POST['id_orden'];
    $cliente = $_POST['idClientephp'];
    $ruc = $_POST['Rucphp'];
    $vendedor = $_POST['Vendedorphp'];
    $fechaEntrega = $_POST['FechaEntregaphp'];
    $fechaInforme = $_POST['FechaInformephp'];
    $estado = $_POST['Estadophp'];

    // Obtener la hora actual en formato H:i:s
    $horaActual = date('H:i:s');

    // Consultar el valor actual de FechaEntrega y FechaInforme
    $queryCurrent = "SELECT FechaEntrega, FechaInforme FROM ordaterra WHERE idOrdAterra = '$id_orden'";
    $result = $conexion->query($queryCurrent);

    if ($result && $row = $result->fetch_assoc()) {
        $currentFechaEntrega = $row['FechaEntrega'];
        $currentFechaInforme = $row['FechaInforme'];

        // Inicializar la consulta de actualización
        $query = "UPDATE ordaterra SET 
                  Cliente = '$cliente', 
                  Ruc = '$ruc', 
                  Vendedor = '$vendedor', 
                  Estado = '$estado'";

        // Solo agregar la hora a FechaEntrega si se ha modificado
        if (!empty($fechaEntrega) && $fechaEntrega !== date('Y-m-d', strtotime($currentFechaEntrega))) {
            $fechaEntrega .= ' ' . $horaActual;
            $query .= ", FechaEntrega = '$fechaEntrega'";
        }

        // Solo agregar la hora a FechaInforme si se ha modificado
        if (!empty($fechaInforme) && $fechaInforme !== date('Y-m-d', strtotime($currentFechaInforme))) {
            $fechaInforme .= ' ' . $horaActual;
            $query .= ", FechaInforme = '$fechaInforme'";
        }

        // Finalizar la consulta
        $query .= " WHERE idOrdAterra = '$id_orden'";

        // Ejecutar la consulta
        if ($conexion->query($query)) {
            // Redirigir a la página principal o mostrar un mensaje de éxito
            header("Location: orden.php?idOrdAterra=" . urlencode($id_orden));
            exit();
        } else {
            // Manejar el error en caso de que la consulta falle
            echo "Error al actualizar la orden: " . $conexion->error;
        }
    } else {
        // Manejar el error si la consulta de valores actuales falla
        echo "Error al obtener los valores actuales: " . $conexion->error;
    }
}

// Cerrar la conexión
$conexion->close();
