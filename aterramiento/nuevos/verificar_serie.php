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

// Construye la consulta SQL para verificar en ordprueba
$sqlOrdPrueba = "SELECT COUNT(*) as count FROM ordprueba WHERE Serie = '$serie'";
$resultOrdPrueba = $conn->query($sqlOrdPrueba);

$rowOrdPrueba = $resultOrdPrueba->fetch_assoc();
$countOrdPrueba = $rowOrdPrueba['count'];

// Construye la consulta SQL para verificar en det_ord_aterra
$sqlDetOrdAterra = "SELECT COUNT(*) as count FROM det_ord_aterra WHERE Serie = '$serie'";
$resultDetOrdAterra = $conn->query($sqlDetOrdAterra);

$rowDetOrdAterra = $resultDetOrdAterra->fetch_assoc();
$countDetOrdAterra = $rowDetOrdAterra['count'];

// Devuelve la suma de ambas consultas
echo $countOrdPrueba + $countDetOrdAterra;

$conn->close();
