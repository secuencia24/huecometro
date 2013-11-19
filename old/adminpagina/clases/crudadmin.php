<?php

final class crudadmin {

    /**
     * almacena determinada secuencia de caracteres recibidos mediante la
     * plataforma blast24
     * @access private
     * @var String
     */
    private $ddb;

    /**
     * inicializa este objeto puente para la comunicacion del blast24 y lms
     */
    public function __construct() {
        $this->ddb = new MySQL();
    }

    /**
     * comprueba si el usuario existe
     * @access public
     * @return Boolean
     */
    //CRUD LOGIN
    final public function loginAdmin($user, $pass) {
        $listgale = array();
        $sqll = $this->ddb->consulta("SELECT * FROM tbl_admin WHERE admin_usuario='".$user."' AND admin_contrasenia='".$pass."'");
        while ($resultados = $this->ddb->fetch_array_object($sqll)) {
            $listgale[] = array("admin_id"=>"".$resultados->admin_id."",
                				"admin_usuario"=>"".$resultados->admin_usuario."",
                				"admin_contrasenia"=>"".$resultados->admin_contrasenia."",
				                "admin_ingreso"=>"".$resultados->admin_ingreso."",
                				"admin_fecharegistro"=>"".$resultados->admin_fecharegistro."");
        }
        return $listgale;
    }

    final public function modificarLogin($id) {
        $fch = date("Y-m-d H:i:s");
        $sqllf = $this->ddb->consulta("UPDATE tbl_admin SET admin_ingreso='".$fch."' WHERE admin_id=".$id);
        return 1;
    }
	
	//CRUD HUEMCOMETRO
	final public function listarHuecometro()
	{
		$listhome=array();
		$sqll = $this->ddb->consulta("SELECT * FROM tbl_dato ORDER BY hcmtr_id DESC");
		while($resultados=$this->ddb->fetch_array_object($sqll)){
			  $listhome[]=array("hcmtr_id"=>"".$resultados->hcmtr_id."",
								 "hcmtr_pavimentado"=>"".$resultados->hcmtr_pavimentado."",
								 "hcmtr_inversion"=>"".$resultados->hcmtr_inversion."",
								 "hcmtr_fecha"=>"".$resultados->hcmtr_fecha."",
								 "hcmtr_fchregist"=>"".$resultados->hcmtr_fchregist."");
		}
		return $listhome;
	}
	final public function listarHuecometroID($id)
	{
		$listhome=array();
		$sqll = $this->ddb->consulta("SELECT * FROM tbl_dato WHERE hcmtr_id=".$id."");
		while($resultados=$this->ddb->fetch_array_object($sqll)){
			  $listhome[]=array("hcmtr_id"=>"".$resultados->hcmtr_id."",
								 "hcmtr_pavimentado"=>"".$resultados->hcmtr_pavimentado."",
								 "hcmtr_inversion"=>"".$resultados->hcmtr_inversion."",
								 "hcmtr_fecha"=>"".$resultados->hcmtr_fecha."",
								 "hcmtr_fchregist"=>"".$resultados->hcmtr_fchregist."");
		}
		return $listhome;
	}
	
	final public function listarHuecometroWEB($fch)
	{		
		$listhome=array();
		$sqll = $this->ddb->consulta("SELECT * FROM tbl_dato WHERE hcmtr_fecha='".$fch."'");
		while($resultados=$this->ddb->fetch_array_object($sqll)){
			  $listhome[]=array("hcmtr_id"=>"".$resultados->hcmtr_id."",
								 "hcmtr_pavimentado"=>"".$resultados->hcmtr_pavimentado."",
								 "hcmtr_inversion"=>"".$resultados->hcmtr_inversion."",
								 "hcmtr_fecha"=>"".$resultados->hcmtr_fecha."",
								 "hcmtr_fchregist"=>"".$resultados->hcmtr_fchregist."");
		}
		return $listhome;
	}
	final public function crearHuecometro($pavimentado,$inversion,$fecha)
	{
		$sqlleq = $this->ddb->consulta("INSERT INTO tbl_dato(hcmtr_pavimentado,hcmtr_inversion,hcmtr_fecha) 
										VALUES ('$pavimentado',$inversion,'$fecha')");
		return 1;
	}
	final public function modificarHuecometro($pavimentado,$inversion,$fecha,$id)
	{
		$sqllf = $this->ddb->consulta("UPDATE tbl_dato SET hcmtr_pavimentado='".$pavimentado."', hcmtr_inversion='".$inversion."', 
									   hcmtr_fecha='".$fecha."' WHERE hcmtr_id=".$id);
		return 1;
	}
	final public function eliminarHuecometro($id)
	{
		$sqllf = $this->ddb->consulta("DELETE FROM tbl_dato WHERE hcmtr_id=".$id);
		return 1;
	}

//FUNCIONES DE LIMPIEZA PARA TEXTO
    final public function ClearUno($text) {
        $text = str_replace(" ", "", $text);
        $text = str_replace("'", "", $text);
        $text = str_replace('"', '', $text);
        $text = str_replace("%", "", $text);
        $text = str_replace('ñ', '', $text);
        $text = str_replace('Ã¡', '', $text);
        $text = str_replace('Ã³', '', $text);
        $text = str_replace('Ã­', '', $text);
        $text = str_replace("´", "", $text);
        $text = str_replace("''", "", $text);
        $text = str_replace("�?", "", $text);
        return $text;
    }

    //FUNCIONES DE LIMPIEZA PARA IMAGEN
    final public function ClearDos($text) {
        $text = str_replace("'", "", $text);
        $text = str_replace('"', '', $text);
        $text = str_replace("%", "", $text);
        $text = str_replace("´", "", $text);
        $text = str_replace("''", "", $text);
        $text = str_replace("�?", "", $text);
        return $text;
    }

}

?>