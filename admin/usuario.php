<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerUser.php';
/**
 * se cargan datos
 */
$USUARIO = new ControllerUser();
$USUARIO->userget();
$arrusuarios = $USUARIO->getResponse();
$isvalid = $arrusuarios['output']['valid'];
$arrusuarios = $arrusuarios['output']['response'];
?>
<!DOCTYPE html>
<html>
    <head>
	<?php include 'include/generic_head.php'; ?>
    </head>
    <body>
        <header>
	    <?php
	    include 'include/generic_header.php';
	    ?>
        </header>
        <section id="section_wrap">
            <div class="container">
		<?php
		$_ACTIVE_SIDEBAR = 'usuario';
		include 'include/generic_navbar.php';
		?>
            </div>
            <div class="container">
                    <a href="#" id="crearusuario" class="btn btn-info botoncrear">Crear</a>
                <h3>Usuario</h3>
                <div>
                    <table class="table table-hover dyntable" id="dynamictable">
                        <thead>
                            <tr>
                                <th class="head0" style="width: 70px;">Acciones</th>
                                <th class="head1">Nombre usuario</th>
                                <th class="head0">Fecha ingreso</th>
                                <th class="head1">Fecha registro</th>
                            </tr>
                        </thead>
                        <colgroup>
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                        </colgroup>
                        <tbody>
			    <?php
			    $c = count($arrusuarios);
			    if ($isvalid) {
				for ($i = 0; $i < $c; $i++) {
				    ?>
				    <tr class="gradeC">
					<td class="con0">
	    				    <a href="#" onclick="USUARIO.editdata(<?php echo $arrusuarios[$i]['admin_id']; ?>);"><span class="icon-pencil"></span></a>
	    				    <a href="#" onclick="USUARIO.deletedata(<?php echo $arrusuarios[$i]['admin_id']; ?>);"><span class="icon-trash"></span></a>
					</td>
					<td class="con1"><?php echo $arrusuarios[$i]['admin_usuario']; ?></td>
					<td class="con0"><?php echo $arrusuarios[$i]['admin_ingreso']; ?></td>
					<td class="con1"><?php echo $arrusuarios[$i]['admin_fecharegistro']; ?></td>
				    </tr>
				    <?php
				}
			    }
			    ?>
                        </tbody>
                    </table>
                </div>
            </div>	    
        </section>
        <footer id="footer_wrap">
	    <?php include 'include/generic_footer.php'; ?>
        </footer>
        <div id="dialog-form" title="Usuario" style="display: none;">
            <p class="validateTips"></p>
            <table>
                <tr>
                    <td>
                        <form id="formcreate1" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Usuario</label>
                                <div class="controls"><input type="text" name="admin_usuario" id="admin_usuario" class="text ui-widget-content ui-corner-all" /></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Contraseña</label>
                                <div class="controls"><input type="password" name="admin_contrasenia" id="admin_contrasenia" class="text ui-widget-content ui-corner-all" /></div>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
	<?php include 'include/generic_script.php'; ?>
        <link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
        <script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
        <script type="text/javascript" src="js/lib/data-md5.js"></script>
        <script type="text/javascript" src="js/usuario.js"></script>
    </body>
</html>