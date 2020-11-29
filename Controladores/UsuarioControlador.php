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

        public function apuestas(){
            require_once "Vistas/Apuestas.phtml";
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
                $ide = isset($_POST['identificadores']) ? $_POST['identificadores'] : false;
                $carrera = $_POST['carreras']=='false' ? false : $_POST['carreras'];
                if($nombre && $apellidos && $email && $pass && $ide && $carrera){
                    $usuario = new Usuario($nombre,$apellidos,$email,$pass,$ide,$carrera);
                    if($usuario->identificador_repetido())
                    {
                        $_SESSION['error_registro'] = "Identificador repetido";
                        header("Location:index.php?c=Usuario&&a=save");
                    }

                    else{
                        if($usuario->email_repetido())
                        {
                            $_SESSION['error_registro'] = "Email repetido";
                            header("Location:index.php?c=Usuario&&a=save");
                        }
                        else{
                            $usuario->save();
                            header("Location:index.php?c=Usuario&&a=iniciosesion");
                        }
                    }
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
                        header("Location:index.php?c=Usuario&&a=apuestas");
                        //var_dump($_SESSION['identidad']);
                    }else{
                        $_SESSION['error_login'] = "Usuario y/o contraseña incorrecto(s)";
                        header("Location:index.php?c=Usuario&&a=iniciosesion");
                    }
    
                }
                else{
                    $_SESSION['error_login'] = "Rellena todos los campos";
                }
                

            }

        }
        
        public function logout(){
            $_SESSION['identidad'] = null;
            session_destroy();
            header("Location:index.php");
        }

        public function editar_usuario()
        {
            if (!isset($_SESSION['identidad']))
            {
                header("Location:index.php");
            }
            $usuario_ant=$_SESSION['identidad'];
            if(!isset($_POST['edit_user']))
            {
                require_once "Vistas/EditarUsuario.phtml";
            }
            else
            {
                $nombre = isset($_POST['nombres']) ? $_POST['nombres'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['correos']) ? $_POST['correos'] : false;
                $pass = isset($_POST['contrasenas']) ? $_POST['contrasenas'] : false;
                $ide = isset($_POST['identificadores']) ? $_POST['identificadores'] : false;
                $carrera = $_POST['carreras']=='false' ? false : $_POST['carreras'];
                if($nombre && $apellidos && $email && $pass && $ide && $carrera)
                {
                    $usuario_ant->insertar_nombre($nombre);
                    $usuario_ant->insertar_apellidos($apellidos);
                    $usuario_ant->insertar_email($email);
                    $usuario_ant->insertar_contrasena($contrasena);
                    $usuario_ant->insertar_identificador($ide);
                    $usuario_ant->insertar_carrera($carrera);
                    $usuario_ant->actualizar_usuario();
                    $_SESSION['identidad']=$usuario_ant;
                }
            }
        }

    }
        
?>
