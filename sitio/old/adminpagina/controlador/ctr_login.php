<?php
session_start();
include"../clases/MySQL.php";
include"../clases/crudadmin.php";
echo '<script type="text/javascript"> document.getElementById("crg").style.display = "inline"; </script>';  
$proceso=new crudadmin();
$usuario=$proceso->ClearUno($_POST['usuario']);
$password=$proceso->ClearUno($_POST['password']);
$tipo=$proceso->ClearUno($_POST['action']);
if($usuario!="" and $password!=""){
	$datosu=$proceso->loginAdmin($usuario,$password);
	$iding = $datosu[0]['admin_id'];
	if($iding!=""){
	   $_SESSION['idusuario']=$iding;
	   if($tipo=="ingre"){
		   $fecharegistro = $proceso->modificarLogin($iding);
		   echo '<script type="text/javascript"> window.open("../huecometro_home.php", "_parent")</script>';
	   }
	   if($tipo==""){
		   echo '<script type="text/javascript"> window.open("../index.php", "_parent")</script>'; 
	   }
	}
	if($iding==""){
	   echo '<script type="text/javascript">alert("¡El usuario o la Contraseña son invalidos, intentalo de nuevo!")</script>';
	  echo '<script type="text/javascript"> window.open("../index.php", "_parent")</script>';
	  // header('Location: ../index.php') ;
	}
    
}
echo '<script type="text/javascript"> document.getElementById("crg").style.display = "none"; </script>'; 
?>