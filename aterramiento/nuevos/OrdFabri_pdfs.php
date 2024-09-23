<?php
require '../../vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

// Conexión a la base de datos
include("conexion.php");

$id_orden = $_GET['id_orden'];

// Escapar el $id_orden para evitar inyecciones SQL
$id_orden_escaped = $conexion->real_escape_string($id_orden);

// Consulta para obtener los detalles de la orden de ordaterra
$query_order_details = "SELECT idOrdAterra, Cliente, Ruc, Cantidad, Vendedor, TipoAterra, Estado, EstChico, EstGrande, EstMetalico, EstPertiga, FechaSolicitud, FechaEntrega, FechaInforme FROM ordaterra WHERE idOrdAterra = '$id_orden_escaped'";
$result_order_details = $conexion->query($query_order_details);
$order_details = $result_order_details->fetch_assoc();

$cliente = $order_details['Cliente'];

$TipoAterra = htmlspecialchars($order_details['TipoAterra']);

// Suponiendo que has obtenido la Cantidad de la consulta inicial
$cantidad = htmlspecialchars($order_details['Cantidad']);

// Determinar el tipo de informe y la imagen correspondiente
$informe_type = 'Desconocido';
$image_path = '';

switch ($order_details['TipoAterra']) {
    case 'ENA':
        $informe_type = 'Enganche Automático';
        $image_path = 'imagenes/ENA.jpg';
        break;
    case 'EXT':
        $informe_type = 'Extensión';
        $image_path = 'imagenes/EXT.jpg';
        break;
    case 'JUM':
        $informe_type = 'Jumper Equipotencial';
        $image_path = 'imagenes/JUM.jpg';
        break;
    case 'PDE':
        $informe_type = 'Pértiga de descarga';
        $image_path = 'imagenes/PDE.jpg';
        break;
    case 'P03':
        $informe_type = 'Pulpo';
        $image_path = 'imagenes/P03.jpg';
        break;
    case 'PEL':
        $informe_type = 'Pulpo con Elastimold';
        $image_path = 'imagenes/PEL.jpg';
        break;
    case 'TRA':
        $informe_type = 'Trapecio';
        $image_path = 'imagenes/TRA.jpg';
        break;
    case 'TPF':
        $informe_type = 'Trapecio con Pértiga Fija';
        $image_path = 'imagenes/TPF.jpg';
        break;
    case 'U01':
        $informe_type = 'Unipolar (1 Tiras)';
        $image_path = 'imagenes/U01.jpg';
        break;
    case 'U03':
        $informe_type = 'Unipolar (3 Tiras)';
        $image_path = 'imagenes/U03.jpg';
        break;
    case 'UPF':
        $informe_type = 'Unipolar con Pértiga Fija';
        $image_path = 'imagenes/UPF.jpg';
        break;
    case 'USA':
        $informe_type = 'Unipolar Con Seguridad Aumentada';
        $image_path = 'imagenes/USA.jpg';
        break;
    case 'UMT':
        $informe_type = 'Unipolar Para Líneas de Media Tensión';
        $image_path = 'imagenes/UMT.jpg';
        break;
    case 'UPV':
        $informe_type = 'Unipolar para Vehículo';
        $image_path = 'imagenes/UPV.jpg';
        break;
    default:
        $informe_type = 'Desconocido';
        break;
}

// Obtener ids de la primera consulta
$query = "SELECT idDetOrdAterra FROM det_ord_aterra WHERE idOrdAterra = '$id_orden_escaped'";
$result = mysqli_query($conexion, $query);

$ids = [];
while ($row = mysqli_fetch_assoc($result)) {
    $ids[] = $row['idDetOrdAterra'];
}

