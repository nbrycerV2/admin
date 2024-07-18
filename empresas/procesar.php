<?php
include("conexion.php");
$funcion = $_GET["funcion"];
$fecha = date("Y-m-d");

if($_SERVER['REQUEST_METHOD'] === 'POST' and $funcion == "add_emp" ){

$ruc = $_POST["ruc"];
$razonSocial = $_POST["razonSocial"];
$direccion = $_POST["direccion"];
$estado = $_POST["estado"];
$departamento = $_POST["Departamento"];
$distrito = $_POST["Distrito"];
$provincia = $_POST["Provincia"];


// Consulta para verificar si el RUC existe
$sql = "SELECT * FROM emp_main_lista WHERE ruc = ?";
$stmt = $conexion2->prepare($sql);
$stmt->bind_param("s", $ruc);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El RUC existe, hacer un UPDATE
    $update_sql = "UPDATE emp_main_lista SET nombre = ?, direccion = ?, estado = ?, dpto = ?, distrito = ?, provincia = ? WHERE ruc = ?";
    $update_stmt = $conexion2->prepare($update_sql);
    $update_stmt->bind_param("sssssss", $razonSocial, $direccion, $estado, $departamento, $distrito, $provincia, $ruc);

    if ($update_stmt->execute()) {
        echo "Registro actualizado exitosamente.";
    } else {
        echo "Error al actualizar el registro: " . $conexion2->error;
    }
} else {
    // El RUC no existe, hacer un INSERT
    $insert_sql = "INSERT INTO emp_main_lista (ruc, nombre, direccion, estado, dpto, distrito, provincia) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conexion2->prepare($insert_sql);
    $insert_stmt->bind_param("sssssss", $ruc, $razonSocial, $direccion, $estado, $departamento, $distrito, $provincia);

    if ($insert_stmt->execute()) {
        echo "Registro insertado exitosamente.";
    } else {
        echo "Error al insertar el registro: " . $conexion2->error;
    }
}

// Cerrar conexión
$conexion2->close();
header("Location:index.php");
}
?>


