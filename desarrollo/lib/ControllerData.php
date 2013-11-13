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
            $q = "INSERT INTO tbl_dato (hcmtr_pavimentado, hcmtr_inversion, hcmtr_fecha, hcmtr_fchregist,hcmtr_actual_pavimento,hcmtr_actual_inversion,hcmtr_actual_minuto,hcmtr_actual_hora)
                VALUES ('$this->hcmtr_pavimentado', '$this->hcmtr_inversion', '$this->hcmtr_fecha', '$this->hcmtr_fchregist', '$this->hcmtr_actual_pavimento',, '$this->hcmtr_actual_inversion',, '$this->hcmtr_actual_minuto',, '$this->hcmtr_actual_hora')";
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

    public function setId($_id) {
        $this->id = $_id;
    }

}

?>