<?php
session_start();
include"adminpagina/clases/MySQL.php";
include"adminpagina/clases/crudadmin.php";
$proceso=new crudadmin();
$fch = date("d-m-Y");
$dtshuecoxFch = $proceso->listarHuecometroWEB($fch);
$dtshuecoCompl = $proceso->listarHuecometro();
?>
