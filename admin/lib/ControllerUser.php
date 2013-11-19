<?php

include 'ConectionDb.php';
include 'Util.php';

/**
 * Clase que contiene todas las operaciones utilizadas sobre la base de datos
 * @author Camilo Garzon Calle
 */
class ControllerUser {

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
	if ($this->op == 'usersave') {
	    $this->admin_usuario = isset($rqst['admin_usuario']) ? $rqst['admin_usuario'] : '';
	    $this->admin_contrasenia = isset($rqst['admin_contrasenia']) ? $rqst['admin_contrasenia'] : '';
	    $this->admin_ingreso = isset($rqst['admin_ingreso']) ? $rqst['admin_ingreso'] : '';
	    $this->admin_fecharegistro = isset($rqst['admin_fecharegistro']) ? $rqst['admin_fecharegistro'] : '';
	    $this->usersave();
	} else if ($this->op == 'userget') {
	    $this->userget();
	} else if ($this->op == 'userlogin') {
	    $this->admin_usuario = isset($rqst['admin_usuario']) ? $rqst['admin_usuario'] : '';
	    $this->admin_contrasenia = isset($rqst['admin_contrasenia']) ? $rqst['admin_contrasenia'] : '';
	    $this->userlogin();
	} else if ($this->op == 'userdelete') {
	    $this->userdelete();
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
    private function usersave() {
	$id = 0;
	if ($this->id > 0) {
	    //actualiza la informacion
	    $q = "SELECT admin_id FROM tbl_admin WHERE admin_id = " . $this->id;
	    $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
	    while ($obj = mysql_fetch_object($con)) {
		$pass = '';
		if (strlen($this->admin_contrasenia) > 3) {
		    $pass = MD5($this->admin_contrasenia);
		}
		$id = $obj->admin_id;
		$table = "tbl_admin";
		$arrfieldscomma = array(
		    'admin_usuario' => $this->admin_usuario,
		    'admin_contrasenia' => $this->admin_contrasenia,
		    'admin_ingreso' => $this->admin_ingreso,
		    'admin_fecharegistro' => $this->admin_fecharegistro);
		$arrfieldsnocomma = array();
		$q = $this->UTILITY->make_query_update($table, "admin_id = '$id'", $arrfieldscomma, $arrfieldsnocomma);
		mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
		$arrjson = array('output' => array('valid' => true, 'id' => $id));
	    }
	} else {
	    $pass = MD5($this->admin_contrasenia);
	    $q = "INSERT INTO tbl_admin (admin_usuario, admin_contrasenia, admin_ingreso, admin_fecharegistro) VALUES ('$this->admin_usuario', '$pass', NOW(), NOW())";
	    mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
	    $id = mysql_insert_id();
	    $arrjson = array('output' => array('valid' => true, 'id' => $id));
	}
	$this->response = ($arrjson);
    }

    private function userlogin() {
	$resultado = 0;
	if (strlen($this->admin_usuario) > 3 && strlen($this->admin_contrasenia) > 3) {
	    $pass = MD5($this->admin_contrasenia);
	    $q = "SELECT * FROM tbl_admin WHERE admin_usuario='" . $this->admin_usuario . "' AND admin_contrasenia='" . $pass . "'";
	    $con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
	    $resultado = mysql_num_rows($con);
	    $arr = array();
	    $id = 0;
	    if ($resultado > 0) {
		while ($obj = mysql_fetch_object($con)) {
		    $id = $obj->admin_id;
		    $arr[] = array(
			'admin_id' => $obj->admin_id,
			'admin_usuario' => ($obj->admin_usuario),
			'admin_contrasenia' => ($obj->admin_contrasenia),
			'admin_ingreso' => ($obj->admin_ingreso),
			'admin_fecharegistro' => ($obj->admin_fecharegistro));
		}
		$q = "UPDATE tbl_admin SET admin_ingreso = NOW() WHERE admin_id = ".$id;
		mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
		$arrjson = array('output' => array('valid' => true, 'response' => $arr));
	    } else {
		$arrjson = $this->UTILITY->error_wrong_data_login();
	    }
	} else {
	    $arrjson = $this->UTILITY->error_missing_data();
	}
	$this->response = ($arrjson);
    }

    public function userget() {
	$q = "SELECT * FROM tbl_admin";
	if ($this->id > 0) {
	    $q = "SELECT * FROM tbl_admin WHERE admin_id = " . $this->id;
	}
	$con = mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
	$resultado = mysql_num_rows($con);
	$arr = array();
	while ($obj = mysql_fetch_object($con)) {
	    $arr[] = array(
		'admin_id' => $obj->admin_id,
		'admin_usuario' => ($obj->admin_usuario),
		'admin_contrasenia' => ($obj->admin_contrasenia),
		'admin_ingreso' => ($obj->admin_ingreso),
		'admin_fecharegistro' => ($obj->admin_fecharegistro));
	}
	if ($resultado > 0) {
	    $arrjson = array('output' => array('valid' => true, 'response' => $arr));
	} else {
	    $arrjson = $this->UTILITY->error_no_result();
	}
	$this->response = ($arrjson);
    }

    private function userdelete() {
	if ($this->id > 0) {
	    $q = "DELETE FROM tbl_admin WHERE admin_id = " . $this->id;
	    mysql_query($q, $this->conexion) or die(mysql_error() . "***ERROR: " . $q);
	    $arrjson = array('output' => array('valid' => true, 'id' => $this->id));
	} else {
	    $arrjson = $this->UTILITY->error_missing_user();
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

    public function extraLogin($username, $pass) {
	$this->admin_usuario = $username;
	$this->admin_contrasenia = $pass;
	$this->userlogin();
    }

}

?>