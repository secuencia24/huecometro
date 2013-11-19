<?php
session_start();
include"../clases/MySQL.php";
include"../clases/crudadmin.php";
$proceso = new crudadmin();
$accion = $proceso->ClearDos($_REQUEST['action']);
if ($accion == 'mod') {
    $camb = 0;
    $id = intval($_POST['key']);
    $pavimentado = $proceso->ClearUno($_REQUEST['pavimento']);
    $inversion = $proceso->ClearUno($_REQUEST['inversion']);
    $fecha = $proceso->ClearUno($_REQUEST['datepicker']);
    $actualizarfondo = $proceso->modificarHuecometro($pavimentado,$inversion,$fecha,$id);
    header("Location: ../huecometro_home.php");
}
if ($accion == 'crear') {
   $pavimentado = $proceso->ClearUno($_REQUEST['pavimento']);
   $inversion = $proceso->ClearUno($_REQUEST['inversion']);
   $fecha = $proceso->ClearUno($_REQUEST['datepicker']);
   $actualizarfondo = $proceso->crearHuecometro($pavimentado,$inversion,$fecha);
   header("Location: ../huecometro_home.php");
}
?>


