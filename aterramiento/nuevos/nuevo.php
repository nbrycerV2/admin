<!DOCTYPE html>
<?php



?>

<html>

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

    <body>
        <div class="wrapper">
            <?php include "side-bar.html";
            ?>
            <div class="main">
                <?php include "nav-bar.html";
                ?>
                <main class="content">
                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-6">
                                <form method="post" action="orden_next.php">
                                    <label onclick="muestro(1)">
                                        <input type="radio" name="aterra" id="ena" value="ENA">
                                        <label for="ena">Enganche Automatico</label>
                                    </label><br>

                                    <label onclick="muestro(2)">
                                        <input type="radio" name="aterra" id="ext" value="EXT">
                                        <label for="ext">Extension</label>
                                    </label><br>

                                    <label onclick="muestro(3)">
                                        <input type="radio" name="aterra" id="jum" value="JUM">
                                        <label for="jum">Jumper Equipotencial</label>
                                    </label><br>

                                    <label onclick="muestro(4)">
                                        <input type="radio" name="aterra" id="pde" value="PDE">
                                        <label for="pde">Pertiga de descarga</label>
                                    </label><br>

                                    <label onclick="muestro(5)">
                                        <input type="radio" name="aterra" id="p03" value="P03">
                                        <label for="p03">Pulpo</label>
                                    </label><br>

                                    <label onclick="muestro(6)">
                                        <input type="radio" name="aterra" id="pel" value="PEL">
                                        <label for="pel">Pulpo con Elastimold</label>
                                    </label><br>

                                    <label onclick="muestro(7)">
                                        <input type="radio" name="aterra" id="tra" value="TRA">
                                        <label for="tra">Trapecio</label>
                                    </label><br>

                                    <label onclick="muestro(8)">
                                        <input type="radio" name="aterra" id="tpf" value="TPF">
                                        <label for="tpf">Trapecio con Pertiga Fija</label>
                                    </label><br>

                                    <label onclick="muestro(14)">
                                        <input type="radio" name="aterra" id="u01" value="U01">
                                        <label for="u01">Unipolar(1 Tiras)</label>
                                    </label><br>

                                    <label onclick="muestro(9)">
                                        <input type="radio" name="aterra" id="u03" value="U03">
                                        <label for="u03">Unipolar(3 Tiras)</label>
                                    </label><br>

                                    <label onclick="muestro(10)">
                                        <input type="radio" name="aterra" id="upf" value="UPF">
                                        <label for="upf">Unipolar con Pertiga Fija</label>
                                    </label><br>

                                    <label onclick="muestro(11)">
                                        <input type="radio" name="aterra" id="usa" value="USA">
                                        <label for="usa">Unipolar Con Seguridad Aumentada</label>
                                    </label><br>

                                    <label onclick="muestro(12)">
                                        <input type="radio" name="aterra" id="umt" value="UMT">
                                        <label for="umt">Unipolar Para Lineas de Media Tension</label>
                                    </label><br>

                                    <label onclick="muestro(13)">
                                        <input type="radio" name="aterra" id="upv" value="UPV">
                                        <label for="upv">Unipolar para Vehiculo</label>
                                    </label><br>

                                    <button type="submit" class="btn">Siguiente</button>
                                </form>
                            </div>
                            <div class="col-6">
                                <img width="300" src="" class="img-fluid" id="matrix">
                            </div>
                        </div>
                </main>
            </div>
        </div>

        <script src="../js/app.js"></script>
        <script src="../lib/jquery.min.js"></script>
        <script src="../lib/datatables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


        <script>
            function muestro(x) {
                var y = x;
                if (y == 1) {
                    document.getElementById('matrix').src = "imagenes/ENA.jpg"; //Enganche automatico
                }
                if (y == 2) {
                    document.getElementById('matrix').src = "imagenes/EXT.jpg"; //Extension
                }
                if (y == 3) {
                    document.getElementById('matrix').src = "imagenes/JUM.jpg"; //Jumper
                }
                if (y == 4) {
                    document.getElementById('matrix').src = "imagenes/PDE.jpg"; //Pertiga de descarga
                }
                if (y == 5) {
                    document.getElementById('matrix').src = "imagenes/P03.jpg"; //Pulpo
                }
                if (y == 6) {
                    document.getElementById('matrix').src = "imagenes/PEL.jpg"; //Pulpo con elastimold
                }
                if (y == 7) {
                    document.getElementById('matrix').src = "imagenes/TRA.jpg"; //Trapecio
                }
                if (y == 8) {
                    document.getElementById('matrix').src = "imagenes/TPF.jpg"; //Trapecio con pertiga fija
                }
                if (y == 9) {
                    document.getElementById('matrix').src = "imagenes/U03.jpg"; //unipolar 3 tiras
                }
                if (y == 10) {
                    document.getElementById('matrix').src = "imagenes/UPF.jpg"; //unipolar con pertiga fija
                }
                if (y == 11) {
                    document.getElementById('matrix').src = "imagenes/USA.jpg"; //unipolar con seguridad aumentada
                }
                if (y == 12) {
                    document.getElementById('matrix').src = "imagenes/UMT.jpg"; //unipolar para lineas de media tension
                }
                if (y == 13) {
                    document.getElementById('matrix').src = "imagenes/UPV.jpg"; //unipolar para vehiculo
                }
                if (y == 14) {
                    document.getElementById('matrix').src = "imagenes/U01.jpg"; //unipolar para lineas de media tension
                } else {

                }

            }

            function quito() {
                document.getElementById('matrix').src = "";
            }
        </script>

    </body>

</html>