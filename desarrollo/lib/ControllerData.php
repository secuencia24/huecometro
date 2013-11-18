<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Camilo Garzon Calle
 */
class ControllerData {

    private $conexion, $CDB, $op, $id, $euid, $sdid;
    private $UTILITY;
    private $response;

    function __construct() {
        $this->CDB = new ConectionDb();
        $this->UTILITY = new Util();
        $this->conexion = $this->CDB->openConect();
        $rqst = $_REQUEST;
        $this->op = isset($rqst['op']) ? $rqst['op'] : '';
        $this->id = isset($rqst['id']) ? intval($rqst['id']) : 0;

        $this->ke = isset($rqst['ke']) ? $rqst['ke'] : '';
        $this->lu = isset($rqst['lu']) ? $rqst['lu'] : '';
        $this->ti = isset($rqst['ti']) ? $rqst['ti'] : '';
//        if (!$this->UTILITY->validate_key($this->ke, $this->ti, $this->lu)) {
//            $this->op = 'noautorizado';
//        }
        if ($this->op == 'datasave') {
            $this->hcmtr_pavimentado = isset($rqst['hcmtr_pavimentado']) ? $rqst['hcmtr_pavimentado'] : '';
            $this->hcmtr_inversion = isset($rqst['hcmtr_inversion']) ? $rqst['hcmtr_inversion'] : '';
            $this->hcmtr_fecha = isset($rqst['hcmtr_fecha']) ? $rqst['hcmtr_fecha'] : '';
            $this->hcmtr_fchregist = isset($rqst['hcmtr_fchregist']) ? $rqst['hcmtr_fchregist'] : '';
            $this->hcmtr_actual_pavimento = isset($rqst['hcmtr_actual_pavimento']) ? $rqst['hcmtr_actual_pavimento'] : '';
            $this->hcmtr_actual_inversion = isset($rqst['hcmtr_actual_inversion']) ? $rqst['hcmtr_actual_inversion'] : '';
            $this->hcmtr_actual_minuto = isset($rqst['hcmtr_actual_minuto']) ? $rqst['hcmtr_actual_minuto'] : '';
            $this->hcmtr_actual_hora = isset($rqst['hcmtr_actual_hora']) ? $rqst['hcmtr_actual_hora'] : '';
            $this->datasave();
        } else if ($this->op == 'dataget') {
            $this->dataget();
        } else if ($this->op == 'datagetactual') {
            $this->datagetactual();
        } else if ($this->op == 'datagetactualtxt') {
            $this->datagetactual();
        } else if ($this->op == 'datadelete') {
            $this->datadelete();
        } else if ($this->op == 'noautorizado') {
            $this->response = $this->UTILITY->error_invalid_authorization();
        } else {
            $this->response = $this->UTILITY->error_invalid_method_called();
        }
        //$this->CDB->closeConect();
    }

