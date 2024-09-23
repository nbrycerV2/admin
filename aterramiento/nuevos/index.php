<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
    <link
        href="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.css"
        rel="stylesheet">
</head>
<style>
    .mi-tabla {
        font-size: 13px;
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Aterramiento</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="index.php">Nuevos</a>
                        <a class="collapse-item" href="../mantenimiento/index.php">Mantenimiento</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Dielectricos</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../../dielectrico/nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="../../dielectrico/mantenimiento/index.php">Mantenimiento</a>
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
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">
                            <a class="btn btn-sm btn-primary" href="nueva_orden.php"> Agregar</a>
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
                                <table class="table table-bordered mi-tabla table-sm" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Id</th>
                                            <th>F. Solicitud</th>
                                            <th>Aterramiento</th>
                                            <th>Cliente</th>
                                            <th>Ruc</th>
                                            <th>Cant.</th>
                                            <th>F. Entrega</th>
                                            <th>Estado</th>
                                            <th>Vendedor</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Id</th>
                                            <th>F. Solicitud</th>
                                            <th>Aterramiento</th>
                                            <th>Cliente</th>
                                            <th>Ruc</th>
                                            <th>Cant.</th>
                                            <th>F. Entrega</th>
                                            <th>Estado</th>
                                            <th>Vendedor</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
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
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.js">
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
                    "data": "",
                    "dataSrc": function(json) {
                        console.log(json);
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                         //<button class="btn btn-danger btn-sm2" onclick="borrar(' + row.idOrdAterra + ')">Borrar</button> DESPUES LE AGREGO
                        render: function(data, type, row) {
                            return '<a class="btn btn-primary btn-sm2" href="orden.php?idOrdAterra=' +
                                row.idOrdAterra +
                                '">Abrir</a>';
                        }
                    },
                    {
                        "data": "idOrdAterra"
                    },
                    {
                        "data": "FechaSolicitud"
                    },
                    {
                        "data": "TipoAterra"
                    },
                    {
                        "data": "Cliente"
                    },
                    {
                        "data": "Ruc"
                    },
                    {
                        "data": "Cantidad"
                    },
                    {
                        "data": "FechaEntrega"
                    },
                    {
                        "data": "Estado",
                        render: function(data, type, row) {
                            switch (data) {
                                case 'Pendiente':
                                    return "<span class='alert-warning'>Pendiente</span>";
                                case 'Entregado':
                                    return "<span class='alert-success'>Entregado</span>";
                                case 'Anulado':
                                    return "<span class='alert-danger'>Anulado</span>";
                                case 'Evaluado':
                                    return "<span class='alert-primary'>Evaluado</span>";
                                default:
                                    return data;
                            }
                        }
                    },
                    {
                        "data": "Vendedor"
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
        });
    </script>

</body>

</html>