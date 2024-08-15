<?php
include '../nuevos/conexion.php'; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IdMantPrueba = $_POST['IdMantPrueba'];
    $updatedData = $_POST['updatedData'];

    // Armar la consulta SQL para la actualización
    $query = "UPDATE mantprueba SET ";
    foreach ($updatedData as $column => $value) {
        $query .= "$column = '$value', ";
    }
    $query = rtrim($query, ', ');
    $query .= " WHERE IdMantPrueba = '$IdMantPrueba'";

    if (mysqli_query($conexion, $query)) {
        echo "Registro actualizado correctamente";
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
}
?>
