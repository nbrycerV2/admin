<?php
include("conexion.php");
// Usa la variable $id_orden obtenida de GET
$id_orden = $_GET['id_orden'];

// Consulta para obtener los datos del formulario
$query = "SELECT `idDetOrdAterra`, `idOrdAterra`, `Serie`, `MLinea`, `LongitudA`, `SeccionA`, `MTierra`, `LongitudB`, `SeccionB`, `TLinea`, `LongitudX`, `SeccionX`, `TerminalX`, `TTierra`, `FechaSolicitud` 
          FROM `det_ord_aterra` 
          WHERE `idOrdAterra` = '$id_orden' 
          ORDER BY idDetOrdAterra DESC 
          LIMIT 1";

$result = mysqli_query($conexion, $query);
$data = mysqli_fetch_assoc($result);

// Manejo de datos si la consulta falla
if (!$data) {
    die("Error al obtener datos: " . mysqli_error($conexion));
}

// Obtener ids de la primera consulta
$query = "SELECT `idDetOrdAterra` FROM `det_ord_aterra` WHERE `idOrdAterra` = '$id_orden'";
$result = mysqli_query($conexion, $query);

$ids = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ids[] = $row['idDetOrdAterra'];
}

// Verificar si hay ids
$accesorios_desactivados = true; // Por defecto, desactiva accesorios
if (count($ids) > 0) {
    // Escapar los ids con mysqli_real_escape_string
    $ids_escapados = array_map(function ($id) use ($conexion) {
        return mysqli_real_escape_string($conexion, $id);
    }, $ids);

    // Convertir el array de ids en una lista separada por comas con comillas simples
    $ids_str = "'" . implode("','", $ids_escapados) . "'";

    // Consulta para obtener accesorios
    $query_accesorios = "SELECT * FROM `acc_ord_aterra` WHERE `idDetOrdAterra` IN ($ids_str) ORDER BY `idDetAcc` DESC LIMIT 1";

    $result_accesorios = mysqli_query($conexion, $query_accesorios);

    // Verificar si hay resultados
    if ($result_accesorios) {
        $accesorios = mysqli_fetch_assoc($result_accesorios);
        $accesorios_desactivados = empty($accesorios); // Desactivar si no hay accesorios
    } else {
        echo "Error en la consulta de accesorios: " . mysqli_error($conexion);
    }
} else {
    echo "No se encontraron idDetOrdAterra.";
}

// Suponiendo que $id_orden está definido
$query_estuches = "SELECT `idOrdAterra`, `TipoAterra`, `EstChico`, `EstGrande`, `EstMetalico`, `EstPertiga` FROM `ordaterra` WHERE idOrdAterra = '$id_orden' ORDER BY idOrdAterra DESC LIMIT 1";
$result_estuches = mysqli_query($conexion, $query_estuches);

if ($result_estuches && mysqli_num_rows($result_estuches) > 0) {
    $estuches = mysqli_fetch_assoc($result_estuches);
    $aterra = $estuches['TipoAterra'];
} else {
    // Manejo de errores si no se encuentran datos
    $estuches = [];
    $aterra = ''; // Asignar un valor predeterminado si no hay datos
}

// Variables para desactivar campos
$desactivar_campos = [
    'serie' => empty($data['Serie']),
    'mLinea' => empty($data['MLinea']),
    'longitudA' => empty($data['LongitudA']),
    'seccionA' => empty($data['SeccionA']),
    'mTierra' => empty($data['MTierra']),
    'longitudB' => empty($data['LongitudB']),
    'seccionB' => empty($data['SeccionB']),
    'tLinea' => empty($data['TLinea']),
    'longitudX' => empty($data['LongitudX']),
    'seccionX' => empty($data['SeccionX']),
    'terminalX' => empty($data['TerminalX']),
    'tTierra' => empty($data['TTierra']),
    'fechaSolicitud' => empty($data['FechaSolicitud']),
    'pertiga' => empty($accesorios['Pertiga']),
    'varilla' => empty($accesorios['Varilla']),
    'adaptador' => empty($accesorios['Adaptador']),
    'otros' => empty($accesorios['Otros']),
    'trifurcacion' => empty($accesorios['Trifurcacion']),
    'estChico' => empty($estuches['EstChico']),
    'estGrande' => empty($estuches['EstGrande']),
    'estMetalico' => empty($estuches['EstMetalico']),
    'estPertiga' => empty($estuches['EstPertiga'])
];

