<?php
require_once 'Modelos/conexionBD.php';
    class Amistad extends BaseDatos
    {
        private $identificador1;
        private $identificador2;
        private $conex;
        function __construct(String $identif1=null,$identif2=null)
        {
            $this->conex=parent::conectar();
            $this->identificador1=$identif1;
            $this->identificador2=$identif2;
        }

        function obtener_identif1(){
            return $this->identificador1;
        }

        function obtener_identif2(){
            return $this->identificador2;
        }

        function insertar_identif1(Int $identif1){
            $this->identificador1=$identif1;
        }
        
        function insertar_identif2(Int $identif2){
            $this->identificador2=$identif2;
        }

        function comprobar_amistad()
        {
            $amistad=false;
            $sql="select * from amigos where (id_user1={$this->obtener_identif1()} and id_user2={$this->obtener_identif2()}) or (id_user1={$this->obtener_identif2()} and id_user2={$this->obtener_identif1()})";
            $save = $this->conex->query($sql);
            if($save && ($save->rowCount()==1)){
                $amistad = $save->fetchObject();
            }
            return $amistad;

        }

        function enviar_solicitud(){
            $sql="insert into amigos values({$this->obtener_identif1()},{$this->obtener_identif2()}, false)";
            $save = $this->conex->exec($sql);
            
            $resultado = false;
            if($save){
                $resultado = true;
            }
            return $resultado;
        }

        function aceptar_amigo() {
            $sql = "update amigos set estado=true where id_user1='{$this->obtener_identif1()}' and id_user2='{$this->obtener_identif2()}'";
            $this->conex->exec($sql);
        }

        function rechazar_amigo() {
            $sql = "delete from amigos where id_user1='{$this->obtener_identif1()}' and id_user2='{$this->obtener_identif2()}'";
            $this->conex->exec($sql);
        }

        function respuestas() {
            $sql = "select * from usuario where id in (select id_user1 from amigos where id_user2 = {$this->obtener_identif2()})";
            return $this->conex->query($sql);
        }

        function obtener_amigos(){
            $sql="select * from usuario where id in(select id_user2 from amigos where id_user1='{$this->obtener_identif1()}' and estado=true) or id in(select id_user1 from amigos where id_user2='{$this->obtener_identif1()}' and estado=true)";
            return $this->conex->query($sql);
        }
    }
