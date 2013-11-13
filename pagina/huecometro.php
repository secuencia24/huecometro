<?php
session_start();
include '../desarrollo/lib/ControllerData.php';
/**
 * se cargan datos
 */
$DATOS = new ControllerData();
$DATOS->datagetFecha('2013-11-13');
$arrdatos = $DATOS->getResponse();
$isvalid = $arrdatos['output']['valid'];
$arrdatos = $arrdatos['output']['response'];

$fch = date("d-m-Y");
$hora = date("H:i:s");

print_r($arrdatos);
echo $hora;
//Con todos los datos
$c = count($arrdatos);
if ($isvalid) {
    $pavimentado1 = $arrdatos[0]['hcmtr_pavimentado'];
    $inversion1 = $arrdatos[0]['hcmtr_inversion'];
    $fecha1 = $arrdatos[0]['hcmtr_fecha'];
    $pavimentado_actual = $arrdatos[0]['hcmtr_actual_pavimento'];
    $inversion_actual = $arrdatos[0]['hcmtr_actual_inversion'];
    $minuto_actual = $arrdatos[0]['hcmtr_actual_minuto'];
    $hora_actual = $arrdatos[0]['hcmtr_actual_hora'];

    $cantPavi = $cantPavi + $pavimentado1;
    $cantPaviTOTAL = $cantPaviTOTAL + $pavimentado1;
    $cantinver = $cantinver + $inversion1;
    $cantinverTOTAL = $cantinverTOTAL + $inversion1;
}

$sw = $_REQUEST['sw'];
$acumulador = isset($_SESSION['acumulador']) ? $_SESSION['acumulador'] : '';
$acumulador_inversion = isset($_SESSION['acumulador_inversion']) ? $_SESSION['acumulador_inversion'] : '';

$acumulador = isset($_REQUEST['acumulador']) ? $_REQUEST['acumulador'] : '';
$acumulador_inversion = isset($_REQUEST['acumulador_inversion']) ? $_REQUEST['acumulador_inversion'] : '';

$contador = isset($_SESSION['contador']) ? $_SESSION['contador'] : '';
$contador = isset($_REQUEST['contador']) ? $_REQUEST['contador'] : '';

$contador = 1 + $contador;
$bandera = 0;
//echo '<pre>' . __FILE__ . ':' . __LINE__ . ' {' . print_r($_REQUEST, true) . '}';
if ($sw == "") {
    $sw = false;
}
$cantPavi = 0;
$cantinver = 0;
//Con todos los datos
if (count($dtshuecoCompl) != 0) {
    foreach ($dtshuecoCompl as $i => $dato) {
        $pavimentado1 = $dato['hcmtr_pavimentado'];
        $inversion1 = $dato['hcmtr_inversion'];
        $fecha1 = $dato['hcmtr_fecha'];
        $cantPavi = $cantPavi + $pavimentado1;
        $cantPaviTOTAL = $cantPaviTOTAL + $pavimentado1;
        $cantinver = $cantinver + $inversion1;
        $cantinverTOTAL = $cantinverTOTAL + $inversion1;
    }
}
//Con la fecha actual
if (count($dtshuecoxFch) != 0) {
    foreach ($dtshuecoxFch as $i => $dato) {
        $pavimentado = $dato['hcmtr_pavimentado'];
        $inversion = $dato['hcmtr_inversion'];
        $fechaActu = $dato['hcmtr_fecha'];
    }
}
$cantPavi = $cantPavi - $pavimentado;
$cantinver = $cantinver - $inversion;
//
//echo 'BD pavimentado ' . $pavimentado . '<br>';
$numerohuecos = $pavimentado;
$cantidadinversion = $inversion;    //asigno el valor de # de inversion

$mostar_cadahora = 12; //sale de 60 1 hora /5 minutos
$horasamostrar = 14;  //horas en las se va a mostar de 6 am a 8 pm

$espacios = $mostar_cadahora * $horasamostrar; // resultado 168
$resultado = $numerohuecos / $espacios;     //9,523	
$resultado_inversion = $cantidadinversion / $espacios; //50
echo '---Acomulador Huecos ' . $acumulador . '>= ' . $cantPaviTOTAL . '<br>';
echo '---Acomulador Inversion ' . $acumulador_inversion . '== ' . $cantinverTOTAL . '<br>';
//genero el numero aletorio
srand(time());
$numero_aleatorio = rand(1, 3);
$numero_aleatorio = isset($_SESSION['numero_aleatorio']) ? $_SESSION['numero_aleatorio'] : '';
$numero_aleatorio = isset($_REQUEST['numero_aleatorio']) ? $_REQUEST['numero_aleatorio'] : '';

