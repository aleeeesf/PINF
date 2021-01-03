<?php
    require_once 'Modelos/UsuarioModelo.php';
    require_once 'Modelos/AsignaturaModelo.php';
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

        public function miperfil(){
            require_once "Vistas/MiPerfil.phtml";
        }
        
        public function ayuda(){
            require_once "Vistas/ayuda.html";
        }

        public function asignaturas(){
            require_once "Vistas/asignatura.phtml";
        }

        public function amigos(){
            require_once "Vistas/principal_amigos.phtml";
        }

        public function apostar(){
            if(!isset($_SESSION['identidad'])){
                require_once 'Vistas/Registro.phtml';
                $_SESSION['error_registro']=false;
            }else{
                if (isset($_POST['apuestas'])){
                    echo "eoeoeoe";
                    //$asignatura = isset($_POST[])
                }
                else{
                    $asig= new Asignatura();
                    $asig->insertar_id_user($_SESSION['identidad']->id);
                    $misasignaturas=$asig->asignaturas_matriculadas_usuario();
                    $apuestas = (new Usuario())->mostrar_apuestas();
                    require_once 'Vistas/apostar.phtml';
                }
            }
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
                    $usuario = new Usuario($nombre,$apellidos,$email,$pass,$ide,$carrera,null);
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
                $usuario=new Usuario(null,null,null,null,null,$usuario_ant->id_carrera,null);
                $carreras=$usuario->listado_carreras();
                require_once "Vistas/EditarPerfil.phtml";
            }
            else
            {
                $nombre = isset($_POST['nombres']) ? $_POST['nombres'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['correos']) ? $_POST['correos'] : false;
                $contrasena = isset($_POST['contrasenas']) ? $_POST['contrasenas'] : false;
                $ide = isset($_POST['identificadores']) ? $_POST['identificadores'] : false;
                $carrera = $_POST['carreras']=='false' ? false : $_POST['carreras'];
                if($nombre && $apellidos  && $contrasena && $ide && $carrera)
                {
                    $usuario_nuevo=new Usuario(null,null,null,null,null,$usuario_ant->id_carrera,$usuario_ant->id,$usuario_ant->pinfcoins);
                    $usuario_nuevo->insertar_nombre($nombre);
                    $usuario_nuevo->insertar_apellidos($apellidos);
                    $usuario_nuevo->insertar_email($email);
                    $usuario_nuevo->insertar_contrasena($contrasena);
                    $usuario_nuevo->insertar_identificador($ide);
                    $usuario_nuevo->insertar_carrera($carrera);
                    var_dump($usuario_nuevo);
                    $usuario_nuevo->actualizar_usuario();
                    $_SESSION['identidad'] = null;
                    session_destroy();
                    header("Location:index.php?c=Usuario&&a=iniciosesion");
                    
                }
            }
            if(!isset($_POST['Agregar']))
            {
                /*$name = $_FILES['imagen']['name'];*/
                if(isset($_FILES['imagen']['name']))
                {
                    $dir = "Estatico/Profiles/";
                    $tipo = ".jpg";
                    $nombre = $_SESSION['identidad']->id;

                    if($_FILES['imagen']['type'] == "image/jpg")
                    {
                        echo "tipo no reconocido";
                    }
                    else
                    {
                        move_uploaded_file($_FILES['imagen']['tmp_name'], $dir.$nombre.$tipo);
                    }
                }
            
            }
        }

        public function aprobadas()
        {
            if (!isset($_SESSION['identidad']))
            {
                header("Location:index.php");
            }
            $usuario=$_SESSION['identidad'];
            $user=new Usuario($usuario->Nombre,$usuario->Apellidos,$usuario->email,$usuario->contrasena,$usuario->identificador,$usuario->id_carrera,$usuario->id,$usuario->pinfcoins);
            if(!isset($_POST['aprobadas']))
            {
                $asignaturas=$user->listado_asignaturas();
                require_once "Vistas/aprobadas.phtml";
            }
            else
            {
                $asignatura = $_POST['asignaturas']=='false' ? false : $_POST['asignaturas'];
                $nota=isset($_POST['notas']) ? $_POST['notas'] : false;
                $nota1=(int)$nota;
                if ($asignatura)
                {
                    $id=(int)$asignatura;
                    $asig=new Asignatura(null,null,$id,null,null);
                    $asig->insertar_id_user($user->obtener_id());
                    //var_dump($id);
                    $asig->insertar_asignatura_aprobada();
                    $asig_ap=$asig->buscar_asignatura();
                    $user->insertar_pinfcoins($user->obtener_pinfcoins()+ ($nota1*$asig_ap->numero_creditos));
                    $user->actualizar_usuario();
                    $_SESSION['identidad']->pinfcoins=$user->obtener_pinfcoins();
                    $asig->borrar_asignatura();
                    header("Location:index.php?c=Usuario&&a=aprobadas");
                }
                else{
                    $_SESSION['error_asignatura_aprobada'] = "Selecciona asignatura";
                    header("Location:index.php?c=Usuario&&a=aprobadas");
                }
            }
        }

        public function matriculadas()
        {
            if (!isset($_SESSION['identidad']))
            {
                header("Location:index.php");
            }
            $usuario=$_SESSION['identidad'];
            $user=new Usuario(null,null,null,null,null,$usuario->id_carrera,$usuario->id,null);
            if(!isset($_POST['matriculadas']))
            {
                
                $asignaturas=$user->listado_asignaturas();
                require_once "Vistas/matriculadas.phtml";
            }
            else
            {
                $asignatura = $_POST['asignaturas']=='false' ? false : $_POST['asignaturas'];
                if ($asignatura)
                {
                    $id=(int)$asignatura;
                    $asig=new Asignatura(null,null,$id,null,null);
                    $asig->insertar_id_user($user->obtener_id());
                    //var_dump($id);
                    $asig->insertar_asignatura_matriculada();
                    header("Location:index.php?c=Usuario&&a=matriculadas");
                }
                else{
                    $_SESSION['error_asignatura_matriculada'] = "Selecciona asignatura";
                    header("Location:index.php?c=Usuario&&a=matriculadas");
                }
            }
        }

    }
        
?>
