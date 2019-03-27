<?php

/** 
 Acceder al recurso de gurpos
 * GET
 * localhost/~instructor/horarios/grupos
 * 
 Registrar grupo
 * POST
 * localhost/~instructor/horarios/grupo/registro
 * 
 Obtener un grupo por clave
 * GET
 * localhost/~instructor/horarios/grupo/[clave]
 * 
 Modificar información de un grupo
 * PUT
 * localhost/~instructor/horarios/grupo/[clave]
 * 
 Eliminar grupo
 * DELETE
 * localhost/~instructor/horarios/grupo/[clave]
*/
class Grupos {
    const NOMBRE_TABLA = "grupos";
    const CLAVE_GRUPO = "clave_grupo";
    const ALUMNO = "alumno";
    const ASIGNATURA = "asignatura";

    public static function get()
    {
        # code...
    }
    
    public static function post()
    {
        # code...
    }

    public static function put()
    {
        # code...
    }

    public static function delete()
    {
        # code...
    }
}