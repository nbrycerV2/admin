<?php
include("../nuevos/conexion.php");

// Consulta SQL para obtener los datos
$sql = "SELECT IdOrdMant, DATE(FechaSolicitud) AS FechaSolicitud, Cliente, Ruc, Cantidad, DATE(FechaEntrega) AS FechaEntrega, Estado
FROM ordmantenimiento;";

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



// Cerrar la conexión
$conexion->close();
