<?php
include 'include/generic_validate_session.php';
include 'lib/ControllerData.php';
/**
 * se cargan datos
 */
$DATOS = new ControllerData();
$DATOS->dataget();
$arrdatos = $DATOS->getResponse();
$isvalid = $arrdatos['output']['valid'];
$arrdatos = $arrdatos['output']['response'];
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
                $_ACTIVE_SIDEBAR = 'datos';
                include 'include/generic_navbar.php';
                ?>
            </div>
            <div class="container">
                <a href="#" id="creardatos" class="btn btn-info botoncrear">Crear</a>
                <h3>Datos</h3>
                <div>
                    <table class="table table-hover dyntable" id="dynamictable">
                        <thead>
                            <tr>
<!--                                <th class="head0" style="width: 140px;">Acciones</th>-->
                                <th class="head0" style="width: 120px;">Acciones</th>
                                <th class="head1">Pavimentados</th>
                                <th class="head0">Inversión</th>
                                <th class="head1">Fecha</th>
                                <th class="head0">Fecha Registro</th>
                            </tr>
                        </thead>
                        <colgroup>
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                        </colgroup>
<!--                                    <td class="con0"><a href="#" onclick="editdata();"><span class="ui-icon ui-icon-pencil"></span></a><a href="#"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                        <tbody>
                            <?php
                            $c = count($arrdatos);
                            if ($isvalid) {
                                for ($i = 0; $i < $c; $i++) {
                                    ?>
                                    <tr class="gradeC">
                                        <td class="con0">
                                            <a href="#" onclick="DATOS.editdata(<?php echo $arrdatos[$i]['hcmtr_id']; ?>);"><span class="icon-pencil"></span></a>
                                            <a href="#" onclick="DATOS.deletedata(<?php echo $arrdatos[$i]['hcmtr_id']; ?>);"><span class="icon-trash"></span></a>
                                        </td>
                                        </td>
                                        <td class="con1"><?php echo $arrdatos[$i]['hcmtr_pavimentado']; ?></td>
                                        <td class="con0"><?php echo $arrdatos[$i]['hcmtr_inversion']; ?></td>
                                        <td class="con1"><?php echo $arrdatos[$i]['hcmtr_fecha']; ?></td>
                                        <td class="con0"><?php echo $arrdatos[$i]['hcmtr_fchregist']; ?></td>
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
        <div id="dialog-form" title="Datos" style="display: none;">
            <p class="validateTips"></p>
            <form class="form-horizontal" id="formcreate">
                <div class="control-group">
                    <label class="control-label">Total Huecos Pavimentados</label>
                    <div class="controls"><input type="text" name="hcmtr_pavimentado" id="hcmtr_pavimentado" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Inversion Total</label>
                    <div class="controls"><input type="text" name="hcmtr_inversion" id="hcmtr_inversion" class="text ui-widget-content ui-corner-all" /></div>
                </div>
                <div class="control-group">
                    <label class="control-label">Seleccione la fecha</label>
                    <div class="controls"><input type="text" name="hcmtr_fecha" id="hcmtr_fecha" class="text ui-widget-content ui-corner-all" /></div>
                </div>

            </form>
        </div>
        <?php include 'include/generic_script.php'; ?>
        <link rel="stylesheet" media="screen" href="css/dynamictable.css" type="text/css" />
        <script type="text/javascript" src="js/jquery/jquery-dataTables.js"></script>
        <script type="text/javascript" src="js/datos.js"></script>
    </body>
</html>