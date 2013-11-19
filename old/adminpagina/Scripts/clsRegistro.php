<script>
function abrir(url) {
open(url,'','top=100,left=100,width=500,height=250') ;
}
</script>
<html>
<body>

<?
$email=$_POST['txtemail'];
$nombre1=$_POST['txtnombre1'];
$nombre2=$_POST['txtnombre2'];
$apellido1=$_POST['txtapellido1'];
$apellido2=$_POST['txtapellido2'];
$documento=$_POST['txtdocumento'];
$pais=$_POST['cmbpais'];
$ciudad=$_POST['txtciudad'];
$genero=$_POST['RadioSexo'];
$fecha=$_POST['FechadeNacimiento'];
$Acepto=$_POST['checkAcepto'];
$dia=$_POST['cmbdia'];
$mes=$_POST['cmbmes'];
$ano=$_POST['cmbano'];

$fecha.=$dia;
$fecha.="/";
$fecha.=$mes;
$fecha.="/";
$fecha.=$ano;
?>
<? 
include "conectar.php";
$conexion=conectarBD();
mysql_select_db("bd_inducerv");
$consulta1="SELECT * FROM usuarios WHERE email='".$email."' ";
$resultados=mysql_query($consulta1,$conexion);
$ingresar= "insert into usuarios
(email,primer_nombre,segundo_nombre,
primer_apellido,segundo_apellido,documento,
pais,ciudad,sexo,fecha,si_informacion) 
values
('$email','$nombre1','$nombre2','$apellido1',
'$apellido2','$documento','$pais','$ciudad',
'$genero','$fecha','0')";
if (mysql_num_rows($resultados)!=0){
echo '<center><img src="imagenes/losentimos.png" width="760" height="362" /></center>';
$tiempo = 8;
$pagina = "frmRegistro.html";
}else{
$insertar= mysql_query($ingresar,$conexion) or
die("Problemas en en la insercion:".mysql_error());

$destinatario = $email;
$asunto = "Confirmación Apostol";
$cuerpo = '
<html>
<head>
   <title>Confirmación Apostol</title>
<title>
<MMString:LoadString id="insertbar/table" />
</title>  
</head>
<body>
<div align="center">
  
<table width="106%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="476" height="33" align="left" valign="top"><table width="100%" height="163" border="0" cellpadding="0" cellspacing="0" bgcolor="#E4E4E9">
          <tr>
            <td align="center" valign="top"><table width="550" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="476" height="33" align="left" valign="top"><table width="550" border="0" cellpadding="0" cellspacing="0" bgcolor="#E4E4E9">
                    <tr>
                      <td align="center" valign="top"><table width="550" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                          
                          <tr bgcolor="#E4E4E9">
                            <td width="550" align="center" valign="top" bgcolor="#FFFFFF"><img src="http://www.apostol.com.co/images_correos/registrado.jpg" width="550" height="578" border="0" usemap="#Map" /></td>
                          </tr>
                          
                          
                      </table></td>
                    </tr>
                  </table></td>
                </tr>

            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<map name="Map" id="Map"><area shape="rect" coords="180,726,358,746" href="http://www.santomascambia.info/" target="_blank" />
<area shape="rect" coords="211,309,341,348" href="http://www.santomas.com.co/" target="_blank" />
<area shape="rect" coords="238,440,316,478" href="Location: http://www.apostol.com.co.leaf.arvixe.com/apostol/frmRegistro.html" target="_blank" />
</map>
</div>

</body>
</html>
';

//para el envío en formato HTML
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

//dirección del remitente
$headers .= "From: APOSTOL <comunidad@apostol.com.co\r\n";

//dirección de respuesta, si queremos que sea distinta que la del remitente
$headers .= "Reply-To: comunidad@apostol.com.co\r\n";

//ruta del mensaje desde origen a destino
$headers .= "Return-path: comunidad@apostol.com.co\r\n";

//direcciones que recibián copia
$headers .= "Cc: comunidad@apostol.com.co\r\n";

//direcciones que recibirán copia oculta
$headers .= "Bcc: comunidad@apostol.com.co\r\n";

mail($destinatario,$asunto,$cuerpo,$headers);

}
echo '<center><img src="imagenes/felicitaciones.png" width="760" height="362" /></center>';
$tiempo = 8;
$pagina = "frmRegistro.html";
?>

<meta http-equiv="refresh" content="<?="$tiempo; url=$pagina"?>">
<p>&nbsp;</p>
</body>
</html>