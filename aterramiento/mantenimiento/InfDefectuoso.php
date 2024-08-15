<?php
require '../../vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta
include("../nuevos/conexion.php");

$id_orden = $_GET['id_orden']; // Retrieve the id_orden from the URL

// Prepare and execute the SQL query
$query = "SELECT 
    md.IdMantDefectuoso,
    md.IdMantPrueba,
    md.Sintoma,
    md.Diagnostico,
    md.AccionesRealizadas,
    md.Conclusiones, 
    md.FechaInforme,
    mp.Aterramiento, 
    mp.Serie, 
    mp.Marca,
    om.Cliente, 
    om.Ruc 
FROM mantdefectuoso md  
LEFT JOIN mantprueba mp ON md.IdMantPrueba = mp.IdMantPrueba 
LEFT JOIN ordmantenimiento om ON mp.IdOrdMant = om.IdOrdMant 
WHERE md.IdMantPrueba = '$id_orden'";

$result = $conexion->query($query);
$data = $result->fetch_assoc();

// Determine the informe_type based on Aterramiento
switch ($data['Aterramiento']) {
    case 'ENA':
        $informe_type = 'Enganche Automático';
        break;
    case 'EXT':
        $informe_type = 'Extensión';
        break;
    case 'JUM':
        $informe_type = 'Jumper Equipotencial';
        break;
    case 'PDE':
        $informe_type = 'Pértiga de descarga';
        break;
    case 'P03':
        $informe_type = 'Pulpo';
        break;
    case 'PEL':
        $informe_type = 'Pulpo con Elastimold';
        break;
    case 'TRA':
        $informe_type = 'Trapecio';
        break;
    case 'TPF':
        $informe_type = 'Trapecio con Pértiga Fija';
        break;
    case 'U01':
        $informe_type = 'Unipolar (1 Tiras)';
        break;
    case 'U03':
        $informe_type = 'Unipolar (3 Tiras)';
        break;
    case 'UPF':
        $informe_type = 'Unipolar con Pértiga Fija';
        break;
    case 'USA':
        $informe_type = 'Unipolar Con Seguridad Aumentada';
        break;
    case 'UMT':
        $informe_type = 'Unipolar Para Líneas de Media Tensión';
        break;
    case 'UPV':
        $informe_type = 'Unipolar para Vehículo';
        break;
    default:
        $informe_type = 'Desconocido';
        break;
}

// Initialize mPDF with Nunito font, smaller default font size, and adjusted margins
$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 10,
    'default_font' => 'Nunito',
    'margin_left' => 20,  // Reduce the left margin
    'margin_right' => 15, // Adjust the right margin if needed
    'margin_top' => 10,   // Reduce the top margin of the page if necessary
]);

// Add Nunito font
$mpdf->fontdata['nunito'] = [
    'R' => 'Nunito-Regular.ttf',
    'B' => 'Nunito-Bold.ttf',
    'I' => 'Nunito-Italic.ttf',
    'BI' => 'Nunito-BoldItalic.ttf',
];

// Prepare the HTML content with the image in the header
$html = '
<div style="display: flex; align-items: flex-start; justify-content: flex-start; margin-top: -10px;">
    <img src="../nuevos/imagenes/LOGYTEC.png" style="width: 180px; height: auto; margin-right: 10px; margin-top: 0px;" alt="Logo">
    <h1 style="text-align: center; font-size: 14px; flex-grow: 1; margin-top: 0px;">INFORME TÉCNICO N° ' . htmlspecialchars($data['IdMantPrueba']) . '</h1>
</div>';

// Start the main content container for the cards
$html .= '<div style="margin-top: 20px;">';

$html .= '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; display: flex; flex-direction: column; align-items: flex-start;">
    <h2 style="font-size: 12px; margin: 0;">Cliente: ' . htmlspecialchars($data['Cliente']) . '</h2>
    <h2 style="font-size: 12px; margin: 0;">RUC: ' . htmlspecialchars($data['Ruc']) . '</h2>
    <h2 style="font-size: 12px; margin: 0;">Aterramiento: ' . htmlspecialchars($informe_type) . ' ' . htmlspecialchars($data['Serie']) . '</h2>
     <h2 style="font-size: 12px; margin: 0;">Fecha: ' . date('Y-m-d', strtotime($data['FechaInforme'])) . '</h2>
</div>';

// Conditionally add sections based on data
if (!empty($data['Sintoma'])) {
    $html .= '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        <h2 style="font-size: 12px; margin: 0;">Síntoma</h2>
        <p style="font-size: 10px; margin: 0;">' . htmlspecialchars($data['Sintoma']) . '</p>
    </div>';
}

if (!empty($data['Diagnostico'])) {
    $html .= '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        <h2 style="font-size: 12px; margin: 0;">Diagnóstico</h2>
        <p style="font-size: 10px; margin: 0;">' . htmlspecialchars($data['Diagnostico']) . '</p>
    </div>';
}

if (!empty($data['AccionesRealizadas'])) {
    $html .= '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        <h2 style="font-size: 12px; margin: 0;">Acciones Realizadas</h2>
        <p style="font-size: 10px; margin: 0;">' . htmlspecialchars($data['AccionesRealizadas']) . '</p>
    </div>';
}

if (!empty($data['Conclusiones'])) {
    $html .= '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
        <h2 style="font-size: 12px; margin: 0;">Conclusiones</h2>
        <p style="font-size: 10px; margin: 0;">' . htmlspecialchars($data['Conclusiones']) . '</p>
    </div>';
}

$html .= '
</div>';

$html .= '<p style="font-size: 10px; text-align: left; padding-left: 45px;">Atentamente,</p>';
$html .= '<div style="font-size: 10px; text-align: center; margin-top: 40px; position: relative;">';
$html .= '<p>Laboratorio de Calibraciones<br>efernandez@logytec.com.pe</p>';
$html .= '<img src="../nuevos/imagenes/SELLO.png" alt="Sello" style="position: absolute; right: 0; top: 0; height: 50px;">';
$html .= '</div>';

// Close the main content container
$html .= '</div>';

// Write the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF as a download
$mpdf->Output('Informe_' . htmlspecialchars($id_orden) . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