if (($cantPaviTOTAL >= $acumulador) && ($cantinverTOTAL >= $acumulador_inversion ) && ($hora < "09:26:00")) {
    if ($sw == false) {
        $acumulador = 0;
        $acumulador_inversion = 0;

        $valor_a_sumar = $espacios * $numero_aleatorio / $horasamostrar;
        $valor_a_sumar_inversion = $espacios * $numero_aleatorio / $horasamostrar;

        $acumulador = $acumulador + (round($resultado) + round($valor_a_sumar)) + $cantPavi;
        $acumulador_inversion = $acumulador_inversion + (round($resultado_inversion) + round($valor_a_sumar_inversion)) + $cantinver;
        $sw = TRUE;
    } else {
        $valor_a_sumar = $espacios * $numero_aleatorio / $horasamostrar;
        $valor_a_sumar_inversion = $espacios * $numero_aleatorio / $horasamostrar;

        $acumulador = $acumulador + (round($resultado) + round($valor_a_sumar));
        $acumulador_inversion = $acumulador_inversion + (round($resultado_inversion) + round($valor_a_sumar_inversion));
    }
    //echo 'VALOR A SUMAR huecos ' . $valor_a_sumar;
    //echo 'VALOR A SUMAR INVERSION ' . $valor_a_sumar_inversion;
} else {
    $bandera = 1;
    $acumulador = $cantPaviTOTAL;
    $acumulador_inversion = $cantinverTOTAL;
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
        <!-- Optimized mobile viewport -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Fin Optimized mobile viewport -->
        <META NAME="Author" CONTENT="www.secuencia24.com"/>
        <META NAME="Description" CONTENT="Huecometro"/>
        <META NAME="Keywords" CONTENT="Huecometro"/>
        <META NAME="Robots" CONTENT="All"/>
        <title>:: Huecometro ::</title>
        <link type="image/x-icon" href="images/animacion_ico.gif" rel="icon" />
        <link href="css/huecometro.css" rel="stylesheet" type="text/css" />

        <!--if IE-->
        <script type="text/javascript">
            var e = ("abbr,article,aside,audio,canvas,datalist,details,figure,footer,header,hgroup,mark,menu,meter,nav,output,progress,section,time,video").split(',');
            for (var i = 0; i < e.length; i++) {
                document.createElement(e[i]);
            }
        </script>
        <!--Fin if IE-->
        <script type="text/javascript">
            var mivar;
            mivar = setTimeout(function() {
                document.getElementById("ismForm").submit();
            }, 3000);
        </script>
    </head>

    <body>
        <section class="boxGeneral">
            <!--<div class="boxTexSup">Texto</div>-->
            <section class="boxPrinHueco" >
                <section class="boxHeader">
                    <img src="images/logoSuperior.png" width="100%" >
                </section>
                <section class="boxCuerpo">
                    <div class="boxTexMalla">
                        <img  src="images/TexMallaVial.png" width="100%" >
                    </div>
                    <div class="boxTexHueco">
                        <img src="images/TexHuecoPavl.png" width="100%" >
                    </div>
                    <div class="RelojHueco">
                        <p ><?php echo number_format($acumulador, 0, ",", "."); ?></p>
                    </div>
                    <div class="boxTexInver" >
                        <img src="images/TexInver.png" width="100%" >
                    </div>
                    <div class="RelojFechaInver">
                        <p ><?php echo number_format($acumulador_inversion, 0, ",", "."); ?></p>
                    </div>
                    <div class="boxTexMillon">
                        <img src="images/TexMillones.png" width="100%" >
                    </div>
                    <div class="RelojFecha">
                        <p ><?php echo $fch; ?></p>
                    </div>
                    <div>
                        <p >
                        <form action="huecometro.php" method="post" name="form" id="ismForm">
                            <input name="action" type="hidden" id="action" value="sw" />
                            <input name="sw" type="hidden" id="sw" value="<?php echo $sw; ?>" />
                            <input name="formula" type="hidden" id="formula" value="<?php echo $formula; ?>" />
                            <input name="acumulador" type="hidden" id="acumulador" value="<?php echo $acumulador; ?>" />
                            <input name="acumulador_inversion" type="hidden" id="acumulador_inversion" value="<?php echo $acumulador_inversion; ?>" />
                            <input name="contador" type="hidden" id="contador" value="<?php echo $contador; ?>" />
                        </form>
                        </p>
                    </div>
                </section>
                <section class="boxFooter">
                    <div class="lineaSupFooter">
                    </div>
                    <div class="boxInfoPie">
                        <img src="images/pieImagenes.png" width="100%">
                    </div>
                </section>
            </section>
            <!--<div class="boxTexInf">Texto</div>-->
        </section>
    </body>
</html>
<?php
if ($bandera == 1) {
    ?>
    <script type="text/javascript">
        clearTimeout(mivar);
    </script>
    <?php
//    echo 'ENTRO POR EL ELSE............ ';
//    echo 'intervalos tiempo ' . $espacios . '<br>';
//    echo '---resultado de numerohuecos/espacios ' . round($resultado) . '<br>';
//    echo '---Resultado de inversion/espacios ' . round($resultado_inversion) . '<br>';
//    echo '<br>-1 y 2-Valor a sumar huecosPavimentados --- inversion /IntervalosTiempo=  ' . round($valor_a_sumar) . '<br>';
//    echo '--valor a sumar huecosPavimentados/IntervalosTiempo=  ' . round($valor_a_sumar) . '<br>';
//    echo 'Numero aleatoreo ' . $numero_aleatorio . '<br>';
//    echo '--Pavimentacion total bd ' . $cantPavi . '<br>';
//
//    echo '<br>Resultado final huecos ' . $acumulador . '<br>';
//    echo '<br>Resultado final inversion ' . $acumulador_inversion . '<br>';
    exit();
}
?>
