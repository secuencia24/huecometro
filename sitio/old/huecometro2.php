<?php
session_start();
require("adminpagina/controlador/ctr_huecometro_web.php");
$fch = date("d-m-Y");
$sw = isset($_REQUEST['sw']) ? $_REQUEST['sw'] : '';
echo '<pre>' . _FILE_ . ':' . _LINE_ . ' {' . print_r($_REQUEST, true) . '}';
$_SESSION['acumulador'] = isset($_REQUEST['acumulador']) ? $_REQUEST['acumulador'] : '';
 //$acumulador = $_SESSION['acumulador'];
$_SESSION['acumulador_inversion'] = isset($_REQUEST['acumulador_inversion']) ? $_REQUEST['acumulador_inversion'] : '';
if ($sw == "") {
    $sw = false;
}
//Con todos los datos
if (count($dtshuecoCompl) != 0) {
    foreach ($dtshuecoCompl as $i => $dato) {
        $pavimentado1 = $dato['hcmtr_pavimentado'];
        $inversion1 = $dato['hcmtr_inversion'];
        $fecha1 = $dato['hcmtr_fecha'];
        $cantPavi = $cantPavi + $pavimentado1;
        $cantinver = $cantinver + $inversion1;
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

$numerohuecos = $pavimentado; //asigno el valor de # de huecos
$cantidadinversion = $inversion;    //asigno el valor de # de inversion

$mostar_cadahora = 12; //sale de 60 1 hora /5 minutos
$horasamostrar = 14;  //horas en las se va a mostar de 6 am a 8 pm
$espacios = $mostar_cadahora * $horasamostrar; // resultado 168

$resultado = $numerohuecos / $espacios;     //9,523 redondeado = 10
$resultado_inversion = $cantidadinversion / $espacios; //50
//Nota: $resultado y $resultado_inversion NO ESTAN TRAYENDO NADA

echo '<br>--1--Acomulador Anterior de Huecos va en ' . $acumulador . '<br>';
echo '--2--Acomulador Anterior de Inversion va en  ' . $acumulador_inversion . '<br>';
//Empiezo a  hacer las operaciones
if ($sw == false) {
    echo '<br>Estoy sw = false ';
    if (!isset($_SESSION['$acumulador'])) {
        $_SESSION['acumulador'] = $_REQUEST['acumulador'];
    }
    if (!isset($_SESSION['acumulador_inversion'])) {
        $_SESSION['acumulador_inversion'] = $_REQUEST['acumulador_inversion'];
    }
//genero el numero aletorio
    srand(time());
    $numero_aleatorio = rand(1, 20);
    $valor_a_sumar = $espacios * $numero_aleatorio / 100;
    $acumulador = $acumulador + (round($resultado) + round($valor_a_sumar)) + $cantPavi;
    $acumulador_inversion = $acumulador_inversion + (round($resultado_inversion) + round($valor_a_sumar)) + $cantinver;
    $sw = TRUE;
} else {
    echo '<br>Estoy sw = TRUE ';
    //genero el numero aletorio
    srand(time());
    $numero_aleatorio = rand(1, 20);
    $valor_a_sumar = $espacios * $numero_aleatorio / 100;
    $acumulador = $acumulador + (round($resultado) + round($valor_a_sumar));
    echo $resultado;
    $acumulador_inversion = $acumulador_inversion + (round($resultado_inversion) + round($valor_a_sumar));
}
/*echo '<br>Intervalos tiempo ' . $espacios . '<br>';
echo '<br>---Resultado de numerohuecos/espacios ' . round($resultado) . '<br>';
echo '---Resultado de inversion/espacios ' . round($resultado_inversion) . '<br>';
echo '<br>-1 y 2-Valor a sumar huecosPavimentados --- inversion /IntervalosTiempo=  ' . round($valor_a_sumar) . '<br>';
echo '<br>Numero aleatoreo ' . $numero_aleatorio . '<br>';
echo '<br>--Pavimentacion suma total de los registros bd ' . $cantPavi . '<br>';
echo '--Inversion suma total de los registros bd ' . $cantinver . '<br>';
echo '<br>Resultado final huecos ' . $acumulador . '<br>';
echo '<br>Resultado final inversion ' . $acumulador_inversion . '<br>';*/
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8"/>
        <!--        refrescar la pagina x tiempo que queramos-->
        <!--        <meta http-equiv="refresh" content="100"/>-->
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
        <!--        refrescar la pagina x tiempo que queramos-->
        <script type="text/javascript">
            setTimeout(function() {
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
                        <p ><?php echo $acumulador; ?></p>
                    </div>
                    <div class="boxTexInver" >
                        <img src="images/TexInver.png" width="100%" >
                    </div>
                    <div class="RelojFechaInver">
                        <p ><?php echo $acumulador_inversion; ?></p>
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