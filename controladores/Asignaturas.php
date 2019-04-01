<?php
/** 
 Acceder al recurso de asignaturas
 * GET
 * localhost/~instructor/horarios/asignaturas
 * 
 Registrar asignatura
 * POST
 * localhost/~instructor/horarios/asignatura/registro
 * 
 Obtener un asignatura por clave
 * GET
 * localhost/~instructor/horarios/asignatura/[clave]
 * 
 Modificar información de una asignatura
 * PUT
 * localhost/~instructor/horarios/asignatura/[clave]
 * 
 Eliminar asignatura
 * DELETE
 * localhost/~instructor/horarios/asignatura/[clave]
*/
class Asignaturas {
    const NOMBRE_TABLA = "asignaturas";
    const CLAVE_ASIG = "clave_asig";
    const NOMBRE = "nombre";
    const CREDITOS = "creditos";
    const HT = "ht";
    const HP = "hp";

    public static function get($peticion)
    {
        $nControl = Alumnos::autorizarAlumno();
        if (empty($peticion)) {
           return self::getAsignaturas($nControl); 
        } else {
           return self::getAsignaturas($nControl, $peticion[0]);
        }
    }
    
    public static function post()
    {
        # code...
    }

    public static function put($peticion)
    {
        # code...
    }

    public static function delete($peticion)
    {
        # code...
    }

    public function getAsignaturas($nControl, $claveAsig = NULL)
    {
        try {
            if (!$claveAsig) {
                
                // Obtener las asignaturas que pertenezcan al
                // alumno autorizado.
                
                $sql = "SELECT a.nombre FROM ". self::NOMBRE_TABLA . 
                " a INNER JOIN grupos g " . 
                "ON g.asignatura = a.clave_asig ". 
                "WHERE g.alumno = " . $nControl;

                $pdo = ConexionBD::obtenerInstancia()->obtenerConexion()->prepare($sql);
                $pdo->bindParam(1, $nControl);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}