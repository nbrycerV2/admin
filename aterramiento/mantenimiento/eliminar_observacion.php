<?php
include("../nuevos/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_orden = isset($_POST['id_orden']) ? $conexion->real_escape_string($_POST['id_orden']) : null;
    $id_observacion = isset($_POST['id_observacion']) ? $conexion->real_escape_string($_POST['id_observacion']) : null;

    if ($id_observacion) {
        $query_delete = "DELETE FROM mantobservacion WHERE IdObs = '$id_observacion'";

        if ($conexion->query($query_delete)) {
            header("Location: orden.php?IdOrdMant=" . urlencode($id_orden));
            exit;
        } else {
            echo "Error eliminando la observación: " . $conexion->error;
        }
    }
}

$conexion->close();
