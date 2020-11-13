<?php
require_once 'Modelos/conexionBD.php';
    class Usuario extends BaseDatos{
        private $nombre;
        private $apellidos;
        private $email;
        private $contrasena;
        private $conex;

        function __construct(String $nom=null,String $apell=null,String $em=null,String $contra=null){
            $this->conex=parent::conectar();
            $this->nombre=$nom;
            $this->apellidos=$apell;
            $this->email=$em;
            $this->contrasena=$contra;
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

        public function save(){
            $sql = "insert into usuario values('{$this->obtener_nombre()}', '{$this->obtener_apellidos()}', '{$this->obtener_contrasena()}', '{$this->obtener_email()}')";
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
    }
?>