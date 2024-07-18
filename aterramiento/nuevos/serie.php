<!DOCTYPE html>
<html>

<head>
    <title>Generar Serie</title>
</head>

<body>
    <h1>Generador de Serie</h1>
    <?php
    //Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "sistema");

    //Obtener el último número de serie generado en la base de datos
    $query = "SELECT MAX(numero_serie) AS last_serie FROM tabla_serie";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $last_serie = $row['last_serie'];

    //Obtener el año, mes y correlativo actual
    $current_year = date('Y');
    $current_month = date('m');
    if ($last_serie) {
        $last_correlativo = substr($last_serie, -3);
        $current_correlativo = str_pad((int)$last_correlativo + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $current_correlativo = "001";
    }

    //Generar el número de serie
    $numero_serie = $current_year . $current_month . "1" . $current_correlativo;

    //Insertar el número de serie en la base de datos al presionar el botón
    if (isset($_POST['generar_serie'])) {
        $insert_query = "INSERT INTO tabla_serie (numero_serie) VALUES ('$numero_serie')";
        $conn->query($insert_query);
        $last_serie = $numero_serie;
    }

    //Cerrar la conexión a la base de datos
    $conn->close();
    ?>

    <p>Último número de serie generado: <?php echo $last_serie; ?></p>

    <form method="post">
        <input type="submit" name="generar_serie" value="Generar Nueva Serie">
    </form>
</body>

</html>