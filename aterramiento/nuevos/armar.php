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
$prefix = "ORD" . $year . $month;

// Consultar el último número de orden de este mes y año
$sql = "SELECT idOrdAterra FROM ordaterra WHERE idOrdAterra LIKE '$prefix%' ORDER BY idOrdAterra DESC LIMIT 1";
$result = $conn->query($sql);

// Inicializar el número correlativo
$correlativo = 1;

if ($result->num_rows > 0) {
    // Si hay resultados, obtener el último número correlativo
    $row = $result->fetch_assoc();
    $lastCodigo = $row['idOrdAterra'];

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
$aterra = $_POST["aterra"];
include("bloqcampos.php");
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

        <!-- Contenido HTML -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb- static-top shadow">
                    <h1 class="h3 mb-0 text-gray-800">Inicio</h1>
                </nav>

                <div class="container-fluid">
                    <form action="procesar_formulario.php" method="post">
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
                                        <span class="input-group-text" id="inputGroup-sizing-sm">ID Orden Aterramiento</span>
                                        <input type="text" class="form-control" name="idOrdAterraphp" value="<?php echo $codigoOrden; ?>" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cliente</span>
                                        <input type="text" class="form-control" name="idClientephp" list="empresas" value="">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Cantidad (Juegos)</span>
                                        <input type="number" min="0" class="form-control" name="Cantidadphp" value="" required>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Vendedor</span>
                                        <input type="text" class="form-control" list="empleados" name="Vendedorphp" value="" required>
                                        <span class="input-group-text ocultar-campo" id="inputGroup-sizing-sm">Fecha De Solicitud</span>
                                        <input type="datetime-local" class="form-control ocultar-campo" name="FechaSolicitudphp" value="<?php echo $fechaHoraActual; ?>">
                                        <span class="input-group-text ocultar-campo" id="inputGroup-sizing-sm">Fecha De Entrega</span>
                                        <input type="date" class="form-control ocultar-campo" name="FechaEntregaphp" value="">
                                        <input type="hidden" name="aterraphp" value="<?php echo htmlspecialchars($aterra); ?>">
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

                        <!-- Configuracion del Aterramiento -->
                        <div class="row">
                            <div class="row">
                                <label for="">Configuracion del Aterramiento</label>
                                <div class="col-12">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Mordaza de Linea</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="MLineaphp" <?php if ($MordazaLineaA) echo 'disabled'; ?> value="" required>
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
                                        <input type="number" min="1" step="0.1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaLineaLA) echo 'disabled'; ?> name="LongitudAphp" value="" required>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion A</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaLineaSA) echo 'disabled'; ?> name="SeccionAphp" value="" required>
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
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($TerminalLinea) echo 'disabled'; ?> name="TLineaphp" value="" required>
                                            <option value=""></option>
                                            <option value="MTA35-C">MTA35-C</option>
                                            <option value="MTA50-C">MTA50-C</option>
                                            <option value="MTA70-C">MTA70-C</option>
                                            <option value="MTA120-C">MTA120-C</option>
                                            <option value="2A10-M10">2A10-M10</option>
                                            <option value="2A10-M10">2A10-M10</option>
                                            <option value="2A14M-10">2A14M-10</option>
                                            <option value="2A5-M8">2A5-M8</option>
                                            <option value="2A7-M8">2A7-M8</option>
                                            <option value="A10-M10">A10-M10</option>
                                            <option value="A14-M10">A14-M10</option>
                                            <option value="A5-M8">A5-M8</option>
                                            <option value="A7-M8">A7-M8</option>
                                            <option value="2710110">2710110</option>
                                            <option value="NAC_EXT">NAC_EXT</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud X</span>
                                        <input type="number" min="1" step="0.1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaTierraLX) echo 'disabled'; ?> name="LongitudXphp" value="" required>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion X</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaTierraSX) echo 'disabled'; ?> name="SeccionXphp" value="" required>
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
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($TerminalX) echo 'disabled'; ?> name="TerminalXphp" value="" required>
                                            <option value=""></option>
                                            <option value="MTA35-C">MTA35-C</option>
                                            <option value="MTA50-C">MTA50-C</option>
                                            <option value="MTA70-C">MTA70-C</option>
                                            <option value="MTA120-C">MTA120-C</option>
                                            <option value="2A10-M10">2A10-M10</option>
                                            <option value="2A10-M10">2A10-M10</option>
                                            <option value="2A14M-10">2A14M-10</option>
                                            <option value="2A5-M8">2A5-M8</option>
                                            <option value="2A7-M8">2A7-M8</option>
                                            <option value="A10-M10">A10-M10</option>
                                            <option value="A14-M10">A14-M10</option>
                                            <option value="A5-M8">A5-M8</option>
                                            <option value="A7-M8">A7-M8</option>
                                            <option value="2710110">2710110</option>
                                            <option value="NAC_EXT">NAC_EXT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Mordaza de Tierra</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaTierra) echo 'disabled'; ?> name="MTierraphp" value="" required>
                                            <option value=""></option>
                                            <option value="ATR11627-2">ATR11627-2</option>
                                            <option value="RG3403T">RG3403T</option>
                                            <option value="RG3363-1">RG3363-1</option>
                                            <option value="ATR03641-1 Carretel">ATR03641-1 Carretel</option>
                                            <option value="RG3363-4SJ">RG3363-4SJ</option>
                                            <option value="N3B8 FAMECA">N3B8 FAMECA</option>
                                            <option value="RC600-0085">RC600-0085</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud B</span>
                                        <input type="number" min="1" step="0.1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaTierraLB) echo 'disabled'; ?> name="LongitudBphp" value="" required>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion B</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($MordazaTierraSB) echo 'disabled'; ?> name="SeccionBphp" value="" required>
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
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($TerminalTierra) echo 'disabled'; ?> name="TTierraphp" value="" required>
                                            <option value=""></option>
                                            <option value="MTA35-C">MTA35-C</option>
                                            <option value="MTA50-C">MTA50-C</option>
                                            <option value="MTA70-C">MTA70-C</option>
                                            <option value="MTA120-C">MTA120-C</option>
                                            <option value="2A10-M10">2A10-M10</option>
                                            <option value="2A10-M10">2A10-M10</option>
                                            <option value="2A14M-10">2A14M-10</option>
                                            <option value="2A5-M8">2A5-M8</option>
                                            <option value="2A7-M8">2A7-M8</option>
                                            <option value="A10-M10">A10-M10</option>
                                            <option value="A14-M10">A14-M10</option>
                                            <option value="A5-M8">A5-M8</option>
                                            <option value="A7-M8">A7-M8</option>
                                            <option value="2710110">2710110</option>
                                            <option value="NAC_EXT">NAC_EXT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <!-- Placeholder para la imagen -->
                                    imagen
                                </div>
                            </div>
                        </div>

                        <!-- Accesorios Extras -->
                        <div class="row">
                            <div class="row">
                                <label for="">Accesorios Extras</label>
                                <div class="col-12">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Pertiga</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($AccPertiga) echo 'disabled'; ?> name="Pertigaphp" value="">
                                                    <option value=""></option>
                                                    <option value="RC600-0434">RC600-0434</option>
                                                    <option value="RH1760-1">RH1760-1</option>
                                                    <option value="RG3363-1">RG3363-1</option>
                                                    <option value="VMR-15">VMR-15</option>
                                                    <option value="VMR-30">VMR-30</option>
                                                    <option value="VMR-45">VMR-45</option>
                                                    <option value="VMR-70">VMR-70</option>
                                                    <option value="VMR-90">VMR-90</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Adaptador</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($AccAdaptador) echo 'disabled'; ?> name="Adaptadorphp" value="">
                                                    <option value=""></option>
                                                    <option value="RG3368">RG3368</option>
                                                    <option value="ATR14442-1 Plato Portapinzas (Dst-7)">ATR14442-1 Plato Portapinzas (Dst-7)</option>
                                                    <option value="VMR07205-1 Adaptador para maniobrar">VMR07205-1 Adaptador para maniobrar</option>
                                                    <option value="RM4455-29B Adaptador para maniobrar">RM4455-29B Adaptador para maniobrar</option>
                                                    <option value="FLV-3585 Pino Bola">FLV-3585 Pino Bola</option>
                                                    <option value="ATR08969-1 Mordaza Pino Bola">ATR08969-1 Mordaza Pino Bola</option>
                                                    <option value="RM4455-78 Extractor de fusibles">RM4455-78 Extractor de fusibles</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Varilla</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($AccVarilla) echo 'disabled'; ?> name="Varillaphp" value="">
                                                    <option value=""></option>
                                                    <option value="Var 5/8">Var 5/8</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Trifurcacion</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" <?php if ($AccTrifurcacion) echo 'disabled'; ?> name="Trifurcacionphp" value="">
                                                    <option value=""></option>
                                                    <option value="RG4754-1 Pulpo">RG4754-1 Pulpo</option>
                                                    <option value="ATR04116-1 Trapecio">ATR04116-1 Trapecio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Otros</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Otrosphp" value="">
                                                    <option></option>
                                                    <option value="RG3625 Soporte de suspension">RG3625 Soporte de suspension</option>
                                                </select>
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
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstChico" value="">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Grande</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstGrande" value="">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Metalico</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstMetalico" value="">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Pertigas</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstPertiga" value="">
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