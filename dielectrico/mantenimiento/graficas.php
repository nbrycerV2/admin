<?php
include("conexion.php");

// Obtén el año seleccionado (si existe)
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Consulta SQL para obtener los datos de la tabla
$sql = "SELECT MONTH(fecha) AS mes, equipo, COUNT(*) AS cantidad FROM orden_item_m WHERE YEAR(fecha) = $selectedYear GROUP BY MONTH(fecha), equipo ";
$result = $conexion->query($sql);

// Inicializar arrays para los datos de cada equipo
$equipos = array();
$datosPorEquipo = array();

while ($row = $result->fetch_assoc()) {
    $mes = intval($row["mes"]);
    $equipo = $row["equipo"];
    $cantidad = intval($row["cantidad"]);

    if (!isset($datosPorEquipo[$equipo])) {
        $datosPorEquipo[$equipo] = array_fill(1, 12, 0);
        $equipos[] = $equipo;
        $totalesPorEquipo[$equipo] = 0;
    }

    $datosPorEquipo[$equipo][$mes] = $cantidad;
    $totalesPorEquipo[$equipo] += $cantidad;
}

// Consulta SQL para obtener los datos del pie chart
function countItemsByClassAndYear($conexion, $selectedYear, $equipo)
{

    // Consulta para contar los items por clase "Guantes" y año específico
    $sql = "SELECT clase, COUNT(*) AS count_items FROM orden_item_m WHERE equipo = $equipo AND YEAR(fecha) = $selectedYear GROUP BY clase";

    $result = $conexion->query($sql);

    $output = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clase = $row["clase"];
            $count = $row["count_items"];

            $output .= "<tr>
                            <td>$clase</td>
                            <td>$count</td>
                        </tr>";
        }
    }

    return $output;
}
// Consulta SQL para obtener los datos del pie chart
function countItemsByClientAndYear($conexion, $selectedYear, $equipo)
{

    // Consulta para contar los items por clase "Guantes" y año específico
    $sql = "SELECT empresa, COUNT(*) AS count_items FROM orden_item_m WHERE equipo = $equipo AND YEAR(fecha) = $selectedYear GROUP BY empresa ORDER BY count_items DESC";

    $result = $conexion->query($sql);

    $output = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clase = $row["empresa"];
            $count = $row["count_items"];

            $output .= "<tr>
                            <td>$clase</td>
                            <td>$count</td>
                        </tr>";
        }
    }

    return $output;
}

function countItemsByMarcaAndYear($conexion, $selectedYear, $equipo)
{

    // Consulta para contar los items por clase "Guantes" y año específico
    $sql = "SELECT marca, COUNT(*) AS count_items FROM orden_item_m WHERE equipo = $equipo AND YEAR(fecha) = $selectedYear GROUP BY marca";

    $result = $conexion->query($sql);

    $output = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $clase = $row["marca"];
            $count = $row["count_items"];

            $output .= "<tr>
                            <td>$clase</td>
                            <td>$count</td>
                        </tr>";
        }
    }

    return $output;
}

// Consulta SQL para obtener los datos
$query = "SELECT equipo, clase, COUNT(*) as cantidad FROM orden_item_m WHERE YEAR(fecha) = $selectedYear GROUP BY equipo, clase";

$resultado = mysqli_query($conexion, $query);

