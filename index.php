<?php
//include '../desarrollo/include/generic_validate_session.php';
include 'admin/lib/ControllerData.php';
//include 'admin/include/generic_validate_session.php';
//un comentario
//include 'admin/lib/ControllerData.php';

$hoy = date("d-m-Y");
$DATOS = new ControllerData();
$DATOS->datagetactual();
$arrdatos = $DATOS->getResponse();
//print_r($arrdatos);
$isvalid = $arrdatos['output']['valid'];
$arrdatos = $arrdatos['output']['response'];
$c = count($arrdatos);
if ($isvalid) {
    $total_inversion = $arrdatos['actual_inversion'];
    $total_pavimentado = $arrdatos['actual_pavimentado'];
}
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
        <script type="text/javascript" src="admin/js/jquery/jquery-1.7.2.min.js"></script>
        <script type="text/javascript">
            function lee_json() {
                $.ajax({
                    dataType: 'json',
                    url: 'http://php52.secuencia24.com/huecometro/admin/ajax/rqst.php?op=datagetactual',
                    type: 'POST',
                    success: function(datos) {
                        for (var clave in datos) {
                            if (datos.hasOwnProperty(clave)) {
                                var pavimentado = datos["output"]["response"]["actual_pavimentado"];
                                var inversion = datos["output"]["response"]["actual_inversion"];
                                //var fecha = datos["output"]["response"]["fecha"];
                                //var hora = datos["output"]["response"]["hora"];
                                //var r = datos["output"]["response"]["r"];

                                //$('#pavimento').attr("value", pavimentado);
                                //$('#inversion').attr("value", inversion);
                                $('#pavimento').html(pavimentado);
                                $('#inversion').html(inversion);
                                //alert('pavimentado :'+pavimentado);
                                //$('#fecha').attr("value", fecha);
                                //$('#hora').attr("value", hora);
                                //$('#r').attr("value", r);
                            }
                        }
                    },
                    error: function() {
                        //alert("Error leyendo fichero jsonP");
                    }
                });
            }
            var int = self.setInterval("lee_json()", 300000);
            //var int=self.setInterval("lee_json()",300);
        </script>
    </head>

    <body onload="lee_json();">
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
                        <p id="pavimento"></p>
                    </div>
                    <div class="boxTexInver" >
                        <img src="images/TexInver.png" width="100%" >
                    </div>
                    <div class="RelojFechaInver">
                        <p id="inversion"></p>
                    </div>
                    <div class="boxTexMillon">
                        <img src="images/TexMillones.png" width="100%" >
                    </div>
                    <div class="RelojFecha">
                        <p ><?php echo $hoy; ?></p>
                    </div>
                    <div>
                        <p >
                        <form action="huecometro.php" method="post" name="form" id="ismForm">
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