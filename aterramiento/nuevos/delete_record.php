<?php
// Conecta a tu base de datos (debes modificar esto según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_dielectricos2";

// Recibe los datos del POST
$serie = $_POST['serie'];

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Inicia una transacción
$conn->begin_transaction();

try {
    // Obtener el idOrdAterra asociado a la Serie
    $sql_id = "SELECT idOrdAterra FROM det_ord_aterra WHERE Serie = '$serie'";
    $result_id = $conn->query($sql_id);

    if ($result_id->num_rows > 0) {
        $row_id = $result_id->fetch_assoc();
        $idOrdAterra = $row_id["idOrdAterra"];
    }

    // Obtener idDetOrdAterra de det_ord_aterra
    $sql_det = "SELECT idDetOrdAterra FROM det_ord_aterra WHERE Serie = '$serie'";
    $result_det = $conn->query($sql_det);

    if ($result_det->num_rows > 0) {
        $row_det = $result_det->fetch_assoc();
        $idDetOrdAterra = $row_det["idDetOrdAterra"];

        // Eliminar de la tabla acc_ord_aterra
        $sql_acc = "DELETE FROM acc_ord_aterra WHERE idDetOrdAterra = '$idDetOrdAterra'";
        if ($conn->query($sql_acc) !== TRUE) {
            throw new Exception("Error al eliminar de acc_ord_aterra: " . $conn->error);
        }
    }

    // Elimina de la tabla ordprueba
    $sql1 = "DELETE FROM ordprueba WHERE Serie = '$serie'";
    if ($conn->query($sql1) !== TRUE) {
        throw new Exception("Error al eliminar de ordprueba: " . $conn->error);
    }

    // Elimina de la tabla det_ord_aterra
    $sql2 = "DELETE FROM det_ord_aterra WHERE Serie = '$serie'";
    if ($conn->query($sql2) !== TRUE) {
        throw new Exception("Error al eliminar de det_ord_aterra: " . $conn->error);
    }

    // Descontar 1 en la columna Cantidad de ordaterra
    $sql3 = "UPDATE ordaterra SET Cantidad = Cantidad - 1 WHERE idOrdAterra = '$idOrdAterra'";
    if ($conn->query($sql3) !== TRUE) {
        throw new Exception("Error al actualizar Cantidad en ordaterra: " . $conn->error);
    }

    // Si todas las operaciones son exitosas, confirma la transacción
    $conn->commit();
    echo "Registro eliminado correctamente";
} catch (Exception $e) {
    // Si hay algún error, revierte la transacción
    $conn->rollback();
    echo $e->getMessage();
}

$conn->close();
