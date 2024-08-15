<?php
include("../nuevos/conexion.php");

$id_orden = $_GET['IdOrdMant'];

// Consultar la información de la orden
$query = "SELECT Cliente, Ruc, Cantidad, FechaSolicitud, FechaEntrega, FechaInforme, 
Estado FROM ordmantenimiento WHERE IdOrdMant = '$id_orden'";
$stmt = $conexion->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    // Obtener los datos de la orden
    $order = $result->fetch_assoc();
} else {
    // Manejar el caso en que no se encuentre la orden
    $order = [
        'Cliente' => 'No encontrada',
        'Ruc' => 'N/A',
        'Vendedor' => 'N/A',
        'FechaSolicitud' => 'N/A',
        'FechaEntrega' => 'N/A',
        'Estado' => 'N/A'
    ];
}
// Preparar datos para el modal
$modal = [
    'FechaSolicitud' => date('Y-m-d', strtotime($order['FechaSolicitud'])),
    'FechaEntrega' => !empty($order['FechaEntrega']) ? date('Y-m-d', strtotime($order['FechaEntrega'])) : '',
    'FechaInforme' => !empty($order['FechaInforme']) ? date('Y-m-d', strtotime($order['FechaInforme'])) : ''
];

// Consulta SQL para obtener las empresas desde la tabla
$sql_empresas = "SELECT nombre, ruc FROM emp_main_lista";
$resultado_empresas = $conexion2->query($sql_empresas);

$listaEmpresas = "";
while ($fila = $resultado_empresas->fetch_assoc()) {
    $cliente = $fila['nombre'];
    $ruc = $fila['ruc'];
    $opcion = $cliente . " | " . $ruc;
    $listaEmpresas .= "<option value='$cliente' data-ruc='$ruc'>$opcion</option>";
}

// Consulta SQL para obtener empleados
$sql_empleados = "SELECT nombre, apellido, cod_user FROM tabla_user";
$resultado_empleados = $conexion3->query($sql_empleados);

$listaEmpleados = "";
while ($fila = $resultado_empleados->fetch_assoc()) {
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
    $cod_user = $fila['cod_user'];
    $opcion2 = $nombre . " " . $apellido;
    $listaEmpleados .= "<option value='$cod_user'>$opcion2</option>";
}

// Obtiene la fecha y hora actual en el formato YYYY-MM-DDTHH:MM
$fechaHoraActual = date('Y-m-d\TH:i');

// Consultar detalles de det_ord_aterra y ordprueba
$query_details = "
    SELECT 
        IdMantPrueba, Serie, Aterramiento, Marca, Tramo, LongitudTotal, Seccion, CorrienteAplicada, ValorMedido, MaxPermisible, Estado, Estuche, FechaPrueba
    FROM 
        mantprueba 
    WHERE 
        IdOrdMant = '$id_orden'
";
$stmt_details = $conexion->prepare($query_details);
$stmt_details->execute();
$result_details = $stmt_details->get_result();

$details = [];
while ($row = $result_details->fetch_assoc()) {
    $details[] = $row;
}

