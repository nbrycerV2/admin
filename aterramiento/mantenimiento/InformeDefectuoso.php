<?php
include("../nuevos/conexion.php");

// Verificar si 'id_orden' está definido en la URL
if (!isset($_GET['id_orden'])) {
    die("Error: El id_orden no está definido.");
}

// Obtener el valor de id_orden de la URL y sanearlo
$id_orden = mysqli_real_escape_string($conexion, $_GET['id_orden']);

// Preparar y ejecutar la consulta para obtener IdOrdMant
$query = "SELECT IdOrdMant, Serie, Aterramiento, Marca FROM mantprueba WHERE IdMantPrueba = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $id_orden);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $idOrdMant = $row['IdOrdMant'];
    $serie = $row['Serie'];
    $aterramiento = $row['Aterramiento'];
    $marca = $row['Marca'];
} else {
    die("Error: No se encontró el IdOrdMant.");
}

// Usar IdOrdMant para obtener Cliente y Ruc
$query = "SELECT Cliente, Ruc FROM ordmantenimiento WHERE IdOrdMant = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $idOrdMant);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cliente = $row['Cliente'];
    $ruc = $row['Ruc'];
} else {
    die("Error: No se encontraron datos para el IdOrdMant.");
}

// Consultar la tabla mantdefectuoso para obtener los campos adicionales
$query = "SELECT Sintoma, Diagnostico, AccionesRealizadas, Conclusiones, FechaInforme FROM mantdefectuoso WHERE IdMantPrueba = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $id_orden);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sintoma = htmlspecialchars($row['Sintoma']);
    $diagnostico = htmlspecialchars($row['Diagnostico']);
    $accionesRealizadas = htmlspecialchars($row['AccionesRealizadas']);
    $conclusiones = htmlspecialchars($row['Conclusiones']);
    $fechainforme = htmlspecialchars($row['FechaInforme']);
} else {
    $sintoma = '';
    $diagnostico = '';
    $accionesRealizadas = '';
    $conclusiones = '';
    $fechainforme = '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Dielectricos Ordenes</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/sb-admin-2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
    <!-- Custom styles for this page -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
</head>
<datalist id="empresas">
    <?php echo $listaEmpresas; ?>
</datalist>
<datalist id="empleados">
    <?php echo $listaEmpleados; ?>
</datalist>
<style>
    .mi-tabla {
        font-size: 13px;
        /* Ajusta el tamaño según lo necesites */
    }

    .btn-sm2 {
        font-size: 13px;
        padding: 0.5px 3px;
    }

    #displayValue {
        float: right;
        text-align: right;
        /*font-size: 50px;*/
        width: 70%;
        margin-right: 15%;
        font-weight: bold;
        outline-offset: 5px
    }

    /* Estilos para las celdas del DataTable */
    #dataTable td {
        vertical-align: middle;
        /* Alinear verticalmente al centro */
    }

    /* Estilos específicos para la columna Tramo */
    #dataTable td.column-tramo {
        white-space: nowrap;
        /* Evitar el salto de línea */
    }

    #dataTable td.column-tramo div {
        display: inline-block;
        /* Mostrar divs en línea */
        margin-right: 5px;
        /* Espaciado derecho entre divs */
        padding: 2px 5px;
        /* Relleno interno */
        border: 1px solid #ccc;
        /* Borde para separación visual */
        border-radius: 4px;
        /* Bordes redondeados */
    }

    .modal-table {
        font-size: 12px;
        /* Ajusta el tamaño de la fuente según sea necesario */
    }

    .modal-table th,
    .modal-table td {
        padding: 4px;
        /* Reduce el padding para que los contenidos sean más compactos */
    }

    .modal-table input.form-control {
        font-size: 12px;
        /* Reduce el tamaño de la fuente del input */
        padding: 2px 4px;
        /* Reduce el padding interno del input */
        height: 25px;
        /* Ajusta la altura del input */
        width: auto;
        /* Ajusta el ancho del input */
    }

    .modal-body {
        overflow-x: auto;
        /* Habilita el scroll horizontal si la tabla es muy ancha */
    }

    .modal-input {
        width: 100px;
        /* Adjust this value as needed */
    }

    .short-input {
        max-width: 70px;
        /* Ajusta este valor según necesites */
    }

    .form-control-sm {
        font-size: 0.875rem;
        /* Ajusta el tamaño de la letra */
    }

    .modal-table td:nth-child(3),
    .modal-table th:nth-child(3) {
        display: none;
    }
