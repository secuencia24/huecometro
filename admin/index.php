<?php
session_start();
//include 'include/SessionData.php';
//$SESSION_DATA = new SessionData();
$mensaje = '';
if (isset($_SESSION['usuario'])) {
    header('Location: main.php');
} else {
    $rqst = $_REQUEST;
    $op = isset($rqst['op']) ? $rqst['op'] : '';
    if ($op == 'userlogin') {
	include 'lib/ControllerUser.php';
	//$ke = isset($rqst['ke']) ? $rqst['ke'] : '';
	$email = isset($rqst['admin_usuario']) ? $rqst['admin_usuario'] : '';
	$pass = isset($rqst['admin_contrasenia']) ? $rqst['admin_contrasenia'] : '';
	$pass = MD5($pass);
	$USUARIO = new ControllerUser();
	$USUARIO->extraLogin($email, $pass);
	$res = $USUARIO->getResponse();
	$isvalid = $res['output']['valid'];
	if ($isvalid) {
	    $_SESSION['usuario'] = $res['output'];
	    header('Location: main.php');
	} else {
	    $mensaje = $res['output']['response']['content'];
	}
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
	<?php 
	include 'include/generic_head.php'; 
	?>
    </head>
    <body>
        <header>
	    <?php
	    include 'include/generic_header.php';
	    ?>
        </header>
	<section id="section_wrap">
	    <form class="form-actions" style="margin: 0 auto !important; width: 220px;" action="index.php" method="POST">
		<div class="control-group">
		    <label class="control-label" for="admin_usuario">Usuario</label>
		    <div class="controls">
			<input type="text" id="admin_usuario" name="admin_usuario" placeholder="correo@ejemplo.com" value="">
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label" for="admin_contrasenia">Contraseña</label>
		    <div class="controls">
			<input type="password" id="admin_contrasenia" name="admin_contrasenia" placeholder="********" value="">
			<input type="hidden" name="op" id="op" value="userlogin"/>
			<input type="hidden" name="ti" id="ti"/>
			<input type="hidden" name="ke" id="ke"/>
		    </div>
		</div>
		<div class="control-group">
		    <label class="control-label"></label>
		    <div class="controls" style="color: red !important;">
			<?php echo $mensaje ?>
		    </div>
		</div>
		<div class="control-group">
		    <div class="controls">
			<button type="submit" class="btn btn-info">Ingresar</button>
		    </div>
		</div>
	    </form>
	</section>
	<footer id="footer_wrap">
	    <?php 
	    include 'include/generic_footer.php'; 
	    ?>
	</footer>
	<script type="text/javascript">
	    $(document).ready(function(){
		$('#ti').val(_utval);
		$('#ke').val(_gcode);
	    });
	</script>
    </body>
</html>