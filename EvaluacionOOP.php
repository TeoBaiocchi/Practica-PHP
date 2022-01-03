<?php
//Prueba resuelta Teo Baiocchi 6to Info

interface Mensaje {
    
    public function contenido();
    public function fecha();
    public function emisor();
}

interface Grupo {
    
    public function agregarUsuario(Usuario $usuario);
    public function quitarUsuario(Usuario $usuario);
    public function enviarMensaje(Mensaje $mensaje);
}

interface Usuario {
    
    public function enviarMensajeAUsuario(Usuario $usuario, Mensaje $mensaje);
    public function enviarMensajeAGrupo(Grupo $grupo, Mensaje $mensaje);
    public function recibirMensaje(Mensaje $mensaje);
    public function identificador();
}


class Persona implements Usuario{
    protected $nombre;
    
    public function __construct(string $nombre){
        $this->nombre = $nombre;
    }
    
    public function identificador(){
        return $this->nombre;
    }
    
    public function enviarMensajeAUsuario(Usuario $u, Mensaje $m){
        $u->recibirMensaje($m);
    }
    
    public function enviarMensajeAGrupo(Grupo $grupo, Mensaje $m){
        $grupo->enviarMensaje($m);   
    }
    
    public function recibirMensaje(Mensaje $mensaje){
        $emisor = $mensaje -> emisor();
        $nombre = $emisor -> identificador();
        print($this -> nombre . " recibió un mensaje de " .$nombre . " que dice: " . $mensaje->contenido() . "\n");
    }
}

class chatGrupal implements Grupo{
   
    protected $integrantes = [];
    
    public function agregarUsuario(Usuario $usuario) {
        $nombre = $usuario -> identificador();
        $this->integrantes[$nombre] = $usuario;
    }
    
    public function quitarUsuario(Usuario $usuario) {
        $nombre = $usuario -> identificador();
        unset($this -> integrantes[$nombre]);
    }
    
    public function enviarMensaje (Mensaje $mensaje) {
        print("Envio de mensaje grupal: \n");
        $nomEmisor = $mensaje -> emisor() -> identificador ();
        foreach($this -> integrantes as $miembro) {
            if($miembro -> identificador() != $nomEmisor) {
                $miembro -> recibirMensaje($mensaje); 
            }
        }
    print("Fin de envio grupal. \n\n");
    }
}

class SMS implements Mensaje{
    protected $contenido;
    protected $fecha;
    protected $emisor;
    
    public function __construct(string $contenido, Usuario $emisor){
        $this -> contenido = $contenido;
        $this -> fecha = date('d-m-y h:i:s');
        $this -> emisor = $emisor;
    }
    
    public function contenido(){
        return $this -> contenido;
    }
    public function fecha(){
        return $this -> fecha;
    }
    public function emisor(){
        return $this -> emisor;
    }
}

class Empresa extends Persona {
    
    public function recibirMensaje(Mensaje $mensaje){
        $emisor = $mensaje -> emisor();
        $nombre = $emisor -> identificador();
        print($this -> nombre . " recibió un mensaje de " .$nombre . " que dice: " . $mensaje->contenido() . "\n");
        $respuestaAutomatica = new SMS ("Respondremos a la brevedad, gracias por su mensaje", $this);
        $this -> enviarMensajeAUsuario($emisor, $respuestaAutomatica);
    }
}

$escuela = new chatGrupal();


$alicia = new Persona("Alicia"); 
$roberto = new Persona("Roberto");
$damian = new Persona("Damian");
$chivoexpiatorio = new Persona("chivo"); // va a ser agregado y eliminado del chat grupal, para comprobar que funciona correctamente 
// el agregado y eliminado de la lista.
$RemerasOK = new Empresa ("RemerasOK");

$escuela -> agregarUsuario($alicia);
$escuela -> agregarUsuario($damian);
$escuela -> agregarUsuario($roberto);
$escuela -> agregarUsuario($chivoexpiatorio);
$escuela -> quitarUsuario($chivoexpiatorio);


$msgParaGrupo = new SMS("Nos vemos en la escuela", $alicia);
$msgDamianRoberto = new SMS("Trae la guitarra", $damian);
$msgAlicia = new SMS ("Hola, cuanto cuesta la remera?", $alicia);
//$respuestaAutomatica = new SMS("Respondremos a la brevedad, gracias por su mensaje");
// Iba a generar esto acá, pero decidí testar generar la instancia dentro de la clase 
print("1) \n");
$alicia -> enviarMensajeAGrupo($escuela, $msgParaGrupo);
print("2) \n");
$damian -> enviarMensajeAUsuario($roberto, $msgDamianRoberto);
print("3) \n");
$alicia -> enviarMensajeAUsuario($RemerasOK, $msgAlicia);

/* 4) Una clase es una definición de propiedades (o atributos) y comportamientos (metodos) que va a tomar un objeto que
sea de dicha clase. Los objetos van a tomar estas propiedades y comportamientos de la clase que los define, pero puedo
tener múltiples objetos de una misma clase y estos van a ser independientes entre sí y van a tener su propio estado interno

Una interfaz, por otro lado, es una definición que comprende métodos que una clase DEBE tener para poder decir que 
implementa dicha interfaz. Es una forma de estandarizar los ingresos y mejorar la modulación genérica del código*/
?>
