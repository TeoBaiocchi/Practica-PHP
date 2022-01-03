<?php

//Nota: Este es el primer programa que vimos/hicimos para entender la OOP. 
// Consiste unicamente en una clase "Semaforo" que cambia de estado, o color, 
// segun intervalos de tiempo dados.

class Semaforo {

  protected $tiempo;
  protected $intermitente;
  protected $color;
    
   public function __construct(string $color) {
    $this->tiempo = 0;
    $this->color = $this->identificarColor($color);
    $this->intermitente = FALSE;
    if ($this->color === 4) $this->intermitente = TRUE;
  }


  public function pasoDelTiempo(int $tiempo) { 
    for ($i = 0; $i < 269; $i++) { 
        if ($this->tiempo === 0)    
            print($this->mostrarColor());
        $this->tiempo = $this->tiempo + $tiempo;
        $this->actualizarColor();
    }    
  }

  protected function actualizarColor() {
    if ($this->color === 0 && $this->tiempo === 30) { //rojo
      $this->color = 1;
      $this->tiempo = 0;
    }

    if ($this->color === 1 && $this->tiempo === 2) { //rojo-amarillo
      $this->color = 3;
      $this->tiempo = 0;
    }

    if ($this->color === 2 && $this->tiempo === 2) { //amarillo
      $this->color = 0;
      $this->tiempo = 0;
    }

    if ($this->color === 3 && $this->tiempo === 20) { //verde
      $this->color = 2;
      $this->tiempo = 0;
    }
  }

  public function mostrarColor() : string {
    if ($this->intermitente) {
      return 'Intermitente ';
    }

    if ($this->color === 0) {
      return 'Rojo -> ';
    }

    if ($this->color === 1) {
      return 'Amarillo-Rojo -> ';
    }

    if ($this->color === 2) {
      return 'Amarillo -> ';
    }

    if ($this->color === 3) {
      return 'Verde -> ';
    }
   
    return '';
  }

  protected function identificarColor(string $color) : int {
    $c = strtolower($color);
    if ($c == 'rojo-amarillo') {
      return 1;
    }
    if ($c == 'amarillo') {
      return 2;
    }
    if ($c == 'verde') {
      return 3;
    }
    if ($c == 'intermitente') {
        return 4;
    }
    return 0;
  }

}

$s = new Semaforo("rojo"); 
$s->pasoDelTiempo(1); // Cambiar esta variable funcionaría como un multiplicador del paso del tiempo

?>