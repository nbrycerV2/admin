<?php
include("conexion.php");
$funcion = $_GET["funcion"];
$fecha = date("Y-m-d");

if ($_SERVER['REQUEST_METHOD'] === 'POST' and $funcion == "agrego_orden") {

    // Obtener los datos del formulario
    $cliente_ruc = $_POST['empresa'];
    $cliente_ruc_arr = explode('|', $cliente_ruc);
    $cliente = $cliente_ruc_arr[0]; // El cliente estará en la posición 0 del array
    $ruc = $cliente_ruc_arr[1]; // El RUC estará en la posición 1 del array
    $equipo = $_POST['equipo'];
    $vendedor = $_POST['vendedor'];
    $estado = $_POST['estado'];
    $items = $_POST['items'];
    $rs = mysqli_query($conexion, "SELECT MAX(id) AS id FROM orden_dielectrico_m");
    if ($row = mysqli_fetch_row($rs)) {
        $id = trim($row[0]);
        $code = substr($id, -6, 2);
        $year = date('y');
        if ($code == $year) {
            $id_ = $id + 1;
        } else {
            $id_ = $year . "0001";
        }
    }

    // Insertar los datos en la tabla "orden_dielectrico_m"
    $sql = "INSERT INTO orden_dielectrico_m (id,cliente, ruc, equipo, vendedor, estado, items, fecha) 
        VALUES ('$id_','$cliente', '$ruc', '$equipo', '$vendedor', '$estado', '$items','$fecha')";

    if ($conexion->query($sql) === TRUE) {
        echo "Datos guardados correctamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
    header("Location:index.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $funcion == "eliminar_orden") {
    $id = $_POST['id'];
    // Función para eliminar una fila
    function eliminarFila($conexion, $sql)
    {
        if ($conexion->query($sql) === TRUE) {
            echo "Fila eliminada correctamente.";
        } else {
            echo "Error al eliminar la fila: " . $conexion->error;
        }
    }
    // Realizar la lógica de eliminación de datos en la base de datos
    $sql1 = "DELETE FROM orden_dielectrico_m WHERE id = '$id'";
    eliminarFila($conexion, $sql1);

    $sql2 = "DELETE FROM orden_item_m where id_orden = '$id'";
    eliminarFila($conexion, $sql2);

    $conexion->close();
    header("Location:index.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' and $funcion == "agrego_items") {

    // Obtener los datos del formulario
    $id_orden = $_POST["id_orden"];
    $empresa = $_POST["empresa"];
    $vendedor = $_POST["vendedor"];
    $marca = $_POST["marca"];
    $equipo = $_POST["equipo"];
    $resultados = "Pendiente";
    $modelo = "";

    function numero_informe($conexion, $id_orden, $i)
    {
        $res2 = mysqli_query($conexion, "SELECT MAX(nro_orden) as max FROM orden_item_m where id_orden='$id_orden'");
        while ($rows2 = mysqli_fetch_array($res2)) {
            $nro_max = $rows2['max'];
        }
        if ($nro_max >= $i) {
            $nro_orden = $nro_max + 1;
        } else {
            $nro_orden = $i;
        }

        return $nro_orden;
    }
    function agrego_guantes($conexion, $id_orden, $marca, $clase, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla, $resultados)
    {
        $consulta = "INSERT INTO orden_item_m(id_orden,marca,clase,fecha,nro_orden,equipo,n_informe,vendedor,empresa,talla,resultado) 
        VALUES('$id_orden','$marca','$clase','$fecha','$nro_orden','$equipo','$n_informe','$vendedor','$empresa','$talla','$resultados')";
        return $resultado = $conexion->query($consulta) || die("Ha ocurrido un error al guardar los datos");
    }
    function agrego_mantas($conexion, $id_orden, $marca, $clase, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados)
    {
        $consulta = "INSERT INTO orden_item_m(id_orden,marca,clase,fecha,nro_orden,equipo,n_informe,vendedor,empresa,talla,resultado) 
        VALUES('$id_orden','$marca','$clase','$fecha','$nro_orden','$equipo','$n_informe','$vendedor','$empresa','$tipo','$resultados')";
        return $resultado = $conexion->query($consulta) || die("Ha ocurrido un error al guardar los datos");
    }
    function agrego_banquetas($conexion, $id_orden, $marca, $clase, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados)
    {
        $consulta = "INSERT INTO orden_item_m(id_orden,marca,clase,fecha,nro_orden,equipo,n_informe,vendedor,empresa,resultado) 
        VALUES('$id_orden','$marca','$clase','$fecha','$nro_orden','$equipo','$n_informe','$vendedor','$empresa','$resultados')";
        return $resultado = $conexion->query($consulta) || die("Ha ocurrido un error al guardar los datos");
    }
    function agrego_pertigas($conexion, $id_orden, $marca, $modelo, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados, $cuerpos)
    {
        $consulta = "INSERT INTO orden_item_m(id_orden,marca,clase,fecha,nro_orden,equipo,n_informe,vendedor,empresa,resultado,talla) 
        VALUES('$id_orden','$marca','$modelo','$fecha','$nro_orden','$equipo','$n_informe','$vendedor','$empresa','$resultados','$cuerpos')";
        return $resultado = $conexion->query($consulta) || die("Ha ocurrido un error al guardar los datos");
    }
    function agrego_mangas($conexion, $id_orden, $marca, $clase, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados)
    {
        $consulta = "INSERT INTO orden_item_m(id_orden,marca,clase,fecha,nro_orden,equipo,n_informe,vendedor,empresa,resultado) 
        VALUES('$id_orden','$marca','$clase','$fecha','$nro_orden','$equipo','$n_informe','$vendedor','$empresa','$resultados')";
        return $resultado = $conexion->query($consulta) || die("Ha ocurrido un error al guardar los datos");
    }

    if ($equipo == "Guantes") {

        $clase00 = $_POST["clase00"];
        $clase0 = $_POST["clase0"];
        $clase1 = $_POST["clase1"];
        $clase2 = $_POST["clase2"];
        $clase3 = $_POST["clase3"];
        $clase4 = $_POST["clase4"];

        $talla00 = $_POST["talla00"];
        $talla0 = $_POST["talla0"];
        $talla1 = $_POST["talla1"];
        $talla2 = $_POST["talla2"];
        $talla3 = $_POST["talla3"];
        $talla4 = $_POST["talla4"];

        $fecha = date('Y-m-d');

        if ($clase00 != 0) {
            for ($i = 1; $i <= $clase00; $i++) {
                $clases = "Clase 00";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";
                if ($equipo == "Guantes") {
                    agrego_guantes($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla00, $resultados);
                }
            }
        }
        if ($clase0 != 0) {
            for ($i = 1; $i <= $clase0; $i++) {
                $clases = "Clase 0";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Guantes") {
                    agrego_guantes($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla0, $resultados);
                }
            }
        }
        if ($clase1 != 0) {
            for ($i = 1; $i <= $clase1; $i++) {
                $clases = "Clase 1";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Guantes") {
                    agrego_guantes($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla1, $resultados);
                }
            }
        }
        if ($clase2 != 0) {
            for ($i = 1; $i <= $clase2; $i++) {
                $clases = "Clase 2";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Guantes") {
                    agrego_guantes($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla2, $resultados);
                }
            }
        }
        if ($clase3 != 0) {
            for ($i = 1; $i <= $clase3; $i++) {
                $clases = "Clase 3";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Guantes") {
                    agrego_guantes($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla3, $resultados);
                }
            }
        }
        if ($clase4 != 0) {
            for ($i = 1; $i <= $clase4; $i++) {
                $clases = "Clase 4";
                $nro_orden = numero_informe($conexion, $id_orden, $i);
                echo $nro_orden;
                echo "<br>";
                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";


                if ($equipo == "Guantes") {
                    agrego_guantes($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $talla4, $resultados);
                }
            }
        }
    }
    if ($equipo == "Mantas") {
        $clase00 = $_POST["clase00"];
        $clase0 = $_POST["clase0"];
        $clase1 = $_POST["clase1"];
        $clase2 = $_POST["clase2"];
        $clase3 = $_POST["clase3"];
        $clase4 = $_POST["clase4"];
        $tipo = $_POST["tipo"];

        if ($clase00 != 0) {
            for ($i = 1; $i <= $clase00; $i++) {
                $clases = "Clase 00";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";
                if ($equipo == "Mantas") {
                    agrego_mantas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados);
                }
            }
        }
        if ($clase0 != 0) {
            for ($i = 1; $i <= $clase0; $i++) {
                $clases = "Clase 0";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mantas") {
                    agrego_mantas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados);
                }
            }
        }
        if ($clase1 != 0) {
            for ($i = 1; $i <= $clase1; $i++) {
                $clases = "Clase 1";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mantas") {
                    agrego_mantas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados);
                }
            }
        }
        if ($clase2 != 0) {
            for ($i = 1; $i <= $clase2; $i++) {
                $clases = "Clase 2";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mantas") {
                    agrego_mantas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados);
                }
            }
        }
        if ($clase3 != 0) {
            for ($i = 1; $i <= $clase3; $i++) {
                $clases = "Clase 3";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mantas") {
                    agrego_mantas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados);
                }
            }
        }
        if ($clase4 != 0) {
            for ($i = 1; $i <= $clase4; $i++) {
                $clases = "Clase 4";
                $nro_orden = numero_informe($conexion, $id_orden, $i);
                echo $nro_orden;
                echo "<br>";
                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";


                if ($equipo == "Mantas") {
                    agrego_mantas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $tipo, $resultados);
                }
            }
        }
    }
    if ($equipo == "Banquetas") {
        $clase00 = $_POST["clase00"];
        $clase0 = $_POST["clase0"];
        $clase1 = $_POST["clase1"];
        $clase2 = $_POST["clase2"];
        $clase3 = $_POST["clase3"];
        $clase4 = $_POST["clase4"];

        if ($clase00 != 0) {
            for ($i = 1; $i <= $clase00; $i++) {
                $clases = "Clase 00";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";
                if ($equipo == "Banquetas") {
                    agrego_banquetas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase0 != 0) {
            for ($i = 1; $i <= $clase0; $i++) {
                $clases = "Clase 0";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Banquetas") {
                    agrego_banquetas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase1 != 0) {
            for ($i = 1; $i <= $clase1; $i++) {
                $clases = "Clase 1";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Banquetas") {
                    agrego_banquetas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase2 != 0) {
            for ($i = 1; $i <= $clase2; $i++) {
                $clases = "Clase 2";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Banquetas") {
                    agrego_banquetas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase3 != 0) {
            for ($i = 1; $i <= $clase3; $i++) {
                $clases = "Clase 3";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Banquetas") {
                    agrego_banquetas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase4 != 0) {
            for ($i = 1; $i <= $clase4; $i++) {
                $clases = "Clase 4";
                $nro_orden = numero_informe($conexion, $id_orden, $i);
                echo $nro_orden;
                echo "<br>";
                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";


                if ($equipo == "Banquetas") {
                    agrego_banquetas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
    }
    if ($equipo == "Pertigas") {
        $cantidad = $_POST["clase00"];

        $modelo = $marca;

        // Preparar la consulta SQL
        $sql = $conexion->prepare("SELECT marca, cuerpos FROM pertigas WHERE modelo = ?");
        $sql->bind_param("s", $modelo);

        // Ejecutar la consulta
        $sql->execute();

        // Obtener el resultado
        $result = $sql->get_result();

        // Procesar los resultados
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //echo "Marca: " . $row["marca"] . " - Cuerpos: " . $row["cuerpos"] . "<br>";

                $marca = $row["marca"];
                $cuerpos = $row["cuerpos"];
            }
        } else {
            echo "0 resultados";
        }

        // Cerrar la conexión
        //$conexion->close();

        echo $modelo;
        echo "<br>";

        if ($cantidad != 0) {
            for ($i = 1; $i <= $cantidad; $i++) {
                //$clases = "Clase 00";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                agrego_pertigas($conexion, $id_orden, $marca, $modelo, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados, $cuerpos);
            }
        }
    }
    if ($equipo == "Mangas") {

        $clase00 = $_POST["clase00"];
        $clase0 = $_POST["clase0"];
        $clase1 = $_POST["clase1"];
        $clase2 = $_POST["clase2"];
        $clase3 = $_POST["clase3"];
        $clase4 = $_POST["clase4"];


        $fecha = date('Y-m-d');

        if ($clase00 != 0) {
            for ($i = 1; $i <= $clase00; $i++) {
                $clases = "Clase 00";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";
                if ($equipo == "Mangas") {
                    agrego_mangas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase0 != 0) {
            for ($i = 1; $i <= $clase0; $i++) {
                $clases = "Clase 0";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mangas") {
                    agrego_mangas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase1 != 0) {
            for ($i = 1; $i <= $clase1; $i++) {
                $clases = "Clase 1";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mangas") {
                    agrego_mangas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase2 != 0) {
            for ($i = 1; $i <= $clase2; $i++) {
                $clases = "Clase 2";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mangas") {
                    agrego_mangas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase3 != 0) {
            for ($i = 1; $i <= $clase3; $i++) {
                $clases = "Clase 3";
                $nro_orden = numero_informe($conexion, $id_orden, $i);

                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";

                if ($equipo == "Mangas") {
                    agrego_mangas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
        if ($clase4 != 0) {
            for ($i = 1; $i <= $clase4; $i++) {
                $clases = "Clase 4";
                $nro_orden = numero_informe($conexion, $id_orden, $i);
                echo $nro_orden;
                echo "<br>";
                $n_informe = $id_orden . "-" . $nro_orden;
                echo $n_informe;
                echo "<br>";


                if ($equipo == "Mangas") {
                    agrego_mangas($conexion, $id_orden, $marca, $clases, $fecha, $nro_orden, $equipo, $n_informe, $vendedor, $empresa, $resultados);
                }
            }
        }
    }

    // Cerrar la conexión
    $conexion->close();
    header("Location:orden.php?id=$id_orden");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and $funcion == "borro_items") {
    $id = $_POST['id'];
    // Realizar la lógica de eliminación de datos en la base de datos
    $sql = "DELETE FROM orden_item_m WHERE id = '$id'";

    // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        echo "Fila eliminada correctamente.";
    } else {
        echo "Error al eliminar la fila: " . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
    //header("Location:index.php");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and $funcion == "edito_items") {

    $equipo = $_POST["equipo"];
    $id_item = $_POST["id_item"];
    $id_orden = $_POST["id_orden"];
    //$tipo = $_POST["talla"];
    //echo $equipo;
    // Cerrar la conexión

    //header("Location:index.php");

    function actualizarGuante($conexion, $serie, $id_item, $n_informe, $clase, $marca, $longitud, $talla, $valor_izq, $valor_der, $resultados, $otro)
    {
        $maxSerie = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(serie_guante) AS max_serie FROM orden_item_m"))['max_serie'];

        $serieColumn = ($serie == $maxSerie) ? "serie_guante" : "serie_edit";

        // Actualizar la columna serie_guante a NULL si serie_edit se va a modificar
        if ($serieColumn === "serie_edit") {
            mysqli_query($conexion, "UPDATE orden_item_m SET serie_guante = NULL WHERE id = '$id_item'");
        }

        $consultaUpdate = "UPDATE orden_item_m 
                          SET $serieColumn = '$serie', n_informe = '$n_informe', clase = '$clase', marca = '$marca', longitud = '$longitud', talla = '$talla', valor_izq = '$valor_izq', valor_der = '$valor_der', resultado = '$resultados',otro = '$otro' 
                          WHERE id = '$id_item'";

        if (mysqli_query($conexion, $consultaUpdate)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conexion);
        }
    }

    function actualizarManta($conexion, $id_item, $equipo, $serie, $n_informe, $clase, $marca, $tipo, $resultados)
    {
        $maxSerie = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(serie_manta) AS max_serie FROM orden_item_m"))['max_serie'];

        $serieColumn = ($serie == $maxSerie) ? "serie_manta" : "serie_edit";

        // Actualizar la columna serie_guante a NULL si serie_edit se va a modificar
        if ($serieColumn === "serie_edit") {
            mysqli_query($conexion, "UPDATE orden_item_m SET serie_manta = NULL WHERE id = '$id_item'");
        }

        $consultaUpdate = "UPDATE orden_item_m 
                          SET $serieColumn = '$serie',equipo = '$equipo' ,n_informe = '$n_informe', clase = '$clase', marca = '$marca',talla = '$tipo' , resultado = '$resultados'
                          WHERE id = '$id_item'";

        if (mysqli_query($conexion, $consultaUpdate)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conexion);
        }
    }

    function actualizarBanqueta($conexion, $id_item, $equipo, $serie, $n_informe, $clase, $marca, $tipo, $resultados)
    {
        $maxSerie = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(serie_banqueta) AS max_serie FROM orden_item_m"))['max_serie'];

        $serieColumn = ($serie == $maxSerie) ? "serie_banqueta" : "serie_edit";

        // Actualizar la columna serie_guante a NULL si serie_edit se va a modificar
        if ($serieColumn === "serie_edit") {
            mysqli_query($conexion, "UPDATE orden_item_m SET serie_banqueta = NULL WHERE id = '$id_item'");
        }

        $consultaUpdate = "UPDATE orden_item_m 
                          SET $serieColumn = '$serie',equipo = '$equipo' ,n_informe = '$n_informe', clase = '$clase', marca = '$marca',talla = '$tipo' , resultado = '$resultados'
                          WHERE id = '$id_item'";

        if (mysqli_query($conexion, $consultaUpdate)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conexion);
        }
    }

    function actualizarPertiga($conexion, $id_item, $equipo, $serie, $n_informe, $clase, $marca, $tipo, $resultados)
    {
        $maxSerie = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(serie_pertiga) AS max_serie FROM orden_item_m"))['max_serie'];

        $serieColumn = ($serie == $maxSerie) ? "serie_pertiga" : "serie_edit";

        // Actualizar la columna serie_guante a NULL si serie_edit se va a modificar
        if ($serieColumn === "serie_edit") {
            mysqli_query($conexion, "UPDATE orden_item_m SET serie_pertiga = NULL WHERE id = '$id_item'");
        }

        $consultaUpdate = "UPDATE orden_item_m 
                          SET $serieColumn = '$serie',equipo = '$equipo' ,n_informe = '$n_informe', clase = '$clase', marca = '$marca',talla = '$tipo' , resultado = '$resultados'
                          WHERE id = '$id_item'";

        if (mysqli_query($conexion, $consultaUpdate)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conexion);
        }
    }

    function actualizarManga($conexion, $serie, $id_item, $n_informe, $clase, $marca, $valor_izq, $valor_der, $resultados, $otro)
    {
        $maxSerie = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT MAX(serie_manga) AS max_serie FROM orden_item_m"))['max_serie'];

        $serieColumn = ($serie == $maxSerie) ? "serie_manga" : "serie_edit";

        // Actualizar la columna serie_guante a NULL si serie_edit se va a modificar
        if ($serieColumn === "serie_edit") {
            mysqli_query($conexion, "UPDATE orden_item_m SET serie_manga = NULL WHERE id = '$id_item'");
        }

        $consultaUpdate = "UPDATE orden_item_m 
                          SET $serieColumn = '$serie', n_informe = '$n_informe', clase = '$clase', marca = '$marca', valor_izq = '$valor_izq', valor_der = '$valor_der', resultado = '$resultados',otro = '$otro' 
                          WHERE id = '$id_item'";

        if (mysqli_query($conexion, $consultaUpdate)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($conexion);
        }
    }

    if ($equipo == "Guantes") {

        $serie = $_POST["serie"];
        $n_informe = $_POST["n_informe"];
        $clase = $_POST["clase"];
        $marca = $_POST["marca"];
        $longitud = $_POST["longitud"];
        $talla = $_POST["talla"];
        $valor_izq = $_POST["valor_izq"];
        $valor_der = $_POST["valor_der"];
        $resultados = $_POST["resultados"];
        $otro = $_POST["otro"];
        // echo "AQUI";
        actualizarGuante($conexion, $serie, $id_item, $n_informe, $clase, $marca, $longitud, $talla, $valor_izq, $valor_der, $resultados, $otro);
        header("Location:orden.php?id=$id_orden");
    }
    if ($equipo == "Mantas") {
        $id_item = $_POST["id_item"];
        $serie = $_POST["serie"];
        $n_informe = $_POST["n_informe"];
        $clase = $_POST["clase"];
        $marca = $_POST["marca"];
        $tipo = $_POST["tipo"];
        $resultados = $_POST["resultados"];


        // Mostrar los valores recibidos
        echo "ID Item: " . $id_item . "<br>";
        echo "Equipo: " . $equipo . "<br>";
        echo "Serie: " . $serie . "<br>";
        echo "Número de informe: " . $n_informe . "<br>";
        echo "Clase: " . $clase . "<br>";
        echo "Marca: " . $marca . "<br>";
        echo "Tipo: " . $tipo . "<br>";
        echo "Resultados: " . $resultados . "<br>";

        actualizarManta($conexion, $id_item, $equipo, $serie, $n_informe, $clase, $marca, $tipo, $resultados);
        header("Location:orden.php?id=$id_orden");
    }
    if ($equipo == "Banquetas") {
        $id_item = $_POST["id_item"];
        $serie = $_POST["serie"];
        $n_informe = $_POST["n_informe"];
        $clase = $_POST["clase"];
        $marca = $_POST["marca"];
        $tipo = $_POST["talla"];
        $resultados = $_POST["resultados"];


        // Mostrar los valores recibidos
        echo "ID Item: " . $id_item . "<br>";
        echo "Equipo: " . $equipo . "<br>";
        echo "Serie: " . $serie . "<br>";
        echo "Número de informe: " . $n_informe . "<br>";
        echo "Clase: " . $clase . "<br>";
        echo "Marca: " . $marca . "<br>";
        echo "Tipo: " . $tipo . "<br>";
        echo "Resultados: " . $resultados . "<br>";

        actualizarBanqueta($conexion, $id_item, $equipo, $serie, $n_informe, $clase, $marca, $tipo, $resultados);
        header("Location:orden.php?id=$id_orden");
    }
    if ($equipo == "Pertigas") {

        $id_item = $_POST["id_item"];
        $serie = $_POST["serie"];
        $n_informe = $_POST["n_informe"];
        $clase = $_POST["clase"];
        $marca = $_POST["marca"];
        $tipo = $_POST["talla"];
        $resultados = $_POST["resultados"];


        // Mostrar los valores recibidos
        echo "ID Item: " . $id_item . "<br>";
        echo "Equipo: " . $equipo . "<br>";
        echo "Serie: " . $serie . "<br>";
        echo "Número de informe: " . $n_informe . "<br>";
        echo "Clase: " . $clase . "<br>";
        echo "Marca: " . $marca . "<br>";
        echo "Cuerpos: " . $tipo . "<br>";
        echo "Resultados: " . $resultados . "<br>";

        actualizarPertiga($conexion, $id_item, $equipo, $serie, $n_informe, $clase, $marca, $tipo, $resultados);
        header("Location:orden.php?id=$id_orden");
    }
    if ($equipo == "Mangas") {

        $serie = $_POST["serie"];
        $n_informe = $_POST["n_informe"];
        $clase = $_POST["clase"];
        $marca = $_POST["marca"];;
        $valor_izq = $_POST["valor_izq"];
        $valor_der = $_POST["valor_der"];
        $resultados = $_POST["resultados"];
        $otro = $_POST["otro"];
        // echo "AQUI";
        actualizarManga($conexion, $serie, $id_item, $n_informe, $clase, $marca, $valor_izq, $valor_der, $resultados, $otro);
        header("Location:orden.php?id=$id_orden");
    }

    //$conexion->close();
    //header("Location:orden.php?id=$id_orden");
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' and $funcion == "agrego_series") {

    $equipo = $_GET["equipo"];
    //$id_item = $_GET["id_item"];
    $id_orden = $_GET["id_orden"];

    if ($equipo == "Guantes") {
        function generarSerie($año, $mes, $valor)
        {
            return (($año . $mes . $valor) * 1000) + 1;
        }

        $año = date('y');
        $mes = date('m');
        $serie_nuevo = generarSerie($año, $mes, 1);
        //$serie_mantenimiento = generarSerie($año, $mes, 0);

        $sql_max_serie = "SELECT MAX(serie_guante) AS max_serie FROM orden_item_m";
        $result_max_serie = $conexion->query($sql_max_serie);
        $max_serie = $result_max_serie->fetch_assoc()["max_serie"];

        $sql_cant_items = "SELECT items FROM orden_dielectrico_m WHERE id = $id_orden";
        $cant_items_result = $conexion->query($sql_cant_items);
        $cant_items = $cant_items_result->fetch_assoc()["items"];

        $query_null_ids = "SELECT id FROM orden_item_m WHERE id_orden = $id_orden AND serie_guante IS NULL AND serie_edit IS NULL";
        $resultado = mysqli_query($conexion, $query_null_ids);

        if ($resultado) {
            $id_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            $num_null_ids = count($id_array);
            echo "Número de IDs con guante_serie NULL: $num_null_ids\n";

            for ($i = 0; $i < $num_null_ids; $i++) {
                $serie_actualizada = ($max_serie > $serie_nuevo) ? ($max_serie + $i + 1) : ($serie_nuevo + $i);
                $id_items = $id_array[$i]['id'];
                echo "Nuevo número de serie: $serie_actualizada\n";
                echo "ID: $id_items\n";
                $update_sql = "UPDATE orden_item_m SET serie_guante = $serie_actualizada WHERE id = $id_items AND serie_guante IS NULL";

                if (mysqli_query($conexion, $update_sql)) {
                    echo "Record updated successfully\n";
                } else {
                    echo "Error updating record: " . mysqli_error($conexion) . "\n";
                }
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion) . "\n";
        }
    }
    if ($equipo == "Mantas") {
        function generarSerie($año, $mes, $valor)
        {
            return (($año . $mes . $valor) * 1000) + 1;
        }

        $año = date('y');
        $mes = date('m');
        $serie_nuevo = generarSerie($año, $mes, 3);
        //$serie_mantenimiento = generarSerie($año, $mes, 2);

        $sql_max_serie = "SELECT MAX(serie_manta) AS max_serie FROM orden_item_m";
        $result_max_serie = $conexion->query($sql_max_serie);
        $max_serie = $result_max_serie->fetch_assoc()["max_serie"];

        $sql_cant_items = "SELECT items FROM orden_dielectrico_m WHERE id = $id_orden";
        $cant_items_result = $conexion->query($sql_cant_items);
        $cant_items = $cant_items_result->fetch_assoc()["items"];

        $query_null_ids = "SELECT id FROM orden_item_m WHERE id_orden = $id_orden AND serie_manta IS NULL AND serie_edit IS NULL";
        $resultado = mysqli_query($conexion, $query_null_ids);

        if ($resultado) {
            $id_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            $num_null_ids = count($id_array);
            echo "Número de IDs con guante_serie NULL: $num_null_ids\n";

            for ($i = 0; $i < $num_null_ids; $i++) {
                $serie_actualizada = ($max_serie > $serie_nuevo) ? ($max_serie + $i + 1) : ($serie_nuevo + $i);
                $id_items = $id_array[$i]['id'];
                echo "Nuevo número de serie: $serie_actualizada\n";
                echo "ID: $id_items\n";
                $update_sql = "UPDATE orden_item_m SET serie_manta = $serie_actualizada WHERE id = $id_items AND serie_manta IS NULL";

                if (mysqli_query($conexion, $update_sql)) {
                    echo "Record updated successfully\n";
                } else {
                    echo "Error updating record: " . mysqli_error($conexion) . "\n";
                }
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion) . "\n";
        }
    }
    if ($equipo == "Banquetas") {
        function generarSerie($año, $mes, $valor)
        {
            return (($año . $mes . $valor) * 1000) + 1;
        }

        $año = date('y');
        $mes = date('m');
        $serie_nuevo = generarSerie($año, $mes, 5);
        //$serie_mantenimiento = generarSerie($año, $mes, 4);

        $sql_max_serie = "SELECT MAX(serie_banqueta) AS max_serie FROM orden_item_m";
        $result_max_serie = $conexion->query($sql_max_serie);
        $max_serie = $result_max_serie->fetch_assoc()["max_serie"];

        $sql_cant_items = "SELECT items FROM orden_dielectrico_m WHERE id = $id_orden";
        $cant_items_result = $conexion->query($sql_cant_items);
        $cant_items = $cant_items_result->fetch_assoc()["items"];

        $query_null_ids = "SELECT id FROM orden_item_m WHERE id_orden = $id_orden AND serie_banqueta IS NULL AND serie_edit IS NULL";
        $resultado = mysqli_query($conexion, $query_null_ids);

        if ($resultado) {
            $id_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            $num_null_ids = count($id_array);
            echo "Número de IDs con guante_serie NULL: $num_null_ids\n";

            for ($i = 0; $i < $num_null_ids; $i++) {
                $serie_actualizada = ($max_serie > $serie_nuevo) ? ($max_serie + $i + 1) : ($serie_nuevo + $i);
                $id_items = $id_array[$i]['id'];
                echo "Nuevo número de serie: $serie_actualizada\n";
                echo "ID: $id_items\n";
                $update_sql = "UPDATE orden_item_m SET serie_banqueta = $serie_actualizada WHERE id = $id_items AND serie_banqueta IS NULL";

                if (mysqli_query($conexion, $update_sql)) {
                    echo "Record updated successfully\n";
                } else {
                    echo "Error updating record: " . mysqli_error($conexion) . "\n";
                }
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion) . "\n";
        }
    }
    if ($equipo == "Pertigas") {
        function generarSerie($año, $mes, $valor)
        {
            return (($año . $mes . $valor) * 1000) + 1;
        }

        $año = date('y');
        $mes = date('m');
        $serie_nuevo = generarSerie($año, $mes, 7);
        //$serie_mantenimiento = generarSerie($año, $mes, 6);

        $sql_max_serie = "SELECT MAX(serie_pertiga) AS max_serie FROM orden_item_m";
        $result_max_serie = $conexion->query($sql_max_serie);
        $max_serie = $result_max_serie->fetch_assoc()["max_serie"];

        $sql_cant_items = "SELECT items FROM orden_dielectrico_m WHERE id = $id_orden";
        $cant_items_result = $conexion->query($sql_cant_items);
        $cant_items = $cant_items_result->fetch_assoc()["items"];

        $query_null_ids = "SELECT id FROM orden_item_m WHERE id_orden = $id_orden AND serie_pertiga IS NULL AND serie_edit IS NULL";
        $resultado = mysqli_query($conexion, $query_null_ids);

        if ($resultado) {
            $id_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            $num_null_ids = count($id_array);
            echo "Número de IDs con guante_serie NULL: $num_null_ids\n";

            for ($i = 0; $i < $num_null_ids; $i++) {
                $serie_actualizada = ($max_serie > $serie_nuevo) ? ($max_serie + $i + 1) : ($serie_nuevo + $i);
                $id_items = $id_array[$i]['id'];
                echo "Nuevo número de serie: $serie_actualizada\n";
                echo "ID: $id_items\n";
                $update_sql = "UPDATE orden_item_m SET serie_pertiga = $serie_actualizada WHERE id = $id_items AND serie_pertiga IS NULL";

                if (mysqli_query($conexion, $update_sql)) {
                    echo "Record updated successfully\n";
                } else {
                    echo "Error updating record: " . mysqli_error($conexion) . "\n";
                }
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion) . "\n";
        }
    }
    if ($equipo == "Mangas") {
        function generarSerie($año, $mes, $valor)
        {
            return (($año . $mes . $valor) * 1000) + 1;
        }

        $año = date('y');
        $mes = date('m');
        $serie_nuevo = generarSerie($año, $mes, 9);
        //$serie_mantenimiento = generarSerie($año, $mes, 8);

        $sql_max_serie = "SELECT MAX(serie_manga) AS max_serie FROM orden_item_m";
        $result_max_serie = $conexion->query($sql_max_serie);
        $max_serie = $result_max_serie->fetch_assoc()["max_serie"];

        $sql_cant_items = "SELECT items FROM orden_dielectrico_m WHERE id = $id_orden";
        $cant_items_result = $conexion->query($sql_cant_items);
        $cant_items = $cant_items_result->fetch_assoc()["items"];

        $query_null_ids = "SELECT id FROM orden_item_m WHERE id_orden = $id_orden AND serie_manga IS NULL AND serie_edit IS NULL";
        $resultado = mysqli_query($conexion, $query_null_ids);

        if ($resultado) {
            $id_array = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
            $num_null_ids = count($id_array);
            echo "Número de IDs con guante_serie NULL: $num_null_ids\n";

            for ($i = 0; $i < $num_null_ids; $i++) {
                $serie_actualizada = ($max_serie > $serie_nuevo) ? ($max_serie + $i + 1) : ($serie_nuevo + $i);
                $id_items = $id_array[$i]['id'];
                echo "Nuevo número de serie: $serie_actualizada\n";
                echo "ID: $id_items\n";
                $update_sql = "UPDATE orden_item_m SET serie_manga = $serie_actualizada WHERE id = $id_items AND serie_manga IS NULL";

                if (mysqli_query($conexion, $update_sql)) {
                    echo "Record updated successfully\n";
                } else {
                    echo "Error updating record: " . mysqli_error($conexion) . "\n";
                }
            }
        } else {
            echo "Error en la consulta: " . mysqli_error($conexion) . "\n";
        }
    }

    header("Location:orden.php?id=$id_orden");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and $funcion == "agrego_series_item") {

    $equipo = $_POST["equipo"];
    $id_item = $_POST["id_item"];
    $id_orden = $_POST["id_orden"];

    if ($equipo = "Guantes") {
    }
    if ($equipo = "Mantas") {
    }
    if ($equipo = "Banquetas") {
    }
    if ($equipo = "Pertigas") {
    }
    header("Location:orden.php?id=$id_orden");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and $funcion == "edito_orden") {
    $id_orden = $_POST["id_orden"];
    $cliente = $_POST["cliente"];
    $ruc = $_POST["ruc"];
    $estado = $_POST["estado"];
    $salida = $_POST["salida"];
    $vendedor = $_POST["vendedor"];

    mysqli_query($conexion, "UPDATE orden_dielectrico_m SET cliente = '$cliente',ruc = '$ruc',estado = '$estado',salida = '$salida',vendedor = '$vendedor' WHERE id = '$id_orden'");
    header("Location:orden.php?id=$id_orden");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and $funcion == "datos_informe") {
    $id_orden = $_POST["id_orden"];
    $humedad = $_POST["humedad_informe"];
    $temperatura = $_POST["temperatura_informe"];
    $fecha_inf = $_POST["fecha_inf"];
    echo $id_orden;
    echo $temperatura;
    mysqli_query($conexion, "UPDATE orden_dielectrico_m SET fecha_informe='$fecha_inf',humedad = '$humedad',temperatura = '$temperatura' WHERE id = '$id_orden'");
    header("Location:orden.php?id=$id_orden");
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' and $funcion == "genero_pdf") {
    $id_orden = $_GET["id_orden"];
    $equipo = $_GET["equipo"];
    //echo $equipo;
    if ($equipo == "Guantes") {

        //Arrays donde guardare los valores de las consultas
        $marca = array();
        $clase = array();
        $equipo = array();
        $n_informe = array();
        $talla = array();
        $resultado = array();
        $longitud = array();
        $valor_izq = array();
        $valor_der = array();
        $otro = array();
        $serie_guante = array();
        $serie_edit = array();
        $otro = array();
        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_item_m WHERE id_orden = $id_orden AND resultado = 'Apto'";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $marca[] = $row["marca"];
                $clase[] = $row["clase"];
                $equipo[] = $row["equipo"];
                $n_informe[] = $row["n_informe"];
                $talla[] = $row["talla"];
                $resultado[] = $row["resultado"];
                $longitud[] = $row["longitud"];
                $valor_izq[] = $row["valor_izq"];
                $valor_der[] = $row["valor_der"];
                $otro[] = $row["otro"];
                $serie_guante[] = $row["serie_guante"];
                $serie_edit[] = $row["serie_edit"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }

        $num_items = count($n_informe);

        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_dielectrico_m WHERE id = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $empresa = $row["cliente"];
                $fecha_informe = $row["fecha_informe"];
                $humedad = $row["humedad"];
                $temperatura = $row["temperatura"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }


        require("../../vendor/autoload.php");

        function GeneroPdf($n_informe, $marca, $clase, $serie, $f_informe, $empresa, $longitud, $valor_izq, $valor_der, $otro)
        {
            $combinaciones = [
                "Clase 00" => [
                    "280" => ["corriente" => "8", "tension" => "2.50 KV"],
                    "360" => ["corriente" => "12", "tension" => "2.50 KV"],
                ],
                "Clase 0" => [
                    "280" => ["corriente" => "8", "tension" => "5.00 KV"],
                    "360" => ["corriente" => "12", "tension" => "5.00 KV"],
                    "410" => ["corriente" => "14", "tension" => "5.00 KV"],
                    "460" => ["corriente" => "16", "tension" => "5.00 KV"],
                ],
                "Clase 1" => [
                    "360" => ["corriente" => "14", "tension" => "10.0 KV"],
                    "410" => ["corriente" => "16", "tension" => "10.0 KV"],
                    "460" => ["corriente" => "18", "tension" => "10.0 KV"],
                ],
                "Clase 2" => [
                    "360" => ["corriente" => "16", "tension" => "20.0 KV"],
                    "410" => ["corriente" => "18", "tension" => "20.0 KV"],
                    "460" => ["corriente" => "20", "tension" => "20.0 KV"],
                ],
                "Clase 3" => [
                    "360" => ["corriente" => "18", "tension" => "30.0 KV"],
                    "410" => ["corriente" => "20", "tension" => "30.0 KV"],
                    "460" => ["corriente" => "22", "tension" => "30.0 KV"],
                ],
                "Clase 4" => [
                    "410" => ["corriente" => "22", "tension" => "40.0 KV"],
                    "460" => ["corriente" => "24", "tension" => "40.0 KV"],
                ],
            ];

            if (isset($combinaciones[$clase][$longitud])) {
                $corriente = $combinaciones[$clase][$longitud]["corriente"];
                $tension = $combinaciones[$clase][$longitud]["tension"];
            }


            $mpdf = new \Mpdf\Mpdf();
            ob_start();
            $css = '
                .container {
                    margin-top: 50px;
                    font-size: 14px;
                }
                .row {
                    margin-bottom: 5px;
                }
                .cabecera td{
                vertical-align:top;
                border:0.1mm solid #CCCCCC;
                font-size:9pt; }
                table thead th {
                background-color:#EEEEEE;
                text-align:center;
                border:0.1mm solid #CCCCCC; 
                font-size:9pt; }
                table tbody td {
                text-align:center;
                border:0.1mm dotted #CCCCCC;
                padding:3pt; 
                padding-bottom:8pt; 
                vertical-align:top; 
                font-size:9pt; 
                color:#000000;}';
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

            $mpdf->WriteHTML('
                <htmlpageheader name="myheader">
                <table width="100%">
                <tr><td width="200"><img src="logo.png"  width="180" height="40"></td><td colspan="2" style="color:#000;font-size:9pt" align="right">Formato:Laboratorio de Ensayo<br>P&aacute;gina: {PAGENO} de {nb}<br> </td></tr>
                <tr><td colspan="3" style="font-size:12pt; background-color:#EEEEEE" align="center">Informe de Verificación Nº' . $n_informe . ' </td></tr>
                </table>
                </htmlpageheader>
                <sethtmlpageheader name="myheader" value="on" show-this-page="1">
            ');

            $mpdf->WriteHTML('
                <htmlpagefooter name="myfooter">
                <div style="border-top:1px solid #000000;text-align:center;font-size:8pt;">
                </htmlpagefooter>
            ');

            $mpdf->SetHTMLHeaderByName('myheader');
            $mpdf->SetHTMLFooterByName('myfooter');
            // Genera el contenido del PDF
            $html = '<div class="container">';
            $html .= '<br><br><br><div class="row" style="font-weight: bold;">1. Datos Generales</div>';
            $html .= '<div class="row"><table>
            <tr><td>Equipo:</td><td>Guante dieléctrico</td></tr>
            <tr><td>Marca:</td><td>' . $marca . '</td></tr>
            <tr><td>Clase:</td><td>' . $clase . '</td></tr>
            <tr><td>Serie:</td><td>' . $serie . '</td></tr>
            <tr><td>Fecha de verificación:</td><td>' . $f_informe . '</td></tr>
            </table></div>';
            $html .= '<div class="row" style="font-weight: bold;">2. Metodo de Verificación</div>';
            $html .= '<div class="row">Inspección visual y rigidez dieléctrica en conformidad con norma técnica ASTM-F496.</div>';
            $html .= '<div class="row" style="font-weight: bold;">3. Resultado de Pruebas de verificación</div>';
            $html .= '<div class="row" style="font-weight: bold;">3.1. Inspección Preliminar</div>';
            $html .= '<div class="row"><table class="tg">
            <thead>
              <tr>
                <th class="tg-uqo3">Lado</th>
                <th class="tg-uqo3">Estado Físico</th>
                <th class="tg-uqo3">Con Inflador</th>
                <th class="tg-uqo3">Estado Físico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>IZQ</td>
                <td>OK</td>
                <td>OK</td>
                <td>APTO</td>
              </tr>
              <tr>
                <td>DER</td>
                <td>OK</td>
                <td>OK</td>
                <td>APTO</td>
              </tr>
            </tbody>
            </table></div>';
            if ($otro == "Inflado") {
                $html .= '<div class="row">Nota: Para las pruebas de inflado, se utilizó probador de guantes marca Salisbury modelo G100.</div>';
            } else {
                $html .= '<div class="row" style="font-weight: bold;">3.2. Verificación de rigidez dieléctrica</div>';
                $html .= '<div class="row"><table class="tg">
                <thead>
                <tr>
                    <th class="tg-uqo3">Lado</th>
                    <th class="tg-uqo3">Clase</th>
                    <th class="tg-uqo3">Tensión de Prueba (AC)</th>
                    <th class="tg-uqo3">Corriente Máxima (mA)</th>
                    <th class="tg-uqo3">Corriente Medida (mA)</th>
                    <th class="tg-uqo3">Resultado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tg-c3ow">IZQ</td>
                    <td class="tg-c3ow">' . $clase . '</td>
                    <td class="tg-c3ow">' . $tension . '</td>
                    <td class="tg-c3ow">' . $corriente . '</td>
                    <td class="tg-baqh">' . $valor_izq . '</td>
                    <td class="tg-baqh">APTO</td>
                </tr>
                <tr>
                    <td class="tg-c3ow">DER</td>
                    <td class="tg-c3ow">' . $clase . '</td>
                    <td class="tg-c3ow">' . $tension . '</td>
                    <td class="tg-c3ow">' . $corriente . '</td>
                    <td class="tg-baqh">' . $valor_der . '</td>
                    <td class="tg-baqh">APTO</td>
                </tr>
                </tbody>
                </table></div>';
                $html .= '<div class="row">Nota: Para las pruebas de verificación dieléctrica, se utilizó un generador de alto voltaje marca Phenix modelo
                6CB50/10-3 verificado con un Patrón kilovoltimetro modelo KVM-100 marca Phenix.</div>';
            }
            $html .= '<div class="row" style="font-weight: bold;">4. Condiciones Ambientales:</div>';
            $html .= '<div class="row">Temperatura ambiente: (20 ± 3) ºC / Humedad: (75 ± 5) %</div>';
            $html .= '<div class="row" style="font-weight: bold;">5. Lugar de calibración:</div>';
            $html .= '<div class="row">Laboratorio de alta tensión de Logytec S.A.</div>';
            $html .= '<div class="row" style="font-weight: bold;">6. Conclusión:</div>';
            $html .= '<div class="row">El par de guantes se encuentra en óptimas condiciones de operación según pruebas realizadas.</div>';
            $html .= '<div class="row" style="font-weight: bold;">7. Recomendaciones:</div>';
            $html .= '<div class="row">Se recomienda realizar su próxima verificación en un plazo no mayor a 6 meses.</div>';
            // Añadir tabla para centrar el logo y el texto en la misma línea
            $html .= '<div style="text-align: center; margin-top: 10px;">'; // Contenedor centrado
            $html .= '<table style="margin: 0 auto; border-collapse: collapse; display: inline-block;">';
            $html .= '<tr style="vertical-align: middle; text-align: center;">';
            $html .= '<td style="padding-right: 5px;"><img src="./img/LOGO.png" alt="Firma" style="height: 50px;"></td>';
            $html .= '<td style="padding-left: 5px; text-align: left;"><p style="font-size: 10px; margin: 0;">FERNANDEZ ULFEE<br>WILLIANM EDUARDO<br>' . $f_informe . '</p></td>';
            $html .= '</tr>';
            $html .= '</table>';
            $html .= '</div>';

            // Ajustar espacio y posición del sello
            $html .= '<div style="font-size: 10px; text-align: center; margin-top: 10px; position: relative;">';
            $html .= '<hr style="width: 200px; border: 1px solid black; margin: 5px auto 0 auto;">';
            $html .= '<p style="margin-top: 5px;">Eduardo Fernandez U.<br>Dpto. Calibraciones</p>';
            $html .= '<img src="SELLO_LABORATORIO_PNG.png" alt="Sello" style="position: absolute; right: 0; top: 0; height: 50px;">';
            $html .= '</div>';

            $html .= '</div>'; // Cierra el contenedor
            $mpdf->WriteHTML($html);
            ob_clean();
            $nombre_archivo_pdf =  $n_informe . '-Guante-' . $marca . '-' . $clase . '-' . $empresa . '(M).pdf';
            $mpdf->Output(__DIR__ . '/pdfs/' . $nombre_archivo_pdf, 'F');  // Guarda el PDF en un directorio

            return $nombre_archivo_pdf;
        }
        $pdf_paths = array();
        $serie_fija = array();
        //echo $num_items;
        for ($i = 0; $i < $num_items; $i++) {
            if (!empty($serie_edit[$i])) {
                $serie_fija[] = $serie_edit[$i];
            } else {
                $serie_fija[] = $serie_guante[$i];
            }
            echo $n_informe[$i] . ":" . $otro[$i];
            echo "<br>";
            $pdf_paths[] = GeneroPdf($n_informe[$i], $marca[$i], $clase[$i], $serie_fija[$i], $fecha_informe, $empresa, $longitud[$i], $valor_izq[$i], $valor_der[$i], $otro[$i]);
        }

        // Directorio donde se encuentran los archivos PDF
        $directorio_pdfs = __DIR__ . '/pdfs';

        // Ruta y nombre del archivo ZIP a generar
        $archivo_zip = $id_orden . '_certificados.zip';

        $zip = new ZipArchive();

        if ($zip->open($archivo_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Recorrer los nombres de archivos PDF y agregarlos al ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    $zip->addFile($pdf_ruta, $pdf_nombre);
                } else {
                    echo 'El archivo ' . $pdf_nombre . ' no existe en el directorio.';
                }
            }

            // Cerrar el ZIP
            $zip->close();
            // Eliminar los archivos PDF después de crear el ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    unlink($pdf_ruta);
                }
            }
        } else {
            echo 'No se pudo crear el archivo ZIP.';
        }

        // Mover el archivo ZIP al directorio público
        rename($archivo_zip, __DIR__ . '/pdfs/' . $archivo_zip);
    }
    if ($equipo == "Mantas") {
        //Arrays donde guardare los valores de las consultas
        $marca = array();
        $clase = array();
        $equipo = array();
        $n_informe = array();
        $talla = array();
        $resultado = array();
        $longitud = array();
        $valor_izq = array();
        $valor_der = array();
        $otro = array();
        $serie_guante = array();
        $serie_edit = array();
        $otro = array();
        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_item_m WHERE id_orden = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $marca[] = $row["marca"];
                $clase[] = $row["clase"];
                $equipo[] = $row["equipo"];
                $n_informe[] = $row["n_informe"];
                $talla[] = $row["talla"];
                $resultado[] = $row["resultado"];
                $serie_guante[] = $row["serie_manta"];
                $serie_edit[] = $row["serie_edit"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }

        $num_items = count($n_informe);

        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_dielectrico_m WHERE id = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $empresa = $row["cliente"];
                $fecha_informe = $row["fecha_informe"];
                $humedad = $row["humedad"];
                $temperatura = $row["temperatura"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }


        require("../../vendor/autoload.php");

        function GeneroPdf($equipo, $marca, $clase, $serie, $f_informe, $n_informe, $empresa)
        {

            $clases_tension = [
                "Clase 00" => "2500",
                "Clase 0" => "5000",
                "Clase 1" => "10000",
                "Clase 2" => "20000",
                "Clase 3" => "30000",
                "Clase 4" => "40000"
            ];

            if (isset($clases_tension[$clase])) {
                $tension_prueba = $clases_tension[$clase];
            }


            $mpdf = new \Mpdf\Mpdf();
            ob_start();
            $css = '
                .container {
                    margin-top: 50px;
                    font-size: 14px;
                }
                .row {
                    margin-bottom: 5px;
                }
                .cabecera td{
                vertical-align:top;
                border:0.1mm solid #CCCCCC;
                font-size:9pt; }
                table thead th {
                background-color:#EEEEEE;
                text-align:center;
                border:0.1mm solid #CCCCCC; 
                font-size:9pt; }
                table tbody td {
                text-align:center;
                border:0.1mm dotted #CCCCCC;
                padding:3pt; 
                padding-bottom:8pt; 
                vertical-align:top; 
                font-size:9pt; 
                color:#000000;}';
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

            $mpdf->WriteHTML('
                <htmlpageheader name="myheader">
                <table width="100%">
                <tr><td width="200"><img src="logo.png"  width="180" height="40"></td><td colspan="2" style="color:#000;font-size:9pt" align="right">Formato:Laboratorio de Ensayo<br>P&aacute;gina: {PAGENO} de {nb}<br> </td></tr>
                <tr><td colspan="3" style="font-size:12pt; background-color:#EEEEEE" align="center">Informe de Verificación Nº' . $n_informe . ' </td></tr>
                </table>
                </htmlpageheader>
                <sethtmlpageheader name="myheader" value="on" show-this-page="1">
            ');

            $mpdf->WriteHTML('
                <htmlpagefooter name="myfooter">
                <div style="border-top:1px solid #000000;text-align:center;font-size:8pt;">
                </htmlpagefooter>
            ');

            $mpdf->SetHTMLHeaderByName('myheader');
            $mpdf->SetHTMLFooterByName('myfooter');
            // Genera el contenido del PDF
            $html = '<div class="container">';
            $html .= '<br><br><br><div class="row" style="font-weight: bold;">1. Datos Generales</div>';
            $html .= '<div class="row"><table>
            <tr><td>Equipo:</td><td>' . $equipo . '</td></tr>
            <tr><td>Marca:</td><td>' . $marca . '</td></tr>
            <tr><td>Clase:</td><td>' . $clase . '</td></tr>
            <tr><td>Serie:</td><td>' . $serie . '</td></tr>
            <tr><td>Fecha de verificación:</td><td>' . $f_informe . '</td></tr>
            </table></div>';
            $html .= '<div class="row" style="font-weight: bold;">2. Metodo de Verificación</div>';
            $html .= '<div class="row">Inspección visual y rigidez dieléctrica en conformidad con norma técnica ASTM-F496.</div>';
            $html .= '<div class="row" style="font-weight: bold;">3. Resultado de Pruebas de verificación</div>';
            $html .= '<div class="row" style="font-weight: bold;">3.1. Inspección Preliminar: APTO[X] NO APTO []</div>';


            $html .= '<div class="row" style="font-weight: bold;">3.2. Verificación de rigidez dieléctrica</div>';
            $html .= '<div class="row"><table class="tg">
                <thead>
                <tr>
                    <th class="tg-uqo3">CLASE</th>
                    <th class="tg-uqo3">TENSION DE PRUEBA (AC)</th>
                    <th class="tg-uqo3">RESULTADO (APTO / NO APTO)</th>
                    
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tg-c3ow">' . $clase . '</td>
                    <td class="tg-c3ow">' . $tension_prueba . '</td>
                    <td class="tg-c3ow">APTO</td>
                    
                </tr>
                </tbody>
                </table></div>';
            $html .= '<div class="row">Nota: Para las pruebas de verificación dieléctrica, se utilizó un generador de alto voltaje marca Phenix modelo
                6CB50/10-3 verificado con un Patrón kilovoltimetro modelo KVM-100 marca Phenix.</div>';

            $html .= '<div class="row" style="font-weight: bold;">4. Condiciones Ambientales:</div>';
            $html .= '<div class="row">Temperatura ambiente: (20 ± 3) ºC / Humedad: (75 ± 5) %</div>';
            $html .= '<div class="row" style="font-weight: bold;">5. Lugar de calibración:</div>';
            $html .= '<div class="row">Laboratorio de alta tensión de Logytec S.A.</div>';
            $html .= '<div class="row" style="font-weight: bold;">6. Conclusión:</div>';
            $html .= '<div class="row">La manta se encuentra en óptimas condiciones de operación según pruebas realizadas.</div>';
            $html .= '<div class="row" style="font-weight: bold;">7. Recomendaciones:</div>';
            $html .= '<div class="row">Se recomienda realizar su próxima verificación en un plazo no mayor a 1 año.</div>';
            $html .= '<p><p><p><p><table align ="center">
                    <tr><td></td></tr><td><img src="SELLO_LABORATORIO_PNG.png"></td>
                    <tr><td style="border-top:0.1pt solid #000000 ">Eduardo Fernandez U.</td></tr>
                    </table>';

            $html .= '</div>'; // Cierra el contenedor
            $mpdf->WriteHTML($html);
            ob_clean();
            $nombre_archivo_pdf =  $n_informe . '-Manta-' . $marca . '-' . $clase . '-' . $empresa . '(M).pdf';
            $mpdf->Output(__DIR__ . '/pdfs/' . $nombre_archivo_pdf, 'F');  // Guarda el PDF en un directorio

            return $nombre_archivo_pdf;
        }
        $pdf_paths = array();
        $serie_fija = array();
        //echo $num_items;
        for ($i = 0; $i < $num_items; $i++) {
            if (!empty($serie_edit[$i])) {
                $serie_fija[] = $serie_edit[$i];
            } else {
                $serie_fija[] = $serie_guante[$i];
            }
            echo $n_informe[$i] . ":" . $otro[$i];
            echo "<br>";
            $pdf_paths[] = GeneroPdf($talla[$i], $marca[$i], $clase[$i], $serie_fija[$i], $fecha_informe, $n_informe[$i], $empresa,);
        }

        // Directorio donde se encuentran los archivos PDF
        $directorio_pdfs = __DIR__ . '/pdfs';

        // Ruta y nombre del archivo ZIP a generar
        $archivo_zip = $id_orden . '_certificados.zip';

        $zip = new ZipArchive();

        if ($zip->open($archivo_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Recorrer los nombres de archivos PDF y agregarlos al ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    $zip->addFile($pdf_ruta, $pdf_nombre);
                } else {
                    echo 'El archivo ' . $pdf_nombre . ' no existe en el directorio.';
                }
            }

            // Cerrar el ZIP
            $zip->close();
            // Eliminar los archivos PDF después de crear el ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    unlink($pdf_ruta);
                }
            }
        } else {
            echo 'No se pudo crear el archivo ZIP.';
        }

        // Mover el archivo ZIP al directorio público
        rename($archivo_zip, __DIR__ . '/pdfs/' . $archivo_zip);
    }
    if ($equipo == "Banquetas") { //Arrays donde guardare los valores de las consultas
        $marca = array();
        $clase = array();
        $equipo = array();
        $n_informe = array();
        $talla = array();
        $resultado = array();
        $otro = array();
        $serie_banqueta = array();
        $serie_edit = array();
        $otro = array();
        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_item_m WHERE id_orden = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $marca[] = $row["marca"];
                $clase[] = $row["clase"];
                $equipo[] = $row["equipo"];
                $n_informe[] = $row["n_informe"];
                $talla[] = $row["talla"];
                $resultado[] = $row["resultado"];
                $serie_guante[] = $row["serie_banqueta"];
                $serie_edit[] = $row["serie_edit"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }

        $num_items = count($n_informe);

        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_dielectrico_m WHERE id = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $empresa = $row["cliente"];
                $fecha_informe = $row["fecha_informe"];
                $humedad = $row["humedad"];
                $temperatura = $row["temperatura"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }


        require("../../vendor/autoload.php");

        function GeneroPdf($talla, $equipo, $marca, $clase, $serie, $f_informe, $n_informe, $empresa)
        {

            $clases_tension = [
                "Clase 00" => "2500",
                "Clase 0" => "5000",
                "Clase 1" => "10000",
                "Clase 2" => "20000",
                "Clase 3" => "30000",
                "Clase 4" => "40000"
            ];

            if (isset($clases_tension[$clase])) {
                $tension_prueba = $clases_tension[$clase];
            }


            $mpdf = new \Mpdf\Mpdf();
            ob_start();
            $css = '
                .container {
                    margin-top: 50px;
                    font-size: 14px;
                }
                .row {
                    margin-bottom: 5px;
                }
                .cabecera td{
                vertical-align:top;
                border:0.1mm solid #CCCCCC;
                font-size:9pt; }
                table thead th {
                background-color:#EEEEEE;
                text-align:center;
                border:0.1mm solid #CCCCCC; 
                font-size:9pt; }
                table tbody td {
                text-align:center;
                border:0.1mm dotted #CCCCCC;
                padding:3pt; 
                padding-bottom:8pt; 
                vertical-align:top; 
                font-size:9pt; 
                color:#000000;}';
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

            $mpdf->WriteHTML('
                <htmlpageheader name="myheader">
                <table width="100%">
                <tr><td width="200"><img src="logo.png"  width="180" height="40"></td><td colspan="2" style="color:#000;font-size:9pt" align="right">Formato:Laboratorio de Ensayo<br>P&aacute;gina: {PAGENO} de {nb}<br> </td></tr>
                <tr><td colspan="3" align="center">Informe de Verificación Nº' . $n_informe . ' </td></tr>
                </table>
                </htmlpageheader>
                <sethtmlpageheader name="myheader" value="on" show-this-page="1">
            ');

            $mpdf->WriteHTML('
                <htmlpagefooter name="myfooter">
                <div style="border-top:1px solid #000000;text-align:center;font-size:8pt;">
                </htmlpagefooter>
            ');

            $mpdf->SetHTMLHeaderByName('myheader');
            $mpdf->SetHTMLFooterByName('myfooter');
            // Genera el contenido del PDF
            $html = '<div class="container">';
            $html .= '<br><br><br><div class="row" style="font-weight: bold;">1. Datos Generales</div>';
            $html .= '<div class="row"><table>
            <tr><td>Equipo:</td><td>' . $equipo . '</td></tr>
            <tr><td>Marca:</td><td>' . $marca . '</td></tr>
            <tr><td>Clase:</td><td>' . $clase . '</td></tr>
            <tr><td>Serie:</td><td>' . $serie . '</td></tr>
            <tr><td>Fecha de verificación:</td><td>' . $f_informe . '</td></tr>
            </table></div>';
            $html .= '<div class="row" style="font-weight: bold;">2. Metodo de Verificación</div>';
            $html .= '<div class="row">Inspección visual y rigidez dieléctrica en conformidad con norma técnica UNE-204001.</div>';
            $html .= '<div class="row" style="font-weight: bold;">3. Resultado de Pruebas de verificación</div>';
            $html .= '<div class="row" style="font-weight: bold;">3.1. Inspección Preliminar: APTO[X] NO APTO []</div>';


            $html .= '<div class="row" style="font-weight: bold;">3.2. Verificación de rigidez dieléctrica</div>';
            $html .= '<div class="row"><table class="tg">
                <thead>
                <tr>
                    <th class="tg-uqo3">CLASE</th>
                    <th class="tg-uqo3">TENSION DE PRUEBA (AC)</th>
                    <th class="tg-uqo3">CORRIENTE MAXIMA (mA)</th>
                    <th class="tg-uqo3">CORRIENTE MEDIDA (mA)</th>
                    <th class="tg-uqo3">RESULTADO (APTO / NO APTO)</th>
                    
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tg-c3ow">' . $clase . '</td>
                    <td class="tg-c3ow">' . $tension_prueba . '</td>
                    <td class="tg-c3ow">2</td>
                    <td class="tg-c3ow">' . $talla . '</td>
                    <td class="tg-c3ow">APTO</td>
                    
                </tr>
                </tbody>
                </table></div>';
            $html .= '<div class="row">Nota: Para las pruebas de verificación dieléctrica, se utilizó un generador de alto voltaje marca Phenix modelo
                6CB50/10-3 verificado con un Patrón kilovoltimetro modelo KVM-100 marca Phenix.</div>';

            $html .= '<div class="row" style="font-weight: bold;">4. Condiciones Ambientales:</div>';
            $html .= '<div class="row">Temperatura ambiente: (20 ± 3) ºC / Humedad: (75 ± 5) %</div>';
            $html .= '<div class="row" style="font-weight: bold;">5. Lugar de calibración:</div>';
            $html .= '<div class="row">Laboratorio de alta tensión de Logytec S.A.</div>';
            $html .= '<div class="row" style="font-weight: bold;">6. Conclusión:</div>';
            $html .= '<div class="row">La Banqueta se encuentra en óptimas condiciones de operación según pruebas realizadas.</div>';
            $html .= '<div class="row" style="font-weight: bold;">7. Recomendaciones:</div>';
            $html .= '<div class="row">Se recomienda realizar su próxima verificación en un plazo no mayor a 1 año.</div>';
            $html .= '<p><p><p><p><table align ="center">
                    <tr><td></td></tr><td><img src="SELLO_LABORATORIO_PNG.png"></td>
                    <tr><td style="border-top:0.1pt solid #000000 ">Eduardo Fernandez U.</td></tr>
                    </table>';

            $html .= '</div>'; // Cierra el contenedor
            $mpdf->WriteHTML($html);
            ob_clean();
            $nombre_archivo_pdf =  $n_informe . '-Banqueta-' . $marca . '-' . $clase . '-' . $empresa . '(M).pdf';
            $mpdf->Output(__DIR__ . '/pdfs/' . $nombre_archivo_pdf, 'F');  // Guarda el PDF en un directorio

            return $nombre_archivo_pdf;
        }
        $pdf_paths = array();
        $serie_fija = array();
        //echo $num_items;
        for ($i = 0; $i < $num_items; $i++) {
            if (!empty($serie_edit[$i])) {
                $serie_fija[] = $serie_edit[$i];
            } else {
                $serie_fija[] = $serie_guante[$i];
            }
            echo $n_informe[$i] . ":" . $otro[$i];
            echo "<br>";
            $pdf_paths[] = GeneroPdf($talla[$i], $equipo[$i], $marca[$i], $clase[$i], $serie_fija[$i], $fecha_informe, $n_informe[$i], $empresa);
        }

        // Directorio donde se encuentran los archivos PDF
        $directorio_pdfs = __DIR__ . '/pdfs';

        // Ruta y nombre del archivo ZIP a generar
        $archivo_zip = $id_orden . '_certificados.zip';

        $zip = new ZipArchive();

        if ($zip->open($archivo_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Recorrer los nombres de archivos PDF y agregarlos al ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    $zip->addFile($pdf_ruta, $pdf_nombre);
                } else {
                    echo 'El archivo ' . $pdf_nombre . ' no existe en el directorio.';
                }
            }

            // Cerrar el ZIP
            $zip->close();
            // Eliminar los archivos PDF después de crear el ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    unlink($pdf_ruta);
                }
            }
        } else {
            echo 'No se pudo crear el archivo ZIP.';
        }

        // Mover el archivo ZIP al directorio público
        rename($archivo_zip, __DIR__ . '/pdfs/' . $archivo_zip);
    }
    if ($equipo == "Pertigas") {

        error_log("ID Orden: $id_orden");
        error_log("Equipo: $equipo");
        error_log("Función: $funcion");
        var_dump($id_orden, $equipo, $funcion);
        error_log("Iniciando generación de PDFs");

        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_item_m WHERE id_orden = $id_orden";
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            $marca = [];
            $clase = [];
            $equipo_array = [];
            $n_informe = [];
            $talla = [];
            $resultado = [];
            $serie_pertiga = [];
            $serie_edit = [];

            while ($row = $result->fetch_assoc()) {
                $marca[] = $row["marca"];
                $clase[] = $row["clase"];
                $equipo_array[] = $row["equipo"];
                $n_informe[] = $row["n_informe"];
                $talla[] = $row["talla"];
                $resultado[] = $row["resultado"];
                $serie_pertiga[] = $row["serie_pertiga"];
                $serie_edit[] = $row["serie_edit"];

                error_log("ID Orden: " . $row["marca"]);
                error_log("Equipo: " . $row["clase"]);
                error_log("Función: " . $row["talla"]);
                var_dump($marca, $clase, $talla);
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }

        $num_items = count($n_informe);

        // Consulta SQL para obtener los valores de la tabla "orden_dielectrico_m"
        $sql = "SELECT * FROM orden_dielectrico_m WHERE id = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $empresa = $row["cliente"];
                $fecha_informe = $row["fecha_informe"];
                $humedad = $row["humedad"];
                $temperatura = $row["temperatura"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }

        require("../../vendor/autoload.php");

        function GeneroPdf($talla, $equipo, $marca, $clase, $serie, $f_informe, $n_informe, $empresa)
        {
            $mpdf = new \Mpdf\Mpdf();
            ob_start();
            $css = '
                .container {
                    margin-top: 50px;
                    font-size: 14px;
                }
                .row {
                    margin-bottom: 5px;
                }
                .cabecera td{
                vertical-align:top;
                border:0.1mm solid #CCCCCC;
                font-size:9pt; }
                table thead th {
                background-color:#EEEEEE;
                text-align:center;
                border:0.1mm solid #CCCCCC; 
                font-size:9pt; }
                table tbody td {
                text-align:center;
                border:0.1mm dotted #CCCCCC;
                padding:3pt; 
                padding-bottom:8pt; 
                vertical-align:top; 
                font-size:9pt; 
                color:#000000;}';
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

            $mpdf->WriteHTML('
                <htmlpageheader name="myheader">
                <table width="100%">
                <tr><td width="200"><img src="logo.png"  width="180" height="40"></td><td colspan="2" style="color:#000;font-size:9pt" align="right">Formato:Laboratorio de Ensayo<br>P&aacute;gina: {PAGENO} de {nb}<br> </td></tr>
                <tr><td colspan="3" align="center">Informe de Verificación Nº' . $n_informe . ' </td></tr>
                </table>
                </htmlpageheader>
                <sethtmlpageheader name="myheader" value="on" show-this-page="1">
            ');

            $mpdf->WriteHTML('
                <htmlpagefooter name="myfooter">
                <div style="border-top:1px solid #000000;text-align:center;font-size:8pt;">
                </htmlpagefooter>
            ');

            $mpdf->SetHTMLHeaderByName('myheader');
            $mpdf->SetHTMLFooterByName('myfooter');
            $html = '<div class="container">';
            $html .= '<br><br><br><div class="row" style="font-weight: bold;">1. Datos Generales</div>';
            $html .= '<div class="row"><table>
            <tr><td>Equipo:</td><td>' . $equipo . '</td></tr>
            <tr><td>Marca:</td><td>' . $marca . '</td></tr>
            <tr><td>Clase:</td><td>' . $clase . '</td></tr>
            <tr><td>Serie:</td><td>' . $serie . '</td></tr>
            <tr><td>Fecha de verificación:</td><td>' . $f_informe . '</td></tr>
            </table></div>';
            $html .= '<div class="row" style="font-weight: bold;">2. Metodo de ensayo</div>';
            $html .= '<div class="row">Ensayo realizado en conformidad al procedimiento de ensayo interno del laboratorio Logytec documentoPCL037 
            Utilizando probadores de Rigidez dieléctrica de Pértigas, y en las recomendaciones de la norma ISO/IEC17025.</div>';
            $html .= '<div class="row" style="font-weight: bold;">3. Observaciones</div>';
            $html .= '<div class="row">Las pruebas fueron realizadas con un equipo probador de pértiga de la marca Ritz, que consiste en generar
            una tensión de 1.8 kV AC a una alta frecuencia, se probó la rigidez dieléctrica cada 30 cm, verificando que el
            probador muestre aprobado en su indicador analógico. Antes de realizar las pruebas el equipo probador fue
            verificado con el bastón de calibración incluido en el instrumento.</div>';
            $html .= '<div class="row" style="font-weight: bold;">4. Resultado del ensayo:</div>';
            $html .= '<table>
                <thead><tr><th>Pertiga</th><th>Estado físico</th><th>Resultado del ensayo</th><th>Resultado final</th></tr></thead>';

            for ($i = 0; $i < $talla; $i++) {
                $html .= '<tbody><tr><td>Cuerpo ' . $i . '</td><td>Aprobado</td><td>Aprobado</td><td>Aprobado</td></tr>';
            }

            $html .= '</table>';

            $html .= '</div>';
            $html .= '<div class="row" style="font-weight: bold;">5. Conclusión:</div>';
            $html .= '<div class="row">La Banqueta se encuentra en óptimas condiciones de operación según pruebas realizadas.</div>';
            $html .= '<p><p><p><p><table align ="center">
            <tr><td></td></tr><td><img src="SELLO_LABORATORIO_PNG.png"></td>
            <tr><td style="border-top:0.1pt solid #000000 ">Eduardo Fernandez U.</td></tr>
            </table>';

            $html .= '</div>'; // Cierra el contenedor
            $mpdf->WriteHTML($html);
            ob_clean();
            $nombre_archivo_pdf =  $n_informe . '-Pertiga-' . $marca . '-' . $empresa . '(M).pdf';

            $mpdf->Output(__DIR__ . '/pdfs/' . $nombre_archivo_pdf, 'F');  // Guarda el PDF en un directorio

            return $nombre_archivo_pdf;
        }

        $pdf_paths = [];
        $serie_fija = [];

        for ($i = 0; $i < $num_items; $i++) {
            if (!empty($serie_edit[$i])) {
                $serie_fija[] = $serie_edit[$i];
            } else {
                $serie_fija[] = $serie_pertiga[$i];
            }
            echo $n_informe[$i];
            echo "<br>";
            $pdf_paths[] = GeneroPdf($talla[$i], $equipo_array[$i], $marca[$i], $clase[$i], $serie_fija[$i], $fecha_informe, $n_informe[$i], $empresa);
        }

        // Directorio donde se encuentran los archivos PDF
        $directorio_pdfs = __DIR__ . '/pdfs';

        // Ruta y nombre del archivo ZIP a generar
        $archivo_zip = $id_orden . '_certificados.zip';

        $zip = new ZipArchive();

        if ($zip->open($archivo_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Recorrer los nombres de archivos PDF y agregarlos al ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    $zip->addFile($pdf_ruta, $pdf_nombre);
                } else {
                    echo 'El archivo ' . $pdf_nombre . ' no existe en el directorio.';
                }
            }

            // Cerrar el ZIP
            $zip->close();
            // Eliminar los archivos PDF después de crear el ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    unlink($pdf_ruta);
                }
            }
        } else {
            echo 'No se pudo crear el archivo ZIP.';
        }

        // Mover el archivo ZIP al directorio público
        rename($archivo_zip, __DIR__ . '/pdfs/' . $archivo_zip);
    }
    if ($equipo == "Mangas") {

        //Arrays donde guardare los valores de las consultas
        $marca = array();
        $clase = array();
        $equipo = array();
        $n_informe = array();
        $talla = array();
        $resultado = array();
        $longitud = array();
        $valor_izq = array();
        $valor_der = array();
        $otro = array();
        $serie_guante = array();
        $serie_edit = array();
        $otro = array();
        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_item_m WHERE id_orden = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $marca[] = $row["marca"];
                $clase[] = $row["clase"];
                $equipo[] = $row["equipo"];
                $n_informe[] = $row["n_informe"];
                $talla[] = $row["talla"];
                $resultado[] = $row["resultado"];
                $longitud[] = $row["longitud"];
                $valor_izq[] = $row["valor_izq"];
                $valor_der[] = $row["valor_der"];
                $otro[] = $row["otro"];
                $serie_guante[] = $row["serie_guante"];
                $serie_edit[] = $row["serie_edit"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }

        $num_items = count($n_informe);

        // Consulta SQL para obtener los valores de la tabla "orden_item_m"
        $sql = "SELECT * FROM orden_dielectrico_m WHERE id = $id_orden";

        // Ejecutar la consulta
        $result = $conexion->query($sql);

        // Verificar si se encontraron filas
        if ($result->num_rows > 0) {
            // Recorrer las filas y guardar los valores en variables
            while ($row = $result->fetch_assoc()) {
                $empresa = $row["cliente"];
                $fecha_informe = $row["fecha_informe"];
                $humedad = $row["humedad"];
                $temperatura = $row["temperatura"];

                // Puedes continuar de la misma manera para otras columnas que necesites
            }
        } else {
            echo "No se encontraron resultados para id_orden = $id_orden";
        }


        require("../../vendor/autoload.php");

        function GeneroPdf($n_informe, $marca, $clase, $serie, $f_informe, $empresa, $longitud, $valor_izq, $valor_der, $otro)
        {
            $combinaciones = [
                "Clase 00" => [
                    "280" => ["corriente" => "8", "tension" => "2.50 KV"],
                    "360" => ["corriente" => "12", "tension" => "2.50 KV"],
                ],
                "Clase 0" => [
                    "280" => ["corriente" => "8", "tension" => "5.00 KV"],
                    "360" => ["corriente" => "12", "tension" => "5.00 KV"],
                    "410" => ["corriente" => "14", "tension" => "5.00 KV"],
                    "460" => ["corriente" => "16", "tension" => "5.00 KV"],
                ],
                "Clase 1" => [
                    "360" => ["corriente" => "14", "tension" => "10.0 KV"],
                    "410" => ["corriente" => "16", "tension" => "10.0 KV"],
                    "460" => ["corriente" => "18", "tension" => "10.0 KV"],
                ],
                "Clase 2" => [
                    "360" => ["corriente" => "16", "tension" => "20.0 KV"],
                    "410" => ["corriente" => "18", "tension" => "20.0 KV"],
                    "460" => ["corriente" => "20", "tension" => "20.0 KV"],
                ],
                "Clase 3" => [
                    "360" => ["corriente" => "18", "tension" => "30.0 KV"],
                    "410" => ["corriente" => "20", "tension" => "30.0 KV"],
                    "460" => ["corriente" => "22", "tension" => "30.0 KV"],
                ],
                "Clase 4" => [
                    "410" => ["corriente" => "22", "tension" => "40.0 KV"],
                    "460" => ["corriente" => "24", "tension" => "40.0 KV"],
                ],
            ];

            if (isset($combinaciones[$clase][$longitud])) {
                $corriente = $combinaciones[$clase][$longitud]["corriente"];
                $tension = $combinaciones[$clase][$longitud]["tension"];
            }


            $mpdf = new \Mpdf\Mpdf();
            ob_start();
            $css = '
                .container {
                    margin-top: 50px;
                    font-size: 14px;
                }
                .row {
                    margin-bottom: 5px;
                }
                .cabecera td{
                vertical-align:top;
                border:0.1mm solid #CCCCCC;
                font-size:9pt; }
                table thead th {
                background-color:#EEEEEE;
                text-align:center;
                border:0.1mm solid #CCCCCC; 
                font-size:9pt; }
                table tbody td {
                text-align:center;
                border:0.1mm dotted #CCCCCC;
                padding:3pt; 
                padding-bottom:8pt; 
                vertical-align:top; 
                font-size:9pt; 
                color:#000000;}';
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

            $mpdf->WriteHTML('
                <htmlpageheader name="myheader">
                <table width="100%">
                <tr><td width="200"><img src="logo.png"  width="180" height="40"></td><td colspan="2" style="color:#000;font-size:9pt" align="right">Formato:Laboratorio de Ensayo<br>P&aacute;gina: {PAGENO} de {nb}<br> </td></tr>
                <tr><td colspan="3" style="font-size:12pt; background-color:#EEEEEE" align="center">Informe de Verificación Nº' . $n_informe . ' </td></tr>
                </table>
                </htmlpageheader>
                <sethtmlpageheader name="myheader" value="on" show-this-page="1">
            ');

            $mpdf->WriteHTML('
                <htmlpagefooter name="myfooter">
                <div style="border-top:1px solid #000000;text-align:center;font-size:8pt;">
                </htmlpagefooter>
            ');

            $mpdf->SetHTMLHeaderByName('myheader');
            $mpdf->SetHTMLFooterByName('myfooter');
            // Genera el contenido del PDF
            $html = '<div class="container">';
            $html .= '<br><br><br><div class="row" style="font-weight: bold;">1. Datos Generales</div>';
            $html .= '<div class="row"><table>
            <tr><td>Equipo:</td><td>Guante dieléctrico</td></tr>
            <tr><td>Marca:</td><td>' . $marca . '</td></tr>
            <tr><td>Clase:</td><td>' . $clase . '</td></tr>
            <tr><td>Serie:</td><td>' . $serie . '</td></tr>
            <tr><td>Fecha de verificación:</td><td>' . $f_informe . '</td></tr>
            </table></div>';
            $html .= '<div class="row" style="font-weight: bold;">2. Metodo de Verificación</div>';
            $html .= '<div class="row">Inspección visual y rigidez dieléctrica en conformidad con norma técnica ASTM-F496.</div>';
            $html .= '<div class="row" style="font-weight: bold;">3. Resultado de Pruebas de verificación</div>';
            $html .= '<div class="row" style="font-weight: bold;">3.1. Inspección Preliminar</div>';
            $html .= '<div class="row"><table class="tg">
            <thead>
              <tr>
                <th class="tg-uqo3">Lado</th>
                <th class="tg-uqo3">Estado Físico</th>
                <th class="tg-uqo3">Con Inflador</th>
                <th class="tg-uqo3">Estado Físico</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>IZQ</td>
                <td>OK</td>
                <td>OK</td>
                <td>APTO</td>
              </tr>
              <tr>
                <td>DER</td>
                <td>OK</td>
                <td>OK</td>
                <td>APTO</td>
              </tr>
            </tbody>
            </table></div>';
            if ($otro == "Inflado") {
                $html .= '<div class="row">Nota: Para las pruebas de inflado, se utilizó probador de guantes marca Salisbury modelo G100.</div>';
            } else {
                $html .= '<div class="row" style="font-weight: bold;">3.2. Verificación de rigidez dieléctrica</div>';
                $html .= '<div class="row"><table class="tg">
                <thead>
                <tr>
                    <th class="tg-uqo3">Lado</th>
                    <th class="tg-uqo3">Clase</th>
                    <th class="tg-uqo3">Tensión de Prueba (AC)</th>
                    <th class="tg-uqo3">Corriente Máxima (mA)</th>
                    <th class="tg-uqo3">Corriente Medida (mA)</th>
                    <th class="tg-uqo3">Resultado</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="tg-c3ow">IZQ</td>
                    <td class="tg-c3ow">' . $clase . '</td>
                    <td class="tg-c3ow">' . $tension . '</td>
                    <td class="tg-c3ow">' . $corriente . '</td>
                    <td class="tg-baqh">' . $valor_izq . '</td>
                    <td class="tg-baqh">APTO</td>
                </tr>
                <tr>
                    <td class="tg-c3ow">DER</td>
                    <td class="tg-c3ow">' . $clase . '</td>
                    <td class="tg-c3ow">' . $tension . '</td>
                    <td class="tg-c3ow">' . $corriente . '</td>
                    <td class="tg-baqh">' . $valor_der . '</td>
                    <td class="tg-baqh">APTO</td>
                </tr>
                </tbody>
                </table></div>';
                $html .= '<div class="row">Nota: Para las pruebas de verificación dieléctrica, se utilizó un generador de alto voltaje marca Phenix modelo
                6CB50/10-3 verificado con un Patrón kilovoltimetro modelo KVM-100 marca Phenix.</div>';
            }
            $html .= '<div class="row" style="font-weight: bold;">4. Condiciones Ambientales:</div>';
            $html .= '<div class="row">Temperatura ambiente: (20 ± 3) ºC / Humedad: (75 ± 5) %</div>';
            $html .= '<div class="row" style="font-weight: bold;">5. Lugar de calibración:</div>';
            $html .= '<div class="row">Laboratorio de alta tensión de Logytec S.A.</div>';
            $html .= '<div class="row" style="font-weight: bold;">6. Conclusión:</div>';
            $html .= '<div class="row">El par de guantes se encuentra en óptimas condiciones de operación según pruebas realizadas.</div>';
            $html .= '<div class="row" style="font-weight: bold;">7. Recomendaciones:</div>';
            $html .= '<div class="row">Se recomienda realizar su próxima verificación en un plazo no mayor a 6 meses.</div>';
            $html .= '<p><p><p><p><table align ="center">
                    <tr><td></td></tr><td><img src="SELLO_LABORATORIO_PNG.png"></td>
                    <tr><td style="border-top:0.1pt solid #000000 ">Eduardo Fernandez U.</td></tr>
                    </table>';

            $html .= '</div>'; // Cierra el contenedor
            $mpdf->WriteHTML($html);
            ob_clean();
            $nombre_archivo_pdf =  $n_informe . '-Guante-' . $marca . '-' . $clase . '-' . $empresa . '(M).pdf';
            $mpdf->Output(__DIR__ . '/pdfs/' . $nombre_archivo_pdf, 'F');  // Guarda el PDF en un directorio

            return $nombre_archivo_pdf;
        }
        $pdf_paths = array();
        $serie_fija = array();
        //echo $num_items;
        for ($i = 0; $i < $num_items; $i++) {
            if (!empty($serie_edit[$i])) {
                $serie_fija[] = $serie_edit[$i];
            } else {
                $serie_fija[] = $serie_guante[$i];
            }
            echo $n_informe[$i] . ":" . $otro[$i];
            echo "<br>";
            $pdf_paths[] = GeneroPdf($n_informe[$i], $marca[$i], $clase[$i], $serie_fija[$i], $fecha_informe, $empresa, $longitud[$i], $valor_izq[$i], $valor_der[$i], $otro[$i]);
        }

        // Directorio donde se encuentran los archivos PDF
        $directorio_pdfs = __DIR__ . '/pdfs';

        // Ruta y nombre del archivo ZIP a generar
        $archivo_zip = $id_orden . '_certificados.zip';

        $zip = new ZipArchive();

        if ($zip->open($archivo_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Recorrer los nombres de archivos PDF y agregarlos al ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    $zip->addFile($pdf_ruta, $pdf_nombre);
                } else {
                    echo 'El archivo ' . $pdf_nombre . ' no existe en el directorio.';
                }
            }

            // Cerrar el ZIP
            $zip->close();
            // Eliminar los archivos PDF después de crear el ZIP
            foreach ($pdf_paths as $pdf_nombre) {
                $pdf_ruta = $directorio_pdfs . '/' . $pdf_nombre;
                if (file_exists($pdf_ruta)) {
                    unlink($pdf_ruta);
                }
            }
        } else {
            echo 'No se pudo crear el archivo ZIP.';
        }

        // Mover el archivo ZIP al directorio público
        rename($archivo_zip, __DIR__ . '/pdfs/' . $archivo_zip);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' and $funcion == "observacion") {
    $id_orden = $_POST["id_orden"];
    $id_item = $_POST["id_item"];
    $obs = $_POST["obs"];

    $consultaUpdate = "UPDATE orden_item_m SET obs = '$obs' WHERE id = '$id_item'";
    if (mysqli_query($conexion, $consultaUpdate)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conexion);
    }

    header("Location:orden.php?id=$id_orden");
}
