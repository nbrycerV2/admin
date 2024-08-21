<?php
require '../../vendor/autoload.php'; // Ensure this path is correct

// Database connection
include("conexion.php");

$id_orden = $_GET['id_orden'];

// Define paths
$temporaryFolder = 'temp_files/';
$downloadFolder = 'Descargas/';

// Ensure the temporary folder exists
if (!is_dir($temporaryFolder)) {
    mkdir($temporaryFolder, 0777, true);
}

// Escaping the $id_orden to avoid SQL injection
$id_orden_escaped = $conexion->real_escape_string($id_orden);

// Query to get the order details from ordaterra
$query_order_details = "SELECT idOrdAterra, Cliente, Ruc, Cantidad, Vendedor, TipoAterra, Estado, EstChico, EstGrande, EstMetalico, EstPertiga, FechaSolicitud, FechaEntrega, FechaInforme FROM ordaterra WHERE idOrdAterra = '$id_orden_escaped'";
$result_order_details = $conexion->query($query_order_details);
$order_details = $result_order_details->fetch_assoc();

$cliente = $order_details['Cliente'];

// Determine the informe type based on TipoAterra
$informe_type = '';
$image_path = '';

// Set the type and image path based on TipoAterra
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

// Query to get all series associated with the given order ID
$query_series = "SELECT Serie FROM det_ord_aterra WHERE idOrdAterra = '$id_orden_escaped'";
$result_series = $conexion->query($query_series);

// Create a new ZIP archive
$zip = new ZipArchive();
$zipFileName = htmlspecialchars($id_orden) . '_' . rawurlencode($cliente) . '.zip'; // New ZIP file name
$zipFilePath = $temporaryFolder . $zipFileName;

if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
    exit("Cannot open <$zipFilePath>\n");
}

