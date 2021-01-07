<?php
require_once 'Modelos/conexionBD.php';
    class UsuApuesAsig extends BaseDatos
    {
        private $identificador_usuario;
        private $identificador_asignatura;
        private $identificador_apuesta;
        private $conex;
        function __construct(Int $id_usuario=null,Int $id_asignatura=null,Int $id_apuesta=null)
        {
            $this->conex=parent::conectar();
            $this->identificador_usuario=$id_usuario;
            $this->identificador_asignatura=$id_asignatura;
            $this->identificador_apuesta=$id_apuesta;
        }

        public function obtener_id_usuario(){
            return $this->identificador_usuario;
        }

        public function obtener_id_asignatura(){
            return $this->identificador_asignatura;
        }

        public function obtener_id_apuesta(){
            return $this->identificador_apuesta;
        }

        public function insertar_id_usuario(Int $id_user){
            $this->identificador_usuario=$id_user;
        }

        public function insertar_id_asignatura(Int $id_asig){
            $this->identificador_asignatura=$id_asig;
        }

        public function obtener_cuota()
        {
            $sql="select cuota from apuestas where id_apuesta={$this->obtener_id_apuesta()}";
            return $this->conex->query($sql);
        }

        

    }