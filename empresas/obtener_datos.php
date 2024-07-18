<?php
include("conexion.php");

// Consulta SQL para obtener los datos
$sql = "SELECT * FROM emp_main_lista";

// Ejecución de la consulta SQL
$resultado = mysqli_query($conexion2, $sql);

// Arreglo para almacenar los resultados
$data = array();

// Almacenamiento de los resultados en el arreglo
while ($fila = mysqli_fetch_assoc($resultado)) {
    $data["data"][] = $fila;
}

// Conversión del arreglo en formato JSON
echo json_encode($data);