while ($row_series = $result_series->fetch_assoc()) {
    $serie = $row_series['Serie'];

    // Query to get the data for each series
    $query_data = "
        SELECT d.Serie, o.Tramo, o.LongitudTotal, o.CorrienteAplicada, o.ValorMedido, o.MaxPermisible 
        FROM det_ord_aterra d 
        LEFT JOIN ordprueba o ON d.Serie = o.Serie 
        WHERE d.Serie = '$serie'
    ";
    $result_data = $conexion->query($query_data);

    $html = '
<style>
    body {
        font-family: "Nunito", sans-serif;
        line-height: 1.2; /* Reducido el interlineado global */
    }
    .combined-table, .data-table {
        width: 90%; /* Ajusta este valor según tus necesidades */
        margin: 0 auto; /* Centra la tabla horizontalmente */
        border-collapse: collapse; /* Asegura que los bordes se colapsen */
        border: 1px solid black; /* Borde alrededor de la tabla */
    }

    .combined-table td, .data-table th, .data-table td {
        padding: 5px;
    }
    .combined-table tr, .data-table tr {
        border-bottom: 1px solid black; /* Add bottom border to each row */
    }
    .combined-table tr:last-child, .data-table tr:last-child {
        border-bottom: none; /* Remove bottom border from the last row to avoid double border */
    }
    .combined-table img, .data-table img {
        max-width: 80%; /* Ensure the image fits well within the cell */
        height: auto;
    }
    .header-cell {
        vertical-align: middle;
        text-align: center;
    }
    .info-cell, .date-cell {
        border: 1px solid black; /* Add border around these specific cells */
        padding: 5px;
    }
    .info-cell {
        text-align: left;
    }
    .date-cell {
        text-align: right;
    }
    .info-cell {
        border-top: 1px solid black; /* Top border */
        border-bottom: 1px solid black; /* Bottom border */
        border-left: 1px solid black; /* Left border */
        border-right: none; /* No right border */
    }
    .date-cell {
        border-top: 1px solid black; /* Top border */
        border-bottom: 1px solid black; /* Bottom border */
        border-left: none; /* No left border */
        border-right: 1px solid black; /* Right border */
    }
    .equipment-info {
        font-size: 10px;
        margin-top: 5px; /* Reduced space before EQUIPO USADO */
        line-height: 1.2; /* Ensure uniform line spacing */
        padding-left: 0; /* Removed left padding */
        padding-right: 0; /* Removed right padding */
    }
    .equipment-info h3 {
        margin-bottom: 5px; /* Adjust spacing below the header */
    }
    .equipment-info p {
        margin: 5px 0; /* Uniform spacing between paragraphs */
    }
    .data-table {
        width: 87%;
        border-collapse: collapse;
        border: 1px solid black; /* Add border to data table */
        font-size: 10px; /* Reduced font size for the data table */
        margin-top: 5px; /* Reduced margin to align with text */
    }
    .data-table th, .data-table td {
        padding: 5px;
        border: 1px solid black;
    }
    .data-table th {
        background-color: #f2f2f2;
    }
</style>
    <table class="combined-table">
    <tr>
        <td style="width: 30%; vertical-align: middle;">
            <img src="imagenes/LOGYTEC.png" alt="Logytec Logo" style="max-width: 30%; height: auto;"/>
        </td>
        <td class="header-cell" style="width: 50%; font-size: 10px;"> <!-- Reduce font-size -->
            <p><strong>EQUIPOS ELECTRO-ELECTRÓNICOS PARA CAMPO Y LABORATORIO</strong></p>
            <p>Dirección: Isidoro Suarez 236, San Miguel, Lima 32</p>
            <p>Telfs. (511) 452 3111 – (511) 561 0684 – (511) 561 1342</p>
            <p>Telefax: (511) 464 4889</p>
            <p>E-mail: ventas@logytec.com.pe Web: www.logytec.com.pe</p>
        </td>
    </tr>
    <tr>
        <td class="info-cell" style="font-size: 12px;">Nro ' . htmlspecialchars($id_orden) . '</td> <!-- Reduce font-size -->
        <td class="date-cell" style="font-size: 12px;">Fecha: ' . date('Y-m-d', strtotime($order_details['FechaInforme'])) . '</td> <!-- Reduce font-size -->
    </tr>
</table>';
    if ($informe_type !== 'Desconocido') {
        $html .= '<div style="font-size: 10px; line-height: 1.2; margin: 0; padding-left: 40px;">'; // Ajusta el margen y el padding
        $html .= '<br>';
        $html .= '<h2 style="text-align: center; margin: 0;">INFORME TÉCNICO</h2>';
        $html .= '<br>';
        $html .= '<p style="margin: 3px 0;">Informe: Prueba Eléctrica a Conjunto de Aterramiento Temporario ' . htmlspecialchars($informe_type) . '</p>';
        $html .= '<p style="margin: 3px 0;">Marca: RITZ</p>';
        $html .= '<p style="margin: 3px 0;">Código: ' . htmlspecialchars($serie) . '</p> <br>';
        $html .= '</div>'; // Finaliza el ajuste de tamaño de fuente y línea

        // Add EQUIPO USADO section with increased indentation
        $html .= '<div class="equipment-info" style="margin: 0; padding-left: 40px;">'; // Ajusta el margen y el padding
        $html .= '<p style="margin: 5px 0;"><strong>EQUIPO USADO</strong></p>';
        $html .= '<p style="margin: 3px 0;">Nombre: Probador de Aterramientos Temporarios en Corriente Continua.</p>';
        $html .= '<p style="margin: 3px 0;">Marca: Vanguard Instrument Co.</p>';
        $html .= '<p style="margin: 3px 0;">Modelo: SGT-600</p>';
        $html .= '<p style="margin: 3px 0;">Serie: 320003</p> <br>';
        $html .= '<p style="margin: 5px 0;">1.-DIAGRAMA DE DISPOSICIÓN DE LOS PUNTOS DE MEDICIÓN:</p>';

        // Add image based on TipoAterra
        $html .= '<img src="' . htmlspecialchars($image_path) . '" alt="Diagrama de Disposición" style="display: block; margin: 10px auto; max-width: 30%; width: auto;">';

        // Add the new section
        $html .= '<p style="margin: 5px 0;">2. VALORES OBTENIDOS EN LA MEDICIÓN:</p>';
        $html .= '</div>'; // Close class for styling
    }


    // Start the table for data
    $html .= '<table class="data-table">';
    $html .= '<thead><tr>';
    $html .= '<th>Tramo</th><th>Longitud Total (m)</th><th>Sección del Conductor (mm²)</th><th>Corriente Aplicada (A)</th><th>ΔΩ Medido (mΩ)</th><th> ΔΩ Máx Permisible (mΩ)*</th>';
    $html .= '</tr></thead>';
    $html .= '<tbody>';

    // Fill table with data
    while ($row_data = $result_data->fetch_assoc()) {
        $tramos = explode('|', $row_data['Tramo']);
        $longitudes = explode('|', $row_data['LongitudTotal']);
        $corrientes = explode('|', $row_data['CorrienteAplicada']);
        $valores = explode('|', $row_data['ValorMedido']);
        $maximos = explode('|', $row_data['MaxPermisible']);

        for ($i = 0; $i < count($tramos); $i++) {
            $html .= '<tr>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars(trim($tramos[$i] ?? '')) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars(trim($longitudes[$i] ?? '')) . '</td>';

            // Determine the section of the conductor
            $corriente = $corrientes[$i] ?? '';
            $seccionConductor = '';
            switch ($corriente) {
                case '150':
                    $seccionConductor = '25';
                    break;
                case '200':
                    $seccionConductor = '35';
                    break;
                case '250':
                    $seccionConductor = '50';
                    break;
                case '300':
                    $seccionConductor = '70';
                    break;
                case '500':
                    $seccionConductor = '90';
                    break;
                default:
                    $seccionConductor = '';
                    break;
            }
            $html .= '<td style="text-align: center;">' . htmlspecialchars($seccionConductor) . '</td>';

            $html .= '<td style="text-align: center;">' . htmlspecialchars($corriente) . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($valores[$i] ?? '') . '</td>';
            $html .= '<td style="text-align: center;">' . htmlspecialchars($maximos[$i] ?? '') . '</td>';
            $html .= '</tr>';
        }
    }

    $html .= '</tbody></table>';

    // Add additional text after the table
    $html .= '<p style="font-size: 10px; text-align: center; margin-top: 20px;">*Valores de Resistencias Máximas Permisibles según Norma ASTM F2249-03.</p>';
    // Add new content
    $html .= '<p style="font-size: 10px; text-align: left; margin-top: 20px; padding-left: 45px;">CONCLUSIONES:</p>';
    $html .= '<p style="font-size: 10px; text-align: left; padding-left: 45px;">De las mediciones realizadas se concluye que los aterramientos, se encuentran en buen estado de operación debido a que los valores medidos se encuentran dentro del rango máximo permisible de resistencia según Tabla de la Norma ASTM F2249-03.</p>';
    $html .= '<p style="font-size: 10px; text-align: left; margin-top: 20px; padding-left: 45px;">RECOMENDACIONES:</p>';
    $html .= '<p style="font-size: 10px; text-align: left; padding-left: 45px;">Se recomienda hacer una prueba similar por lo menos una vez al año.</p>';
    $html .= '<p style="font-size: 10px; text-align: left; padding-left: 45px;">APROBADO POR:</p>';

    // Añadir tabla para centrar el logo y el texto en la misma línea
    $html .= '<div style="text-align: center; margin-top: 10px;">'; // Contenedor centrado
    $html .= '<table style="margin: 0 auto; border-collapse: collapse; display: inline-block;">';
    $html .= '<tr style="vertical-align: middle; text-align: center;">';
    $html .= '<td style="padding-right: 5px;"><img src="../nuevos/imagenes/LOGO.png" alt="Firma" style="height: 50px;"></td>';
    $html .= '<td style="padding-left: 5px; text-align: left;"><p style="font-size: 10px; margin: 0;">FERNANDEZ ULFEE<br>WILLIANM EDUARDO<br>' . date('Y-m-d', strtotime($order_details['FechaInforme'])) . '</p></td>';
    $html .= '</tr>';
    $html .= '</table>';
    $html .= '</div>';

    // Ajustar espacio y posición del sello
    $html .= '<div style="font-size: 10px; text-align: center; margin-top: 10px; position: relative;">';
    $html .= '<hr style="width: 200px; border: 1px solid black; margin: 5px auto 0 auto;">';
    $html .= '<p style="margin-top: 5px;">Eduardo Fernandez U.<br>Dpto. Calibraciones</p>';
    $html .= '<img src="../nuevos/imagenes/SELLO.png" alt="Sello" style="position: absolute; right: 0; top: 0; height: 50px;">';
    $html .= '</div>';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);

    $pdfFilePath = $temporaryFolder . "Informe_Serie_$serie.pdf";
    $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::FILE);

    // Add the PDF to the ZIP file
    $zip->addFile($pdfFilePath, "Informe_Serie_$serie.pdf");
}

$zip->close();

// Establecer encabezados y devolver el archivo ZIP
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
header('Content-Length: ' . filesize($zipFilePath));
readfile($zipFilePath);

// Limpieza
unlink($zipFilePath);
