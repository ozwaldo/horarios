<?php
    // ExceptionApi.php

    class ExceptionApi extends Exception  
    {
        public $estado;

        function __construct($estado, $mensaje, $codigo = 400)
        {
            $this->estado = $estado;
            $this->message = $mensaje;
            $this->code = $codigo;
        }
    }
?>