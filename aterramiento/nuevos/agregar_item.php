<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_dielectricos2";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$idOrdAterra = $_GET['idOrdAterra'];

echo "OrdAterra: $idOrdAterra<br>"; // Depuración

// Obtener el último registro para el idOrdAterra dado en det_ord_aterra
$queryDetOrd = "SELECT * FROM det_ord_aterra WHERE idOrdAterra = '$idOrdAterra' ORDER BY idDetOrdAterra DESC LIMIT 1";
$resultDetOrd = $conn->query($queryDetOrd);

if ($resultDetOrd->num_rows > 0) {
    $rowDetOrd = $resultDetOrd->fetch_assoc();

    // Generar nuevo idDetOrdAterra secuencial
    $lastIdQuery = "SELECT idDetOrdAterra FROM det_ord_aterra ORDER BY idDetOrdAterra DESC LIMIT 1";
    $lastIdResult = $conn->query($lastIdQuery);
    $lastIdRow = $lastIdResult->fetch_assoc();
    $lastId = $lastIdRow['idDetOrdAterra'];
    $newIdDetOrdAterra = 'DET' . date('ym') . str_pad((int)substr($lastId, 8) + 1, 3, '0', STR_PAD_LEFT);

    echo "Nuevo idDetOrdAterra: $newIdDetOrdAterra<br>"; // Depuración

    // Generar nueva Serie secuencial
    $currentYearMonth = date('ym');
    $lastSerieQuery = "SELECT Serie FROM det_ord_aterra WHERE Serie LIKE '$currentYearMonth%' ORDER BY Serie DESC LIMIT 1";
    $lastSerieResult = $conn->query($lastSerieQuery);
    $lastSerieRow = $lastSerieResult->fetch_assoc();
    $lastSerie = isset($lastSerieRow['Serie']) ? $lastSerieRow['Serie'] : $currentYearMonth . '000';
    $newSerieNumber = (int)substr($lastSerie, 4) + 1;
    $newSerie = $currentYearMonth . str_pad($newSerieNumber, 3, '0', STR_PAD_LEFT);

    echo "Nueva Serie: $newSerie<br>"; // Depuración

    // Obtener el último idDetAcc y generar el siguiente
    $lastIdAccQuery = "SELECT idDetAcc FROM acc_ord_aterra ORDER BY idDetAcc DESC LIMIT 1";
    $lastIdAccResult = $conn->query($lastIdAccQuery);
    $lastIdAccRow = $lastIdAccResult->fetch_assoc();
    $lastIdAcc = $lastIdAccRow['idDetAcc'];
    $newIdDetAcc = 'ACC' . date('ym') . str_pad((int)substr($lastIdAcc, 7) + 1, 3, '0', STR_PAD_LEFT);

    echo "Nuevo idDetAcc: $newIdDetAcc<br>"; // Depuración

    // Obtener campos faltantes de acc_ord_aterra
    $queryAcc = "SELECT Pertiga, Varilla, Adaptador, Otros, Trifurcacion FROM acc_ord_aterra WHERE idDetOrdAterra = '{$rowDetOrd['idDetOrdAterra']}'";
    $resultAcc = $conn->query($queryAcc);

    if ($resultAcc->num_rows > 0) {
        $rowAcc = $resultAcc->fetch_assoc();

        // Obtener la fecha de solicitud del último registro en det_ord_aterra
        $fechaSolicitud = $rowDetOrd['FechaSolicitud'];

        // Insertar nuevo registro en det_ord_aterra
        $insertQueryDetOrd = "INSERT INTO det_ord_aterra (
            idDetOrdAterra,
            idOrdAterra,
            Serie,
            MLinea,
            LongitudA,
            SeccionA,
            MTierra,
            LongitudB,
            SeccionB,
            TLinea,
            LongitudX,
            SeccionX,
            TerminalX,
            TTierra,
            FechaSolicitud
        ) VALUES (
            '$newIdDetOrdAterra',
            '$idOrdAterra',
            '$newSerie',
            '{$rowDetOrd['MLinea']}',
            '{$rowDetOrd['LongitudA']}',
            '{$rowDetOrd['SeccionA']}',
            '{$rowDetOrd['MTierra']}',
            '{$rowDetOrd['LongitudB']}',
            '{$rowDetOrd['SeccionB']}',
            '{$rowDetOrd['TLinea']}',
            '{$rowDetOrd['LongitudX']}',
            '{$rowDetOrd['SeccionX']}',
            '{$rowDetOrd['TerminalX']}',
            '{$rowDetOrd['TTierra']}',
            '$fechaSolicitud'
        )";

        echo "Insert Query (det_ord_aterra): $insertQueryDetOrd<br>"; // Depuración

        if ($conn->query($insertQueryDetOrd) === TRUE) {
            echo "Nuevo item de orden de aterra registrado correctamente<br>";

            // Insertar nuevo registro en acc_ord_aterra
            $insertQueryAcc = "INSERT INTO acc_ord_aterra (
                idDetAcc,
                idDetOrdAterra,
                Pertiga,
                Varilla,
                Adaptador,
                Otros,
                Trifurcacion,
                FechaSolicitud
            ) VALUES (
                '$newIdDetAcc',
                '$newIdDetOrdAterra',
                '{$rowAcc['Pertiga']}',
                '{$rowAcc['Varilla']}',
                '{$rowAcc['Adaptador']}',
                '{$rowAcc['Otros']}',
                '{$rowAcc['Trifurcacion']}',
                '$fechaSolicitud'
            )";

            echo "Insert Query (acc_ord_aterra): $insertQueryAcc<br>"; // Depuración

            if ($conn->query($insertQueryAcc) === TRUE) {
                echo "Nuevo item de accesorios agregado correctamente<br>";

                // Obtener campos para ordprueba desde det_ord_aterra con la serie del último registro
                $queryOrdPrueba = "SELECT Tramo, LongitudTotal, CorrienteAplicada, ValorMedido, MaxPermisible, Resultado FROM ordprueba WHERE Serie = '{$rowDetOrd['Serie']}'";
                $resultOrdPrueba = $conn->query($queryOrdPrueba);

                if ($resultOrdPrueba->num_rows > 0) {
                    $rowOrdPrueba = $resultOrdPrueba->fetch_assoc();

                    // Obtener el último idPrueba y generar el siguiente
                    $lastIdPruebaQuery = "SELECT idPrueba FROM ordprueba ORDER BY idPrueba DESC LIMIT 1";
                    $lastIdPruebaResult = $conn->query($lastIdPruebaQuery);
                    $lastIdPruebaRow = $lastIdPruebaResult->fetch_assoc();
                    $lastIdPrueba = $lastIdPruebaRow['idPrueba'];
                    $newIdPrueba = 'PRU' . date('ym') . str_pad((int)substr($lastIdPrueba, 7) + 1, 3, '0', STR_PAD_LEFT);

                    // Insertar nuevo registro en ordprueba con FechaPrueba = '0000-00-00 00:00:00'
                    $insertQueryOrdPrueba = "INSERT INTO ordprueba (
                        idPrueba,
                        Serie,
                        Tramo,
                        LongitudTotal,
                        CorrienteAplicada,
                        ValorMedido,
                        MaxPermisible,
                        Resultado,
                        FechaPrueba
                    ) VALUES (
                        '$newIdPrueba',
                        '$newSerie',
                        '{$rowOrdPrueba['Tramo']}',
                        '{$rowOrdPrueba['LongitudTotal']}',
                        '{$rowOrdPrueba['CorrienteAplicada']}',
                        '{$rowOrdPrueba['ValorMedido']}',
                        '{$rowOrdPrueba['MaxPermisible']}',
                        '{$rowOrdPrueba['Resultado']}',
                        '0000-00-00 00:00:00'
                    )";

                    echo "Insert Query (ordprueba): $insertQueryOrdPrueba<br>"; // Depuración

                    if ($conn->query($insertQueryOrdPrueba) === TRUE) {
                        echo "Nuevo registro de prueba agregado correctamente";

                        // Actualizar el campo cantidad en la tabla ordaterra
                        $updateOrdAterraQuery = "UPDATE ordaterra SET cantidad = cantidad + 1 WHERE idOrdAterra = '$idOrdAterra'";
                        if ($conn->query($updateOrdAterraQuery) === TRUE) {
                            echo "Campo cantidad actualizado correctamente en ordaterra";
                        } else {
                            echo "Error al actualizar el campo cantidad en ordaterra: " . $conn->error;
                        }
                    } else {
                        echo "Error al agregar el nuevo registro de prueba: " . $conn->error;
                    }
                } else {
                    echo "No se encontraron registros para Serie = {$rowDetOrd['Serie']} en ordprueba";
                }
            } else {
                echo "Error al agregar el nuevo item de accesorios: " . $conn->error;
            }
        } else {
            echo "Error al registrar nuevo item de orden de aterra: " . $conn->error;
        }
    } else {
        echo "No se encontraron registros para idDetOrdAterra = {$rowDetOrd['idDetOrdAterra']} en acc_ord_aterra";
    }
} else {
    echo "No se encontraron registros para idOrdAterra = $idOrdAterra";
}

$conn->close();
