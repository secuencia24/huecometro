<?php

/**
 * en este archivo se atienden todas las peticiones AJAX
 */
$rqst = $_REQUEST;
$op = isset($rqst['op']) ? $rqst['op'] : '';
header("Content-type: application/javascript; charset=utf-8");
header("Cache-Control: max-age=15, must-revalidate");
header('Access-Control-Allow-Origin: *');

if ($op == 'datasave' || $op == 'dataget' || $op == 'datadelete' || $op == 'datagetactual' ) {
    include '../lib/ControllerData.php';
    $CONTROL = new ControllerData();
    echo $CONTROL->getResponseJSON(); 
}else if ($op == 'usersave' || $op == 'userget' || $op == 'userdelete' || $op == 'userlogin' ) {
    include '../lib/ControllerUser.php';
    $CONTROL = new ControllerUser();
    echo $CONTROL->getResponseJSON(); 
} else {
    echo 'OPERACION NO DISPONIBLE';
}
?>
