<?php
// Verificar si el RUC está presente en la solicitud GET
if (isset($_GET['numero'])) {
    // Datos
    $token = 'apis-token-6051.46J8Cd7dirNVCONnmpCVROJ7CAknXS3m';
    $ruc = $_GET['numero'];

    // Iniciar llamada a API
    $curl = curl_init();

    // Buscar RUC SUNAT
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/ruc?numero=' . $ruc,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => 0,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Referer: http://apis.net.pe/api-ruc',
        'Authorization: Bearer ' . $token
      ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    // Enviar respuesta como JSON
    echo $response;
} else {
    echo json_encode(['error' => 'No se proporcionó un número de RUC.']);
}
?>
