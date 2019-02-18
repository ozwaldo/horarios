<?php
  // ConexionBD.php
  require_once 'datosBD.php';

  /**
   * Realiza la conexion la base de datos con los datos del archivo datosBD.php
   */
  class ConexionBD
  {

    private static $bd = null;
    private static $pdo;

    function __construct()
    {
      try {

      } catch (PDOException $e) {
        echo "<h2>Error al conectar con la base de dadtos: </h2>" . $e;
      }
    }

    public static function obtenerInstancia()
    {
      if (self::$bd == null) {
        self::$bd = new self();
      }
      return self::$bd;
    }

    public function obtenerConexion()
    {
      if (self::$pdo == null) {
        self::$pdo = new PDO(
          'mysql:dbname='.BASE_DE_DATOS.
          ';host='.HOST.';',
          USUARIO,
          PASSWORD,
          array(PDO::MYSQL_ATTR_INIT_COMMAND =>"SET NAMES utf8")
        );
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }
      return self::$pdo;
    }

    // destruimos la conexión con la base de datos.
    function __destruct() {
      self::$pdo;
    }

  }

?>
