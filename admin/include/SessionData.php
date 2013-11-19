<?php

class SessionData {

    private $THE_KEY;
    private $THE_RANDOM;

    function __construct() {
	$this->THE_KEY = 'e1ca41c9c29a354fea64d33228f45503';
	$this->THE_RANDOM = sha1(rand(100, 2000));
    }

    public function getKey() {
	return $this->THE_KEY;
    }

    public function getRandom() {
	return $this->THE_RANDOM;
    }

    public function getPermission($id) {
	if (isset($_SESSION['usuario'])) {
	    $permisos = $_SESSION['usuario']['permisos'];
	    return (in_array($id, $permisos));
	} else {
	    return false;
		}
    }

    public function getUserCustomerId() {
	return $_SESSION['usuario']['idcli'];
    }

    public function getUserCustomerName() {
	return $_SESSION['usuario']['clientenombre'];
    }

    public function getUserId() {
	if (isset($_SESSION['usuario'])) {
	    return $_SESSION['usuario']['id'];
	} else {
	    return sha1(rand(100, 2000));
		}
    }

    public function getKeyUser() {
	if (isset($_SESSION['usuario'])) {
	    $userid = $_SESSION['usuario']['id'];
	    return sha1($userid . $this->THE_KEY . $this->THE_RANDOM);
	} else {
	    return sha1(rand(100, 2000));
	}
    }

    public function getKeyGeneric() {
	return sha1($this->THE_KEY . $this->THE_RANDOM);
    }

    public function getUserFullName() {
	$fullname = $_SESSION['usuario']['nombre'] . ' ' . $_SESSION['usuario']['apellido'];
	return $fullname;
    }
   
}

?>
