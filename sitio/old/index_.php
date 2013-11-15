<?php
$sw = $_REQUEST['sw'];
$acumulador = $_REQUEST['acumulador'];

if ($sw == "") {
    $sw = false;
}
$numerohuecos = 1600; //Ejemplo que sean 1600
$mostar_cadahora = 12; //sale de 60 1 hora /5 minutos
$horasamostrar = 14;  //horas en las se va a mostar de 6 am a 8 pm
$espacios = $mostar_cadahora * $horasamostrar; // resultado 168
//echo ' Espacios para repartir---> ' . $espacios . '<br>';
$resultado = $numerohuecos / $espacios;     //9,523
echo ' Resultado division---> ' . round($resultado) . '<br>';
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>::HUECOMETRO ::</title>
    </head>
    <body >
        <form id="form3" name="form3" action="index.php" method="post">
            <table width="100%" border="0" cellspacing="5">
                <?php
                if ($sw == false) {
                    $acumulador = 0;
                    echo 'estoy en false ' . $sw . '<br>';

                    //genero el numero aletorio
                    srand(time());
                    $numero_aleatorio = rand(1, 5);
                    echo 'Numero Aleatorio---> ' . $numero_aleatorio . '<br>';
                    $valor_a_sumar = $espacios * $numero_aleatorio / 100;
                    echo ' Resultado de la Formula ENTERO--->' . round($valor_a_sumar) . '<br>';
                    //$valoramostar = ($resultado + $valor_a_sumar);
                    $acumulador = $acumulador + (round($resultado) + round($valor_a_sumar));
                    echo ' Resultado mostar en Pantalla ENTERO---> ' . round($acumulador);
                    $sw = TRUE;
                } else {
                    echo 'estoy en true ' . $sw . '<br>';
                    echo ' ACUMULADOR ' . round($acumulador) . '<br>';

                    //genero el numero aletorio
                    srand(time());
                    $numero_aleatorio = rand(1, 5);
                    echo 'Numero Aleatorio---> ' . $numero_aleatorio . '<br>';
                    $valor_a_sumar = $espacios * $numero_aleatorio / 100;
                    echo ' Resultado de la Formula ENTERO--->' . round($valor_a_sumar) . '<br>';
                    //$valoramostar = ($resultado + $valor_a_sumar);
                     $acumulador = $acumulador + (round($resultado) + round($valor_a_sumar));
                    echo ' Resultado mostar en Pantalla ENTERO---> ' . round($acumulador);
                    '<br>';
                }
                ?>
                <input type="submit" name="sw" id="sw" value="Siguiente" />
                <input name="action" type="hidden" id="action" value="sw" />
                <input name="sw" type="hidden" id="sw" value="<?php echo $sw; ?>" />
                <input name="formula" type="hidden" id="formula" value="<?php echo $formula; ?>" />
                <input name="acumulador" type="hidden" id="acumulador" value="<?php echo $acumulador; ?>" />
            </table>
        </form>






    </body>
</html>