    /**
     * Metodo para guardar y actualizar
     */
    private function datasave() {
        $id = 0;
        if ($this->id > 0) {
            //actualiza la informacion
            $q = "SELECT hcmtr_id FROM tbl_dato WHERE hcmtr_id = " . $this->id;
            $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            while ($obj = mysql_fetch_object($con)) {
                $id = $obj->hcmtr_id;
                $table = "tbl_dato";
                $arrfieldscomma = array(
                    'hcmtr_pavimentado' => $this->hcmtr_pavimentado,
                    'hcmtr_inversion' => $this->hcmtr_inversion,
                    'hcmtr_fecha' => $this->hcmtr_fecha,
                    'hcmtr_fchregist' => $this->hcmtr_fchregist,
                    'hcmtr_actual_pavimento' => $this->hcmtr_actual_pavimento,
                    'hcmtr_actual_inversion' => $this->hcmtr_actual_inversion,
                    'hcmtr_actual_minuto' => $this->hcmtr_actual_minuto,
                    'hcmtr_actual_hora' => $this->hcmtr_actual_hora);
                $arrfieldsnocomma = array();
                $q = $this->UTILITY->make_query_update($table, "hcmtr_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
                mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                $arrjson = array('output' => array('valid' => true, 'id' => $id));
            }
        } else {
            $q = "INSERT INTO tbl_dato (hcmtr_pavimentado, hcmtr_inversion, hcmtr_fecha, hcmtr_fchregist) VALUES ('$this->hcmtr_pavimentado', '$this->hcmtr_inversion', '$this->hcmtr_fecha', " . $this->CDB->getServerDate() . ")";
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $id = mysql_insert_id();
            $arrjson = array('output' => array('valid' => true, 'id' => $id));
        }
        $this->response = ($arrjson);
    }

    public function dataget() {
        $q = "SELECT * FROM tbl_dato";
        if ($this->id > 0) {
            $q = "SELECT * FROM tbl_dato WHERE hcmtr_id = " . $this->id;
        }
        $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
        $resultado = mysql_num_rows($con);
        $arr = array();
        while ($obj = mysql_fetch_object($con)) {
            $arr[] = array(
                'hcmtr_id' => $obj->hcmtr_id,
                'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                'hcmtr_inversion' => ($obj->hcmtr_inversion),
                'hcmtr_fecha' => ($obj->hcmtr_fecha),
                'hcmtr_fchregist' => ($obj->hcmtr_fchregist),
                'hcmtr_actual_pavimento' => ($obj->hcmtr_actual_pavimento),
                'hcmtr_actual_inversion' => ($obj->hcmtr_actual_inversion),
                'hcmtr_actual_minuto' => ($obj->hcmtr_actual_minuto),
                'hcmtr_actual_hora' => ($obj->hcmtr_actual_hora)
            );
        }
        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    public function calcularDatoActual($y, $t) {
        $yActual = ($y * $t) / 840;
        $yActual = $this->UTILITY->rounding($yActual, 0);
        return $yActual;
    }

    public function datagetactual() {
        $total_pavimentado = 0;
        $total_inversion = 0;
        $actual_pavimentado = 0;
        $actual_inversion = 0;
        //ORGANIZAR FECHA Y HORA DE ACUERDO CON EL SERVIDOR
        $fch = date("Y-m-d");
        //***************************************************
//        $hora = (date('H:i:s', strtotime('-5 hour'))); //restar horas
//        $horaAnterior = (date('H:i:s', strtotime('-5 hour', strtotime('-5 minute')))); //resta horas y minutos
        $hora = (date('H:i:s', strtotime('+3 hour'))); //restar horas
        $horaAnterior = (date('H:i:s', strtotime('+3 hour', strtotime('-5 minute')))); //resta horas y minutos
//        $hora = (date('H:i:s')); //restar horas
//        $horaAnterior = (date('H:i:s', strtotime('-5 minute'))); //resta horas y minutos
        //***************************************************
        //
        //se calcula el total que se tiene hasta la fecha
        $qTotal = "SELECT * FROM tbl_dato WHERE hcmtr_fecha < '" . $fch . "'";
        $conTotal = mysql_query($qTotal, $this->conexion) or die(mysql_error() . "***ERROR: " . $qTotal);
        $arrtotal = array();
        //suma todos los registro de la bd
        while ($obj = mysql_fetch_object($conTotal)) {
            $arrtotal[] = array(
                'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                'hcmtr_inversion' => ($obj->hcmtr_inversion));
        }
        //se suma cada uno de los valores de interes
        foreach ($arrtotal as $dato) {
            $total_pavimentado = $total_pavimentado + $dato['hcmtr_pavimentado'];
            $total_inversion = $total_inversion + $dato['hcmtr_inversion'];
        }
        $minutosActuales = $this->UTILITY->convertHourToMinutes($hora);
        //se manda el valor antes de las 06:00AM
        if ($minutosActuales <= 360) {
            $arr = array(
                'actual_pavimentado' => ($total_pavimentado),
                'actual_inversion' => ($total_inversion),
                'fecha' => $fch,
                'hora' => $hora,
                'r' => 'r1'
            );
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        }
        //se manda el valor despues de las 08:00PM
        else if ($minutosActuales >= 1200) {
            $qActualizar = "SELECT * FROM tbl_dato WHERE hcmtr_fecha = '" . $fch . "'";
            $conActualizar = mysql_query($qActualizar, $this->conexion) or die(mysql_error() . "***ERROR: " . $qActualizar);
            $resultadoActualizar = mysql_num_rows($conActualizar);
            //se encuentran los datos del dia de hoy
            while ($obj = mysql_fetch_object($conActualizar)) {
                $arrActual = array(
                    'hcmtr_id' => $obj->hcmtr_id,
                    'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                    'hcmtr_inversion' => ($obj->hcmtr_inversion),
                    'hcmtr_actual_pavimento' => ($obj->hcmtr_actual_pavimento),
                    'hcmtr_actual_inversion' => ($obj->hcmtr_actual_inversion),
                    'hcmtr_actual_minuto' => ($obj->hcmtr_actual_minuto),
                    'hcmtr_actual_hora' => ($obj->hcmtr_actual_hora)
                );
            }
            $actual_pavimentado = $arrActual['hcmtr_pavimentado'];
            $actual_inversion = $arrActual['hcmtr_inversion'];
            $arr = array(
                'actual_pavimentado' => ($actual_pavimentado + $total_pavimentado),
                'actual_inversion' => ($actual_inversion + $total_inversion),
                'fecha' => $fch,
                'hora' => $hora,
                'r' => 'r2'
            );
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            //se consultan los datos ACTUALES de fecha y hora enviados al servidor
            $qActual = "SELECT * FROM tbl_dato WHERE hcmtr_fecha = '" . $fch . "' AND hcmtr_actual_hora > '" . $horaAnterior . "'";
            $conActual = mysql_query($qActual, $this->conexion) or die(mysql_error() . "***ERROR: " . $qActual);
            $resultadoActual = mysql_num_rows($conActual);
            $arrActual = array();
            //si se encuentran resultados actualizados, estos se mandan al "cliente"
            if ($resultadoActual > 0) {
                //se cargan los valores
                while ($obj = mysql_fetch_object($conActual)) {
                    $actual_pavimentado = ($obj->hcmtr_actual_pavimento);
                    $actual_inversion = ($obj->hcmtr_actual_inversion);
                }
                $arr = array(
                    'actual_pavimentado' => ($actual_pavimentado + $total_pavimentado),
                    'actual_inversion' => ($actual_inversion + $total_inversion),
                    'fecha' => $fch,
                    'hora' => $hora,
                    'r' => 'r3'
                );
                $arrjson = array('output' => array('valid' => true, 'response' => $arr));
            } else {
                // si no se encuentra ningun dato entonces se calcula y se actualizan los valores
                $qActualizar = "SELECT * FROM tbl_dato WHERE hcmtr_fecha = '" . $fch . "'";
                $conActualizar = mysql_query($qActualizar, $this->conexion) or die(mysql_error() . "***ERROR: " . $qActualizar);
                $resultadoActualizar = mysql_num_rows($conActualizar);
                if ($resultadoActualizar > 0) {
                    //se encuentran los datos del dia de hoy
                    while ($obj = mysql_fetch_object($conActualizar)) {
                        $arrActual = array(
                            'hcmtr_id' => $obj->hcmtr_id,
                            'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                            'hcmtr_inversion' => ($obj->hcmtr_inversion),
                            'hcmtr_actual_pavimento' => ($obj->hcmtr_actual_pavimento),
                            'hcmtr_actual_inversion' => ($obj->hcmtr_actual_inversion),
                            'hcmtr_actual_minuto' => ($obj->hcmtr_actual_minuto),
                            'hcmtr_actual_hora' => ($obj->hcmtr_actual_hora)
                        );
                    }
                    //se elige un nomero aleatorio para sumarlo al tiempo y calcular el valor actual de inversion o pavimento
                    $randomNumber = rand(1, 5);
                    $t = $this->UTILITY->convertHourToMinutes($horaAnterior) + $randomNumber - 360; //resta 360 por los minutos que hay de 00:00 hasta las 06:00
                    $actual_pavimentado = $this->calcularDatoActual($arrActual['hcmtr_pavimentado'], $t);
                    $actual_inversion = $this->calcularDatoActual($arrActual['hcmtr_inversion'], $t);
                    // se actualiza el valor actual de pavimento e inversion
                    $qUpdate = "UPDATE tbl_dato SET hcmtr_actual_pavimento='" . $actual_pavimentado . "', hcmtr_actual_inversion = '" . $actual_inversion . "' , hcmtr_actual_minuto ='" . $t . "' , hcmtr_actual_hora = '" . $hora . "' WHERE hcmtr_id = " . $arrActual['hcmtr_id'];
                    mysql_query($qUpdate, $this->conexion) or die(mysql_error() . "***ERROR: " . $qUpdate);
                    $qUpdate = "SELECT * FROM tbl_dato WHERE hcmtr_id = " . $arrActual['hcmtr_id'];
                    $conUpdate = mysql_query($qUpdate, $this->conexion) or die(mysql_error() . "***ERROR: " . $qUpdate);
                    while ($obj = mysql_fetch_object($conUpdate)) {
                        $arrActual = array(
                            'hcmtr_id' => $obj->hcmtr_id,
                            'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                            'hcmtr_inversion' => ($obj->hcmtr_inversion),
                            'hcmtr_fecha' => ($obj->hcmtr_fecha),
                            'hcmtr_actual_pavimento' => ($obj->hcmtr_actual_pavimento),
                            'hcmtr_actual_inversion' => ($obj->hcmtr_actual_inversion),
                            'hcmtr_actual_minuto' => ($obj->hcmtr_actual_minuto),
                            'hcmtr_actual_hora' => ($obj->hcmtr_actual_hora)
                        );
                    }
                    $arr = array(
                        'actual_pavimentado' => ($arrActual['hcmtr_actual_pavimento'] + $total_pavimentado),
                        'actual_inversion' => ($arrActual['hcmtr_actual_inversion'] + $total_inversion),
                        'fecha' => $arrActual['hcmtr_fecha'],
                        'hora' => $arrActual['hcmtr_actual_hora'],
                        'r' => 'r4'
                    );
                    $arrjson = array('output' => array('valid' => true, 'response' => $arr));
                } else {
                    $arr = array(
                        'actual_pavimentado' => ($total_pavimentado),
                        'actual_inversion' => ($total_inversion),
                        'fecha' => $fch,
                        'hora' => $hora,
                        'r' => 'r5'
                    );
                    $arrjson = array('output' => array('valid' => true, 'response' => $arr));
                }
            }
        }
        $this->response = ($arrjson);
    }

    /**
     *  la funcion de willy
     * @param type $fch
     * @param type $hora
     */
    public function datagetFechaWilly($fch, $hora) {
        $total_pavimentado = 0;
        $total_inversion = 0;
        $restapavimento = 0;
        $restainversion = 0;
        $qTotal = "SELECT * FROM tbl_dato";
        $conTotal = mysql_query($qTotal, $this->conexion) or die(mysql_error() . "***ERROR: " . $qTotal);
        $resultado = mysql_num_rows($conTotal);
        $arrtotal = array();
        //suma todos los registro de la bd
        while ($obj = mysql_fetch_object($conTotal)) {
            $arrtotal[] = array(
                'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                'hcmtr_inversion' => ($obj->hcmtr_inversion));
        }
        foreach ($arrtotal as $dato) {
            $total_pavimentado = $total_pavimentado + $dato['hcmtr_pavimentado'];
            $total_inversion = $total_inversion + $dato['hcmtr_inversion'];
        }
        $qFecha = "SELECT * FROM tbl_dato WHERE hcmtr_fecha='" . $fch . "'";
        $consulfecha = mysql_query($qFecha, $this->conexion) or die(mysql_error() . "***ERROR: " . $qFecha);
        if ($consulfecha != "") {
            while ($obj = mysql_fetch_object($consulfecha)) {
                $arrfecha[] = array(
                    'hcmtr_id' => $obj->hcmtr_id,
                    'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                    'hcmtr_inversion' => ($obj->hcmtr_inversion),
                    'hcmtr_actual_pavimento' => ($obj->hcmtr_actual_pavimento),
                    'hcmtr_actual_inversion' => ($obj->hcmtr_actual_inversion),
                    'hcmtr_actual_minuto' => ($obj->hcmtr_actual_minuto),
                    'hcmtr_actual_hora' => ($obj->hcmtr_actual_hora));
            }

            foreach ($arrfecha as $datoactual) {
                $restapavimento = $datoactual['hcmtr_pavimentado'];
                $restainversion = $datoactual['hcmtr_inversion'];
                $hrabd = $datoactual['hcmtr_actual_hora'];
            }
            print_r($hora . ' > ' . $hrabd . '<br>');
            if ($hora > $hrabd) {
                print_r('Hora actual ' . date('H:i:s') . '<br>');
                print_r('Resultado Hora ' . $horaactualC . '<br>');
                $q1 = "SELECT * FROM tbl_dato WHERE hcmtr_fecha='" . $fch . "' and hcmtr_actual_hora > '" . $horaactualC . "'";
                $con2 = mysql_query($q1, $this->conexion) or die(mysql_error() . "***ERROR: " . $q1);
                $resultado2 = mysql_num_rows($con2);
                $arr2 = array();
                while ($obj = mysql_fetch_object($con2)) {
                    $id = $obj->$obj->hcmtr_id;
                    $arr[] = array(
                        'hcmtr_id' => $obj->hcmtr_id,
                        'hcmtr_pavimentado' => ($obj->hcmtr_pavimentado),
                        'hcmtr_inversion' => ($obj->hcmtr_inversion),
                        'hcmtr_fecha' => ($obj->hcmtr_fecha),
                        'hcmtr_fchregist' => ($obj->hcmtr_fchregist),
                        'hcmtr_actual_pavimento' => ($obj->hcmtr_actual_pavimento),
                        'hcmtr_actual_inversion' => ($obj->hcmtr_actual_inversion),
                        'hcmtr_actual_minuto' => ($obj->hcmtr_actual_minuto),
                        'hcmtr_actual_hora' => ($obj->hcmtr_actual_hora));
                }
                //genero el numero aletorio
            } else {
                srand(time());
                //$time_aleatorio = rand(1, 5)+$contaTmp;
                // $time_aleatorio = rand(1, 5);
                //$time_real = $hora - '06:00'; //calculo el tiempo real
                $actual_minuto = $time_real + $time_aleatorio; //se va modifcar en la bd actual minutos
                $formulahuecos = ($obj->hcmtr_pavimentado) * $time_real / 840; //se le lleva ala bd actual_huecos
                $formulainversion = ($obj->hcmtr_inversion) * $time_real / 840; //se le lleva ala bd actual_inversion
                /* $q = "UPDATE tbl_dato SET hcmtr_actual_pavimento='" . $formulahuecos . "',
                  hcmtr_actual_inversion = '" . $formulainversion . "' ,hcmtr_actual_minuto ='" . $actual_minuto . "' ,
                  hcmtr_actual_hora = NOW() WHERE hcmtr_id = " . $id;
                  mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
                  $arrjson = array('output' => array('valid' => true, 'response' => $arr)); */
            }
        } else {
            print_r('ento en consulfecha vacio');
        }
        $total_pavimentado = ($total_pavimentado - $restapavimento); //todo el total menos el dia de hoy
        $total_inversion = ($total_inversion - $restainversion); //todo el total menos el dia de hoy
        $arr = array(
            'total_pavimentado' => ($total_pavimentado),
            'total_inversion' => ($total_inversion));

        if ($resultado > 0) {
            $arrjson = array('output' => array('valid' => true, 'response' => $arr));
        } else {
            $arrjson = $this->UTILITY->error_no_result();
        }
        $this->response = ($arrjson);
    }

    private function datadelete() {
        if ($this->id > 0) {
            $q = "DELETE FROM tbl_dato WHERE hcmtr_id = " . $this->id;
            mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
            $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
        } else {
            $arrjson = $this->UTILITY->error_missing_data();
        }
        $this->response = ($arrjson);
    }

    public function getResponse() {
        $this->CDB->closeConect();
        return $this->response;
    }

    public function getResponseJSON() {
        $this->CDB->closeConect();
        return json_encode($this->response);
    }

    public function getResponseDatagetactualTXT() {
        $this->CDB->closeConect();
        $arrResponse = $this->response['output']['response'];
        $txt = $arrResponse['actual_pavimentado'].",".$arrResponse['actual_inversion'].",".$arrResponse['fecha'].",".$arrResponse['hora'].",".$arrResponse['r'];
        return ($txt);
    }

    public function setId($_id) {
        $this->id = $_id;
    }

}

?>
