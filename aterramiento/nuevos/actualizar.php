<?php
include 'conexion.php'; // Asegúrate de que este archivo define $conexion

// Verifica si se ha enviado una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener valores de los campos del formulario
    $id = $_POST['id'];
    $MLinea = $_POST['MLineaphp'] ?? null;
    $LongitudA = $_POST['LongitudAphp'] ?? null;
    $SeccionA = $_POST['SeccionAphp'] ?? null;
    $TLinea = $_POST['TLineaphp'] ?? null;
    $LongitudX = $_POST['LongitudXphp'] ?? null;
    $SeccionX = $_POST['SeccionXphp'] ?? null;
    $TerminalX = $_POST['TerminalXphp'] ?? null;
    $MTierra = $_POST['MTierraphp'] ?? null;
    $LongitudB = $_POST['LongitudBphp'] ?? null;
    $SeccionB = $_POST['SeccionBphp'] ?? null;
    $TTierra = $_POST['TTierraphp'] ?? null;
    $Pertiga = $_POST['Pertigaphp'] ?? null;
    $Adaptador = $_POST['Adaptadorphp'] ?? null;
    $Varilla = $_POST['Varillaphp'] ?? null;
    $Trifurcacion = $_POST['Trifurcacionphp'] ?? null;
    $Otros = $_POST['Otrosphp'] ?? null;
    $EstChico = $_POST['EstChico'] ?? null;
    $EstGrande = $_POST['EstGrande'] ?? null;
    $EstMetalico = $_POST['EstMetalico'] ?? null;
    $EstPertiga = $_POST['EstPertiga'] ?? null;

    // Sanitize inputs
    $id = mysqli_real_escape_string($conexion, $id);
    $MLinea = mysqli_real_escape_string($conexion, $MLinea);
    $LongitudA = mysqli_real_escape_string($conexion, $LongitudA);
    $SeccionA = mysqli_real_escape_string($conexion, $SeccionA);
    $TLinea = mysqli_real_escape_string($conexion, $TLinea);
    $LongitudX = mysqli_real_escape_string($conexion, $LongitudX);
    $SeccionX = mysqli_real_escape_string($conexion, $SeccionX);
    $TerminalX = mysqli_real_escape_string($conexion, $TerminalX);
    $MTierra = mysqli_real_escape_string($conexion, $MTierra);
    $LongitudB = mysqli_real_escape_string($conexion, $LongitudB);
    $SeccionB = mysqli_real_escape_string($conexion, $SeccionB);
    $TTierra = mysqli_real_escape_string($conexion, $TTierra);
    $Pertiga = mysqli_real_escape_string($conexion, $Pertiga);
    $Adaptador = mysqli_real_escape_string($conexion, $Adaptador);
    $Varilla = mysqli_real_escape_string($conexion, $Varilla);
    $Trifurcacion = mysqli_real_escape_string($conexion, $Trifurcacion);
    $Otros = mysqli_real_escape_string($conexion, $Otros);
    $EstChico = mysqli_real_escape_string($conexion, $EstChico);
    $EstGrande = mysqli_real_escape_string($conexion, $EstGrande);
    $EstMetalico = mysqli_real_escape_string($conexion, $EstMetalico);
    $EstPertiga = mysqli_real_escape_string($conexion, $EstPertiga);

    // Definir el valor de TipoAterra
    $query_tipo_aterra = "SELECT TipoAterra FROM ordaterra WHERE idOrdAterra = '$id'";
    $result_tipo_aterra = mysqli_query($conexion, $query_tipo_aterra);

    if ($row_tipo_aterra = mysqli_fetch_assoc($result_tipo_aterra)) {
        $aterra = $row_tipo_aterra['TipoAterra'];

        // Definir LongitudTotal
        if ($aterra === 'ENA') {
            $LongitudTotal = "$LongitudA|$LongitudA|$LongitudB";
        } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
            $LongitudTotal = "$LongitudA";
        } elseif (in_array($aterra, ['P03'])) {
            $LongitudTotal = ($LongitudA + $LongitudB) . '|' . ($LongitudA + $LongitudB) . '|' . ($LongitudA + $LongitudB);
        } elseif (in_array($aterra, ['PEL'])) {
            $LongitudTotal = "$LongitudB|$LongitudB|$LongitudB";
        } elseif (in_array($aterra, ['TRA', 'TPF'])) {
            $LongitudTotal = "$LongitudA|$LongitudB";
        } elseif (in_array($aterra, ['U03', 'UPF'])) {
            $LongitudTotal = "$LongitudA|$LongitudA|$LongitudA";
        } elseif (in_array($aterra, ['USA'])) {
            $LongitudTotal = "$LongitudA|$LongitudB|$LongitudX";
        } elseif (in_array($aterra, ['UMT'])) {
            $LongitudTotal = "$LongitudA|$LongitudA|$LongitudB";
        } else {
            $LongitudTotal = 0;
        }

        // Definir CorrienteAplicada
        $corrienteMap = [
            25 => 150,
            35 => 200,
            50 => 250,
            70 => 300,
            95 => 400,
        ];

        if ($aterra === 'ENA') {
            $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
            $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaA|$CorrienteAplicadaB";
        } elseif (in_array($aterra, ['EXT', 'JUM', 'PDE', 'U01', 'UPV'])) {
            $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaA";
        } elseif (in_array($aterra, ['P03', 'PEL'])) {
            $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaB|$CorrienteAplicadaB|$CorrienteAplicadaB";
        } elseif (in_array($aterra, ['TRA', 'TPF'])) {
            $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
            $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaB";
        } elseif (in_array($aterra, ['U03', 'UPF'])) {
            $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaA|$CorrienteAplicadaA";
        } elseif (in_array($aterra, ['USA'])) {
            $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
            $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
            $CorrienteAplicadaX = isset($corrienteMap[$SeccionX]) ? $corrienteMap[$SeccionX] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaB|$CorrienteAplicadaX";
        } elseif (in_array($aterra, ['UMT'])) {
            $CorrienteAplicadaA = isset($corrienteMap[$SeccionA]) ? $corrienteMap[$SeccionA] : 0;
            $CorrienteAplicadaB = isset($corrienteMap[$SeccionB]) ? $corrienteMap[$SeccionB] : 0;
            $CorrienteAplicada = "$CorrienteAplicadaA|$CorrienteAplicadaA|$CorrienteAplicadaB";
        } else {
            $CorrienteAplicada = 0;
        }

        // Actualizar det_ord_aterra
        $sql_det = "UPDATE det_ord_aterra 
                    SET MLinea = '$MLinea', LongitudA = '$LongitudA', SeccionA = '$SeccionA', TLinea = '$TLinea', 
                        LongitudX = '$LongitudX', SeccionX = '$SeccionX', TerminalX = '$TerminalX', 
                        MTierra = '$MTierra', LongitudB = '$LongitudB', SeccionB = '$SeccionB', 
                        TTierra = '$TTierra'
                    WHERE idOrdAterra = '$id'";

        if (mysqli_query($conexion, $sql_det)) {
            // Obtener ids de la primera consulta
            $query_ids = "SELECT idDetOrdAterra FROM det_ord_aterra WHERE idOrdAterra = '$id'";
            $result_ids = mysqli_query($conexion, $query_ids);

            $ids = [];
            while ($row = mysqli_fetch_assoc($result_ids)) {
                $ids[] = $row['idDetOrdAterra'];
            }

            if (count($ids) > 0) {
                $ids_escapados = array_map(function ($id) use ($conexion) {
                    return mysqli_real_escape_string($conexion, $id);
                }, $ids);

                $ids_str = "'" . implode("','", $ids_escapados) . "'";

                // Actualizar accesorios
                $query_accesorios = "UPDATE acc_ord_aterra 
                                     SET Pertiga = '$Pertiga', Varilla = '$Varilla', Adaptador = '$Adaptador', 
                                         Otros = '$Otros', Trifurcacion = '$Trifurcacion'
                                     WHERE idDetOrdAterra IN ($ids_str)";

                mysqli_query($conexion, $query_accesorios);

                // Actualizar ordaterra
                $sql_ordaterra = "UPDATE ordaterra 
                                  SET EstChico = '$EstChico', EstGrande = '$EstGrande', EstMetalico = '$EstMetalico', 
                                      EstPertiga = '$EstPertiga'
                                  WHERE idOrdAterra = '$id'";

                if (mysqli_query($conexion, $sql_ordaterra)) {
                    // Actualizar ordprueba
                    $sql_ordprueba = "UPDATE ordprueba o 
                                      LEFT JOIN det_ord_aterra d ON d.Serie = o.Serie 
                                      SET o.LongitudTotal = '$LongitudTotal', o.CorrienteAplicada = '$CorrienteAplicada'
                                      WHERE d.idOrdAterra = '$id'";

                    if (mysqli_query($conexion, $sql_ordprueba)) {
                        // Redirige después de actualizar
                        header("Location: orden.php?idOrdAterra=" . urlencode($id));
                        exit();
                    } else {
                        echo "Error al actualizar ordprueba: " . mysqli_error($conexion);
                    }
                } else {
                    echo "Error al actualizar ordaterra: " . mysqli_error($conexion);
                }
            } else {
                echo "No se encontraron idDetOrdAterra.";
            }
        } else {
            echo "Error al actualizar det_ord_aterra: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al obtener TipoAterra.";
    }

    // Cierra la conexión
    mysqli_close($conexion);
}
?>
