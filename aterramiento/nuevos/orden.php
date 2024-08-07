<?php
include("conexion.php");

$id_orden = $_GET['idOrdAterra'];

// Consultar la información de la orden
$query = "SELECT Cliente, Ruc, Vendedor, TipoAterra, Cantidad, EstChico, EstGrande, EstMetalico, EstPertiga, 
FechaSolicitud, FechaEntrega, FechaInforme, Estado FROM ordaterra WHERE idOrdAterra = '$id_orden'";
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
        d.idDetOrdAterra, d.Serie, o.Tramo, o.LongitudTotal, o.CorrienteAplicada, o.ValorMedido, o.MaxPermisible, o.Resultado, o.FechaPrueba
    FROM 
        det_ord_aterra d
    LEFT JOIN 
        ordprueba o ON d.Serie = o.Serie
    WHERE 
        d.idOrdAterra = '$id_orden'
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
                        <a class="collapse-item" href="index.php">Nuevos</a>
                        <a class="collapse-item" href="#">Mantenimiento</a>
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
                                                <td>Vendedor</td>
                                                <td><?php echo htmlspecialchars($order['Vendedor']); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Aterramiento</td>
                                                <td><?php echo htmlspecialchars($order['TipoAterra']); ?></td>
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
                                </div>
                                <div class="col-6">
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
                                    </div>
                                    <div class="row">
                                        <table class="table mi-tabla table-striped table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Tipo de Estuche</th>
                                                    <th>Cantidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Estuches Chicos</td>
                                                    <td><?php echo htmlspecialchars($order['EstChico']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Estuches Grandes</td>
                                                    <td><?php echo htmlspecialchars($order['EstGrande']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Estuches Metálicos</td>
                                                    <td><?php echo htmlspecialchars($order['EstMetalico']); ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Estuches de Pértiga</td>
                                                    <td><?php echo htmlspecialchars($order['EstPertiga']); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <table>
                                        <thead>
                                            <tr>
                                                <td><button class="btn btn-sm2 btn-secondary" data-bs-toggle="modal" data-bs-target="#agregar_item" id="agregarItemBtn">Agregar Item</button></td>
                                                <td><a class="btn btn-sm2 btn-secondary" href="OrdFabri_pdfs.php?id_orden=<?php echo $id_orden ?>">Orden de Fabricación<a></td>
                                                <td><a class="btn btn-sm2 btn-secondary" href="aterramiento.php?id_orden=<?php echo $id_orden ?>">Modelo de Aterramiento</a></td>
                                                <td><a class="btn btn-sm2 btn-secondary" href="generar_pdfs.php?id_orden=<?php echo $id_orden ?>">Descargar todos los Informes</a></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <br>
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
                <div class="modal-dialog modal-lg">
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
                                                <td>
                                                    <div class="input-group input-group-sm mb-3">
                                                        <span class="input-group-text" id="inputGroup-sizing-sm">Vendedor</span>
                                                        <input type="text" class="form-control" name="Vendedorphp" list="empleados" value="<?php echo htmlspecialchars($order['Vendedor']); ?>">
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
                        return `
                    <button class="btn btn-sm btn-primary editBtn" data-bs-toggle="modal" data-bs-target="#editModal" data-serie="${row.Serie}">Editar</button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-serie="${row.Serie}">Borrar</button>
                `;
                    }
                },
                {
                    title: "Serie",
                    data: "Serie"
                },
                {
                    title: "Tramo",
                    data: "Tramo",
                    render: renderTramos
                },
                {
                    title: "LongitudTotal",
                    data: "LongitudTotal",
                    render: renderTramos
                },
                {
                    title: "CorrienteAplicada",
                    data: "CorrienteAplicada",
                    render: renderTramos
                },
                {
                    title: "ValorMedido",
                    data: "ValorMedido",
                    render: renderTramos
                },
                {
                    title: "MaxPermisible",
                    data: "MaxPermisible",
                    render: renderTramos
                },
                {
                    title: "Resultado",
                    data: "Resultado",
                    render: renderTramos
                },
                {
                    title: "FechaPrueba",
                    data: "FechaPrueba"
                }
            ];

            function renderTramos(data) {
                var tramos = data.split("|");
                var html = '';
                tramos.forEach(function(tramo) {
                    html += '<div>' + tramo.trim() + '</div>';
                });
                return html;
            }

            var headerRow = $('#dataTable-header tr');
            columns.forEach(function(column) {
                headerRow.append('<th>' + column.title + '</th>');
            });

            var footerRow = $('#dataTable-footer tr');
            columns.forEach(function(column) {
                footerRow.append('<th>' + column.title + '</th>');
            });

            var table = $('#dataTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
                },
                data: data,
                columns: columns,
                lengthChange: false,
                paging: false
            });

            var originalSerie; // Variable para almacenar la serie original

            $('#dataTable').on('click', '.editBtn', function() {
                var rowData = table.row($(this).parents('tr')).data();
                originalSerie = rowData.Serie; // Guardar la serie original

                var modalTable = '<table class="table table-sm modal-table">';
                modalTable += '<thead><tr>';
                columns.forEach(function(column) {
                    if (column.title !== "Acciones") {
                        modalTable += '<th>' + column.title + '</th>';
                    }
                });
                modalTable += '</tr></thead>';
                modalTable += '<tbody><tr>';
                columns.forEach(function(column) {
                    if (column.title !== "Acciones") {
                        if (column.data === "Tramo" || column.data === "LongitudTotal" ||
                            column.data === "CorrienteAplicada" || column.data === "ValorMedido" ||
                            column.data === "MaxPermisible" || column.data === "Resultado"
                        ) {
                            var items = rowData[column.data].split("|");
                            var inputs = '';
                            items.forEach(function(item, index) {
                                if (column.data === "Resultado") {
                                    var options = ['Pendiente', 'Apto', 'No Apto'];
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
                        } else {
                            var inputClass = column.data === "Serie" ? "form-control form-control-sm short-input" : "form-control form-control-sm";
                            modalTable += '<td><input type="text" class="' + inputClass + '" id="' + column.data + '" value="' + rowData[column.data] + '"></td>';
                        }
                    }
                });
                modalTable += '</tr></tbody>';
                modalTable += '</table>';

                $('#modalBodyContent').html(modalTable);
            });

            $('#dataTable').on('click', '.editBtn', function() {
                var rowData = table.row($(this).parents('tr')).data();
                var modalTable = '<table class="table table-sm modal-table">';
                modalTable += '<thead><tr>';
                columns.forEach(function(column) {
                    if (column.title !== "Acciones") {
                        modalTable += '<th>' + column.title + '</th>';
                    }
                });
                modalTable += '</tr></thead>';
                modalTable += '<tbody><tr>';
                columns.forEach(function(column) {
                    if (column.title !== "Acciones") {
                        if (column.data === "Tramo" || column.data === "LongitudTotal" ||
                            column.data === "CorrienteAplicada" || column.data === "ValorMedido" ||
                            column.data === "MaxPermisible" || column.data === "Resultado"
                        ) {
                            var items = rowData[column.data].split("|");
                            var inputs = '';
                            items.forEach(function(item, index) {
                                if (column.data === "Resultado") {
                                    var options = ['Pendiente', 'Apto', 'No Apto'];
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
                        } else {
                            var inputClass = column.data === "Serie" ? "form-control form-control-sm short-input" : "form-control form-control-sm";
                            var inputField = '<input type="text" class="' + inputClass + '" id="' + column.data + '" value="' + rowData[column.data] + '"';
                            if (column.data === "Serie") {
                                inputField += ' data-original-serie="' + rowData[column.data] + '" maxlength="7"'; // Añadido maxlength para Serie
                            }
                            inputField += '>';
                            modalTable += '<td>' + inputField + '</td>';
                        }
                    }
                });
                modalTable += '</tr></tbody>';
                modalTable += '</table>';

                $('#modalBodyContent').html(modalTable);
            });

            $('#saveChangesBtn').on('click', function() {
                var modifiedData = {};
                var originalSerie = $('#Serie').data('original-serie'); // Obtiene la serie original
                var nuevaSerie = $('#Serie').val(); // Obtiene la nueva serie

                columns.forEach(function(column) {
                    if (column.title !== "Acciones") {
                        if (column.data === "Tramo" || column.data === "LongitudTotal" ||
                            column.data === "CorrienteAplicada" || column.data === "ValorMedido" ||
                            column.data === "MaxPermisible" || column.data === "Resultado"
                        ) {
                            var inputs = [];
                            $('#modalBodyContent').find('[id^=' + column.data + ']').each(function() {
                                inputs.push($(this).val());
                            });
                            modifiedData[column.data] = inputs.join("|");
                        } else {
                            modifiedData[column.data] = $('#' + column.data).val();
                        }
                    }
                });

                // Agregar la fecha y hora actual al campo FechaPrueba en la zona horaria de Perú
                var currentDateTime = moment().tz("America/Lima").format("YYYY-MM-DD HH:mm:ss");
                modifiedData['FechaPrueba'] = currentDateTime;

                $.ajax({
                    url: 'guardar_cambios.php',
                    method: 'POST',
                    data: {
                        serie: originalSerie,
                        nuevaSerie: nuevaSerie,
                        updatedData: modifiedData
                    },
                    success: function(response) {
                        console.log(response);
                        alert(response); // Muestra la respuesta del servidor en una alerta

                        if (response === "Registro actualizado correctamente") {
                            var rowIndex = table.row(function(idx, data, node) {
                                return data.Serie === originalSerie;
                            }).index();

                            if (rowIndex !== undefined) {
                                var updatedRow = table.row(rowIndex).data();
                                columns.forEach(function(column) {
                                    if (column.title !== "Acciones") {
                                        updatedRow[column.data] = modifiedData[column.data];
                                    }
                                });

                                table.row(rowIndex).data(updatedRow).draw(false);
                            }

                            $('#editModal').modal('hide');

                            // Recargar la página después de guardar cambios
                            location.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                        alert("Error al actualizar el registro: " + textStatus);
                    }
                });
            });

            $('#dataTable').on('click', '.deleteBtn', function() {
                var row = $(this).closest('tr');
                var rowData = table.row(row).data();
                var serie = rowData.Serie;
                if (confirm("¿Estás seguro de que quieres borrar este registro?")) {
                    $.ajax({
                        url: 'delete_record.php',
                        method: 'POST',
                        data: {
                            serie: serie
                        },
                        success: function(response) {
                            console.log(response); // Mostrar respuesta en consola (opcional)

                            // Mostrar mensaje de éxito o cualquier otra notificación al usuario (opcional)
                            alert("Registro eliminado correctamente");

                            // Redireccionar a la misma página actual
                            window.location.reload();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error(textStatus, errorThrown);
                        }
                    });
                }
            });

            $('#agregarItemBtn').on('click', function() {
                var idOrdAterra = '<?php echo $id_orden; ?>'; // Obtener dinámicamente el valor de idOrdAterra

                $.ajax({
                    url: 'agregar_item.php?idOrdAterra=' + idOrdAterra,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);
                        window.location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                    }
                });
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
</body>

</html>