<?php
include("conexion.php");
$id_orden = $_GET['id'];
function generarListaEmpresas($conexion)
{
    $sql = "SELECT nombre, ruc FROM emp_main_lista";
    $resultado = $conexion->query($sql);

    $listaEmpresas = "";
    while ($fila = $resultado->fetch_assoc()) {
        $cliente = $fila['nombre'];
        $ruc = $fila['ruc'];

        $opcion = $cliente . " | " . $ruc;
        $listaEmpresas .= "<option value='$opcion'>$opcion</option>";
    }

    return $listaEmpresas;
}

function generarListaEmpleados($conexion)
{
    $sql = "SELECT nombre, apellido, cod_user FROM tabla_user";
    $resultado = $conexion->query($sql);

    $listaEmpleados = "";
    while ($fila = $resultado->fetch_assoc()) {
        $nombre = $fila['nombre'];
        $apellido = $fila['apellido'];
        $cod_user = $fila['cod_user'];

        $opcion2 = $nombre . " " . $apellido;
        $listaEmpleados .= "<option value='$cod_user'>$opcion2</option>";
    }

    return $listaEmpleados;
}

function generarListaMarcas($conexion)
{
    $sql = "SELECT * FROM guantes";
    $resultado = $conexion->query($sql);

    $listaMarcas = "";
    while ($fila = $resultado->fetch_assoc()) {
        $marca_datalist = $fila["marca"];
        $listaMarcas .= "<option value='$marca_datalist'>$marca_datalist</option>";
    }

    return $listaMarcas;
}

function generarListaPertigas($conexion)
{
    $sql = "SELECT * FROM pertigas";
    $resultado = $conexion->query($sql);

    $listaPertigas = "";
    while ($fila = $resultado->fetch_assoc()) {
        $listaPertigas .= "<option value='" . $fila['modelo'] . "'>" . $fila['modelo'] . " (Nº Cuerpos" . $fila['cuerpos'] . ")</option>";
    }

    return $listaPertigas;
}
// Query para obtener los datos de la tabla "orden_dielectrico" donde id coincide con $id
$query = "SELECT * FROM orden_dielectrico WHERE id = $id_orden";
// Ejecutar la consulta
$result = mysqli_query($conexion, $query);
// Verificar si la consulta fue exitosa
if ($result) {
    // Extraer los datos de la consulta y guardarlos en variables con los nombres de las columnas
    $row = mysqli_fetch_assoc($result);

    // Ahora tienes las variables con los datos de la tabla
    $fecha_creacion = $row["fecha"];
    $cliente = $row['cliente'];
    $ruc = $row['ruc'];
    $equipo = $row['equipo'];
    $salida = $row['salida'];
    $estado = $row['estado'];
    $vendedor = $row['vendedor'];
    $items = $row['items'];
    $marcas = $row['marcas'];
    $fecha_inf = $row['fecha_informe'];
    $temperatura = $row['temperatura'];
    $humedad = $row['humedad'];
}

function actualizarItems($conexion, $id_orden)
{
    $sql = "SELECT COUNT(*) AS count_items FROM orden_item WHERE id_orden = $id_orden ";
    $result = $conexion->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $count = $row["count_items"];

        $sql_update = "UPDATE orden_dielectrico SET items = $count WHERE id = $id_orden";

        if ($conexion->query($sql_update) === TRUE) {
            return $count;
        } else {
            return "Error al actualizar la columna: " . $conexion->error;
        }
    } else {
        return "No se encontraron items con id_orden igual a $id_orden";
    }
}

function generarTablaResultados($conexion, $id_orden)
{
    $sql = "SELECT resultado, COUNT(*) AS count_resultado FROM orden_item WHERE id_orden = $id_orden GROUP BY resultado";

    $result = $conexion->query($sql);

    $tabla = '';

    while ($row = $result->fetch_assoc()) {
        $estado = $row['resultado'];
        $count_estado = $row['count_resultado'];
        $tabla .= "<tr>
                    <td>$estado</td>
                    <td>$count_estado</td>
                </tr>";
    }

    return $tabla;
}

function generarTablaClases($conexion, $id_orden)
{
    $sql = "SELECT clase, COUNT(*) AS count_resultado FROM orden_item WHERE id_orden = $id_orden GROUP BY clase";

    $result = $conexion->query($sql);

    $tabla = '';

    while ($row = $result->fetch_assoc()) {
        $estado = $row['clase'];
        $count_estado = $row['count_resultado'];
        $tabla .= "<tr>
                    <td>$estado</td>
                    <td>$count_estado</td>
                </tr>";
    }

    return $tabla;
}



$listaGenerada = generarListaEmpresas($conexion2);
$listaGenerada2 = generarListaMarcas($conexion);
$listaGeneradaEmpleados = generarListaEmpleados($conexion3);
$listaPertigas = generarListaPertigas($conexion);
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
    <!-- Custom styles for this page -->
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.css" rel="stylesheet">

    <!-- Summernote CSS for Bootstrap 5 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs5.min.css" rel="stylesheet">



</head>

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
</style>

<datalist id="empresas">
    <?php echo $listaGenerada; ?>
