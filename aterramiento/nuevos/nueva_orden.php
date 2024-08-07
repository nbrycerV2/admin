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
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
</head>

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
            <li class="nav-item active">
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
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Aterramiento</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="index.php">Nuevos</a>
                        <a class="collapse-item" href="#">Mantenimiento</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Dielectricos</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="../../dielectrico/nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="#">Mantenimiento</a>
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
                    <form action="armar.php" method="post">
                        <div class="row">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 ">
                                    <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                    <a class="btn btn-sm btn-danger" href="index.php"> Cancelar</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">

                                <label onclick="muestro(1)">
                                    <input type="radio" name="aterra" id="ena" value="ENA">
                                    <label for="ena">Enganche Automatico</label>
                                </label><br>

                                <label onclick="muestro(2)">
                                    <input type="radio" name="aterra" id="ext" value="EXT">
                                    <label for="ext">Extension</label>
                                </label><br>

                                <label onclick="muestro(3)">
                                    <input type="radio" name="aterra" id="jum" value="JUM">
                                    <label for="jum">Jumper Equipotencial</label>
                                </label><br>

                                <label onclick="muestro(4)">
                                    <input type="radio" name="aterra" id="pde" value="PDE">
                                    <label for="pde">Pertiga de descarga</label>
                                </label><br>

                                <label onclick="muestro(5)">
                                    <input type="radio" name="aterra" id="p03" value="P03">
                                    <label for="p03">Pulpo</label>
                                </label><br>

                                <label onclick="muestro(6)">
                                    <input type="radio" name="aterra" id="pel" value="PEL">
                                    <label for="pel">Pulpo con Elastimold</label>
                                </label><br>

                                <label onclick="muestro(7)">
                                    <input type="radio" name="aterra" id="tra" value="TRA">
                                    <label for="tra">Trapecio</label>
                                </label><br>
                            </div>
                            <div class="col-3">

                                <label onclick="muestro(14)">
                                    <input type="radio" name="aterra" id="u01" value="U01">
                                    <label for="u01">Unipolar(1 Tiras)</label>
                                </label><br>

                                <label onclick="muestro(9)">
                                    <input type="radio" name="aterra" id="u03" value="U03">
                                    <label for="u03">Unipolar(3 Tiras)</label>
                                </label><br>

                                <label onclick="muestro(10)">
                                    <input type="radio" name="aterra" id="upf" value="UPF">
                                    <label for="upf">Unipolar con Pertiga Fija</label>
                                </label><br>

                                <label onclick="muestro(11)">
                                    <input type="radio" name="aterra" id="usa" value="USA">
                                    <label for="usa">Unipolar Con Seguridad Aumentada</label>
                                </label><br>

                                <label onclick="muestro(12)">
                                    <input type="radio" name="aterra" id="umt" value="UMT">
                                    <label for="umt">Unipolar Para Lineas de Media Tension</label>
                                </label><br>

                                <label onclick="muestro(13)">
                                    <input type="radio" name="aterra" id="upv" value="UPV">
                                    <label for="upv">Unipolar para Vehiculo</label>
                                </label><br>

                    </form>
                </div>
                <div class="col-6">
                    <img src="" class="img-fluid" id="matrix">
                </div>
            </div>

            </form>

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

    <!-- Logout Modal-->

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

    <script>
        function muestro(x) {
            var y = x;
            if (y == 1) {
                document.getElementById('matrix').src = "imagenes/ENA.jpg"; //Enganche automatico
            }
            if (y == 2) {
                document.getElementById('matrix').src = "imagenes/EXT.jpg"; //Extension
            }
            if (y == 3) {
                document.getElementById('matrix').src = "imagenes/JUM.jpg"; //Jumper
            }
            if (y == 4) {
                document.getElementById('matrix').src = "imagenes/PDE.jpg"; //Pertiga de descarga
            }
            if (y == 5) {
                document.getElementById('matrix').src = "imagenes/P03.jpg"; //Pulpo
            }
            if (y == 6) {
                document.getElementById('matrix').src = "imagenes/PEL.jpg"; //Pulpo con elastimold
            }
            if (y == 7) {
                document.getElementById('matrix').src = "imagenes/TRA.jpg"; //Trapecio
            }
            if (y == 8) {
                document.getElementById('matrix').src = "imagenes/TPF.jpg"; //Trapecio con pertiga fija
            }
            if (y == 9) {
                document.getElementById('matrix').src = "imagenes/U03.jpg"; //unipolar 3 tiras
            }
            if (y == 10) {
                document.getElementById('matrix').src = "imagenes/UPF.jpg"; //unipolar con pertiga fija
            }
            if (y == 11) {
                document.getElementById('matrix').src = "imagenes/USA.jpg"; //unipolar con seguridad aumentada
            }
            if (y == 12) {
                document.getElementById('matrix').src = "imagenes/UMT.jpg"; //unipolar para lineas de media tension
            }
            if (y == 13) {
                document.getElementById('matrix').src = "imagenes/UPV.jpg"; //unipolar para vehiculo
            }
            if (y == 14) {
                document.getElementById('matrix').src = "imagenes/U01.jpg"; //unipolar para lineas de media tension
            } else {

            }

        }

        function quito() {
            document.getElementById('matrix').src = "";
        }
    </script>
</body>

</html>