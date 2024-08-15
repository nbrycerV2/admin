<?php
include '../nuevos/conexion.php'; // Incluye el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $IdMantPrueba = $_POST['IdMantPrueba'];

    // Consultar el IdOrdMant relacionado con el IdMantPrueba
    $querySelect = "SELECT IdOrdMant FROM mantprueba WHERE IdMantPrueba = '$IdMantPrueba'";
    $resultSelect = mysqli_query($conexion, $querySelect);

    if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {
        $row = mysqli_fetch_assoc($resultSelect);
        $IdOrdMant = $row['IdOrdMant'];

        // Eliminar el registro de mantprueba
        $queryDelete = "DELETE FROM mantprueba WHERE IdMantPrueba = '$IdMantPrueba'";

        if (mysqli_query($conexion, $queryDelete)) {
            // Actualizar la cantidad en ordmantenimiento
            $queryUpdate = "UPDATE ordmantenimiento SET Cantidad = Cantidad - 1 WHERE IdOrdMant = '$IdOrdMant'";

            if (mysqli_query($conexion, $queryUpdate)) {
                echo "Registro borrado y cantidad actualizada correctamente";
            } else {
                echo "Error al actualizar la cantidad: " . mysqli_error($conexion);
            }
        } else {
            echo "Error al borrar el registro: " . mysqli_error($conexion);
        }
    } else {
        echo "No se encontró el IdOrdMant asociado con IdMantPrueba";
    }

    mysqli_close($conexion);
}
?>
