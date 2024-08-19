<?php
$server = "localhost";
$user = "root";
$password = "";
$database = "sistema_dielectricos2"; //sisven_logytec directorio
$database2 = "sistema_laboratorio"; //para sacar empresas
$database3 = "sistema_integral"; //para sacar usuarios

$conexion = mysqli_connect($server, $user, $password, $database);
date_default_timezone_set("America/Lima");
mysqli_set_charset($conexion, "utf8");

$conexion2 = mysqli_connect($server, $user, $password, $database2);
date_default_timezone_set("America/Lima");
mysqli_set_charset($conexion, "utf8");

$conexion3 = mysqli_connect($server, $user, $password, $database3);
date_default_timezone_set("America/Lima");
mysqli_set_charset($conexion, "utf8");
//hola mundo