<?php
    require_once 'Modelos/UsuarioModelo.php';
    class UsuarioControlador {
        public function principal(){
            require_once 'Vistas/Principal.html';
        }
        public function registro(){
            require_once "Vistas/Registro.html";
        }
        public function login(){
            require_once "Vistas/InicioSesion.html";
        }

        public function save(){
            
            if(!isset($_POST['register'])){
                require_once 'Vistas/Registro.html';
            }else{
                $nombre = isset($_POST['nombres']) ? $_POST['nombres'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['correos']) ? $_POST['correos'] : false;
                $pass = isset($_POST['contrasenas']) ? $_POST['contrasenas'] : false;
                
                if($nombre && $apellidos && $email && $pass){
                    $usuario = new Usuario($nombre,$apellidos,$email,$pass);
                    $usuario->save();
                }
            }
            header("Location:index.php?c=Usuario&&a=login");
        }

    }
        
?>
