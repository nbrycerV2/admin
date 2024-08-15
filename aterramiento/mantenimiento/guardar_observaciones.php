<?php
include("../nuevos/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_orden = $conexion->real_escape_string($_POST['id_orden']);
    $serie = $conexion->real_escape_string($_POST['serie']);

    // Eliminar observación si se solicita
    if (isset($_POST['eliminar_observacion'])) {
        $idObsEliminar = $conexion->real_escape_string($_POST['eliminar_observacion']);
        $query_delete = "DELETE FROM mantobservacion WHERE IdObs = '$idObsEliminar'";

        if (!$conexion->query($query_delete)) {
            echo "Error eliminando la observación: " . $conexion->error;
        } else {
            header("Location: orden.php?IdOrdMant=" . urlencode($id_orden));
            exit;
        }
    }

    // Actualizar observaciones existentes
    if (isset($_POST['observaciones_existentes'])) {
        foreach ($_POST['observaciones_existentes'] as $idObs => $observacion) {
            $observacion = $conexion->real_escape_string($observacion);
            $query_update = "
            UPDATE mantobservacion 
            SET Observacion = '$observacion' 
            WHERE IdObs = '$idObs'
        ";
            if (!$conexion->query($query_update)) {
                echo "Error actualizando registro: " . $conexion->error;
            }
        }
    }

    // Insertar nuevas observaciones
    if (isset($_POST['observaciones_nuevas'])) {
        foreach ($_POST['observaciones_nuevas'] as $observacion) {
            if (!empty($observacion)) {
                $observacion = $conexion->real_escape_string($observacion);

                // Generar un nuevo IdObs
                $year = date('y');
                $month = date('m');
                $new_id = generarIdObs($conexion, $year, $month);

                $query_insert = "
                INSERT INTO mantobservacion (IdObs, Serie, Observacion) 
                VALUES ('$new_id', '$serie', '$observacion')
            ";
                if (!$conexion->query($query_insert)) {
                    echo "Error insertando registro: " . $conexion->error;
                }
            }
        }
    }

    // Redirigir después de completar las operaciones
    header("Location: orden.php?IdOrdMant=" . urlencode($id_orden));
    exit;
}

$conexion->close();

// Función para generar el próximo número correlativo
function generarIdObs($conexion, $year, $month)
{
    // Consulta para obtener el último IdObs generado en el mes y año actual
    $query_last_id = "
        SELECT IdObs 
        FROM mantobservacion 
        WHERE IdObs LIKE 'OBS{$year}{$month}%' 
        ORDER BY IdObs DESC 
        LIMIT 1
    ";
    $result_last_id = $conexion->query($query_last_id);

    if ($result_last_id->num_rows > 0) {
        $last_id = $result_last_id->fetch_assoc()['IdObs'];
        // Extraer el número correlativo y sumarle 1
        $correlativo = intval(substr($last_id, -3)) + 1;
    } else {
        // Si no existe ningún IdObs para el mes actual, iniciar en 1
        $correlativo = 1;
    }

    // Formatear el correlativo a tres dígitos
    $correlativo_formateado = str_pad($correlativo, 3, '0', STR_PAD_LEFT);

    // Generar el nuevo IdObs
    return "OBS{$year}{$month}{$correlativo_formateado}";
}