</datalist>
<datalist id="empleados">
    <?php echo $listaGeneradaEmpleados; ?>
</datalist>
<datalist id="tallas">
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="8.5">8.5</option>
    <option value="9">9</option>
    <option value="9.5">9.5</option>
    <option value="10">10</option>
    <option value="10.5">10.5</option>
    <option value="11">11</option>
</datalist>
<datalist id="marca_lista">
    <?php echo $listaGenerada2; ?>
</datalist>
<datalist id="lista_pertigas">
    <?php echo $listaPertigas; ?>
</datalist>

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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Aterramiento</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../../aterramiento/nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="../../aterramiento/mantenimiento/index.php">Mantenimiento</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item  active">
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Dielectricos</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="index.php">Nuevos</a>
                        <a class="collapse-item" href="../mantenimiento/index.php">Mantenimiento</a>
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
                                                <td><?php echo $cliente; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Ruc</td>
                                                <td><?php echo $ruc; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Vendedor</td>
                                                <td><?php echo $vendedor; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Fecha de creacion</td>
                                                <td><?php echo $fecha_creacion; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Fecha de Salida</td>
                                                <td><?php echo $salida; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Estado del Servicio</td>
                                                <td><?php echo $estado; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <table class="table mi-tabla table-striped table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Cantidades Totales</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $resultado2 = generarTablaClases($conexion, $id_orden);
                                                echo $resultado2;
                                                ?>
                                                <tr>
                                                    <td>Total</td>
                                                    <td><?php $resultado = actualizarItems($conexion, $id_orden);
                                                        echo $resultado; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <table class="table mi-tabla table-striped table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Estado de los items</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tablaResultados = generarTablaResultados($conexion, $id_orden);
                                                echo $tablaResultados;
                                                ?>
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
                                                <td><button class="btn btn-sm2 btn-secondary" data-bs-toggle="modal" data-bs-target="#agregar_item">Agregar Item</button></td>
                                                <td><button class="btn btn-sm2 btn-secondary" data-bs-toggle="modal" data-bs-target="#datos_informe">Datos para el Informe</button>
                                                </td>
                                                <td><a class="btn btn-sm2 btn-secondary" href="procesar.php?id_orden=<?php echo $id_orden ?>&equipo=<?php echo $equipo ?>&funcion=agrego_series">Generar
                                                        serie a todos los Items</a></td>
                                                <td><a class="btn btn-sm2 btn-secondary" id="generarPDFs">Descargar
                                                        todos los Informes</a></td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="table-responsive">

                                    <?php if ($equipo == "Guantes") {
                                        include("./tablas/tabla_guantes.php");
                                    }
                                    if ($equipo == "Mantas") {
                                        include("./tablas/tabla_mantas.php");
                                    }
                                    if ($equipo == "Banquetas") {
                                        include("./tablas/tabla_banquetas.php");
                                    }
                                    if ($equipo == "Pertigas") {
                                        include("./tablas/tabla_pertiga.php");
                                    }
                                    if ($equipo == "Mangas") {
                                        include("./tablas/tabla_mangas.php");
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Logytec 2023</span>

                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>

    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.js">
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>

    <!-- Summernote JS for Bootstrap 5 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs5.min.js"></script>
    <?php
    if ($equipo == "Guantes") {
        include("./js/dt_guantes.php");
    }
    if ($equipo == "Mantas") {
        include("./js/dt_mantas.php");
    }
    if ($equipo == "Banquetas") {
        include("./js/dt_banquetas.php");
    }
    if ($equipo == "Pertigas") {
        include("./js/dt_pertiga.php");
    }
    if ($equipo == "Mangas") {
        include("./js/dt_mangas.php");
    }
    ?>

    <script>
        function borrar(id) {
            // Mostrar el modal de confirmación
            $('#confirmarBorradoModal').modal('show');

            // Cuando se hace clic en el botón de "Borrar" en el modal, enviar la solicitud al servidor para eliminar los datos
            $('#confirmarBorradoBtn').on('click', function() {
                $.ajax({
                    url: 'procesar.php?funcion=borro_items',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        // Manejar la respuesta del servidor si es necesario
                        console.log(response);
                        //recargo la pagina
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores si los hay
                        console.log(error);
                    }
                });

                // Ocultar el modal de confirmación
                $('#confirmarBorradoModal').modal('hide');
            });
        }
    </script>

    <!-- Modal -->
    <?php if ($equipo == "Guantes") {
        include("./modals/modals_guantes.php");
    }
    if ($equipo == "Mantas") {
        include("./modals/modals_mantas.php");
    }
    if ($equipo == "Banquetas") {
        include("./modals/modals_banquetas.php");
    }
    if ($equipo == "Pertigas") {
        include("./modals/modals_pertiga.php");
    }
    if ($equipo == "Mangas") {
        include("./modals/modals_mangas.php");
    }
    ?>



    <!-- Modal borrar-->
    <div class="modal fade" id="confirmarBorradoModal" tabindex="-1" role="dialog" aria-labelledby="confirmarBorradoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarBorradoModalLabel">Confirmar borrado</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas borrar este elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarBorradoBtn">Borrar</button>
                </div>
            </div>
        </div>
    </div>



</body>

</html>