<?php
include "../modelo/conexion.php";
error_reporting(0);
$date = date('Y-m-d');
if (isset($_POST['configuracion'])) {
    $configuracion = $_POST['configuracion'];
    //echo $configuracion;
}
if (isset($_POST['cantidad'])) {
    $cantidad = $_POST['cantidad'];
    //echo $cantidad;
}
if (isset($_POST['mordaza_linea'])) {
    $mordaza_linea = $_POST['mordaza_linea'];
    //echo $mordaza_linea;
}
if (isset($_POST['mordaza_tierra'])) {
    $mordaza_tierra = $_POST['mordaza_tierra'];
    //echo $mordaza_tierra;
}
if (isset($_POST['long_a'])) {
    $long_a = $_POST['long_a'];
    //echo $long_a;
}
if (isset($_POST['seccion_a'])) {
    $seccion_a = $_POST['seccion_a'];
    //echo $seccion_a;
}
if (isset($_POST['long_b'])) {
    $long_b = $_POST['long_b'];
    //echo $long_b;
}
if (isset($_POST['seccion_b'])) {
    $seccion_b = $_POST['seccion_b'];
    //echo $seccion_b;
}
if (isset($_POST['terminal_linea'])) {
    $terminal_linea = $_POST['terminal_linea'];
    //echo $terminal_linea;
}
if (isset($_POST['terminal_tierra'])) {
    $terminal_tierra = $_POST['terminal_tierra'];
    //echo $terminal_tierra;
}
if (isset($_POST['long_x'])) {
    $long_x = $_POST['long_x'];
    //echo $long_x;
}
if (isset($_POST['sec_x'])) {
    $sec_x = $_POST['sec_x'];
    //echo $sec_x;
}
if (isset($_POST['terminal_lineax'])) {
    $terminal_lineax = $_POST['terminal_lineax'];
    //echo $terminal_tierra_2;
}
if (isset($_POST['terminal_tierra_2'])) {
    $terminal_tierra_2 = $_POST['terminal_tierra_2'];
    //echo $terminal_tierra_2;
}

if (isset($_POST['pertiga'])) {
    $pertiga = $_POST['pertiga'];
    //echo $pertiga;
}
if (isset($_POST['varilla'])) {
    $varilla = $_POST['varilla'];
    //echo $varilla;
}
if (isset($_POST['trifurcacion'])) {
    $trifurcacion = $_POST['trifurcacion'];
    //echo $trifurcacion;
} else {
    $trifurcacion = "";
}
if (isset($_POST['adaptador'])) {
    $adaptador = $_POST['adaptador'];
    //echo $adaptador;
} else {
    $cant_em = "";
}
if (isset($_POST['otros'])) {
    $otros = $_POST['otros'];
    //echo $otros;
} else {
    $otros = "";
}
if (isset($_POST['estuche_g'])) {
    $estuche_g = $_POST['estuche_g'];
    //echo $estuche_g;
} else {
    $estuche_g = "";
}
if (isset($_POST['estuche_c'])) {
    $estuche_c = $_POST['estuche_c'];
    //echo $estuche_c;
} else {
    $estuche_c = "";
}
if (isset($_POST['estuche_m'])) {
    $estuche_m = $_POST['estuche_m'];
    //echo $estuche_m;
} else {
    $estuche_m = "";
}
if (isset($_POST['cant_eg'])) {
    $cant_eg = $_POST['cant_eg'];
    //echo $cant_eg;
} else {
    $cant_eg = "";
}
if (isset($_POST['cant_ec'])) {
    $cant_ec = $_POST['cant_ec'];
    //echo $cant_ec;
} else {
    $cant_ec = "";
}
if (isset($_POST['cant_em'])) {
    $cant_em = $_POST['cant_em'];
    //echo $cant_em;
} else {
    $cant_em = "";
}

