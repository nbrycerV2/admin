<?php
// Suponiendo que la variable $aterra viene definida en alguna parte antes de este código
$aterra = $_POST['aterra'] ?? ''; // Obtiene el valor de la variable $aterra, por ejemplo, de un formulario
// Validar si el valor $aterra no se relaciona para el campo Mordaza de Linea
//$MordazaLinea = ($aterra === 'ENA');
// Para bloquear el campo Mordaza de Linea segun el valor programado
$MordazaLineaA = ($aterra === 'EXT');
// Para bloquear el campo Longitud A segun el valor programado
$MordazaLineaLA = ($aterra === 'PEL');
// Para bloquear el campo Seccion A segun el valor programado
$MordazaLineaSA = ($aterra === 'PEL');
// Para bloquear el campo Terminal de Linea segun el valor programado
$TerminalLinea = ($aterra === 'PEL');
// Para bloquear el campo Mordaza de Tierra segun el valor programado
$MordazaTierra = ($aterra === 'EXT' || $aterra === 'JUM');
// Para bloquear el campo Longitud B segun el valor programado
$MordazaTierraLB = ($aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE' || $aterra === 'U01'
    || $aterra === 'U03' || $aterra === 'UPF' || $aterra === 'UPV');
// Para bloquear el campo Sección B segun el valor programado
$MordazaTierraSB = ($aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE' || $aterra === 'U01'
    || $aterra === 'U03' || $aterra === 'UPF' || $aterra === 'UPV');
// Para bloquear el campo Terminal de Tierra segun el valor programado
$TerminalTierra = ($aterra === 'JUM');

// Para bloquear el campo Longitud X segun el valor programado
$MordazaTierraLX = ($aterra === 'ENA' || $aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE'
    || $aterra === 'P03' || $aterra === 'PEL' || $aterra === 'TRA' || $aterra === 'TPF' || $aterra === 'U01'
    || $aterra === 'U03' || $aterra === 'UPF' || $aterra === 'UMT' || $aterra === 'UPV');
// Para bloquear el campo Sección X segun el valor programado
$MordazaTierraSX = ($aterra === 'ENA' || $aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE'
    || $aterra === 'P03' || $aterra === 'PEL' || $aterra === 'TRA' || $aterra === 'TPF' || $aterra === 'U01'
    || $aterra === 'U03' || $aterra === 'UPF' || $aterra === 'UMT' || $aterra === 'UPV');
// Para bloquear el campo Terminal de X segun el valor programado
$TerminalX = ($aterra === 'ENA' || $aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE'
    || $aterra === 'P03' || $aterra === 'PEL' || $aterra === 'TRA' || $aterra === 'TPF' || $aterra === 'U01'
    || $aterra === 'U03' || $aterra === 'UPF' || $aterra === 'UPV' || $aterra === 'USA' || $aterra === 'UMT');

//Accesorios Extras
// Para bloquear el campo Pertiga segun el valor programado
$AccPertiga = ($aterra === 'ENA' || $aterra === 'P03' || $aterra === 'PEL'
    || $aterra === 'U01' || $aterra === 'U03' || $aterra === 'UPV');
// Para bloquear el campo Adaptador segun el valor programado
$AccAdaptador = ($aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE' || $aterra === 'PEL'
    || $aterra === 'UPF');
// Para bloquear el campo Varilla segun el valor programado
$AccVarilla = ($aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE' || $aterra === 'PEL'
    || $aterra === 'TPF' || $aterra === 'U01' || $aterra === 'U03'  || $aterra === 'UPF');
// Para bloquear el campo Trifurcación segun el valor programado
$AccTrifurcacion = ($aterra === 'ENA' || $aterra === 'EXT' || $aterra === 'JUM' || $aterra === 'PDE'
    || $aterra === 'TPF' || $aterra === 'U01' || $aterra === 'U03' || $aterra === 'UPF' || $aterra === 'USA'
    || $aterra === 'UMT' || $aterra === 'UPV' || $aterra === 'UMT');
