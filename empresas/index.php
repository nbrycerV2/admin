<?php
include("conexion.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Listado de Empresas</title>

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->

    <link rel="stylesheet" href="../css/sb-admin-2.min.css">
    <!-- Custom styles for this page -->
    <link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="../index.html">
                <div class="sidebar-brand-text mx-3">Logytec</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0" />

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="../index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0" />
            <!-- Nav Item - Dashboard -->
            <li class="nav-item  active">
                <a class="nav-link" href="index.php">
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Aterramiento</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="#">Nuevos</a>
                        <a class="collapse-item" href="#">Mantenimiento</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item ">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench active"></i>
                    <span>Dielectricos</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../dielectrico/nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="../dielectrico/mantenimiento/index.php">Mantenimiento</a>
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
                    <h1 class="h3 mb-0 text-gray-800">Lista de Empresas</h1>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">

                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#exampleModal">
                                Agregar
                            </button>

                            <a class="btn btn-sm btn-secondary"> Graficas</a>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabla de Empresas</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mi-tabla table-sm" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Id</th>
                                            <th>RUC</th>
                                            <th>Razon Social</th>
                                            <th>Departamento</th>
                                            <th>Distrito</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Id</th>
                                            <th>RUC</th>
                                            <th>Razon Social</th>
                                            <th>Departamento</th>
                                            <th>Distrito</th>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins-->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json"></script>
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
                        return '<a class="btn btn-primary btn-sm2" href="queja.php?id=' + row
                            .id +
                            '">Abrir</a>  <button class="btn btn-danger btn-sm2" onclick="borrar(' +
                            row.id + ')">Borrar</button>';
                    }
                }, {
                    "data": "id"
                }, {
                    "data": "ruc"
                }, {
                    "data": "nombre"
                }, {
                    "data": "dpto"
                }, {
                    "data": "distrito"
                }],
                order: [
                    [1, 'desc']
                ]

            });
        });
    </script>

    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Modal -->
    <div class="modal fade" id="confirmarBorradoModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmarBorradoModalLabel" aria-hidden="true">
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="procesar.php?funcion=add_emp" method="post">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">RUC</span>
                            </div>
                            <input type="text" class="form-control" placeholder="RUC" id="ruc" name="ruc"
                                aria-label="Username" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"
                                    id="button-addon2">Consultar</button>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Razon Social</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Razon Social" id="razonSocial"
                                name="razonSocial" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Direccion</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Direccion" id="direccion"
                                name="direccion" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="Departamento" name="Departamento"
                                aria-label="Username" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" id="Provincia" name="Provincia"
                                aria-label="Username" aria-describedby="basic-addon1">
                            <input type="text" class="form-control" id="Distrito" name="Distrito" aria-label="Username"
                                aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Estado</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Estado" id="estado" name="estado"
                                aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#button-addon2').on('click', function() {
                var ruc = $('#ruc').val();
                $.ajax({
                    url: 'agregar.php', // Cambia esta ruta por la ruta correcta a tu archivo PHP
                    method: 'GET',
                    data: {
                        numero: ruc
                    },
                    success: function(response) {
                        var empresa = JSON.parse(response);
                        $('#ruc').val(empresa.numeroDocumento);
                        $('#razonSocial').val(empresa.razonSocial);
                        $('#direccion').val(empresa.direccion);
                        $('#estado').val(empresa.estado);
                        $('#Departamento').val(empresa.departamento);
                        $('#Provincia').val(empresa.provincia);
                        $('#Distrito').val(empresa.distrito);
                        $('#exampleModal').modal('show');
                    },
                    error: function() {
                        alert('Error al consultar la API');
                    }
                });
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
                    url: 'procesar.php?funcion=el_emp',
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




</body>

</html>