<?php

session_start();
session_destroy();
$_SESSION = NULL;
header('Location: index.php');

?>
