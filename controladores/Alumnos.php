<?php
// Alumnos.php
/**
  Acceder al recurso alumnos
 * GET
 * localhost/horarios/alumnos/
 *
 Registrar alumnos
 * POST
 * localhost/horarios/alumnnos/registro
 *
 Acceder al WS
 * POST
 * localhost/horarios/alumnos/login
 */
define('ESTADO_URL_INCORRECTA', 400);
define('ESTADO_DATOS_INCORRECTOS',423);

class Alumnos
{
  const NCONTROL = "nControl";
  const NOMBRE = "nombre";
  const A_PATERNO = "a_paterno";
  const A_MATERNO = "a_materno";
  const CARRERA = "carrera";
  const EMAIL = "email";
  const PASSWORD = "password";
  const CLAVE_API = "claveApi";

  const ESTADO_CREACION_OK = 200;
  const ESTADO_CREACION_ERROR = 404;
  const ESTADO_ERROR_BD = 500;
  const ESTADO_NO_CLAVE_API = 422;
  const ESTADO_CLAVE_NO_AUTORIZADA = 401;
  //const ESTADO_URL_INCORRECTA = 400;
  //define("ESTADO_URL_INCORRECTA", 400);
  const ESTADO_FALLA_DESCONOCsIDA = 504;
  //const ESTADO_DATOS_INCORRECTOS = 423;

  function __construct()
  {
    // code...
  }

  function crear($datosAlumno)
  {
    $nombre = $datosAlumno->nombre;
    $password = $datosAlumno->password;
    $passwordEnc = self::encriptarPassword($password);
    $correo = $datosAlumno->correo;
  }

  function encriptarPassword($password)
  {
    if ($password) {
      return password_hash($password, PASSWORD_DEFAULT);
    } else {
      return null;
    }
  }
}


?>
