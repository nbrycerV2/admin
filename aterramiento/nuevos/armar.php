<?php
$aterra = $_POST["aterra"];
echo $aterra;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet" />
</head>
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
                    <form action="procesar.php" method="post">
                        <div class="row">
                            <div class="row">
                                <label for="">
                                    Configuracion de la Orden
                                </label>
                                <div class="col-12 ">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cliente</span>
                                        <input type="text" class="form-control" list="empresas">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cantidad (Juegos)</span>
                                        <input type="number" min="0" class="form-control">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Vendedor</span>
                                        <input type="text" class="form-control" list="empleados">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            -En caso de que no se encuentre el cliente, dar click <a href="">aqui</a> primero.
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="row">
                                <label for="">
                                    Configuracion del Aterramiento
                                </label>
                                <div class="col-12 ">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Mordaza de Linea</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            <option value=""></option>
                                            <option value="RC600-2282">RC600-2282</option>
                                            <option value="RC600-0965">RC600-0965</option>
                                            <option value="RG3369">RG3369</option>
                                            <option value="RG3403">RG3403</option>
                                            <option value="RG3622-1">RG3622-1</option>
                                            <option value="RC600-2300 MORDAZA CONCHA-BOLA">RC600-2300 MORDAZA CONCHA-BOLA</option>
                                            <option value="ATR13628-1 (Enganche Automatico)">ATR13628-1 (Enganche Automatico)</option>
                                            <option value="161GP Set de Bushing y Cable elastimold">161GP Set de Bushing y Cable elastimold</option>
                                            <option value="272GP Set de Bushing y Cable elastimold">272GP Set de Bushing y Cable elastimold</option>
                                            <option value="RG3368">RG3368</option>
                                            <option value="RG3363-1">RG3363-1</option>
                                            <option value="RG3403T">RG3403T</option>
                                            <option value="ATR11627-2">ATR11627-2</option>
                                            <option value="RC600-0065">RC600-0065</option>
                                            <option value="RG3367-1">RG3367-1</option>
                                            <option value="ATR08969-3">ATR08969-3</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud A</span>
                                        <input type="number" min="0" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion A</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            <option value=""></option>
                                            <option value="25">25</option>
                                            <option value="35">35</option>
                                            <option value="50">50</option>
                                            <option value="70">70</option>
                                            <option value="95">95</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Terminal de Linea</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">

                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud X</span>
                                        <input type="number" min="0" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion X</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            <option value=""></option>
                                            <option value="25">25</option>
                                            <option value="35">35</option>
                                            <option value="50">50</option>
                                            <option value="70">70</option>
                                            <option value="95">95</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Terminal de X</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Mordaza de Tierra</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            <option value=""></option>
                                            <option value="ATR11627-2">ATR11627-2</option>
                                            <option value="RG3403T">RG3403T</option>
                                            <option value="RG3363-1">RG3363-1</option>
                                            <option value="ATR03641-1 Carretel">ATR03641-1 Carretel</option>
                                            <option value="S/CODIGO Carrete Nacional">S/CODIGO Carrete Nacional</option>
                                            <option value="RG3363-4SJ">RG3363-4SJ</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud B</span>
                                        <input type="number" min="0" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion B</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            <option value=""></option>
                                            <option value="25">25</option>
                                            <option value="35">35</option>
                                            <option value="50">50</option>
                                            <option value="70">70</option>
                                            <option value="95">95</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Terminal de Tierra</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                </div>
                                <div class="col-4">imagen</div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="row">
                                <label for="">
                                    Accesorios Extras
                                </label>
                                <div class="col-12 ">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Pertiga</span>
                                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Adaptador</span>
                                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Varilla</span>
                                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Trifurcacion</span>
                                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Otros</span>
                                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="card">
                                            <div class="card-body">
                                                Considerar cantidad de estuches para 1 solo juego de aterramientos.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Chico</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Grande</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Metalico</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Pertigas</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                                    </div>
                                </div>
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
        function actualizarOpciones2() {
            var opcionesSelect2 = document.getElementById("terminal_tierra");
            opcionesSelect2.innerHTML = ""; // Limpiamos las opciones del select

            var opcionesSelect3 = document.getElementById("terminal_tierra_2");
            opcionesSelect3.innerHTML = ""; // Limpiamos las opciones del select

            var grosorCableSelect2 = document.getElementById("seccion_B");
            var grosorCable2 = grosorCableSelect2.options[grosorCableSelect2.selectedIndex].value;

            var configuracion = document.getElementById("configuracion");



            if (grosorCable2 == "35") {
                opcionesSelect2.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "50") {
                opcionesSelect2.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "25") {
                opcionesSelect2.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "70") {
                opcionesSelect2.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "95") {
                opcionesSelect2.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            }

        }
    </script>
    <script>
        function actualizarOpciones() {
            var opcionesSelect = document.getElementById("terminal_linea");
            opcionesSelect.innerHTML = ""; // Limpiamos las opciones del select

            var grosorCableSelect = document.getElementById("seccion_A");
            var grosorCable = grosorCableSelect.options[grosorCableSelect.selectedIndex].value;

            if (grosorCable == "35") {
                opcionesSelect.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "50") {
                opcionesSelect.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "25") {
                opcionesSelect.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "70") {
                opcionesSelect.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "95") {
                opcionesSelect.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            }
        }
    </script>
    <script>
        function actualizarOpciones3() {
            var opcionesSelect4 = document.getElementById("terminal_lineax");
            opcionesSelect4.innerHTML = ""; // Limpiamos las opciones del select

            var grosorCableSelect4 = document.getElementById("sec_x");
            var grosorCable4 = grosorCableSelect4.options[grosorCableSelect4.selectedIndex].value;


            if (grosorCable4 == "35") {
                opcionesSelect4.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "50") {
                opcionesSelect4.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "25") {
                opcionesSelect4.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "70") {
                opcionesSelect4.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "95") {
                opcionesSelect4.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            }
        }
    </script>


</body>

</html>