// Verificar si hay ids
$accesorios_desactivados = true; // Por defecto, desactiva accesorios
$accesorios = [];
if (count($ids) > 0) {
    // Escapar los ids con mysqli_real_escape_string
    $ids_escapados = array_map(function ($id) use ($conexion) {
        return mysqli_real_escape_string($conexion, $id);
    }, $ids);

    // Convertir el array de ids en una lista separada por comas con comillas simples
    $ids_str = "'" . implode("','", $ids_escapados) . "'";

    // Consulta para obtener accesorios
    $query_accesorios = "SELECT idDetAcc, idDetOrdAterra, Pertiga, Varilla, Adaptador, Otros, Trifurcacion 
                         FROM acc_ord_aterra 
                         WHERE idDetOrdAterra IN ($ids_str) 
                         ORDER BY idDetAcc DESC 
                         LIMIT 1";

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
$query_estuches = "SELECT idOrdAterra, TipoAterra, EstChico, EstGrande, EstMetalico, EstPertiga 
                   FROM ordaterra 
                   WHERE idOrdAterra = '$id_orden_escaped' 
                   ORDER BY idOrdAterra DESC 
                   LIMIT 1";
$result_estuches = mysqli_query($conexion, $query_estuches);

if ($result_estuches && mysqli_num_rows($result_estuches) > 0) {
    $estuches = mysqli_fetch_assoc($result_estuches);
    $aterra = $estuches['TipoAterra'];
} else {
    // Manejo de errores si no se encuentran datos
    $estuches = [];
    $aterra = ''; // Asignar un valor predeterminado si no hay datos
}

// Obtener todos los detalles adicionales del formulario
$query_details = "SELECT idDetOrdAterra, idOrdAterra, MLinea, LongitudA, SeccionA, MTierra, LongitudB, SeccionB, TLinea, LongitudX, SeccionX, TerminalX, TTierra, FechaSolicitud 
                  FROM det_ord_aterra 
                  WHERE idOrdAterra = '$id_orden_escaped' 
                  ORDER BY idDetOrdAterra DESC 
                  LIMIT 1";
$result_details = mysqli_query($conexion, $query_details);
$data_details = mysqli_fetch_assoc($result_details);

// Manejo de datos si la consulta falla
if (!$data_details) {
    die("Error al obtener datos: " . mysqli_error($conexion));
}

// Obtener todas las series asociadas
$query_series = "SELECT Serie FROM det_ord_aterra WHERE idOrdAterra = '$id_orden_escaped'";
$result_series = $conexion->query($query_series);

// Datos detallados
$data_details = [
    'LongitudA' => !empty($data_details['LongitudA']) ? $data_details['LongitudA'] : '',
    'SeccionA' => !empty($data_details['SeccionA']) ? $data_details['SeccionA'] : '',
    'MLinea' => !empty($data_details['MLinea']) ? $data_details['MLinea'] : '',
    'LongitudB' => !empty($data_details['LongitudB']) ? $data_details['LongitudB'] : '',
    'SeccionB' => !empty($data_details['SeccionB']) ? $data_details['SeccionB'] : '',
    'TLinea' => !empty($data_details['TLinea']) ? $data_details['TLinea'] : '',
    'LongitudX' => !empty($data_details['LongitudX']) ? $data_details['LongitudX'] : '',
    'SeccionX' => !empty($data_details['SeccionX']) ? $data_details['SeccionX'] : '',
    'TerminalX' => !empty($data_details['TerminalX']) ? $data_details['TerminalX'] : '',
    'TTierra' => !empty($data_details['TTierra']) ? $data_details['TTierra'] : '',
    'MTierra' => !empty($data_details['MTierra']) ? $data_details['MTierra'] : '',
];

// Accesorios
$accesorios = [
    'Pertiga' => !empty($accesorios['Pertiga']) ? $accesorios['Pertiga'] : '',
    'Varilla' => !empty($accesorios['Varilla']) ? $accesorios['Varilla'] : '',
    'Adaptador' => !empty($accesorios['Adaptador']) ? $accesorios['Adaptador'] : '',
    'Otros' => !empty($accesorios['Otros']) ? $accesorios['Otros'] : '',
    'Trifurcacion' => !empty($accesorios['Trifurcacion']) ? $accesorios['Trifurcacion'] : '',
];

// Estuches
$estuches = [
    'EstChico' => !empty($estuches['EstChico']) ? $estuches['EstChico'] : '',
    'EstGrande' => !empty($estuches['EstGrande']) ? $estuches['EstGrande'] : '',
    'EstMetalico' => !empty($estuches['EstMetalico']) ? $estuches['EstMetalico'] : '',
    'EstPertiga' => !empty($estuches['EstPertiga']) ? $estuches['EstPertiga'] : '',
];


// Crear una instancia de mPDF
$mpdf = new \Mpdf\Mpdf();

$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Fabricaciòn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px; /* Tamaño de fuente general */
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            font-size: 7px; /* Tamaño del encabezado */
            margin-bottom: 10px; /* Ajustar el margen inferior del encabezado */
        }
        .header h1 {
            margin: 0; /* Eliminar margen por defecto */
        }
        .details, .combined-table, .series {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        .details th, .details td, .combined-table th, .combined-table td, .series th, .series td {
            padding: 8px; /* Ajustar padding */
            text-align: left;
            border: 1px solid #ddd; /* Añadir borde para mejor visualización */
        }
        .details th, .combined-table th, .series th {
            background-color: #f2f2f2;
        }
        .details img {
            width: 100px; /* Tamaño de la imagen */
            height: auto;
        }
        .combined-table th, .combined-table td {
            font-size: 12px; /* Tamaño de fuente reducido para la tabla combinada */
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px; /* Tamaño de letra del pie de página */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
    <h1>ORDEN DE FABRICACIÓN DE ATERRAMIENTO TEMPORARIO Nº ' . htmlspecialchars($order_details['idOrdAterra']) . '</h1>
</div>
        <div class="details">
            <h2>Detalles de la Orden</h2>
           <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
    <tr>
        <td style="width: 80%; vertical-align: top;">
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #f2f2f2;">Cliente:</th>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . htmlspecialchars($order_details['Cliente']) . '</td>
                </tr>
                <tr>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #f2f2f2;">Cantidad:</th>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . htmlspecialchars($order_details['Cantidad']) . '</td>
                </tr>
                <tr>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #f2f2f2;">Vendedor:</th>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . htmlspecialchars($order_details['Vendedor']) . '</td>
                </tr>
                <tr>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #f2f2f2;">Tipo de Aterrizaje:</th>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . htmlspecialchars($informe_type) . '</td>
                </tr>
                <tr>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #f2f2f2;">Fecha de Solicitud:</th>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">' . htmlspecialchars($order_details['FechaSolicitud']) . '</td>
                </tr>
            </table>
        </td>
        <td style="width: 20%; vertical-align: top; text-align: center;">
            <div style="height: 100%; display: flex; align-items: center; justify-content: center;">
                <img src="' . $image_path . '" alt="Imagen del Aterrizaje" style="max-width: 80%; max-height: 22%; border: 1px solid #ddd;" />
            </div>
        </td>
    </tr>
</table>
        </div>
        <div class="combined-table">
    <table>
        <!-- Detalles del Aterramiento -->
        <tr>
            <th colspan="2">DETALLES DEL ATERRAMIENTO</th>
            <th colspan="1">UNIDAD</th>
            <th colspan="1" style="text-align: center;">TOTAL / Cantidad</th>
            <th colspan="1">✓</th>
        </tr>';

// Detalles del Aterramiento
if (!empty($data_details['MLinea'])) {
    // Determinar el valor de la Columna Vacía 1
    if (
        $order_details['TipoAterra'] === 'U01' || $order_details['TipoAterra'] === 'PDE'
        || $order_details['TipoAterra'] === 'PEL' || $order_details['TipoAterra'] === 'UPV'
    ) {
        $ValorMLinea = '1';
    } elseif (
        $order_details['TipoAterra'] === 'ENA' || $order_details['TipoAterra'] === 'P03'
        || $order_details['TipoAterra'] === 'TRA' || $order_details['TipoAterra'] === 'U03'
        || $order_details['TipoAterra'] === 'UPF'
    ) {
        $ValorMLinea = '3';
    } elseif ($order_details['TipoAterra'] === 'JUM') {
        $ValorMLinea = '2';
    } elseif ($order_details['TipoAterra'] === 'USA') {
        $ValorMLinea = '7';
    } elseif ($order_details['TipoAterra'] === 'UMT') {
        $ValorMLinea = '5';
    } else {
        $ValorMLinea = '';
    }
    $html .= '
            <tr>
                <th>Mordaza de Línea</th>
                <td>' . htmlspecialchars($data_details['MLinea']) . '</td>
                <td> ' . htmlspecialchars($ValorMLinea) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($ValorMLinea * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
/*if (!empty($data_details['LongitudA'])) {
    $html .= '
            <tr>
                <th>Longitud A</th>
                <td>' . htmlspecialchars($data_details['LongitudA']) . '</td>
                <td></td> <!-- Columna vacía -->
                <td></td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}*/
if (!empty($data_details['SeccionA'])) {
    // Determinar el valor de la Columna Vacía 1
    if (
        $order_details['TipoAterra'] === 'U03' || $order_details['TipoAterra'] === 'P03'
        || $order_details['TipoAterra'] === 'UPF' || $order_details['TipoAterra'] === 'UPV'
    ) {
        $ValorSeccionA = '3';
    } elseif (
        $order_details['TipoAterra'] === 'TRA' || $order_details['TipoAterra'] === 'USA'
        || $order_details['TipoAterra'] === 'UMT'
    ) {
        $ValorSeccionA  = '2';
    } elseif (
        $order_details['TipoAterra'] === 'EXT'
        || $order_details['TipoAterra'] === 'JUM' || $order_details['TipoAterra'] === 'PDE'
        || $order_details['TipoAterra'] === 'PEL' || $order_details['TipoAterra'] === 'U01'
    ) {
        $ValorSeccionA  = '1';
    } elseif (
        $order_details['TipoAterra'] === 'ENA'
    ) {
        $ValorSeccionA  = '2';
    } else {
        $ValorSeccionA = '';
    }
    $html .= '
            <tr>
                <th>Sección A</th>
                <td> Cable ' . htmlspecialchars($data_details['SeccionA']) . '</td>
                <td>' . htmlspecialchars($data_details['LongitudA'] * $ValorSeccionA) . ' metros</td> <!-- Valor Unitario de Longitud A -->
                <td>' . htmlspecialchars(($data_details['LongitudA'] * $cantidad) * $ValorSeccionA) . ' metros</td> <!-- Total * Cantidad -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($data_details['TLinea'])) {
    // Determinar el valor de la Columna Vacía 1
    if ($order_details['TipoAterra'] === 'PDE') {
        $ValorTLinea = '1';
    } elseif ($order_details['TipoAterra'] === 'ENA') {
        $ValorTLinea = '3';
    } elseif ($order_details['TipoAterra'] === 'TRA') {
        $ValorTLinea = '4';
    } elseif (
        $order_details['TipoAterra'] === 'EXT' || $order_details['TipoAterra'] === 'JUM'
        || $order_details['TipoAterra'] === 'U01' || $order_details['TipoAterra'] === 'UPV'
    ) {
        $ValorTLinea = '2';
    } elseif (
        $order_details['TipoAterra'] === 'P03' || $order_details['TipoAterra'] === 'U03'
        || $order_details['TipoAterra'] === 'UPF'
    ) {
        $ValorTLinea = '6';
    } elseif ($order_details['TipoAterra'] === 'USA') {
        $ValorTLinea = '7';
    } elseif ($order_details['TipoAterra'] === 'UMT') {
        $ValorTLinea = '5';
    } else {
        $ValorTLinea = '';
    }
    $html .= '
            <tr>
                <th>Terminal de Línea</th>
                <td>' . htmlspecialchars($data_details['TLinea']) . '</td>
                <td>' . htmlspecialchars($ValorTLinea) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($ValorTLinea * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($data_details['MTierra'])) {
    // Determinar el valor de la Columna Vacía 1
    if ($order_details['TipoAterra'] === 'U01') {
        $ValorMTierra = '1';
    } elseif (
        $order_details['TipoAterra'] === 'ENA' || $order_details['TipoAterra'] === 'PDE'
        || $order_details['TipoAterra'] === 'UPV'
    ) {
        $ValorMTierra = '1';
    } elseif ($order_details['TipoAterra'] === 'JUM' || $order_details['TipoAterra'] === 'PEL') {
        $ValorMTierra = '1';
    } elseif ($order_details['TipoAterra'] === 'PDE' || $order_details['TipoAterra'] === 'TRA') {
        $ValorMTierra = '1';
    } elseif (
        $order_details['TipoAterra'] === 'P03' || $order_details['TipoAterra'] === 'USA'
        || $order_details['TipoAterra'] === 'UMT'
    ) {
        $ValorMTierra = '1';
    } elseif ($order_details['TipoAterra'] === 'U03' || $order_details['TipoAterra'] === 'UPF') {
        $ValorMTierra = '3';
    } else {
        $ValorMTierra = '';
    }
    $html .= '
            <tr>
                <th>Mordaza de Tierra</th>
                <td>' . htmlspecialchars($data_details['MTierra']) . '</td>
                <td>' . htmlspecialchars($ValorMTierra) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($ValorMTierra * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
/*if (!empty($data_details['LongitudB'])) {
    $html .= '
            <tr>
                <th>Longitud B</th>
                <td>' . htmlspecialchars($data_details['LongitudB']) . '</td>
                <td></td> <!-- Columna vacía -->
                <td></td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}*/
if (!empty($data_details['SeccionB'])) {
    $html .= '
            <tr>
                <th>Sección B</th>
                <td>Cable ' . htmlspecialchars($data_details['SeccionB']) . '</td>
                <td>' . htmlspecialchars($data_details['LongitudB']) . ' metros</td> <!-- Valor Unitario de Longitud B -->
                <td>' . htmlspecialchars($data_details['LongitudB'] * $cantidad) . ' metros</td> <!-- Total * Cantidad -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($data_details['TTierra'])) {
    // Determinar el valor de la Columna Vacía 1
    if ($order_details['TipoAterra'] === 'U01') {
        $ValorTTierra = '2';
    } elseif (
        $order_details['TipoAterra'] === 'ENA' || $order_details['TipoAterra'] === 'PDE'
        || $order_details['TipoAterra'] === 'UMT'
    ) {
        $ValorTTierra = '1';
    } elseif (
        $order_details['TipoAterra'] === 'EXT' || $order_details['TipoAterra'] === 'P03'
        || $order_details['TipoAterra'] === 'PEL' || $order_details['TipoAterra'] === 'TRA'
    ) {
        $ValorTTierra = '2';
    } elseif ($order_details['TipoAterra'] === 'JUM' || $order_details['TipoAterra'] === 'USA') {
        $ValorTTierra = '1';
    } elseif ($order_details['TipoAterra'] === 'U03' || $order_details['TipoAterra'] === 'UPF') {
        $ValorTTierra = '6';
    } else {
        $ValorTTierra = '';
    }
    $html .= '
            <tr>
                <th>Terminal de Tierra</th>
                <td>' . htmlspecialchars($data_details['TTierra']) . '</td>
                <td>' . htmlspecialchars($ValorTTierra) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($ValorTTierra * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
/*if (!empty($data_details['LongitudX'])) {
    $html .= '
            <tr>
                <th>Longitud X</th>
                <td>' . htmlspecialchars($data_details['LongitudX']) . '</td>
                <td></td> <!-- Columna vacía -->
                <td></td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}*/
if (!empty($data_details['SeccionX'])) {
    $html .= '
            <tr>
                <th>Sección X</th>
                <td>Cable ' . htmlspecialchars($data_details['SeccionX']) . '</td>
                <td>' . htmlspecialchars($data_details['LongitudX']) . ' metros</td> <!-- Valor Unitario de Longitud X -->
                <td>' . htmlspecialchars($data_details['LongitudX'] * $cantidad) . ' metros</td> <!-- Total * Cantidad -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($data_details['TerminalX'])) {
    // Determinar el valor de la Columna Vacía 1
    if ($order_details['TipoAterra'] === 'ENA') {
        $TerminalX = '1';
    } else {
        $TerminalX = '';
    }
    $html .= '
            <tr>
                <th>Terminal X</th>
                <td>' . htmlspecialchars($data_details['TerminalX']) . '</td>
                <td>' . htmlspecialchars($TerminalX) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($TerminalX * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}

if (!$accesorios_desactivados) {
    // Accesorios
    if (!empty($accesorios['Pertiga'])) {
        // Determinar el valor de la Columna Vacía 1
        if ($order_details['TipoAterra'] === 'U01') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'ENA') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'EXT') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'JUM') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'PDE') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'P03') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'TRA') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'U03') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'UPF') {
            $ValorPertiga = '1';
        } elseif ($order_details['TipoAterra'] === 'UMT') {
            $ValorPertiga = '1';
        } else {
            $ValorPertiga = '';
        }
        // Determinar el valor de la Columna Vacía 1
        if ($order_details['TipoAterra'] === 'U01') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'ENA') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'EXT') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'JUM') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'PDE') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'P03') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'TRA') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'U03') {
            $ValorCantidad = '1';
        } elseif ($order_details['TipoAterra'] === 'UPF') {
            $ValorCantidad = '3';
        } elseif ($order_details['TipoAterra'] === 'UPF') {
            $ValorCantidad = '3';
        } elseif ($order_details['TipoAterra'] === 'UMT') {
            $ValorCantidad = '1';
        } else {
            $ValorCantidad = '';
        }
        $html .= '
                <tr>
                    <th>Pértiga</th>
                    <td>' . htmlspecialchars($accesorios['Pertiga']) . '</td>
                    <td>' . htmlspecialchars($ValorPertiga * $ValorCantidad) . ' </td> <!-- Columna vacía -->
                    <td>' . htmlspecialchars($ValorPertiga * $ValorCantidad * $cantidad) . '</td> <!-- Columna vacía -->
                    <td >□</td> <!-- Columna vacía -->
                </tr>';
    }
    if (!empty($accesorios['Varilla'])) {
        // Determinar el valor de la Columna Vacía 1
        if ($order_details['TipoAterra'] === 'U01') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'ENA') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'EXT') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'JUM') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'PDE') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'P03') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'TRA') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'U03') {
            $ValorVarilla = '1';
        } elseif ($order_details['TipoAterra'] === 'UMT') {
            $ValorVarilla = '1';
        } else {
            $ValorVarilla = '';
        }
        $html .= '
                <tr>
                    <th>Varilla</th>
                    <td>' . htmlspecialchars($accesorios['Varilla']) . '</td>
                    <td>' . htmlspecialchars($ValorVarilla) . ' </td> <!-- Columna vacía -->
                    <td>' . htmlspecialchars($ValorVarilla * $cantidad) . '</td> <!-- Columna vacía -->
                    <td >□</td> <!-- Columna vacía -->
                </tr>';
    }
    if (!empty($accesorios['Adaptador'])) {
        // Determinar el valor de la Columna Vacía 1
        if ($order_details['TipoAterra'] === 'U01') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'ENA') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'EXT') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'JUM') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'PDE') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'P03') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'TRA') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'U03') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'USA') {
            $ValorAdaptador = '1';
        } elseif ($order_details['TipoAterra'] === 'UMT') {
            $ValorAdaptador = '1';
        } else {
            $ValorAdaptador = '';
        }
        $html .= '
                <tr>
                    <th>Adaptador</th>
                    <td>' . htmlspecialchars($accesorios['Adaptador']) . '</td>
                    <td>' . htmlspecialchars($ValorAdaptador) . '</td> <!-- Columna vacía -->
                    <td>' . htmlspecialchars($ValorAdaptador * $cantidad) . '</td> <!-- Columna vacía -->
                    <td >□</td> <!-- Columna vacía -->
                </tr>';
    }
    if (!empty($accesorios['Otros'])) {
        // Determinar el valor de la Columna Vacía 1
        if ($order_details['TipoAterra'] === 'U01') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'ENA') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'EXT') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'JUM') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'PDE') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'P03') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'TRA') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'U03') {
            $ValorOtros = '1';
        } elseif ($order_details['TipoAterra'] === 'UMT') {
            $ValorOtros = '1';
        } else {
            $ValorOtros = '';
        }
        $html .= '
                <tr>
                    <th>Otros</th>
                    <td>' . htmlspecialchars($accesorios['Otros']) . '</td>
                    <td>' . htmlspecialchars($ValorOtros) . '</td> <!-- Columna vacía -->
                    <td>' . htmlspecialchars($ValorOtros * $cantidad) . '</td> <!-- Columna vacía -->
                    <td >□</td> <!-- Columna vacía -->
                </tr>';
    }
    if (!empty($accesorios['Trifurcacion'])) {
        // Determinar el valor de la Columna Vacía 1
        if ($order_details['TipoAterra'] === 'U01') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'ENA' || $order_details['TipoAterra'] === 'PEL') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'EXT') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'JUM') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'PDE') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'P03') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'TRA') {
            $ValorTrifurcacion = '1';
        } elseif ($order_details['TipoAterra'] === 'U03') {
            $ValorTrifurcacion = '1';
        } else {
            $ValorTrifurcacion = '';
        }
        $html .= '
                <tr>
                    <th>Trifurcación</th>
                    <td>' . htmlspecialchars($accesorios['Trifurcacion']) . '</td>
                    <td>' . htmlspecialchars($ValorTrifurcacion) . '</td> <!-- Columna vacía -->
                    <td>' . htmlspecialchars($ValorTrifurcacion * $cantidad) . '</td> <!-- Columna vacía -->
                    <td >□</td> <!-- Columna vacía -->
                </tr>';
    }
}

