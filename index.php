<?php
  //print $_GET['PATH_INFO'];
  require_once "datos/ConexionBD.php";
  print ConexionBD::obtenerInstancia()->obtenerConexion()->errorCode();
?>
