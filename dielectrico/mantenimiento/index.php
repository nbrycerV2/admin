<?php
include("conexion.php");

// Consulta SQL para obtener las empresas desde la tabla
$sql = "SELECT nombre, ruc FROM emp_main_lista";

$year = date("Y");
// Ejecutar la consulta
$resultado = $conexion2->query($sql);

// Crear una lista con los valores obtenidos
$listaEmpresas = "";
while ($fila = $resultado->fetch_assoc()) {
    $cliente = $fila['nombre'];
    $ruc = $fila['ruc'];

    // Combinar nombre de empresa y RUC en una sola opción
    $opcion = $cliente . " | " . $ruc;

    // Agregar opción a la lista
    $listaEmpresas .= "<option value='$opcion'>$opcion</option>";
}

// Consulta SQL para obtener empleados
$sql = "SELECT nombre, apellido, cod_user FROM tabla_user";

// Ejecutar la consulta
$resultado = $conexion3->query($sql);

// Crear una lista con los valores obtenidos
$listaEmpleados = "";
while ($fila = $resultado->fetch_assoc()) {
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
    $cod_user = $fila['cod_user'];

    // Combinar nombre de empresa y RUC en una sola opción
    $opcion2 = $nombre . " " . $apellido;

    // Agregar opción a la lista
    $listaEmpleados .= "<option value='$cod_user'>$opcion2</option>";
}

?>

<!DOCTYPE html>
<html lang="es">

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
</style>

<datalist id="empresas">
    <?php echo $listaEmpresas; ?>
</datalist>
<datalist id="empleados">
    <?php echo $listaEmpleados; ?>
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
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
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
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="index.php">Mantenimiento</a>
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
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <h1 class="h3 mb-0 text-gray-800">Dielectricos Mantenimiento</h1>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Agregar
                            </button>

                            <a class="btn btn-sm btn-secondary" href="graficas.php"> Graficas</a>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabla de Ordenes</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mi-tabla table-sm" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Id</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Ruc</th>
                                            <th>Equipo</th>
                                            <th>Salida</th>
                                            <th>Estado</th>
                                            <th>Vendedor</th>
                                            <th>Items</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Id</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Ruc</th>
                                            <th>Equipo</th>
                                            <th>Salida</th>
                                            <th>Estado</th>
                                            <th>Vendedor</th>
                                            <th>Items</th>

                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

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

    <!-- Page level plugins-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.js">
    </script>

    <script>
        $(document).ready(function() {
            $("#dataTable").DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
                },
                "ajax": {
                    "url": "obtener_datos.php",
                    "method": "POST",
                    "data": ""
                },
                columns: [{
                    data: null,
                    render: function(data, type, row) {
                        return '<a class="btn btn-primary btn-sm2" href="orden.php?id=' + row
                            .id +
                            '">Abrir</a>  <button class="btn btn-danger btn-sm2" onclick="borrar(' +
                            row.id + ')">Borrar</button>';

                    }
                }, {
                    "data": "id"
                }, {
                    "data": "fecha"
                }, {
                    "data": "cliente"
                }, {
                    "data": "ruc"
                }, {
                    "data": "equipo"
                }, {
                    "data": "salida"
                }, {
                    "data": null,
                    render: function(data, type, row) {
                        if (row.estado == "Pendiente") {
                            return "<span class='alert-warning'>Pendiente</span>"
                        }
                        if (row.estado == "Entregado") {
                            return "<span class='alert-success'>Entregado</span>"
                        }
                        if (row.estado == "Anulado") {
                            return "<span class='alert-danger'>Anulado</span>"
                        }
                        if (row.estado == "Evaluado") {
                            return "<span class='alert-primary'>Evaluado</span>"
                        }
                    }
                }, {
                    "data": "vendedor"
                }, {
                    "data": "items"
                }],
                order: [
                    [1, 'desc']
                ]

            });
        });
    </script>
    <script>
        function borrar(id) {
            // Mostrar el modal de confirmación
            $('#confirmarBorradoModal').modal('show');

            // Cuando se hace clic en el botón de "Borrar" en el modal, enviar la solicitud al servidor para eliminar los datos
            $('#confirmarBorradoBtn').on('click', function() {
                $.ajax({
                    url: 'procesar.php?funcion=eliminar_orden',
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarBorradoBtn">Borrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Orden</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="procesar.php?funcion=agrego_orden" method="post">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Cliente</span>
                            </div>
                            <input type="text" class="form-control" name="empresa" list="empresas" placeholder="Buscar por empresa o ruc" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Equipo</span>
                            </div>

                            <select class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="equipo">
                                <option value="Guantes">Guantes</option>
                                <option value="Mantas">Mantas</option>
                                <option value="Banquetas">Banquetas</option>
                                <option value="Pertigas">Pertigas</option>
                                <option value="Mangas">Mangas</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Vendedor</span>
                            </div>
                            <input type="text" class="form-control" name="vendedor" list="empleados" placeholder="Buscar por nombre" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <input type="hidden" value="Pendiente" name="estado">
                        <input type="hidden" value="0" name="items">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>