<?php

if ($aterra == "Enganche Automatico" or $aterra == "Pulpo" or $aterra == "Pulpo con Elastimold" or $aterra == "Unipolar (3 Tiras)" or $aterra == "Unipolar con Pertiga Fija") {
  $tabla = "<table class='table table-striped table-bordered'>
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Tramo</th>
      <th>Longitud Total</th>
      <th>Corriente Aplicada</th>
      <th>Voltaje Medido</th>
      <th>Max. Permisible</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan='3'></td>
      <td>R-GND</td>
      <td></td>
      <td rowspan='3'></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>S-GND</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>T-GND</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
  </table>";
}
if ($aterra == "Extension" or $aterra == "Jumper Equipotencial" or $aterra == "Pertiga de Descarga" or $aterra == "Unipolar (1 Tira)") {
  $tabla = "<table class='table table-striped table-bordered'>
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Tramo</th>
      <th>Longitud Total</th>
      <th>Corriente Aplicada</th>
      <th>Voltaje Medido</th>
      <th>Max. Permisible</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td>R-GND</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
  </table>";
}

if ($aterra == "Trapecio" or $aterra == "Trapecio con Pertiga Fija") {
  $tabla = "<table class='table table-striped table-bordered'>
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Tramo</th>
      <th>Longitud Total</th>
      <th>Corriente Aplicada</th>
      <th>Voltaje Medido</th>
      <th>Max. Permisible</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td rowspan='2'></td>
      <td>R-S-T</td>
      <td></td>
      <td rowspan='2'></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td>S-GND</td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
  </table>";
}
if ($aterra == "Unipolar con Seguridad Aumentada" or $aterra == "Unipolar para Lineas de Media Tension") {
  $tabla = "<table class='table table-striped table-bordered'>
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Tramo</th>
      <th>Longitud Total</th>
      <th>Corriente Aplicada</th>
      <th>Voltaje Medido</th>
      <th>Max. Permisible</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td></td>
      <td>R-GND</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>S-GND</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td>T-GND</td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
  </tbody>
  </table>";
}
if ($aterra == "") {
  $tabla = "";
}

echo $tabla;