// Procesar los datos y generar un array para el gráfico
$data = [];
while ($row = mysqli_fetch_assoc($resultado)) {
    $data[$row['equipo']][] = ['clase' => $row['clase'], 'cantidad' => $row['cantidad']];
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
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <h1 class="h3 mb-0 text-gray-800">Graficas de Dielectricos Mantenimiento</h1>
                </nav>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Atras</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="graficas.php">Dashboard Tablas</a>
                        </li>

                    </ul>
                    <br>

                    <div class="input-group mb-3">
                        <label class="input-group-text" for="yearSelect">Seleccione el Año</label>
                        <form>
                            <select class="form-select" id="yearSelect" onchange="onChangeYear()">
                                <?php
                                // Obtén el año actual
                                $currentYear = date('Y');

                                // Definir el año inicial y el año final
                                $startYear = 2015;
                                $endYear = ($currentYear < $startYear) ? $startYear : $currentYear;

                                // Obtén el año seleccionado (si existe)
                                $selectedYear = isset($_GET['year']) ? $_GET['year'] : $currentYear;

                                // Generar las opciones del menú desplegable
                                for ($year = $startYear; $year <= $endYear; $year++) {
                                    $selected = ($year == $selectedYear) ? 'selected' : '';
                                    echo "<option value='$year' $selected>$year</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                    <?php
                    // Verificar si se ha seleccionado un año
                    if (isset($_GET['year'])) {
                        $selectedYear = $_GET['year'];
                        // Realizar acciones con el año seleccionado
                        echo "Año seleccionado: $selectedYear";
                    }
                    ?>
                    <div class="row">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 table-responsive">
                                <table class="table align-middle table-sm mi-tabla table-striped-columns">
                                    <thead>
                                        <tr>
                                            <th>Equipo/Mes</th>
                                            <th>Enero</th>
                                            <th>Febrero</th>
                                            <th>Marzo</th>
                                            <th>Abril</th>
                                            <th>Mayo</th>
                                            <th>Junio</th>
                                            <th>Julio</th>
                                            <th>Agosto</th>
                                            <th>Setiembre</th>
                                            <th>Octubre</th>
                                            <th>Noviembre</th>
                                            <th>Diciembre</th>
                                            <th>Total</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($equipos as $equipo) : ?>
                                            <tr>
                                                <td><?php echo $equipo; ?></td>
                                                <?php foreach ($datosPorEquipo[$equipo] as $cantidad) : ?>
                                                    <td><?php echo $cantidad; ?></td>
                                                <?php endforeach; ?>
                                                <td><?php echo $totalesPorEquipo[$equipo]; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseCardtabla" class="d-block card-header py-3" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                <h6 class="m-0 font-weight-bold text-primary">Resumen en Tablas</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" id="collapseCardtabla">
                                <div class="card-body">
                                    <div class="row">
                                        <h5>Tabla Por Clases</h5>
                                        <div class="col">Guantes
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Clase</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $output1 = countItemsByClassAndYear($conexion, $selectedYear, "'Guantes'");
                                                    echo $output1;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col">Mantas
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Clase</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $output2 = countItemsByClassAndYear($conexion, $selectedYear, "'Mantas'");
                                                    echo $output2;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col">Banquetas
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Clase</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $output3 = countItemsByClassAndYear($conexion, $selectedYear, "'Banquetas'");
                                                    echo $output3;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col">Pertigas
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Clase</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $output4 = countItemsByClassAndYear($conexion, $selectedYear, "'Pertigas'");
                                                    echo $output4;
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h5>Tabla Por Empresa</h5>
                                        <div class="col">Guantes
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output5 = countItemsByClientAndYear($conexion, $selectedYear, "'Guantes'");
                                                echo $output5;
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col">Mantas
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output6 = countItemsByClientAndYear($conexion, $selectedYear, "'Mantas'");
                                                echo $output6;
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col">Banquetas
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output7 = countItemsByClientAndYear($conexion, $selectedYear, "'Banquetas'");
                                                echo $output7;
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col">Pertigas
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Empresa</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output8 = countItemsByClientAndYear($conexion, $selectedYear, "'Pertigas'");
                                                echo $output8;
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h5>Tabla Por Marca</h5>
                                        <div class="col">Guantes
                                            <table class="table table-bordered table-sm mi-tabla">
                                                <thead>
                                                    <tr>
                                                        <th>Marca</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output5 = countItemsByMarcaAndYear($conexion, $selectedYear, "'Guantes'");
                                                echo $output5;
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col">Mantas
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Marca</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output5 = countItemsByMarcaAndYear($conexion, $selectedYear, "'Mantas'");
                                                echo $output5;
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col">Banquetas
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Marca</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output5 = countItemsByMarcaAndYear($conexion, $selectedYear, "'Banquetas'");
                                                echo $output5;
                                                ?>
                                            </table>
                                        </div>
                                        <div class="col">Pertigas
                                            <table class="table table-bordered table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Marca</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $output5 = countItemsByMarcaAndYear($conexion, $selectedYear, "'Pertigas'");
                                                echo $output5;
                                                ?>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseCardgrafica" class="d-block card-header py-3" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                <h6 class="m-0 font-weight-bold text-primary">Resumen en Graficas</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" id="collapseCardgrafica">
                                <div class="card-body">
                                    <div>
                                        <canvas id="myChart"></canvas>

                                    </div>
                                    <div>
                                        <canvas id="myPieChart"></canvas>
                                    </div>
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

    <script>
        function onChangeYear() {
            var selectedYear = document.getElementById("yearSelect").value;
            var url = window.location.href.split("?")[0]; // Obtener la URL actual sin parámetros
            window.location.href = url + "?year=" + selectedYear; // Redireccionar con el año seleccionado
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/r-2.5.0/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                datasets: [
                    <?php foreach ($equipos as $equipo) : ?> {
                            label: '<?php echo $equipo; ?>',
                            data: [<?php echo implode(", ", $datosPorEquipo[$equipo]); ?>]

                        },
                    <?php endforeach; ?>
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Totales de Equipos por mes'
                    }
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('myPieChart').getContext('2d');

        var data = <?php echo json_encode($data); ?>;

        var datasets = [];
        var labels = [];

        for (var equipo in data) {
            var claseData = data[equipo];
            var cantidadPorEquipo = claseData.reduce(function(total, current) {
                return total + current.cantidad;
            }, 0);


            datasets.push({
                data: claseData.map(item => item.cantidad),
                backgroundColor: colores,
            });

            labels.push(`${equipo} (${cantidadPorEquipo})`);
        }

        var config = {
            type: 'pie',
            data: {
                datasets: datasets,
                labels: labels
            },
            options: {
                responsive: true,
            }
        };

        new Chart(ctx, config);
    </script>
</body>

</html>