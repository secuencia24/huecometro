<?php
session_start();
include"clases/MySQL.php";
include"clases/crudadmin.php";
$proceso=new crudadmin();
$accion = $_REQUEST['action'];
$dtshueco = $proceso->listarHuecometro();
if($accion == 'del'){
	$id = intval($_REQUEST['key']);
	$actualizarfondo=$proceso->eliminarHuecometro($id);
	header("Location: huecometro_home.php");
}

?>
