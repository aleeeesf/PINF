<?php
    class BaseDatos{
        private static $basedatos="mysql:host=localhost;dbname=usuarios;charset=utf8";
        private static $username="root";
        private static $password="";
        public function conectar()
        {
            try {
                $conex=new PDO(self::$basedatos,self::$username,self::$password);
                $conex->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $conex;
            }
            catch(PDOException $e){
                echo ("ERROR DE CONEXIÓN ".$e->getMessage());
            }
        }
    }
?>