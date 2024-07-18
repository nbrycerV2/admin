<?php
include("conexion.php");

$id_orden = $_POST["id_orden"];
// Consulta SQL para obtener los datos
$sql = "SELECT * FROM orden_item WHERE id_orden='$id_orden'";

// Ejecución de la consulta SQL
$resultado = mysqli_query($conexion, $sql);

// Arreglo para almacenar los resultados
$data = array();

// Almacenamiento de los resultados en el arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $data["data"][] = $fila;
}

// Conversión del arreglo en formato JSON
echo json_encode($data);