</style>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../../index.html">
                <div class="sidebar-brand-text mx-3">Logytec</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../../index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0" />
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../../empresas/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Empresas</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider" />

            <!-- Heading -->
            <div class="sidebar-heading">Seleccion</div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Aterramiento</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="index.php">Mantenimiento</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Dielectricos</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../../dielectrico/nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="">Mantenimiento</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block" />

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
        </ul>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">

                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-sm btn-primary" href="orden.php?IdOrdMant=<?php echo $idOrdMant ?>">
                                Atras
                            </a>

                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">INFORME N°: <?php echo htmlspecialchars($id_orden); ?></h6>
                        </div>
                        <div class="card-body">
                            <form action="guardar_diagnostico.php" method="post">
                                <input type="hidden" name="id_orden" value="<?php echo htmlspecialchars($id_orden); ?>">
                                <div class="row">
                                    <div class="col-4">
                                        <table class="table mi-tabla table-striped table-bordered table-sm">
                                            <thead class="">
                                                <tr>
                                                    <th>Informacion general</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Empresa</td>
                                                    <td><?php echo htmlspecialchars($cliente); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Ruc</td>
                                                    <td><?php echo htmlspecialchars($ruc); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Marca</td>
                                                    <td><?php echo htmlspecialchars($marca); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Modelo</td>
                                                    <td><?php echo htmlspecialchars($aterramiento); ?> -
                                                        <?php
                                                        switch ($aterramiento) {
                                                            case 'ENA':
                                                                echo 'Enganche Automático';
                                                                break;
                                                            case 'EXT':
                                                                echo 'Extensión';
                                                                break;
                                                            case 'JUM':
                                                                echo 'Jumper Equipotencial';
                                                                break;
                                                            case 'PDE':
                                                                echo 'Pértiga de descarga';
                                                                break;
                                                            case 'P03':
                                                                echo 'Pulpo';
                                                                break;
                                                            case 'PEL':
                                                                echo 'Pulpo con Elastimold';
                                                                break;
                                                            case 'TRA':
                                                                echo 'Trapecio';
                                                                break;
                                                            case 'TPF':
                                                                echo 'Trapecio con Pértiga Fija';
                                                                break;
                                                            case 'U01':
                                                                echo 'Unipolar (1 Tiras)';
                                                                break;
                                                            case 'U03':
                                                                echo 'Unipolar (3 Tiras)';
                                                                break;
                                                            case 'UPF':
                                                                echo 'Unipolar con Pértiga Fija';
                                                                break;
                                                            case 'USA':
                                                                echo 'Unipolar Con Seguridad Aumentada';
                                                                break;
                                                            case 'UMT':
                                                                echo 'Unipolar Para Líneas de Media Tensión';
                                                                break;
                                                            case 'UPV':
                                                                echo 'Unipolar para Vehículo';
                                                                break;
                                                            default:
                                                                echo 'Desconocido';
                                                                break;
                                                        }
                                                        ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Serie</td>
                                                    <td><?php echo htmlspecialchars($serie); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Fecha de Informe</td>
                                                    <td><?php echo htmlspecialchars($fechainforme); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><button type="submit" class="btn btn-sm2 btn-secondary" id="agregarItemBtn">Guardar Informe</button></td>
                                                    <td><a class="btn btn-sm2 btn-secondary" href="InfDefectuoso.php?id_orden=<?php echo htmlspecialchars($id_orden); ?>">Descargar Informe</a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="col-6">
                                        <div class="row">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Sintoma</span>
                                                <textarea id="sintoma" name="Sintomaphp" class="form-control"><?php echo $sintoma; ?></textarea>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Diagnóstico</span>
                                                <textarea id="diagnostico" name="Diagnosticophp" class="form-control"><?php echo $diagnostico; ?></textarea>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Acciones Realizadas</span>
                                                <textarea id="AccionesRealizadas" name="AccionesRealizadasphp" class="form-control"><?php echo $accionesRealizadas; ?></textarea>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Conclusiones Y/O Recomendaciones</span>
                                                <textarea id="Conclusiones" name="Conclusionesphp" class="form-control"><?php echo $conclusiones; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="card">
                                        <div class="card-body">
                                            Primero Guardar y despues Descargar Informe
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>

    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
</body>

</html>