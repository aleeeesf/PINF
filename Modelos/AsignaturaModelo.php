<?php
require_once 'Modelos/conexionBD.php';
    class Asignatura extends BaseDatos
    {
        private $nombre;
        private $num_creditos;
        private $id;
        private $curso;
        private $id_carrera;
        private $id_user;
        private $conex;

        function __construct(String $nom=null, Int $creditos=null, Int $id_asig=null,Int $curs=null,String $id_carr=null)
        {
            $this->conex=parent::conectar();
            $this->nombre=$nom;
            $this->num_creditos=$creditos;
            $this->id=$id_asig;
            $this->curso=$curs;
            $this->id_carrera=$id_carr;
        }
        function insertar_id_user(Int $id)
        {
            $this->id_user=$id;
        }

        function insertar_id_asignatura(Int $id_a){
            $this->id=$id_a;
        }
        function obtener_nombre() {
            return $this->nombre;
        }

        function obtener_creditos() {
            return $this->num_creditos;
        }

        function obtener_identificador() {
            return $this->id;
        }

        function obtener_curso() {
            return $this->curso;
        }

        function obtener_carrera() {
            return $this->id_carrera;
        }

        function obtener_id_usuario() {
            return $this->id_user;
        }

        
        public function buscar_asignatura()
        {
            $sql="select * from asignatura where id_asignatura={$this->obtener_identificador()}";
            $save = $this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $asignatura = $save->fetchObject();
            }
            return $asignatura;
        }

        public function insertar_asignatura_aprobada()
        {
            $sql = "insert into asignaturas_aprobadas values({$this->obtener_id_usuario()},{$this->obtener_identificador()})";
            $save = $this->conex->exec($sql);
            
            $resultado = false;
            if($save){
                $resultado = true;
            }
            return $resultado;
        }

        public function insertar_asignatura_matriculada()
        {
            $sql = "insert into asignaturas_matriculadas values({$this->obtener_id_usuario()},{$this->obtener_identificador()})";
            $save = $this->conex->exec($sql);
            
            $resultado = false;
            if($save){
                $resultado = true;
            }
            return $resultado;
        }

        function borrar_asignatura() {
            $sql = "delete from asignaturas_matriculadas where id_asignatura={$this->obtener_identificador()} and id={$this->obtener_id_usuario()}";
            $this->conex->exec($sql);
        }

        function asignaturas_matriculadas_usuario(){
            $sql="select * from asignatura where id_asignatura in (select id_asignatura from asignaturas_matriculadas where id = {$this->obtener_id_usuario()})";
            $save = $this->conex->query($sql);
            return $save;
        }

        function comprobar_asignatura_aprobada(){
            $sql = "select * from asignaturas_aprobadas where id_asignatura={$this->obtener_identificador()} and id={$this->obtener_id_usuario()}";
            $save = $this->conex->query($sql);
            if($save->rowCount()==0){
                return true;
            }
            else{
                return false;
            }
        }

        function comprobar_asignatura_matriculada(){
            $sql = "select * from asignaturas_matriculadas where id_asignatura={$this->obtener_identificador()} and id={$this->obtener_id_usuario()}";
            $save = $this->conex->query($sql);
            if($save->rowCount()==0){
                return true;
            }
            else{
                return false;
            }
        }

        function recuento_asignaturas_aprobadas(){
            $sql ="select count(id_asignatura) num from asignaturas_aprobadas where id={$this->obtener_id_usuario()}";
            $save = $this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $asignatura = $save->fetchObject();
            }
            return $asignatura;
        }

        function recuento_asignaturas_matriculadas(){
            $sql ="select count(id_asignatura) num from asignaturas_matriculadas where id={$this->obtener_id_usuario()}";
            $save = $this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $asignatura = $save->fetchObject();
            }
            return $asignatura;
        }
        
    }
?>