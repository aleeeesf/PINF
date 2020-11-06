<?php
require_once 'Modelos/conexionBD.php';
    class Usuario extends BaseDatos{
        private $nombre;
        private $apellidos;
        private $email;
        private $contrasena;
        private $conex;

        function __construct(String $nom,String $apell,String $em,String $contra){
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

        public function save(){
            $sql = "insert into usuario values('{$this->obtener_nombre()}', '{$this->obtener_apellidos()}', '{$this->obtener_contrasena()}', '{$this->obtener_email()}')";
            $save = $this->conex->exec($sql);
            
            $resultado = false;
            
            if($save){
                $resultado = true;
            }
            return $resultado;
    
        }
    }
?>