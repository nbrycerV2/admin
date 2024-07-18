<?php

$aterra = $_POST["aterra"];

function nombre($nom)
{
    if ($nom == "ENA") {
        echo "Enganche Automatico";
    }
    if ($nom == "EXT") {
        echo "Extension";
    }
    if ($nom == "JUM") {
        echo "Jumper Equipotencial";
    }
    if ($nom == "PDE") {
        echo "Pertiga de Descarga";
    }
    if ($nom == "P03") {
        echo "Pulpo";
    }
    if ($nom == "PEL") {
        echo "Pulpo con Elastimold";
    }
    if ($nom == "TRA") {
        echo "Trapecio";
    }
    if ($nom == "TPF") {
        echo "Trapecio con Pertiga Fija";
    }
    if ($nom == "U01") {
        echo "Unipolar (1 Tira)";
    }
    if ($nom == "U03") {
        echo "Unipolar (3 Tiras)";
    }
    if ($nom == "UPF") {
        echo "Unipolar con Pertiga Fija";
    }
    if ($nom == "USA") {
        echo "Unipolar con Seguridad Aumentada";
    }
    if ($nom == "UMT") {
        echo "Unipolar para Lineas de Media Tension";
    }
    if ($nom == "UPV") {
        echo "Unipolar para Vehiculo";
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>Document</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Dielectrico">
    <meta name="author" content="Logytec">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="../img/icons/icon-48x48.png" />
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />
    <link href="../css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../lib/datatables.min.css">
</head>

<body>
    <div class="wrapper">
        <?php include "side-bar.html";
        ?>

        <div class="main">
            <?php include "nav-bar.html";
            ?>

            <main class="content">
                <div class="container-fluid">
                    <form action="proceso_orden.php" method="post">
                        <div class="row">
                            <div class="btn-group col-3" role="group" aria-label="Basic example">
                                <a type="button" class="btn btn-primary" href="nuevo.php">Atras</a>
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </div>
                        <div class="col-12 ">
                            <div class="dropdown-divider"></div>
                        </div>
                        <label for="">
                            Configuracion del Aterramiento
                        </label>
                        <div class="col-12 ">
                            <div class="dropdown-divider"></div>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="inputEmail4" class="form-label">Configuracion</label>
                                        <input class="form-control" disabled value="<?php nombre($aterra); ?>">
                                        <input type="text" value="<?php nombre($aterra); ?>" id="configuracion" name="configuracion" hidden>
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputEmail4" class="form-label">Cantidad</label>
                                        <input type="number" min="0" class="form-control" id="cantidad" name="cantidad">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-auto">
                                        <label for="inputEmail4" class="form-label">Mordaza de Linea</label>
                                        <select class="form-select" id="mordaza_linea" name="mordaza_linea">
                                            <option value=""></option>
                                            <option value="RC600-2282">RC600-2282</option>
                                            <option value="RC600-0965">RC600-0965</option>
                                            <option value="RG3369">RG3369</option>
                                            <option value="RG3403">RG3403</option>
                                            <option value="RG3622-1">RG3622-1</option>
                                            <option value="RC600-2300 MORDAZA CONCHA-BOLA">RC600-2300 MORDAZA CONCHA-BOLA</option>
                                            <option value="ATR13628-1 (Enganche Automatico)">ATR13628-1 (Enganche Automatico)</option>
                                            <option value="161GP Set de Bushing y Cable elastimold">161GP Set de Bushing y Cable elastimold</option>
                                            <option value="272GP Set de Bushing y Cable elastimold">272GP Set de Bushing y Cable elastimold</option>
                                            <option value="RG3368">RG3368</option>
                                            <option value="RG3363-1">RG3363-1</option>
                                            <option value="RG3403T">RG3403T</option>
                                            <option value="ATR11627-2">ATR11627-2</option>
                                            <option value="RC600-0065">RC600-0065</option>
                                            <option value="RG3367-1">RG3367-1</option>
                                            <option value="ATR08969-3">ATR08969-3</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputEmail4" class="form-label">Mordaza de Tierra</label>
                                        <select class="form-select" id="mordaza_tierra" name="mordaza_tierra">
                                            <option value=""></option>
                                            <option value="ATR11627-2">ATR11627-2</option>
                                            <option value="RG3403T">RG3403T</option>
                                            <option value="RG3363-1">RG3363-1</option>
                                            <option value="ATR03641-1 Carretel">ATR03641-1 Carretel</option>
                                            <option value="S/CODIGO Carrete Nacional">S/CODIGO Carrete Nacional</option>
                                            <option value="RG3363-4SJ">RG3363-4SJ</option>

                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label for="inputEmail4" class="form-label">Longitud (A)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="long_a" name="long_a">
                                            <div class="input-group-text">m.</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail4" class="form-label">Seccion (A)</label>
                                        <div class="input-group mb-3">
                                            <select class="form-select" id="seccion_A" name="seccion_a" onchange="actualizarOpciones()">
                                                <option value=""></option>
                                                <option value="25">25</option>
                                                <option value="35">35</option>
                                                <option value="50">50</option>
                                                <option value="70">70</option>
                                                <option value="95">95</option>
                                            </select>
                                            <label class="input-group-text" for="inputGroupSelect02">mm <sup>2</sup></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <label for="inputEmail4" class="form-label">Longitud (B)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="long_b" name="long_b">
                                            <div class="input-group-text">m.</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail4" class="form-label">Seccion (B)</label>
                                        <div class="input-group mb-3">
                                            <select class="form-select" id="seccion_B" name="seccion_b" onchange="actualizarOpciones2()">
                                                <option value=""></option>
                                                <option value="25">25</option>
                                                <option value="35">35</option>
                                                <option value="50">50</option>
                                                <option value="70">70</option>
                                                <option value="95">95</option>
                                            </select>
                                            <label class="input-group-text" for="inputGroupSelect02">mm <sup>2</sup></label>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-5">
                                        <label for="inputEmail4" class="form-label">Terminal de Linea (A)</label>
                                        <select class="form-select" id="terminal_linea" name="terminal_linea">
                                            <option value=""></option>

                                        </select>
                                    </div>

                                    <div class="col-auto">
                                        <label for="inputEmail4" class="form-label">Terminal de Tierra (B)</label>
                                        <select class="form-select" id="terminal_tierra" name="terminal_tierra">
                                            <option value=""></option>

                                        </select>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label for="inputEmail4" class="form-label">Longitud (X)</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="long_x" name="long_x">
                                            <div class="input-group-text">m.</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="inputEmail4" class="form-label">Seccion (X)</label>
                                        <div class="input-group mb-3">
                                            <select class="form-select" id="sec_x" name="sec_x" onchange="actualizarOpciones3()">
                                                <option value=""></option>
                                                <option value="25">25</option>
                                                <option value="35">35</option>
                                                <option value="50">50</option>
                                                <option value="70">70</option>
                                                <option value="95">95</option>
                                            </select>
                                            <label class="input-group-text" for="inputGroupSelect02">mm <sup>2</sup></label>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputEmail4" class="form-label">Terminal de Tierra (B-2)</label>
                                        <select class="form-select" id="terminal_tierra_2" name="terminal_tierra_2">
                                            <option></option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <label for="inputEmail4" class="form-label">Terminal de Linea (X)</label>
                                        <select class="form-select" id="terminal_lineax" name="terminal_lineax">
                                            <option></option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <img width="300" src="imagenes/<?php echo $aterra; ?>.jpg" class="img-fluid" id="matrix">
                            </div>
                        </div>
                        <div class="col-12 ">
                            <div class="dropdown-divider"></div>
                        </div>
                        <div>
                            <label for="">Accesorios extras</label>
                            <br>
                            <label for="">-En la seleccion de estuches colocar el total.</label>
                        </div>
                        <div class="col-12 ">
                            <div class="dropdown-divider"></div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Pertiga</label>
                                    <select class="form-select" id="pertiga" name="pertiga">
                                        <option value=""></option>
                                        <option value="RC600-0434">RC600-0434</option>
                                        <option value="RH1760-1">RH1760-1</option>
                                        <option value="VMR-15">VMR-15</option>
                                        <option value="VMR-30">VMR-30</option>
                                        <option value="VMR-45">VMR-45</option>
                                        <option value="VMR-70">VMR-70</option>
                                        <option value="VMR-90">VMR-90</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Adaptador</label>
                                    <select class="form-select" id="adaptador" name="adaptador">
                                        <option value=""></option>
                                        <option value="RG3368">RG3368</option>
                                        <option value="ATR14442-1 Plato Portapinzas (Dst-7)">ATR14442-1 Plato Portapinzas (Dst-7)</option>
                                        <option value="VMR07205-1 Adaptador para maniobrar">VMR07205-1 Adaptador para maniobrar</option>
                                        <option value="RM4455-29B Adaptador para maniobrar">RM4455-29B Adaptador para maniobrar</option>
                                        <option value="FLV-3585 Pino Bola">FLV-3585 Pino Bola</option>
                                        <option value="ATR08969-1 Mordaza Pino Bola">ATR08969-1 Mordaza Pino Bola</option>
                                        <option value="RM4455-78 Extractor de fusibles">RM4455-78 Extractor de fusibles</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Varilla</label>
                                    <select class="form-select" id="varilla" name="varilla">
                                        <option></option>
                                        <option value="Var 5/8">Var 5/8</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Trifurcacion</label>
                                    <select class="form-select" id="trifurcacion" name="trifurcacion">
                                        <option value=""></option>
                                        <option value="RG4754-1 Pulpo">RG4754-1 Pulpo</option>
                                        <option value="ATR04116-1 Trapecio">ATR04116-1 Trapecio</option>
                                        <option value="ATR03318-1 Trapecio tipo silla">ATR03318-1 (trapecio tipo silla)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Otros</label>
                                    <select class="form-select" id="otros" name="otros">
                                        <option></option>
                                        <option value="RG3625 Soporte de suspension">RG3625 Soporte de suspension</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Estuche Grande</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="estuche_g" name="estuche_g" aria-label="Checkbox for following text input">
                                        </div>
                                        <input type="number" min="0" class="form-control" aria-label="Text input with checkbox" id="cant_eg" name="cant_eg">
                                    </div>
                                </div>

                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Estuche Chico</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="estuche_c" name="estuche_c" aria-label="Checkbox for following text input">
                                        </div>
                                        <input type="number" min="0" class="form-control" aria-label="Text input with checkbox" id="cant_ec" name="cant_ec">
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <label for="inputEmail4" class="form-label">Estuche Metalico</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="estuche_m" name="estuche_m" aria-label="Checkbox for following text input">
                                        </div>
                                        <input type="number" min="0" class="form-control" aria-label="Text input with checkbox" id="cant_em" name="cant_em">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </main>
        </div>
    </div>
    <script src="../js/app.js"></script>
    <script src="../lib/jquery.min.js"></script>
    <script src="../lib/datatables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script>
        var select = document.getElementById("mordaza_linea"); // Obtener el select
        var options = Array.from(select.options); // Convertir las opciones a un array
        options.sort(function(a, b) { // Ordenar el array alfabéticamente
            return a.text.localeCompare(b.text);
        });
        select.innerHTML = ""; // Limpiar el contenido del select
        options.forEach(function(option) { // Agregar las opciones ordenadas al select
            select.appendChild(option);
        });

        var select = document.getElementById("mordaza_tierra"); // Obtener el select
        var options = Array.from(select.options); // Convertir las opciones a un array
        options.sort(function(a, b) { // Ordenar el array alfabéticamente
            return a.text.localeCompare(b.text);
        });
        select.innerHTML = ""; // Limpiar el contenido del select
        options.forEach(function(option) { // Agregar las opciones ordenadas al select
            select.appendChild(option);
        });
    </script>
    <script>
        function actualizarOpciones2() {
            var opcionesSelect2 = document.getElementById("terminal_tierra");
            opcionesSelect2.innerHTML = ""; // Limpiamos las opciones del select

            var opcionesSelect3 = document.getElementById("terminal_tierra_2");
            opcionesSelect3.innerHTML = ""; // Limpiamos las opciones del select

            var grosorCableSelect2 = document.getElementById("seccion_B");
            var grosorCable2 = grosorCableSelect2.options[grosorCableSelect2.selectedIndex].value;

            var configuracion = document.getElementById("configuracion");



            if (grosorCable2 == "35") {
                opcionesSelect2.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "50") {
                opcionesSelect2.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "25") {
                opcionesSelect2.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "70") {
                opcionesSelect2.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable2 == "95") {
                opcionesSelect2.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
                opcionesSelect3.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            }

        }
    </script>
    <script>
        function actualizarOpciones() {
            var opcionesSelect = document.getElementById("terminal_linea");
            opcionesSelect.innerHTML = ""; // Limpiamos las opciones del select

            var grosorCableSelect = document.getElementById("seccion_A");
            var grosorCable = grosorCableSelect.options[grosorCableSelect.selectedIndex].value;

            if (grosorCable == "35") {
                opcionesSelect.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "50") {
                opcionesSelect.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "25") {
                opcionesSelect.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "70") {
                opcionesSelect.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable == "95") {
                opcionesSelect.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            }
        }
    </script>
    <script>
        function actualizarOpciones3() {
            var opcionesSelect4 = document.getElementById("terminal_lineax");
            opcionesSelect4.innerHTML = ""; // Limpiamos las opciones del select

            var grosorCableSelect4 = document.getElementById("sec_x");
            var grosorCable4 = grosorCableSelect4.options[grosorCableSelect4.selectedIndex].value;


            if (grosorCable4 == "35") {
                opcionesSelect4.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A7-M8">2A7-M8 Cañon Largo P/Cable</option><option value="A7-M8">A7-M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "50") {
                opcionesSelect4.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A10-M10">2A10-M10 Cañon Largo P/Cable</option><option value="A10-M10">A10-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "25") {
                opcionesSelect4.innerHTML = '<option value="MTA50-C">MTA50-C</option><option value="2A5-M8">2A5-M8 Cañon Largo P/Cable</option><option value="A5M8">A5M8 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "70") {
                opcionesSelect4.innerHTML = '<option value="MTA70-C">MTA70-C</option><option value="2A14-M10">2A14-M10 Cañon Largo P/Cable</option><option value="A14-M10">A14-M10 Cañon Corto P/Cable</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            } else if (grosorCable4 == "95") {
                opcionesSelect4.innerHTML = '<option value="MTA120-C">MTA120-C</option><option value="2710110">2710110</option><option value="NAC_EXT Terminal Nacional">NAC_EXT Terminal Nacional</option>';
            }



        }
    </script>

    <?php
    if ($aterra == "ENA") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
    }
    if ($aterra == "EXT") {
        echo "<script>document.getElementById('mordaza_linea').disabled = true;</script>";
        echo "<script>document.getElementById('mordaza_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('adaptador').disabled = true;</script>";
    }
    if ($aterra == "JUM") {
        echo "<script>document.getElementById('mordaza_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('adaptador').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
    }
    if ($aterra == "PDE") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('adaptador').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
    }
    if ($aterra == "P03") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }
    if ($aterra == "PEL") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('long_a').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_A').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_linea').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('adaptador').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }
    if ($aterra == "TRA") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }
    if ($aterra == "TPF") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
    }
    if ($aterra == "U01") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }
    if ($aterra == "U03") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }
    if ($aterra == "UPF") {
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('varilla').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
    }
    if ($aterra == "USA") {
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";

        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }
    if ($aterra == "UMT") {
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
    }
    if ($aterra == "UPV") {
        echo "<script>document.getElementById('terminal_tierra_2').disabled = true;</script>";
        echo "<script>document.getElementById('long_b').disabled = true;</script>";
        echo "<script>document.getElementById('seccion_B').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_tierra').disabled = true;</script>";
        echo "<script>document.getElementById('long_x').disabled = true;</script>";
        echo "<script>document.getElementById('sec_x').disabled = true;</script>";
        echo "<script>document.getElementById('terminal_lineax').disabled = true;</script>";
        echo "<script>document.getElementById('trifurcacion').disabled = true;</script>";
        echo "<script>document.getElementById('pertiga').disabled = true;</script>";
    }

    ?>
</body>

</html>