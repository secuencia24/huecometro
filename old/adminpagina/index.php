<?php
session_start();
//$cl = $_REQUEST['cl'];
$cl = isset($_GET['cl']) ? intval($_GET['cl']) : "";
if ($cl == 1) {
    $_SESSION['idlogin'] = "";
}
// Inicializar la sesión.
// Si está usando session_name("algo"), ¡no lo olvide ahora!
// Destruir todas las variables de sesión.
$_SESSION = array();
// Si se desea destruir la sesión completamente, borre también la cookie de sesión.
// Nota: ¡Esto destruirá la sesión, y no la información de la sesión!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}
// Finalmente, destruir la sesión.
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Logeo</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- estilo menu flip -->
        <link type="text/css" rel="stylesheet" href="css/menuflip.css"></link>
        <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
        <script type="text/javascript" src="js/menuflip.js"></script>
        <!-- fin estilo menu -->
        <script type="text/javascript" src="js/ajax.js"></script>

        <!-- Le styles -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                max-width: 300px;
                padding: 19px 29px 29px;
                margin: 0 auto 20px;
                background-color: #fff;
                border: 1px solid #e5e5e5;
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin input[type="text"],
            .form-signin input[type="password"] {
                font-size: 16px;
                height: auto;
                margin-bottom: 15px;
                padding: 7px 9px;
            }

        </style>
        <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="../assets/js/html5shiv.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
        <link rel="shortcut icon" href="../assets/ico/favicon.png">
    </head>

    <body>
        <div class="container">

            <form action="controlador/ctr_login.php" method="post" class="form-signin" id="form1" name="form1" >
              <h5 class="form-signin-heading" style="margin-bottom:2px !important;">Iniciar sesión</h5>
              <div style="text-align:center; width:90%;"><img src="images/logocmsblasColor.png" width="100%"></div>
              <input type="text" class="input-block-level" name="usuario" id="usuario" placeholder="Usuario" required>
                <input  name="password" id="password" type="password" value="" class="input-block-level" placeholder="Password" required>
                <!--        <label class="checkbox">
                          <input type="checkbox" value="remember-me"> Remember me
                        </label>-->
                <button class="btn btn-large btn-primary" type="submit" name="enviar" id="enviar" >Ingresar</button>
                <input name="action" type="hidden" id="ingre" value="ingre" />

            </form>
            <?php
            //$_SESSION["usuario"] = $row['password'];
            ?>
        </div> <!-- /container -->

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="bootstrap/js/jquery.js"></script>
        <script src="bootstrap/js/bootstrap-transition.js"></script>
        <script src="bootstrap/js/bootstrap-alert.js"></script>
        <script src="bootstrap/js/bootstrap-modal.js"></script>
        <script src="bootstrap/assets/js/bootstrap-dropdown.js"></script>
        <script src="bootstrap/js/bootstrap-scrollspy.js"></script>
        <script src="bootstrap/js/bootstrap-tab.js"></script>
        <script src="bootstrap/js/bootstrap-tooltip.js"></script>
        <script src="bootstrap/js/bootstrap-popover.js"></script>
        <script src="bootstrap/js/bootstrap-button.js"></script>
        <script src="../assets/js/bootstrap-collapse.js"></script>
        <script src="../assets/js/bootstrap-carousel.js"></script>
        <script src="../assets/js/bootstrap-typeahead.js"></script>

    </body>
</html>
