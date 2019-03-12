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
  const NOMBRE_TABLA = "alumnos";
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
  const ESTADO_FALLA_DESCONOCIDA = 504;
  const ESTADO_DATOS_INCORRECTOS = 423;

  function __construct()
  {
    // code...
  }

  public static function post($solucitud)
  {
    if (isset($solucitud)) {
      if ($solucitud[0] == "registro") {
        return self::registrarAlumno();
      } elseif ($solucitud[0] == "ingresar") {
        return self::ingresar();
      } else {
        throw new ExceptionApi(self::ESTADO_URL_INCORRECTA,
          "Solicitud Incorrecta.");
      }
    } else {
      throw new ExceptionApi(self::ESTADO_DATOS_INCORRECTOS,
        "Error al solicitar información.");

    }

  }

  private static function registrarAlumno()
  {
    // { "nControl":"i15120278","nombre":"Zaira","a_paterno":"Sandoval","a_materno":"Garcia","carrera":"INF","email":"zahyrasg09@gmail.com"}
    // {   "nControl": "i15120285",  "nombre": "Alfredo",  "a_paterno": "Maciel",  "a_materno": "Torres",  "carrera": "INF",  "password": "passwordZhido123",  "email": "i15120285@alumnos.itsur.edu.mx" }
    $cuerpo = file_get_contents('php://input');
    $alumnno = json_decode($cuerpo);

    $resultado = self::crearAlumno($alumnno);
    switch($resultado) {
      case self::ESTADO_CREACION_OK:
        http_response_code(200);
        return [
          "estado"=>self::ESTADO_CREACION_OK,
          "mensaje"=>utf8_encode("Registro creado.")
        ];
        break;
      case self::ESTADO_CREACION_ERROR:
        throw new ExceptionApi(
          self::ESTADO_CREACION_ERROR,
          'Error al crear el Alumno.'
        );
        break;
      default:
        throw new ExceptionApi(
          self::ESTADO_FALLA_DESCONOCIDA,
          "Error desconocido.");
    }
  }

  public static function ingresar()
  {
    // { "email":"zahyrasg09@gmail.com","password":".........." }
    $cuerpo = file_get_contents('php://input');
    $datosAlumno = json_decode($cuerpo);

    $respuesta = array();

    $email = $datosAlumno->email;
    $password = $datosAlumno->password;

    if (self::autenticarAlumno($email, $password)) {
      $alumnno = self::getAlumnoPorEmail($email);
      if ($alumnno != null) {
        http_response_code(200);
        return [
          "estado" => self::ESTADO_CREACION_OK,
          "alumno" => $alumnno
        ];
      } else {
        throw new ExceptionApi(self::ESTADO_FALLA_DESCONOCIDA,
        "Error al obtener los datos del Alumno.");
      }
    } else {
      throw new ExceptionApi(self::ESTADO_DATOS_INCORRECTOS,
        "Email o password incorrectos");
    }
  }

  function autorizarAlumno(){
    $cabecera = apache_request_headers();
    if (isset($cabecera["Authorization"])) {
      $claveApi = $cabecera["Authorization"];
      if (Alumnos::validarClaveApi($claveApi)) {
        return Alumnos::getIdAlumno($claveApi);
      } else {
        throw new ExceptionApi(self::ESTADO_CLAVE_NO_AUTORIZADA,
          "Clave API no valida.");
      }
    } else {
      throw new ExceptionApi(self::ESTADO_NO_CLAVE_API,
        "Se requiere una clave API para la autorización.");
    }
  }

  private function getIdAlumno($claveApi)
  {
    /*
    1. Escribir la consulta para obtener Numero de Control Alumno.
    2. Ejecutar la consulta.
    3. Convertir el resultado de la consulta a un arreglo.
    4. Devolver el Numero de Control del Alumno.
    */

    $sql = "SELECT " . self::NCONTROL .
           " FROM " . self::NOMBRE_TABLA .
           " WHERE " . self::CLAVE_API . " = $claveApi";

    $pdo = ConexionBD::obtenerInstancia()->obtenerConexion()->prepare($sql);
    $pdo->excecute();

    $resultado = $pdo->fetch();
    return $resultado['nControl'];
  }

  private static function validarClaveApi($claveApi) {
    $sql = "SELECT COUNT(". self::NCONTROL .")".
          " FROM " . self::NOMBRE_TABLA .
          " WHERE " . self::CLAVE_API . " = $claveApi";

    $pdo = ConexionBD::obtenerInstancia()->obtenerConexion()->prepare($sql);
    $pdo->excecute();

    return $pdo->fetchColumn(0) > 0;
  }

  static function getAlumnoPorEmail($email) {
    $sql = "SELECT " .
            self::NCONTROL . ", " .
            self::NOMBRE . ", " .
            self::A_PATERNO . ", " .
            self::A_MATERNO . ", " .
            self::CARRERA . ", " .
            self::CLAVE_API .
            " FROM " . self::NOMBRE_TABLA .
            " WHERE " . self::EMAIL . " = ?" ;

    $pdo = ConexionBD::obtenerInstancia()->obtenerConexion();
    $query = $pdo->prepare($sql);
    $query->bindParam(1,$email);

    if ($query->execute()) {
      return $query->fetch(PDO::FETCH_ASSOC);
    } else {
      return null;
    }
  }

  public static function autenticarAlumno($email, $password)
  {
    $sql = "SELECT " . self::PASSWORD .
           " FROM " . self::NOMBRE_TABLA .
           " WHERE " . self::EMAIL . " = ?";
    try {
      $pdo = ConexionBD::obtenerInstancia()->obtenerConexion();
      $query = $pdo->prepare($sql);
      $query->bindParam(1, $email);
      $resultado = $query->execute();

      if ($resultado) {
        $resultado = $query->fetch();
        if (password_verify($password, $resultado['password'])) {
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }

    } catch (PDOException $e) {
      throw new ExceptionApi(self::ESTADO_ERROR_BD, $e);
    }
  }

  private static function crearAlumno($datosAlumno)
  {
    $nControl = $datosAlumno->nControl;
    $nombre = $datosAlumno->nombre;
    $password = $datosAlumno->password;
    $passwordEnc = self::encriptarPassword($password);
    $email = $datosAlumno->email;
    try {
      $pdo = ConexionBD::obtenerInstancia()->obtenerConexion();
      $sql = "INSERT INTO " . self::NOMBRE_TABLA . " (".
        self::NCONTROL . "," .
        self::NOMBRE . "," .
        self::A_PATERNO . "," .
        self::A_MATERNO . "," .
        self::CARRERA . "," .
        self::EMAIL . "," .
        self::PASSWORD . "," .
        self::CLAVE_API . ") VALUES (?,?,?,?,?,?,?,?)";
      $query = $pdo->prepare($sql);
      $query->bindParam(1, $nControl);
      $query->bindParam(2, $nombre);
      $query->bindParam(3, $datosAlumno->a_paterno);
      $query->bindParam(4, $datosAlumno->a_materno);
      $query->bindParam(5, $datosAlumno->carrera);
      $query->bindParam(6, $datosAlumno->email);
      $query->bindParam(7, $passwordEnc);
      $clave = self::generarClaveApi();
      $query->bindParam(8, $clave);

      $resultado = $query->execute();

      if ($resultado) {
        return self::ESTADO_CREACION_OK;
      } else {
        return self::ESTADO_CREACION_ERROR;
      }
    } catch (PDOException $e) {
      throw new ExceptionApi(ESTADO_ERROR_BD,
        $e->getMessage());
    }
  }

  private static function generarClaveApi()
  {
    $tiempo = microtime().rand();
    return md5($tiempo);
  }

  private static function encriptarPassword($password)
  {
    if ($password) {
      return password_hash($password, PASSWORD_DEFAULT);
    } else {
      return null;
    }
  }
}
?>