$rs = mysqli_query($conexion2, "SELECT MAX(id) AS id FROM aterra_orden");
if ($row = mysqli_fetch_row($rs)) {
    $id = trim($row[0]);
    $code = substr($id, -8, 2);

    $year = date('y'); // obtiene el año actual con formato "y" (ejemplo: 2023)
    $year = substr($year, -2); // obtiene los últimos dos caracteres del año (ejemplo: 23)
    if ($code == $year) {
        $id_ = $id + 1;
    } else {
        $id_ = $year . "001";
    }
}
$estado = "Pendiente";
$consulta = "INSERT INTO aterra_orden(id, f_solicitud,aterra,cantidad,mordaza_linea,mordaza_tierra,long_a,sec_a,long_b,sec_b,terminal_linea,terminal_tierra,long_x,sec_x,terminal_tierra_2,pertiga,varilla,trifurcacion,adaptador,otros,estuche_g,estuche_c,estuche_m,cant_eg,cant_ec,cant_em,terminal_lineax,estado) 
VALUES('$id_', '$date', '$configuracion','$cantidad','$mordaza_linea','$mordaza_tierra','$long_a','$seccion_a','$long_b','$seccion_b','$terminal_linea','$terminal_tierra','$long_x','$sec_x','$terminal_tierra_2','$pertiga','$varilla','$trifurcacion','$adaptador','$otros','$estuche_g','$estuche_c','$estuche_m','$cant_eg','$cant_ec','$cant_em','$terminal_lineax','$estado')";
$resultado = $conexion2->query($consulta) || die("Ha ocurrido un error al guardar los datos");


$db = mysqli_query($conexion2, "SELECT MAX(id) as ultimo FROM aterra_orden");
$row_items = mysqli_fetch_array($db);
$max_id = $row_items["ultimo"];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Document</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Dielectrico">
    <meta name="author" content="Logytec">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="../img/icons/icon-48x48.png" />
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link href="../css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../lib/datatables.min.css">
    <script src="http://yui.yahooapis.com/3.18.1/build/yui/yui-min.js"></script>

</head>


<body class="yui3-skin-sam">
    <div class="wrapper">
        <?php include "side-bar.html";
        ?>

        <div class="main">
            <?php include "nav-bar.html";
            ?>

            <main class="content">
                <div class="container-fluid">
                    <form action="update_orden.php" method="post">
                        <div class="row">
                            <div class="btn-group col-3">
                                <input value="<?php echo $max_id; ?>" name="id" id="id" hidden>
                                <a href="" class="btn btn-primary">Atras</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="row">
                                    <label for="inputEmail4" class="form-label">Datos del Cliente</label>
                                    <div class="input-group">
                                        <script src="../apps/Yui/yui-min.js"></script>
                                        <script src="proformas_clienteyui.php"></script>
                                        <input type="text" class="form-control" id="empresa_yui" name="empresa" placeholder="Colocar RUC o Nombre de la Empresa">
                                    </div>
                                </div>
                                <div class="row">
                                    <label for="inputEmail4" class="form-label">Compromiso de Entrega</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="f_entrega" name="f_entrega">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="form-label" for="inputGroupSelect01">Vendedor</label>
                                    <div class="input-group">
                                        <select class="form-select" id="vendedor" name="vendedor">
                                            <option selected>Selecciona...</option>
                                            <?php
                                            $reg = mysqli_query($conexion2, "SELECT id,nombre FROM ven_usuarios where v_guantes like '1' order by id");
                                            while ($row3 = mysqli_fetch_array($reg)) {
                                                $db_data_id = $row3['id'];
                                                $db_data_name = $row3['nombre'];
                                                echo '<option value="' . $db_data_id . '">' . $db_data_name . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-1">
                                <div class="d-flex" style="height: 200px;">
                                    <div class="vr"></div>
                                </div>
                            </div>

                            <div class="col-5">
                                <label for="">
                                    En caso no se encuentre la empresa en la lista, has click <a href="">aqui</a>
                                </label>
                                <label>Funcion aun no disponible
                                </label>
                            </div>
                        </div>
                    </form>

                </div>
            </main>
        </div>
    </div>
    <script src="../js/app.js"></script>
    <script src="../lib/jquery.min.js"></script>
    <script src="../lib/datatables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</body>

</html>