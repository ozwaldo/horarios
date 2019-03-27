<?php
// VistaJson.php

require_once 'VistaApi.php';
/**
 *
 */
class VistaJson extends VistaApi
{
  function __construct()
  {
    
  }

  public function imprimir($cuerpo)
  {
    if ($this->mEstado) {
      http_response_code($this->mEstado);    
    }
    header('Content-Type: application/json; charset=utf8');
    echo json_encode($cuerpo, JSON_PRETTY_PRINT);
    exit;
  }
}

 ?>