// Cerrar la conexión
$conexion->close();
?>

<?php
// Conecta a tu base de datos (debes modificar esto según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_dielectricos2";


// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
<style>
    .custom-nav-item {
        width: 150px;
        /* Adjust the width as needed */
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
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 ">

                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-sm btn-primary" href="orden.php?idOrdAterra=<?php echo htmlspecialchars($id_orden); ?>">
                                Atras
                            </a>

                        </div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ORDEN N°:<?php echo htmlspecialchars($id_orden); ?></h6>
                        </div>
                    </div>
                    <form action="actualizar.php" method="post">
                        <!-- Configuracion del Aterramiento -->
                        <div class="row">
                            <div class="row">
                                <label for="">Configuracion del Aterramiento</label>
                                <div class="col-12">
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="<?php echo $id_orden; ?>">
                            <div class="row">
                                <div class="col-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Mordaza de Linea</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="MLineaphp" value="" <?php echo $desactivar_campos['mLinea'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="RC600-2282" <?php if ($data['MLinea'] == 'RC600-2282') echo 'selected'; ?>>RC600-2282</option>
                                            <option value="RC600-0965" <?php if ($data['MLinea'] == 'RC600-0965') echo 'selected'; ?>>RC600-0965</option>
                                            <option value="RG3369" <?php if ($data['MLinea'] == 'RG3369') echo 'selected'; ?>>RG3369</option>
                                            <option value="RG3403" <?php if ($data['MLinea'] == 'RG3403') echo 'selected'; ?>>RG3403</option>
                                            <option value="RG3622-1" <?php if ($data['MLinea'] == 'RG3622-1') echo 'selected'; ?>>RG3622-1</option>
                                            <option value="RC600-2300 MORDAZA CONCHA-BOLA" <?php if ($data['MLinea'] == 'RC600-2300 MORDAZA CONCHA-BOLA') echo 'selected'; ?>>RC600-2300 MORDAZA CONCHA-BOLA</option>
                                            <option value="ATR13628-1 (Enganche Automatico)" <?php if ($data['MLinea'] == 'ATR13628-1 (Enganche Automatico)') echo 'selected'; ?>>ATR13628-1 (Enganche Automatico)</option>
                                            <option value="161GP Set de Bushing y Cable elastimold" <?php if ($data['MLinea'] == '161GP Set de Bushing y Cable elastimold') echo 'selected'; ?>>161GP Set de Bushing y Cable elastimold</option>
                                            <option value="272GP Set de Bushing y Cable elastimold" <?php if ($data['MLinea'] == '272GP Set de Bushing y Cable elastimold') echo 'selected'; ?>>272GP Set de Bushing y Cable elastimold</option>
                                            <option value="RG3368" <?php if ($data['MLinea'] == 'RG3368') echo 'selected'; ?>>RG3368</option>
                                            <option value="RG3363-1" <?php if ($data['MLinea'] == 'RG3363-1') echo 'selected'; ?>>RG3363-1</option>
                                            <option value="RG3403T" <?php if ($data['MLinea'] == 'RG3403T') echo 'selected'; ?>>RG3403T</option>
                                            <option value="ATR11627-2" <?php if ($data['MLinea'] == 'ATR11627-2') echo 'selected'; ?>>ATR11627-2</option>
                                            <option value="RC600-0065" <?php if ($data['MLinea'] == 'RC600-0065') echo 'selected'; ?>>RC600-0065</option>
                                            <option value="RG3367-1" <?php if ($data['MLinea'] == 'RG3367-1') echo 'selected'; ?>>RG3367-1</option>
                                            <option value="ATR08969-3" <?php if ($data['MLinea'] == 'ATR08969-3') echo 'selected'; ?>>ATR08969-3</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud A</span>
                                        <input type="number" min="1" step="0.1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="LongitudAphp" value="<?php echo htmlspecialchars($data['LongitudA']); ?>" <?php echo $desactivar_campos['longitudA'] ? 'disabled' : ''; ?>>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion A</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="SeccionAphp" value="" <?php echo $desactivar_campos['seccionA'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="25" <?php if ($data['SeccionA'] == '25') echo 'selected'; ?>>25</option>
                                            <option value="35" <?php if ($data['SeccionA'] == '35') echo 'selected'; ?>>35</option>
                                            <option value="50" <?php if ($data['SeccionA'] == '50') echo 'selected'; ?>>50</option>
                                            <option value="70" <?php if ($data['SeccionA'] == '70') echo 'selected'; ?>>70</option>
                                            <option value="95" <?php if ($data['SeccionA'] == '95') echo 'selected'; ?>>95</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Terminal de Linea</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="TLineaphp" value="" <?php echo $desactivar_campos['tLinea'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="MTA35-C" <?php if ($data['TLinea'] == 'MTA35-C') echo 'selected'; ?>>MTA35-C</option>
                                            <option value="MTA50-C" <?php if ($data['TLinea'] == 'MTA50-C') echo 'selected'; ?>>MTA50-C</option>
                                            <option value="MTA70-C" <?php if ($data['TLinea'] == 'MTA70-C') echo 'selected'; ?>>MTA70-C</option>
                                            <option value="MTA120-C" <?php if ($data['TLinea'] == 'MTA120-C') echo 'selected'; ?>>MTA120-C</option>
                                            <option value="2A10-M10" <?php if ($data['TLinea'] == '2A10-M10') echo 'selected'; ?>>2A10-M10</option>
                                            <option value="2A14-M10" <?php if ($data['TLinea'] == '2A14-M10') echo 'selected'; ?>>2A14-M10</option>
                                            <option value="2A5-M8" <?php if ($data['TLinea'] == '2A5-M8') echo 'selected'; ?>>2A5-M8</option>
                                            <option value="2A7-M8" <?php if ($data['TLinea'] == '2A7-M8') echo 'selected'; ?>>2A7-M8</option>
                                            <option value="A10-M10" <?php if ($data['TLinea'] == 'A10-M10') echo 'selected'; ?>>A10-M10</option>
                                            <option value="A14-M10" <?php if ($data['TLinea'] == 'A14-M10') echo 'selected'; ?>>A14-M10</option>
                                            <option value="A5-M8" <?php if ($data['TLinea'] == 'A5-M8') echo 'selected'; ?>>A5-M8</option>
                                            <option value="A7-M8" <?php if ($data['TLinea'] == 'A7-M8') echo 'selected'; ?>>A7-M8</option>
                                            <option value="2710110" <?php if ($data['TLinea'] == '2710110') echo 'selected'; ?>>2710110</option>
                                            <option value="NAC_EXT" <?php if ($data['TLinea'] == 'NAC_EXT') echo 'selected'; ?>>NAC_EXT</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud X</span>
                                        <input type="number" min="1" step="0.1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="LongitudXphp" value="<?php echo htmlspecialchars($data['LongitudX']); ?>" <?php echo $desactivar_campos['longitudX'] ? 'disabled' : ''; ?>>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion X</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="SeccionXphp" value="" <?php echo $desactivar_campos['seccionX'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="25" <?php if ($data['SeccionX'] == '25') echo 'selected'; ?>>25</option>
                                            <option value="35" <?php if ($data['SeccionX'] == '35') echo 'selected'; ?>>35</option>
                                            <option value="50" <?php if ($data['SeccionX'] == '50') echo 'selected'; ?>>50</option>
                                            <option value="70" <?php if ($data['SeccionX'] == '70') echo 'selected'; ?>>70</option>
                                            <option value="95" <?php if ($data['SeccionX'] == '95') echo 'selected'; ?>>95</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Terminal de X</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="TerminalXphp" value="" <?php echo $desactivar_campos['terminalX'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="MTA35-C" <?php if ($data['TerminalX'] == 'MTA35-C') echo 'selected'; ?>>MTA35-C</option>
                                            <option value="MTA50-C" <?php if ($data['TerminalX'] == 'MTA50-C') echo 'selected'; ?>>MTA50-C</option>
                                            <option value="MTA70-C" <?php if ($data['TerminalX'] == 'MTA70-C') echo 'selected'; ?>>MTA70-C</option>
                                            <option value="MTA120-C" <?php if ($data['TerminalX'] == 'MTA120-C') echo 'selected'; ?>>MTA120-C</option>
                                            <option value="2A10-M10" <?php if ($data['TerminalX'] == '2A10-M10') echo 'selected'; ?>>2A10-M10</option>
                                            <option value="2A14-M10" <?php if ($data['TerminalX'] == '2A14-M10') echo 'selected'; ?>>2A14-M10</option>
                                            <option value="2A5-M8" <?php if ($data['TerminalX'] == '2A5-M8') echo 'selected'; ?>>2A5-M8</option>
                                            <option value="2A7-M8" <?php if ($data['TerminalX'] == '2A7-M8') echo 'selected'; ?>>2A7-M8</option>
                                            <option value="A10-M10" <?php if ($data['TerminalX'] == 'A10-M10') echo 'selected'; ?>>A10-M10</option>
                                            <option value="A14-M10" <?php if ($data['TerminalX'] == 'A14-M10') echo 'selected'; ?>>A14-M10</option>
                                            <option value="A5-M8" <?php if ($data['TerminalX'] == 'A5-M8') echo 'selected'; ?>>A5-M8</option>
                                            <option value="A7-M8" <?php if ($data['TerminalX'] == 'A7-M8') echo 'selected'; ?>>A7-M8</option>
                                            <option value="2710110" <?php if ($data['TerminalX'] == '2710110') echo 'selected'; ?>>2710110</option>
                                            <option value="NAC_EXT" <?php if ($data['TerminalX'] == 'NAC_EXT') echo 'selected'; ?>>NAC_EXT</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Mordaza de Tierra</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="MTierraphp" value="" <?php echo $desactivar_campos['mTierra'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="ATR11627-2" <?php if ($data['MTierra'] == 'ATR11627-2') echo 'selected'; ?>>ATR11627-2</option>
                                            <option value="RG3403T" <?php if ($data['MTierra'] == 'RG3403T') echo 'selected'; ?>>RG3403T</option>
                                            <option value="RG3363-1" <?php if ($data['MTierra'] == 'RG3363-1') echo 'selected'; ?>>RG3363-1</option>
                                            <option value="ATR03641-1 Carretel" <?php if ($data['MTierra'] == 'ATR03641-1 Carretel') echo 'selected'; ?>>ATR03641-1 Carretel</option>
                                            <option value="RG3363-4SJ" <?php if ($data['MTierra'] == 'RG3363-4SJ') echo 'selected'; ?>>RG3363-4SJ</option>
                                            <option value="N3B8 FAMECA" <?php if ($data['MTierra'] == 'N3B8 FAMECA') echo 'selected'; ?>>N3B8 FAMECA</option>
                                            <option value="RC600-0085" <?php if ($data['MTierra'] == 'RC600-0085') echo 'selected'; ?>>RC600-0085</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Longitud B</span>
                                        <input type="number" min="1" step="0.01" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="LongitudBphp" value="<?php echo htmlspecialchars($data['LongitudB']); ?>" <?php echo $desactivar_campos['longitudB'] ? 'disabled' : ''; ?>>
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Seccion B</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="SeccionBphp" value="" <?php echo $desactivar_campos['seccionB'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="25" <?php if ($data['SeccionB'] == '25') echo 'selected'; ?>>25</option>
                                            <option value="35" <?php if ($data['SeccionB'] == '35') echo 'selected'; ?>>35</option>
                                            <option value="50" <?php if ($data['SeccionB'] == '50') echo 'selected'; ?>>50</option>
                                            <option value="70" <?php if ($data['SeccionB'] == '70') echo 'selected'; ?>>70</option>
                                            <option value="95" <?php if ($data['SeccionB'] == '95') echo 'selected'; ?>>95</option>
                                        </select>
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Terminal de Tierra</span>
                                        <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="TTierraphp" value="" <?php echo $desactivar_campos['tTierra'] ? 'disabled' : ''; ?>>
                                            <option value=""></option>
                                            <option value="MTA35-C" <?php if ($data['TTierra'] == 'MTA35-C') echo 'selected'; ?>>MTA35-C</option>
                                            <option value="MTA50-C" <?php if ($data['TTierra'] == 'MTA50-C') echo 'selected'; ?>>MTA50-C</option>
                                            <option value="MTA70-C" <?php if ($data['TTierra'] == 'MTA70-C') echo 'selected'; ?>>MTA70-C</option>
                                            <option value="MTA120-C" <?php if ($data['TTierra'] == 'MTA120-C') echo 'selected'; ?>>MTA120-C</option>
                                            <option value="2A10-M10" <?php if ($data['TTierra'] == '2A10-M10') echo 'selected'; ?>>2A10-M10</option>
                                            <option value="2A14-M10" <?php if ($data['TTierra'] == '2A14-M10') echo 'selected'; ?>>2A14-M10</option>
                                            <option value="2A5-M8" <?php if ($data['TTierra'] == '2A5-M8') echo 'selected'; ?>>2A5-M8</option>
                                            <option value="2A7-M8" <?php if ($data['TTierra'] == '2A7-M8') echo 'selected'; ?>>2A7-M8</option>
                                            <option value="A10-M10" <?php if ($data['TTierra'] == 'A10-M10') echo 'selected'; ?>>A10-M10</option>
                                            <option value="A14-M10" <?php if ($data['TTierra'] == 'A14-M10') echo 'selected'; ?>>A14-M10</option>
                                            <option value="A5-M8" <?php if ($data['TTierra'] == 'A5-M8') echo 'selected'; ?>>A5-M8</option>
                                            <option value="A7-M8" <?php if ($data['TTierra'] == 'A7-M8') echo 'selected'; ?>>A7-M8</option>
                                            <option value="2710110" <?php if ($data['TTierra'] == '2710110') echo 'selected'; ?>>2710110</option>
                                            <option value="NAC_EXT" <?php if ($data['TTierra'] == 'NAC_EXT') echo 'selected'; ?>>NAC_EXT</option>
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
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Pertigaphp" value="">
                                                    <option value=""></option>
                                                    <option value="RC600-0434" <?php if ($accesorios['Pertiga'] == 'RC600-0434') echo 'selected'; ?>>RC600-0434</option>
                                                    <option value="RH1760-1" <?php if ($accesorios['Pertiga'] == 'RH1760-1') echo 'selected'; ?>>RH1760-1</option>
                                                    <option value="RG3363-1" <?php if ($accesorios['Pertiga'] == 'RG3363-1') echo 'selected'; ?>>RG3363-1</option>
                                                    <option value="VMR-15" <?php if ($accesorios['Pertiga'] == 'VMR-15') echo 'selected'; ?>>VMR-15</option>
                                                    <option value="VMR-30" <?php if ($accesorios['Pertiga'] == 'VMR-30') echo 'selected'; ?>>VMR-30</option>
                                                    <option value="VMR-45" <?php if ($accesorios['Pertiga'] == 'VMR-45') echo 'selected'; ?>>VMR-45</option>
                                                    <option value="VMR-70" <?php if ($accesorios['Pertiga'] == 'VMR-70') echo 'selected'; ?>>VMR-70</option>
                                                    <option value="VMR-90" <?php if ($accesorios['Pertiga'] == 'VMR-90') echo 'selected'; ?>>VMR-90</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Adaptador</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Adaptadorphp" value="">
                                                    <option value=""></option>
                                                    <option value="RG3368" <?php if ($accesorios['Adaptador'] == 'RG3368') echo 'selected'; ?>>RG3368</option>
                                                    <option value="ATR14442-1 Plato Portapinzas (Dst-7)" <?php if ($accesorios['Adaptador'] == 'ATR14442-1 Plato Portapinzas (Dst-7)') echo 'selected'; ?>>ATR14442-1 Plato Portapinzas (Dst-7)</option>
                                                    <option value="VMR07205-1 Adaptador para maniobrar" <?php if ($accesorios['Adaptador'] == 'VMR07205-1 Adaptador para maniobrar') echo 'selected'; ?>>VMR07205-1 Adaptador para maniobrar</option>
                                                    <option value="RM4455-29B Adaptador para maniobrar" <?php if ($accesorios['Adaptador'] == 'RM4455-29B Adaptador para maniobrar') echo 'selected'; ?>>RM4455-29B Adaptador para maniobrar</option>
                                                    <option value="FLV-3585 Pino Bola" <?php if ($accesorios['Adaptador'] == 'FLV-3585 Pino Bola') echo 'selected'; ?>>FLV-3585 Pino Bola</option>
                                                    <option value="ATR08969-1 Mordaza Pino Bola" <?php if ($accesorios['Adaptador'] == 'ATR08969-1 Mordaza Pino Bola') echo 'selected'; ?>>ATR08969-1 Mordaza Pino Bola</option>
                                                    <option value="RM4455-78 Extractor de fusibles" <?php if ($accesorios['Adaptador'] == 'RM4455-78 Extractor de fusibles') echo 'selected'; ?>>RM4455-78 Extractor de fusibles</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Varilla</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Varillaphp" value="">
                                                    <option value=""></option>
                                                    <option value="Var 5/8" <?php if ($accesorios['Varilla'] == 'Var 5/8') echo 'selected'; ?>>Var 5/8</option>
                                                </select>
                                            </div>
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Trifurcacion</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Trifurcacionphp" value="">
                                                    <option value=""></option>
                                                    <option value="RG4754-1 Pulpo" <?php if ($accesorios['Trifurcacion'] == 'RG4754-1 Pulpo') echo 'selected'; ?>>RG4754-1 Pulpo</option>
                                                    <option value="ATR04116-1 Trapecio" <?php if ($accesorios['Trifurcacion'] == 'ATR04116-1 Trapecio') echo 'selected'; ?>>ATR04116-1 Trapecio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="input-group input-group-sm mb-3">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">Otros</span>
                                                <select class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="Otrosphp" value="">
                                                    <option></option>
                                                    <option value="RG3625 Soporte de suspension" <?php if ($accesorios['Otros'] == 'RG3625 Soporte de suspension') echo 'selected'; ?>>RG3625 Soporte de suspension</option>
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
                                        <input type="number" min="1" step="1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstChico" value="<?php echo htmlspecialchars($estuches['EstChico']); ?>">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Grande</span>
                                        <input type="number" min="1" step="1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstGrande" value="<?php echo htmlspecialchars($estuches['EstGrande']); ?>">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Metalico</span>
                                        <input type="number" min="1" step="1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstMetalico" value="<?php echo htmlspecialchars($estuches['EstMetalico']); ?>">
                                    </div>
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Estuche Pertigas</span>
                                        <input type="number" min="1" step="1" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="EstPertiga" value="<?php echo htmlspecialchars($estuches['EstPertiga']); ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card shadow mb-3">
                                        <div class="card-header py-3 ">
                                            <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                            <a class="btn btn-sm btn-danger" href="orden.php?idOrdAterra=<?php echo $id_orden ?>"> Cancelar</a>
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
</body>

</html>