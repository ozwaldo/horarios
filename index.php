<?php
  // print $_GET['PATH_INFO'];
  // require_once "datos/ConexionBD.php";
  // print ConexionBD::obtenerInstancia()->obtenerConexion()->errorCode();

  require 'datos/ConexionBD.php';
  require 'controladores/Alumnos.php';
  require 'controladores/Asignaturas.php';
  require 'vistas/VistaJson.php';
  require 'utils/ExceptionApi.php';

  $vista = new VistaJson();

  set_exception_handler(
    function ($exception) use ($vista) {
      $body = array(
        "estado" => $exception->estado,
        "mensaje" => $exception->getMessage()
      );
      if ($exception->getCode()) {
        $vista->mEstado = $exception->getCode();
      } else {
        $vista->mEstado = 500;
      }
      $vista->imprimir($body);
    }
  );

  if (isset($_GET['PATH_INFO'])) {
    $peticion = explode('/',$_GET['PATH_INFO']);
    //print_r($peticion);
  } else {
    throw new ExceptionApi(ESTADO_URL_INCORRECTA,"Solicitud incorrecta");
  }

  $recurso = array_shift($peticion);
  $recursos_disponibles = array("alumnos","grupos","asignaturas");

  //echo "Recurso: " . $recurso;

  if (!in_array($recurso,$recursos_disponibles)) {
    throw new ExceptionApi(ESTADO_DATOS_INCORRECTOS, "Recurso no disponible");
  }

  $metodo = strtolower($_SERVER['REQUEST_METHOD']);

  switch ($metodo) {
    case 'get':
      $vista->imprimir(Asignaturas::get($peticion));
      break;
    case 'post':
      $vista->imprimir(Alumnos::post($peticion));
      break;
    case 'put':

      break;
    case 'delete':

      break;
    default:
      # code...
      break;
  }

?>
