<?php
require_once 'Modelos/conexionBD.php';
    class Usuario extends BaseDatos{
        private $nombre;
        private $apellidos;
        private $email;
        private $contrasena;
        private $conex;
        private $identificador;
        private $pinfcoins;
        private $carrera;
        function __construct(String $nom=null,String $apell=null,String $em=null,String $contra=null,String $id=null,String $carrer=null){ 
            $this->conex=parent::conectar();
            $this->nombre=$nom;
            $this->apellidos=$apell;
            $this->email=$em;
            $this->contrasena=$contra;
            $this->identificador=$id;
            $this->pinfcoins=1000;
            $this->carrera=$carrer;
        }

        function obtener_nombre() {
            return $this->nombre;
        }

        function obtener_apellidos(){
            return $this->apellidos;
        }

        function obtener_email(){
            return $this->email;
        }

        function obtener_contrasena(){
            return $this->contrasena;
        }

        function obtener_identificador(){
            return $this->identificador;
        }

        function obtener_pinfcoins(){
            return $this->pinfcoins;
        }

        function obtener_carrera(){
            return $this->carrera;
        }

        function insertar_nombre(String $nombre){
            $this->nombre=$nombre;
        }

        function insertar_apellidos(String $apellidos){
            $this->apellidos=$apellidos;
        }

        function insertar_contrasena(String $contrasena){
            $this->contrasena=$contrasena;
        }

        function insertar_email(String $email){
            $this->email=$email;
        }

        function insertar_identificador(String $ident){
            $this->identificador=$ident;
        }

        function insertar_pinfcoins(Int $pinfc){
            $this->pinfcoins=$pinfc;
        }

        function insertar_carrera(String $carrer){
            $this->carrera=$carrer;
        }

        public function identificador_repetido(){
            $ident=false;
            $sql="select * from usuario where identificador='{$this->obtener_identificador()}'";
            $save=$this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $ident = true;
            }
            return $ident;
        }

        public function email_repetido(){
            $ident=false;
            $sql="select * from usuario where email='{$this->obtener_email()}'";
            $save=$this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $ident = true;
            }
            return $ident;
        }

        public function save(){
            $sql = "insert into usuario values('{$this->obtener_nombre()}', '{$this->obtener_apellidos()}', '{$this->obtener_contrasena()}', '{$this->obtener_email()}','{$this->obtener_identificador()}','{$this->obtener_pinfcoins()}','{$this->obtener_carrera()}' )";
            $save = $this->conex->exec($sql);
            
            $resultado = false;
            if($save){
                $resultado = true;
            }
            return $resultado;
    
        }

        public function iniciosesion(){
            $usuario=false;
            $sql = "select * from usuario where email='{$this->obtener_email()}' and contrasena='{$this->obtener_contrasena()}'";
            $save = $this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $usuario = $save->fetchObject();
            }
            return $usuario;
        }

        public function actualizar_usuario()
        {
            $usuario=false;
            $sql = "update 'usuario' set 'Nombre'='{$this->obtener_nombre()}','Apellidos'='{$this->obtener_apellidos()}','contrasena'='{$this->obtener_contrasena()}','email'='{$this->obtener_email()}','identificador'='{$this->obtener_identificador()}','pinfcoins'='{$this->obtener_pinfcoins()}','id_carrera'={$this->obtener_carrera()} where 1";
            $save = $this->conex->query($sql);
            $resultado = false;
            if($save){
                $resultado = true;
            }
            return $resultado;
        }
    }
?>