<?php
session_start();
$idusuario=$_SESSION['idusuario'];
if($idusuario==""){
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="description" content="Productos qimicos">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Huecometro</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css">
<link href="css/navMenu.css" rel="stylesheet" type="text/css">
<link href="css/dcdrilldown.css" rel="stylesheet" type="text/css" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/cmsblast24.css" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/tsc_datagrid.js"></script>
<script type="text/javascript" src="js/jquery.datepicker.js"></script>
<script type="text/javascript">
function campos(elEvento, permitidos) {
  // Variables que definen los caracteres permitidos
  var numeros = "0123456789";
  var caracteres = " abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
  var numeros_caracteres = numeros + caracteres;
  var teclas_especiales = [8, 37, 39, 46];
  // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha 
  // Seleccionar los caracteres a partir del parámetro de la función
  switch(permitidos) {
	case 'num':
	  permitidos = numeros;
	  break;
	case 'car':
	  permitidos = caracteres;
	  break;
	case 'num_car':
	  permitidos = numeros_caracteres;
	  break;
  }
 
  // Obtener la tecla pulsada
  var evento = elEvento || window.event;
  var codigoCaracter = evento.charCode || evento.keyCode;
  var caracter = String.fromCharCode(codigoCaracter);
 
  // Comprobar si la tecla pulsada es alguna de las teclas especiales
  // (teclas de borrado y flechas horizontales)
  var tecla_especial = false;
  for(var i in teclas_especiales) {
	if(codigoCaracter == teclas_especiales[i]) {
	  tecla_especial = true;
	  break;
	}
  }
 
  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  // o si es una tecla especial
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
$(function() {
	$( "#datepicker" ).datepicker();
});
</script>
<!--Google Analytic-->
<!--FIN Google Analytic-->
</head>
<body>
<?php
include 'includes/prin-header.php';
?>
<div id="wrapper">
 <section id="cuerpoPrin">
    <div class="divcontenido">
    <table width="100%" border="0" cellspacing="5">
    	<tr>
          <td width="95%" align="right">         	
          </td>
          <td width="5%"></td>
        </tr>
    </table>
    <form action="controlador/ctr_huecometro_cred.php" method="post" name="form1" id="form1" enctype="multipart/form-data">
      <table width="100%" border="0" cellspacing="5">
        <tr>
          <td><a href="huecometro_home.php">Listado de Huecometro</a> / Agregar Huecometro</td>
          <td align="right">
           </td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" border="0" cellspacing="5">
            <tr>
              <td colspan="2"><?php echo $msj;?></td>
            </tr>
            <tr>
              <td>Total Huecos Pavimentados</td>
              <td><input type="text" name="pavimento" id="pavimento" onKeyPress="return campos(event, 'num')" maxlength="7" required></td>
            </tr>
            <tr>
              <td>Inversion Total</td>
              <td><input type="text" name="inversion" id="inversion" onKeyPress="return campos(event, 'num')" maxlength="5" required></td>
            </tr>
            <tr>
              <td>Seleccione la fecha</td>
              <td><input type="text" id="datepicker" name="datepicker" required/></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="26%">&nbsp;</td>
              <td width="74%"><div2>
                <input type="submit" name="enviar" id="enviar" value="Crear" />
                <input name="boton" type="hidden" id="boton" value="Enviar" />
                <input name="action" type="hidden" id="action" value="crear" />
                </div2></td>
            </tr>
            </table></td>
          </tr>
      </table>
      </form>
    </div>
 </section>
</div>
<?php
include 'includes/prin-footer.php';
?>
</body>
</html>
