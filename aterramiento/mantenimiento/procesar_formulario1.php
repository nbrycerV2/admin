<?php
// Establece la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_dielectricos2";

// Crea la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para manejar valores nulos o vacíos en consultas SQL
function prepareValue($value, $isNumeric = false, $defaultValue = '')
{
    global $conn;
    if ($value === null || $value === '') {
        if ($isNumeric) {
            return $defaultValue !== '' ? $defaultValue : 0; // Para valores numéricos, devolvemos el valor por defecto o 0 si están vacíos o son nulos
        } else {
            return $defaultValue !== '' ? "'" . $conn->real_escape_string($defaultValue) . "'" : "''"; // Para valores no numéricos, devolvemos el valor por defecto o cadena vacía
        }
    }
    if ($isNumeric) {
        return $value; // Asume que ya es un número
    }
    return "'" . $conn->real_escape_string($value) . "'";
}

// Asignar valores de los campos del formulario y usar valores por defecto si están vacíos
$idOrdMant = $_POST['IdOrdMantphp'] ?? '';
$idCliente = $_POST['idClientephp'] ?? '';
$Cantidad = $_POST['Cantidadphp'] ?? 1; // Asumimos que la cantidad es al menos 1
$FechaSolicitud = $_POST['FechaSolicitudphp'] ?? '';
$FechaEntrega = $_POST['FechaEntregaphp'] ?? '';

// Obtener el año y mes actual para la generación del código
$currentYear = date('y'); // Obtener los últimos dos dígitos del año actual
$currentMonth = date('m'); // Obtener el mes actual en formato numérico de dos dígitos (por ejemplo, "07" para julio)

// Separar Cliente y Ruc
if ($idCliente !== null && $idCliente !== '') {
    $clienteRuc = explode('|', $idCliente);
    $Cliente = trim($clienteRuc[0]);
    $Ruc = trim($clienteRuc[1]);
} else {
    $Cliente = 'N/A';
    $Ruc = 'N/A';
}

// Insertar datos en la tabla ordaterra
$sql = "INSERT INTO ordmantenimiento (IdOrdMant, Cliente, Ruc, Cantidad, FechaSolicitud, FechaEntrega, Estado)
        VALUES (" . prepareValue($idOrdMant) . ", " . prepareValue($Cliente) . ", " . prepareValue($Ruc) . ", " . prepareValue($Cantidad, true) . ", " . prepareValue($FechaSolicitud) . ", " . prepareValue($FechaEntrega) . ", 'Pendiente')";

if ($conn->query($sql) !== TRUE) {
    $error = $conn->error;
    $conn->close();
    header("Location: error.php?error=" . urlencode($error));
    exit();




    // Incrementar los números para los siguientes códigos
    $nextId++;
}

// Cerrar la conexión
$conn->close();
// Redirige al index.php después de la inserción exitosa
header("Location: index.php");
exit();