$json_details = json_encode($details);
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

    textarea {
        overflow: hidden;
        /* Oculta la barra de desplazamiento */
        resize: none;
        /* Desactiva el redimensionamiento manual */
    }

    .table-container {
        max-height: 300px;
        /* Ajusta la altura según sea necesario */
        overflow-y: auto;
        display: block;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-container thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        /* Ajusta el color de fondo según sea necesario */
        z-index: 1;
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
                            <a type="button" class="btn btn-sm btn-primary" href="index.php">
                                Atras
                            </a>

                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ORDEN N°:<?php echo $id_orden; ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table mi-tabla table-striped table-bordered table-sm">
                                        <thead class="">
                                            <tr>
                                                <th>Informacion general</th>
                                                <th><button class="btn btn-sm2 btn-secondary" data-bs-toggle="modal" data-bs-target="#edit_orden">Editar</button></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Empresa</td>
                                                <td><?php echo htmlspecialchars($order['Cliente']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ruc</td>
                                                <td><?php echo htmlspecialchars($order['Ruc']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Cantidad</td>
                                                <td><?php echo htmlspecialchars($order['Cantidad']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Fecha de creacion</td>
                                                <td><?php echo htmlspecialchars($order['FechaSolicitud']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Fecha de Salida</td>
                                                <td><?php echo htmlspecialchars($order['FechaEntrega']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Fecha de Informe</td>
                                                <td><?php echo htmlspecialchars($order['FechaInforme']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Estado del Servicio</td>
                                                <td><?php echo htmlspecialchars($order['Estado']); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table>
                                        <thead>
                                            <tr>
                                                <td><button class="btn btn-sm2 btn-secondary" data-bs-toggle="modal" data-bs-target="#agregar_item" id="">Agregar Item</button></td>
                                                <td><a class="btn btn-sm2 btn-secondary" href="generar_pdfs.php?id_orden=<?php echo $id_orden ?>">Descargar todos los Informes</a></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <?php /*
                                    <div class="row">
                                        <table class="table mi-tabla table-striped table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Cantidades Totales</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Aterramiento</td>
                                                    <td><?php echo htmlspecialchars($order['Cantidad']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>*/
                                    ?>
                                    <div class="row">
                                        <div class="table-container">
                                            <table class="table mi-tabla table-striped table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Series</th>
                                                        <th>Observaciones</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($details as $detail): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($detail['Serie']); ?></td>
                                                            <td>
                                                                <form method="post" action="guardar_observaciones.php">
                                                                    <input type="hidden" name="id_orden" value="<?php echo htmlspecialchars($id_orden); ?>">
                                                                    <input type="hidden" name="serie" value="<?php echo htmlspecialchars($detail['Serie']); ?>">

                                                                    <?php
                                                                    // Consulta para obtener todas las observaciones de la serie
                                                                    $query_observations = "
                                    SELECT IdObs, Observacion 
                                    FROM mantobservacion 
                                    WHERE Serie = '" . $conexion->real_escape_string($detail['Serie']) . "'
                                ";
                                                                    $result_observations = $conexion->query($query_observations);

                                                                    $has_observations = false; // Variable para verificar si hay observaciones

                                                                    if ($result_observations->num_rows > 0):
                                                                        $has_observations = true; // Se encontró al menos una observación
                                                                        // Mostrar cada observación existente en un textarea
                                                                        while ($row_observations = $result_observations->fetch_assoc()):
                                                                            $idObs = $row_observations['IdObs'];
                                                                    ?>
                                                                            <textarea name="observaciones_existentes[<?php echo htmlspecialchars($idObs); ?>]"
                                                                                class="form-control mb-2 auto-resize"
                                                                                style="overflow: hidden; resize: none; font-size: 12px;"><?php echo htmlspecialchars($row_observations['Observacion']); ?></textarea>
                                                                    <?php endwhile;
                                                                    endif; ?>

                                                                    <!-- Textarea para nueva observación -->
                                                                    <textarea name="observaciones_nuevas[]"
                                                                        class="form-control mb-2 auto-resize"
                                                                        style="overflow: hidden; resize: none; font-size: 12px;"
                                                                        placeholder="Agregar nueva observación"></textarea>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group" role="group">
                                                                    <button type="submit" class="btn btn-primary btn-sm" style="font-size: 12px;">Guardar</button>
                                                                    <?php if ($has_observations): ?>
                                                                        <button type="submit" name="eliminar_observacion" value="<?php echo htmlspecialchars($idObs); ?>"
                                                                            class="btn btn-danger btn-sm" style="font-size: 12px;">Eliminar</button>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </td>
                                                            </form>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php
                            /*
                            <div class="row">
                                <div class="col-6">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td><button class="btn btn-sm2 btn-secondary" data-bs-toggle="modal" data-bs-target="#agregar_item" id="">Agregar Item</button></td>
                                                <td><a class="btn btn-sm2 btn-secondary" href="generar_pdfs.php?id_orden=<?php echo $id_orden ?>">Descargar todos los Informes</a></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>*/
                            ?>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered mi-tabla table-sm" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>

                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <!-- Data will be inserted here via JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
            <!-- Modal de Edición -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Editar Registro</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modalBodyContent">
                            <!-- Contenido del formulario de edición se carga dinámicamente aquí -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="saveChangesBtn">Guardar Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Main Content -->
            <!-- Modal Edito Orden -->
            <div class="modal fade" tabindex="-1" id="edit_orden">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Orden</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="procesar.php?funcion=edito_orden" method="post">
                            <input type="hidden" name="id_orden" value="<?php echo $id_orden; ?>">
                            <div class="modal-body">
                                <div class="col">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="input-group input-group-sm mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-sm">Empresa</span>
                                                        <input type="text" class="form-control" name="idClientephp" list="empresas" value="<?php echo htmlspecialchars($order['Cliente']); ?>" id="empresaInput">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-sm">Ruc</span>
                                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($order['Ruc']); ?>" name="Rucphp" id="rucInput">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estado</span>
                                                        <select class="form-control" name="Estadophp" id="">
                                                            <?php
                                                            $estadoActual = htmlspecialchars($order['Estado']);
                                                            $estados = ["Pendiente", "Anulado", "Entregado", "Evaluado"];
                                                            echo "<option value='$estadoActual'>$estadoActual</option>";
                                                            foreach ($estados as $estado) {
                                                                if ($estado != $estadoActual) {
                                                                    echo "<option value='$estado'>$estado</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-sm">Fecha de Salida</span>
                                                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($modal['FechaEntrega']); ?>" name="FechaEntregaphp" id="">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-sm">Fecha de Informe</span>
                                                        <input type="date" class="form-control" value="<?php echo htmlspecialchars($modal['FechaInforme']); ?>" name="FechaInformephp" id="">
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="agregar_item" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Nuevo Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="agregar_item.php" method="post">
                    <input type="hidden" name="id_orden" value="<?php echo $id_orden; ?>">
                    <div class="modal-body">
                        <div class="col">
                            <table>
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Marca</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Marcaphp" value="" required>
                                                    <option value=""></option>
                                                    <option value="RITZ">Ritz</option>
                                                    <option value="FAMECA">Fameca</option>
                                                    <option value="CATU">Catu</option>
                                                    <option value="VIVAX-METROTECH">Vivax - Metrotech</option>
                                                    <option value="WHITE SAFETY LINE">White Safety Line</option>
                                                    <option value="SOFAMEL">Sofamel</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Aterramiento</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Aterramientophp" value="" required>
                                                    <option value=""></option>
                                                    <option value="ENA">Enganche Automatico</option>
                                                    <option value="EXT">Extension</option>
                                                    <option value="JUM">Jumper Equipotencial</option>
                                                    <option value="PDE">Pertiga de descarga</option>
                                                    <option value="P03">Pulpo</option>
                                                    <option value="PEL">Pulpo con Elastimold</option>
                                                    <option value="TRA">Trapecio</option>
                                                    <option value="U01">Unipolar(1 Tiras)</option>
                                                    <option value="U03">Unipolar(3 Tiras)</option>
                                                    <option value="UPF">Unipolar con Pertiga Fija</option>
                                                    <option value="USA">Unipolar Con Seguridad Aumentada</option>
                                                    <option value="UMT">Unipolar Para Lineas de Media Tension</option>
                                                    <option value="UPV">Unipolar para Vehiculo</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Cantidad</span>
                                                <input type="number" min="0" max="50" class="form-control" name="Cantidadphp" value="" required>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
                    </div>
                </form>
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
        <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

        <script>
            $(document).ready(function() {
                var data = <?php echo $json_details; ?>;
                var columns = [{
                        title: "Acciones",
                        data: null,
                        render: function(data, type, row) {
                            var buttons = `
                        <button class="btn btn-sm2 btn-primary editBtn" data-bs-toggle="modal" data-bs-target="#editModal" data-serie="${row.IdMantPrueba}">Editar</button>
                        <button class="btn btn-sm2 btn-danger deleteBtn" data-serie="${row.IdMantPrueba}">Borrar</button>
                    `;

                            // Verificar si alguno de los estados es "Defectuoso"
                            var estados = row.Estado.split("|");
                            var mostrarInforme = estados.some(function(estado) {
                                return estado.trim() === "Defectuoso";
                            });

                            // Agregar el botón "Informe" si al menos un estado es "Defectuoso"
                            if (mostrarInforme) {
                                buttons += `
                            <button class="btn btn-sm2 btn-warning informeBtn" data-serie="${row.IdMantPrueba}">Informe</button>
                        `;
                            }

                            return buttons;
                        }
                    },
                    {
                        title: "Serie",
                        data: "Serie"
                    },
                    {
                        title: "Aterramiento",
                        data: "Aterramiento"
                    },
                    {
                        title: "Marca",
                        data: "Marca"
                    },
                    {
                        title: "Tramo",
                        data: "Tramo",
                        render: renderTramos,
                        width: "10%"
                    },
                    {
                        title: "Longitud Total",
                        data: "LongitudTotal",
                        render: renderTramos
                    },
                    {
                        title: "Sección",
                        data: "Seccion",
                        render: renderTramos
                    },
                    {
                        title: "Corriente Aplicada",
                        data: "CorrienteAplicada",
                        render: renderTramos
                    },
                    {
                        title: "Valor Medido",
                        data: "ValorMedido",
                        render: renderTramos
                    },
                    {
                        title: "Max Permisible",
                        data: "MaxPermisible",
                        render: renderTramos
                    },
                    {
                        title: "Estado",
                        data: "Estado",
                        render: renderTramos,
                    },
                    {
                        title: "Estuche",
                        data: "Estuche"
                    },
                    {
                        title: "Fecha Prueba",
                        data: "FechaPrueba"
                    }
                ];

                function renderTramos(data) {
                    if (typeof data !== 'string' || data.trim() === '') {
                        return '';
                    }

                    var tramos = data.split("|");
                    var html = '';
                    tramos.forEach(function(tramo) {
                        html += '<div>' + tramo.trim() + '</div>';
                    });
                    return html;
                }

                $('#dataTable').DataTable({
                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
                    },
                    data: data,
                    columns: columns,
                    lengthChange: false,
                    paging: false,
                    ordering: false, // Desactivar la ordenación automática
                    order: [], // Remover cualquier ordenación por defecto
                });

                // Función para manejar el clic en el botón Informe
                $('#dataTable').on('click', '.informeBtn', function() {
                    var idMantPrueba = $(this).data('serie');
                    // Redireccionar a la página aterramiento.php con el id_orden
                    window.location.href = 'InformeDefectuoso.php?id_orden=' + idMantPrueba;
                });

                $('#dataTable').on('click', '.editBtn', function() {
                    var table = $('#dataTable').DataTable();
                    var rowData = table.row($(this).parents('tr')).data();
                    originalIdMantPrueba = rowData.IdMantPrueba;

                    var modalTable = '<table class="table table-sm modal-table">';
                    modalTable += '<thead><tr>';
                    columns.forEach(function(column) {
                        if (column.title !== "Acciones" && column.title !== "Aterramiento") {
                            modalTable += '<th>' + column.title + '</th>';
                        }
                    });
                    modalTable += '</tr></thead>';
                    modalTable += '<tbody><tr>';
                    columns.forEach(function(column) {
                        if (column.title !== "Acciones" && column.title !== "Aterramiento") {
                            if (column.data === "Tramo" || column.data === "LongitudTotal" || column.data === "Seccion" ||
                                column.data === "CorrienteAplicada" || column.data === "ValorMedido" ||
                                column.data === "MaxPermisible" || column.data === "Estado"
                            ) {
                                var items = rowData[column.data].split("|");
                                var inputs = '';
                                items.forEach(function(item, index) {
                                    if (column.data === "Estado") {
                                        var options = ['Pendiente', 'Esperando', 'Apto', 'Defectuoso'];
                                        var selectHtml = '<select class="form-select form-select-sm" id="' + column.data + '-' + index + '">';
                                        options.forEach(function(option) {
                                            var selected = (option.trim() === item.trim()) ? 'selected' : '';
                                            selectHtml += '<option value="' + option + '" ' + selected + '>' + option + '</option>';
                                        });
                                        selectHtml += '</select>';
                                        inputs += selectHtml;
                                    } else if (column.data === "Seccion") {
                                        var options = [' ', '25', '35', '50', '70', '95'];
                                        var selectHtml = '<select class="form-select form-select-sm" id="' + column.data + '-' + index + '">';
                                        options.forEach(function(option) {
                                            var selected = (option.trim() === item.trim()) ? 'selected' : '';
                                            selectHtml += '<option value="' + option + '" ' + selected + '>' + option + '</option>';
                                        });
                                        selectHtml += '</select>';
                                        inputs += selectHtml;
                                    } else {
                                        inputs += '<input type="text" class="form-control form-control-sm short-input mb-1" id="' + column.data + '-' + index + '" value="' + item.trim() + '">';
                                    }
                                });
                                modalTable += '<td>' + inputs + '</td>';
                            } else if (column.data === "Estuche") {
                                var checked = rowData[column.data].trim() === "SI" ? 'checked' : '';
                                var checkbox = '<input type="checkbox" class="form-check-input" id="' + column.data + '" ' + checked + '>';
                                modalTable += '<td><div class="form-check">' + checkbox + '</div></td>';
                            } else {
                                var inputClass = column.data === "Serie" ? "form-control form-control-sm short-input" : "form-control form-control-sm";
                                var inputField = '<input type="text" class="' + inputClass + '" id="' + column.data + '" value="' + rowData[column.data] + '">';
                                modalTable += '<td>' + inputField + '</td>';
                            }
                        }
                    });
                    modalTable += '</tr></tbody>';
                    modalTable += '</table>';

                    $('#modalBodyContent').html(modalTable);

                    $('[id^=Seccion-]').on('change', function() {
                        var selectedSeccion = $(this).val();
                        var index = $(this).attr('id').split('-')[1];
                        var correspondingCorriente;

                        switch (selectedSeccion) {
                            case '25':
                                correspondingCorriente = '150';
                                break;
                            case '35':
                                correspondingCorriente = '200';
                                break;
                            case '50':
                                correspondingCorriente = '250';
                                break;
                            case '70':
                                correspondingCorriente = '300';
                                break;
                            case '95':
                                correspondingCorriente = '400';
                                break;
                            default:
                                correspondingCorriente = '';
                        }

                        $('#CorrienteAplicada-' + index).val(correspondingCorriente);
                    });
                });

                $('#saveChangesBtn').on('click', function() {
                    var modifiedData = {};

                    columns.forEach(function(column) {
                        if (column.title !== "Acciones" && column.title !== "Aterramiento") {
                            if (column.data === "Tramo" || column.data === "LongitudTotal" || column.data === "Seccion" ||
                                column.data === "CorrienteAplicada" || column.data === "ValorMedido" ||
                                column.data === "MaxPermisible" || column.data === "Estado"
                            ) {
                                var inputs = [];
                                $('#modalBodyContent').find('[id^=' + column.data + ']').each(function() {
                                    inputs.push($(this).val());
                                });
                                modifiedData[column.data] = inputs.join("|");
                            } else if (column.data === "Estuche") {
                                var isChecked = $('#' + column.data).is(':checked');
                                modifiedData[column.data] = isChecked ? "SI" : "NO";
                            } else {
                                modifiedData[column.data] = $('#' + column.data).val();
                            }
                        }
                    });

                    var currentDateTime = moment().tz("America/Lima").format("YYYY-MM-DD HH:mm:ss");
                    modifiedData['FechaPrueba'] = currentDateTime;

                    $.ajax({
                        url: 'guardar_cambios.php',
                        method: 'POST',
                        data: {
                            IdMantPrueba: originalIdMantPrueba,
                            updatedData: modifiedData
                        },
                        success: function(response) {
                            console.log(response);
                            alert(response);
                            // Recargar la página después de guardar cambios
                            location.reload();
                            if (response === "Registro actualizado correctamente") {
                                var table = $('#dataTable').DataTable();
                                var rowIndex = table.row(function(idx, data, node) {
                                    return data.IdMantPrueba === originalIdMantPrueba;
                                }).index();

                                if (rowIndex !== undefined) {
                                    var updatedRow = table.row(rowIndex).data();
                                    columns.forEach(function(column) {
                                        if (column.title !== "Acciones" && column.title !== "Aterramiento" && column.title !== "Marca") {
                                            updatedRow[column.data] = modifiedData[column.data];
                                        }
                                    });
                                    table.row(rowIndex).data(updatedRow).draw();
                                }

                                $('#editModal').modal('hide');

                            }
                        }
                    });
                });

                $('#dataTable').on('click', '.deleteBtn', function() {
                    var idMantPrueba = $(this).data('serie');
                    if (confirm('¿Está seguro de que desea eliminar este registro?')) {
                        $.ajax({
                            url: 'delete_record.php',
                            method: 'POST',
                            data: {
                                IdMantPrueba: idMantPrueba
                            },
                            success: function(response) {
                                alert(response);
                                // Redireccionar a la misma página actual
                                window.location.reload();
                                if (response === "Registro eliminado correctamente") {
                                    var table = $('#dataTable').DataTable();
                                    var rowIndex = table.row(function(idx, data, node) {
                                        return data.IdMantPrueba === idMantPrueba;
                                    }).index();

                                    if (rowIndex !== undefined) {
                                        table.row(rowIndex).remove().draw();
                                    }
                                }
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            document.getElementById('empresaInput').addEventListener('input', function() {
                var options = document.getElementById('empresas').options;
                var empresaInput = this.value;

                for (var i = 0; i < options.length; i++) {
                    if (options[i].value === empresaInput) {
                        var ruc = options[i].getAttribute('data-ruc');
                        document.getElementById('rucInput').value = ruc;
                        break;
                    }
                }
            });
        </script>
        <script>
            function autoResize(textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = (textarea.scrollHeight) + 'px';
            }

            // Aplicar ajuste automático a todos los textarea al cargar la página
            document.querySelectorAll('.auto-resize').forEach(textarea => autoResize(textarea));
            // Aplicar el ajuste automático en tiempo real cuando el usuario escribe
            document.querySelectorAll('.auto-resize').forEach(textarea => {
                textarea.addEventListener('input', () => autoResize(textarea));
            });

            function confirmDelete(idObs) {
                if (confirm("¿Estás seguro de que quieres eliminar esta observación?")) {
                    window.location.href = 'eliminar_observacion.php?IdObs=' + encodeURIComponent(idObs) + '&IdOrdMant=' + encodeURIComponent(document.querySelector('input[name="id_orden"]').value);
                }
            }
        </script>

</body>

</html>