// Estuches
if (!empty($estuches['EstChico'])) {
    $html .= '
            <tr>
                <th>EstChico</th>
                <td>ESTUCHE ATERRA-02</td>
                <td>' . htmlspecialchars($estuches['EstChico']) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($estuches['EstChico'] * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($estuches['EstGrande'])) {
    $html .= '
            <tr>
                <th>EstGrande</th>
                <td>ESTUCHE ATERRA-01</td>
                <td>' . htmlspecialchars($estuches['EstGrande']) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($estuches['EstGrande'] * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($estuches['EstMetalico'])) {
    $html .= '
            <tr>
                <th>EstMetalico</th>
                <td>ESTUCHE ATERRA-03</td>
                <td>' . htmlspecialchars($estuches['EstMetalico']) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($estuches['EstMetalico'] * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}
if (!empty($estuches['EstPertiga'])) {
    $html .= '
            <tr>
                <th>EstPertiga</th>
                <td>ESTUCHE PERTIGA</td>
                <td>' . htmlspecialchars($estuches['EstPertiga']) . '</td> <!-- Columna vacía -->
                <td>' . htmlspecialchars($estuches['EstPertiga'] * $cantidad) . '</td> <!-- Columna vacía -->
                <td >□</td> <!-- Columna vacía -->
            </tr>';
}

$html .= '
    </table>
</div>';

if ($result_series && mysqli_num_rows($result_series) > 0) {
    $series_list = '';
    $count = 0;

    while ($row = mysqli_fetch_assoc($result_series)) {
        // Agregar una nueva fila después de cada 9 series
        if ($count % 8 == 0 && $count != 0) {
            $series_list .= '</tr><tr>';
        }

        // Agregar el cuadrado al lado de cada serie
        $series_list .= '<td>' . htmlspecialchars($row['Serie']) . ' □</td>';
        $count++;
    }

    // Envolver la lista de series en una tabla con filas divididas
    $html .= '
        <div class="series">
            <h2>Series</h2>
            <table>
                <tr>' . $series_list . '</tr>
            </table>
        </div>';

    // Envolver la lista de series en una tabla con filas divididas
    $html .= '
    <div class="OBSERVADO">
        <h2>Observado:</h2>
       
    </div>';
}


// Escribir el contenido HTML al PDF
$mpdf->WriteHTML($html);
// Enviar el PDF al navegador
$mpdf->Output('Orden_Fabricacion_' . $id_orden . '.pdf', 'D');
