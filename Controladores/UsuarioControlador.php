<?php
    require_once 'Modelos/UsuarioModelo.php';
    class UsuarioControlador {
        public function principal(){
            require_once 'Vistas/Principal.html';
        }

        public function cambiocontra(){
            require_once 'Vistas/CambioContra.html';
        }

        public function contacto(){
            require_once "Vistas/contacto.html";
        }

        public function terminos(){
            require_once "Vistas/Terminos.html";
        }

        public function hola(){
            require_once "Vistas/hola.phtml";
        }
    
        public function save(){
            if(!isset($_POST['register'])){
                require_once 'Vistas/Registro.phtml';
                $_SESSION['error_registro']=false;
            }else{
                $nombre = isset($_POST['nombres']) ? $_POST['nombres'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['correos']) ? $_POST['correos'] : false;
                $pass = isset($_POST['contrasenas']) ? $_POST['contrasenas'] : false;
                if($nombre && $apellidos && $email && $pass){
                    $usuario = new Usuario($nombre,$apellidos,$email,$pass);
                    $usuario->save();
                    header("Location:index.php?c=Usuario&&a=iniciosesion");
                }
                else{
                    $_SESSION['error_registro'] = "Rellena todos los campos";
                    header("Location:index.php?c=Usuario&&a=save");
                }
            } 
        }

        public function iniciosesion(){
            if (!isset($_POST['inicio'])){
                require_once 'Vistas/InicioSesion.phtml';
                $_SESSION['error_login']=false;
            }else{
                $email = isset($_POST['correos']) ? $_POST['correos'] : false;
                $pass = isset($_POST['contrasenas']) ? $_POST['contrasenas'] : false;
                if($email && $pass)
                {
                    $_SESSION['error_login']=false;
                    $usuario = new Usuario();
                    $usuario->insertar_email($email);
                    $usuario->insertar_contrasena($pass);
                    $miusuario=$usuario->iniciosesion();
                    if($miusuario){
                        $_SESSION['identidad'] = $miusuario;
                        var_dump($_SESSION['identidad']);
                    }else{
                        $_SESSION['error_login'] = "Usuario y/o contraseña incorrecto(s)";
                        header("Location:index.php?c=Usuario&&a=iniciosesion");
                    }
    
                }
                else{
                    $_SESSION['error_login'] = "Rellena todos los campos";
                    header("Location:index.php?c=Usuario&&a=iniciosesion");
                }
               
            }

        }

    }
        
?>
