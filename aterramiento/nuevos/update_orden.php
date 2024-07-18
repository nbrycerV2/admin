<?php
include "../modelo/conexion.php";
$date = date('Y-m-d');

if (isset($_POST['empresa'])) {
    $empresa = $_POST['empresa'];
    //echo $configuracion;
}
if (isset($_POST['vendedor'])) {
    $vendedor = $_POST['vendedor'];
    //echo $cantidad;
}
if (isset($_POST['f_entrega'])) {
    $f_entrega = $_POST['f_entrega'];
    //echo $mordaza_linea;
}
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    //echo $configuracion;
}

$sql = "UPDATE aterra_orden SET empresa = '$empresa',vendedor = '$vendedor',f_entrega='$f_entrega' where id like '$id'";
$resultado = $conexion2->query($sql) || die("Ha ocurrido un error al editar los datos final");

$db = mysqli_query($conexion2, "SELECT MAX(id) as ultimo, cantidad, aterra FROM aterra_orden where id like '$id'");
$row_items = mysqli_fetch_array($db);
$max_id = $row_items["ultimo"];
$cantidad = $row_items["cantidad"];
$aterra = $row_items["aterra"];

$num = 0;
while ($num < $cantidad) {

    $query = "SELECT MAX(serie) AS last_serie FROM aterra_item";
    $result = $conexion2->query($query);
    $row = $result->fetch_assoc();
    $last_serie = $row['last_serie'];

    //Obtener el año, mes y correlativo actual
    $current_year = date('Y');
    $current_year = substr($current_year, -2);
    $current_month = date('m');
    if ($last_serie) {
        $last_correlativo = substr($last_serie, -3);
        $current_correlativo = str_pad((int)$last_correlativo + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $current_correlativo = "001";
    }
    $numero_serie = $current_year . $current_month . $current_correlativo;

    $insert_query = "INSERT INTO aterra_item (serie,id_orden) VALUES ('$numero_serie','$max_id')";
    $conexion2->query($insert_query);
    $last_serie = $numero_serie;
    $num++;
}


header("Location:../mod_aterramiento/orden.php?id=$max_id&aterra=$aterra");
