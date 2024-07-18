<?php
include "../modelo/conexion.php";

$id = $_GET['id'];
$aterra = $_GET['aterra'];
echo $aterra;
$fecha = date('Y-m-d');
$db = mysqli_query($conexion2, "SELECT * FROM aterra_orden WHERE id LIKE '$id' ");
$row_items = mysqli_fetch_array($db);
$separado = explode("|", $row_items["empresa"]);
$id_empresa = $separado[0];
$empresa = $separado[1];
$ruc = $separado[2];
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../lib/datatables.min.css">
</head>

<body>
    <div class="wrapper">
        <?php include "side-bar.html";
        ?>

        <div class="main">
            <?php include "nav-bar.html";
            ?>

            <main class="content">
                <form id="form-abrir">
                    <div class="form-group">

                        <input type="hidden" id="id_abrir">
                        <input type="hidden" id="equipo_abrir">
                    </div>
                </form>

                <!--Contenido info,conteo y aptos -->
                <div class="row">
                    <div class="col">Informacion General
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Informacion</th>
                                    <th>Datos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Empresa</td>
                                    <td><?php echo $empresa; ?></td>
                                </tr>
                                <tr>
                                    <td>Ruc</td>
                                    <td><?php echo $ruc; ?></td>
                                </tr>
                                <tr>
                                    <td>Fecha Entrada</td>
                                    <td><?php echo $row_items["f_solicitud"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Fecha Salida</td>
                                    <td><?php echo $row_items["f_entrega"]; ?></td>
                                </tr>
                                <tr>
                                    <td>Estado del Servicio</td>
                                    <td><?php echo $row_items["estado"]; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col">Informacion de la Orden
                        <div class="row">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Informacion</th>
                                        <th>Datos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td><?php echo $row_items["cantidad"]; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Fecha de informe</th>
                                        <th>Temperatura</th>
                                        <th>Humedad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row_items["f_informe"]; ?></td>
                                        <td>20</td>
                                        <td>75</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">Items de la Orden
                        <div class="row">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#agrego">Agregar Items a la Orden</button>
                            <button class="btn btn-sm btn-outline-primary">Modificar valores del Informe</button>
                        </div>
                    </div>
                </div>
                <!-- Datatable de items-->
                <div class="row">
                    <div class="col">
                        <?php
                        include("tablas.php");
                        ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
<script src="../js/app.js"></script>
<script src="../lib/jquery.min.js"></script>
<script src="../lib/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


</html>