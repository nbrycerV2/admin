<?php
// Conecta a tu base de datos (debes modificar esto según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_dielectricos2";

// Recibe los datos del POST
$originalSerie = $_POST['serie']; // "Serie" original del registro a actualizar
$nuevaSerie = $_POST['nuevaSerie']; // Nueva serie para actualizar
$updatedData = $_POST['updatedData']; // Datos actualizados

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicia la transacción
$conn->begin_transaction();

try {
    // Verifica si la nueva serie ya está registrada en ordprueba o det_ord_aterra, solo si la serie ha cambiado
    if ($originalSerie !== $nuevaSerie) {
        $sqlVerificarSerieOrdprueba = "SELECT COUNT(*) as count FROM ordprueba WHERE Serie = '$nuevaSerie'";
        $resultOrdprueba = $conn->query($sqlVerificarSerieOrdprueba);
        $rowOrdprueba = $resultOrdprueba->fetch_assoc();
        $countOrdprueba = $rowOrdprueba['count'];

        $sqlVerificarSerieDetOrdAterra = "SELECT COUNT(*) as count FROM det_ord_aterra WHERE Serie = '$nuevaSerie'";
        $resultDetOrdAterra = $conn->query($sqlVerificarSerieDetOrdAterra);
        $rowDetOrdAterra = $resultDetOrdAterra->fetch_assoc();
        $countDetOrdAterra = $rowDetOrdAterra['count'];

        if ($countOrdprueba > 0 || $countDetOrdAterra > 0) {
            throw new Exception("La nueva serie ya está registrada.");
        }
    }

    // Actualiza la tabla ordprueba
    $sqlOrdprueba = "UPDATE ordprueba SET ";
    foreach ($updatedData as $key => $value) {
        $sqlOrdprueba .= "$key = '$value', ";
    }
    $sqlOrdprueba = rtrim($sqlOrdprueba, ", ");
    $sqlOrdprueba .= " WHERE Serie = '$originalSerie'";

    if ($conn->query($sqlOrdprueba) !== TRUE) {
        throw new Exception("Error al actualizar el registro en ordprueba: " . $conn->error);
    }

    // Actualiza la Serie en ordprueba y det_ord_aterra si es diferente
    if ($originalSerie !== $nuevaSerie) {
        $sqlUpdateSerieOrdprueba = "UPDATE ordprueba SET Serie = '$nuevaSerie' WHERE Serie = '$originalSerie'";
        if ($conn->query($sqlUpdateSerieOrdprueba) !== TRUE) {
            throw new Exception("Error al actualizar la Serie en ordprueba: " . $conn->error);
        }

        $sqlUpdateSerieDetOrdAterra = "UPDATE det_ord_aterra SET Serie = '$nuevaSerie' WHERE Serie = '$originalSerie'";
        if ($conn->query($sqlUpdateSerieDetOrdAterra) !== TRUE) {
            throw new Exception("Error al actualizar la Serie en det_ord_aterra: " . $conn->error);
        }
    }

    // Commit de la transacción
    $conn->commit();
    echo "Registro actualizado correctamente";
} catch (Exception $e) {
    // Rollback de la transacción en caso de error
    $conn->rollback();
    echo $e->getMessage();
}

$conn->close();
