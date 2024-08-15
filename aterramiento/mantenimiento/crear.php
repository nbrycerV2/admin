<?php
// Archivo: nuevo_orden.php

// Establecer la conexión con la base de datos
$servername = "localhost"; // Cambia esto si tu servidor de MySQL es diferente
$username = "root"; // Cambia esto si tu nombre de usuario es diferente
$password = ""; // Cambia esto si tu contraseña es diferente
$dbname = "sistema_dielectricos2"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener la fecha actual
$year = date("y"); // Obtiene los dos últimos dígitos del año
$month = date("m"); // Obtiene el mes en formato numérico de dos dígitos

// Construir el prefijo del código de orden
$prefix = "MAN" . $year . $month;

// Consultar el último número de orden de este mes y año
$sql = "SELECT IdOrdMant FROM ordmantenimiento WHERE IdOrdMant LIKE '$prefix%' ORDER BY IdOrdMant DESC LIMIT 1";
$result = $conn->query($sql);

// Inicializar el número correlativo
$correlativo = 1;

if ($result->num_rows > 0) {
    // Si hay resultados, obtener el último número correlativo
    $row = $result->fetch_assoc();
    $lastCodigo = $row['IdOrdMant'];

    // Extraer el número correlativo del código
    $lastNumber = substr($lastCodigo, -3); // Últimos tres dígitos
    $correlativo = intval($lastNumber) + 1; // Incrementar en uno
}

// Formatear el número correlativo a tres dígitos
$correlativoStr = str_pad($correlativo, 3, "0", STR_PAD_LEFT);

// Construir el nuevo código de orden
$codigoOrden = $prefix . $correlativoStr;

// Cerrar la conexión
$conn->close();
?>

<?php
include("../nuevos/bloqcampos.php");
include("../nuevos/conexion.php");

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
// Obtiene la fecha y hora actual en el formato YYYY-MM-DDTHH:MM
$fechaHoraActual = date('Y-m-d\TH:i');
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
<style>
    .ocultar-campo {
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
                        <a class="collapse-item" href="../nuevos/index.php">Nuevos</a>
                        <a class="collapse-item" href="index.php">Mantenimiento</a>
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

        <!-- Contenido HTML -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb- static-top shadow">
                    <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
                </nav>

                <div class="container-fluid">
                    <form action="procesar_formulario1.php" method="post">
                        <div class="row">
                            <!-- Configuracion de la Orden -->
                            <div class="row">
                                <label for="">Configuracion de la Orden</label>
                                <div class="col-12">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <!-- Campo para mostrar el ID de la orden de aterramiento -->
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">ID Orden Mantenimiento</span>
                                        <input type="text" class="form-control" name="IdOrdMantphp" value="<?php echo $codigoOrden; ?>" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cliente</span>
                                        <input type="text" class="form-control" name="idClientephp" list="empresas" value="">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text ocultar-campo" id="inputGroup-sizing-sm">Cantidad (Juegos)</span>
                                        <input type="number" min="0" class="form-control ocultar-campo" name="Cantidadphp" value="0" required>
                                        <span class="input-group-text ocultar-campo" id="inputGroup-sizing-sm">Fecha De Solicitud</span>
                                        <input type="datetime-local" class="form-control ocultar-campo" name="FechaSolicitudphp" value="<?php echo $fechaHoraActual; ?>">
                                        <span class="input-group-text ocultar-campo" id="inputGroup-sizing-sm">Fecha De Entrega</span>
                                        <input type="date" class="form-control ocultar-campo" name="FechaEntregaphp" value="">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <div class="card-body">
                                            -En caso de que no se encuentre el cliente, dar click <a href="../../empresas/index.php">aqui</a> primero.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card shadow mb-3">
                                <div class="card-header py-3 ">
                                    <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                    <a class="btn btn-sm btn-danger" href="nueva_orden.php"> Cancelar</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            </form>
        </div>
    </div>
    </div>
    <!-- End of Main Content -->


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


</body>

</html>