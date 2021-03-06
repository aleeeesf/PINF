<?php
    require_once 'Modelos/UsuarioModelo.php';
    require_once 'Modelos/AsignaturaModelo.php';
    require_once 'Modelos/UsuApuesAsigModelo.php';
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

        public function declaracion(){
            require_once "Vistas/declaracionresp.html";
        }

        public function apuestas(){
            $asig=new Asignatura(null,null,null,null,null);
            $asig->insertar_id_user($_SESSION['identidad']->id);
            $num=$asig->recuento_asignaturas_aprobadas();
            $num1=(int)$num->num;
            $amist=new Amistad(null,null);
            $amist->insertar_identif1($_SESSION['identidad']->id);
            $num2=$amist->recuento_amigos();
            $num3=(int)$num2->num4;
            require_once "Vistas/Apuestas.phtml";
        }

        public function miperfil(){
            $asig=new Asignatura(null,null,null,null,null);
            $asig->insertar_id_user($_SESSION['identidad']->id);
            $num=$asig->recuento_asignaturas_aprobadas();
            $num1=(int)$num->num;
            $asig1=new Asignatura(null,null,null,null,null);
            $asig1->insertar_id_user($_SESSION['identidad']->id);
            $num2=$asig1->recuento_asignaturas_matriculadas();
            $num3=(int)$num2->num;
            require_once "Vistas/MiPerfil.phtml";
        }
        
        public function ayuda(){
            require_once "Vistas/ayuda.html";
        }

        public function asignaturas(){
            require_once "Vistas/asignatura.phtml";
        }


        public function apostar(){
            if(!isset($_SESSION['identidad'])){
                require_once 'Vistas/Registro.phtml';
                $_SESSION['error_registro']=false;
                $_SESSION['acertar']=false;
                $_SESSION['fallar']=false;
            }else{

                $_SESSION['error_apostar']  = false;
                $_SESSION['acertar']=false;
                $_SESSION['fallar']=false;
                $asig= new Asignatura();
                $asig->insertar_id_user($_SESSION['identidad']->id);
                $misasignaturas=$asig->asignaturas_matriculadas_usuario();
                $apuestas = (new Usuario())->mostrar_apuestas();
                if (isset($_POST['apuestas'])){
                    $asigapos = $_POST['asignaturas']=='false' ? false : $_POST['asignaturas'];
                    $apos = $_POST['apuesta']=='false' ? false : $_POST['apuesta'];
                    $pinfc=isset($_POST['pinfcoin']) ? $_POST['pinfcoin'] : false;

                    $asig->insertar_id_asignatura($asigapos);
                    if($asigapos && $apos && $pinfc){
                        $apuesta= new UsuApuesAsig ($_SESSION['identidad']->id,(int)$asigapos,(int)$apos);
                        $aleatorio=rand(0,10);
                        
                        $cuota=($apuesta->obtener_cuota())->fetchObject();
                        $cuota1=(float)$cuota->cuota;
                        $pinfcoins_t = $_SESSION['identidad']->pinfcoins-$pinfc;
                        if($apos==1 && $aleatorio<5){
                            
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==1){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($apos==2 && $aleatorio >= 5){
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==2){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($apos==3 && $aleatorio == 10){
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==3){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($apos==4 && $aleatorio == 0){
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==4){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($apos==5 && $aleatorio ==4){
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==5){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($aleatorio >=5){
                            $asig1=$asig->buscar_asignatura();
                            $pinfcoins_t=$pinfcoins_t+($aleatorio*$asig1->numero_creditos);
                            $asig->insertar_asignatura_aprobada();
                            $asig->borrar_asignatura();
                        }
                        $_SESSION['identidad']->pinfcoins=$pinfcoins_t;
                        $user=new Usuario(null,null,null,null,null,null,$_SESSION['identidad']->id,$_SESSION['identidad']->pinfcoins);
                        $user->actualizar_pinfcoins_usuario();
                        $apuesta->insertar_apuesta();
                    } else {
                        $_SESSION['error_apostar'] = "Rellena todos los campos";
                    }
                    require_once 'Vistas/apostar.phtml';
                    //header("Location:index.php?c=Usuario&&a=apostar");
                    //$asignatura = isset($_POST[])
                }
                require_once 'Vistas/apostar.phtml';
                
            }
        }

        public function apostar_amigo(){
            if(!isset($_SESSION['identidad'])){
                require_once 'Vistas/Registro.phtml';
                $_SESSION['error_registro']=false;
                $_SESSION['acertar']=false;
                $_SESSION['fallar']=false;
            }else{
                $_SESSION['error_apostar_amigo']  = false;
                $_SESSION['acertar']=false;
                $_SESSION['fallar']=false;
                $asig= new Asignatura();
                $asig->insertar_id_user($_SESSION['id_amigo']);
                $misasignaturas=$asig->asignaturas_matriculadas_usuario();
                $apuestas = (new Usuario())->mostrar_apuestas();
                if (isset($_POST['apuestas'])){
                    $asigapos = $_POST['asignaturas']=='false' ? false : $_POST['asignaturas'];
                    $apos = $_POST['apuesta']=='false' ? false : $_POST['apuesta'];
                    $pinfc=isset($_POST['pinfcoin']) ? $_POST['pinfcoin'] : false;

                    $asig->insertar_id_asignatura($asigapos);
                    if($asigapos && $apos && $pinfc){
                        $apuesta= new UsuApuesAsig ($_SESSION['identidad']->id,$asigapos,$apos);
                        $aleatorio=rand(0,10);
                        
                        $cuota=($apuesta->obtener_cuota())->fetchObject();
                        $cuota1=(float)$cuota->cuota;
                        $pinfcoins_t = $_SESSION['identidad']->pinfcoins-$pinfc;
                        if($apos==1 && $aleatorio<5){
                            
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==1){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($apos==2 && $aleatorio >= 5){
                            $pinfcoins_t=$pinfcoins_t+($pinfc*$cuota1);
                            $pinfcoins_t=(int)$pinfcoins_t;
                            $_SESSION['acertar']="Has acertado la apuesta";
                        }
                        else{
                            if($apos==2 ){
                                $_SESSION['fallar']="Has fallado la apuesta";
                            }
                        }
                        if($aleatorio >= 5){
                            $user=new Usuario(null,null,null,null,null,null,$_SESSION['id_amigo']);
                            $user2=$user->buscar_usuario_id();
                            $asig1=$asig->buscar_asignatura();
                            $pinfcoins_u=$user2->pinfcoins+($aleatorio*$asig1->numero_creditos);
                            $user->insertar_pinfcoins($pinfcoins_u);
                            $user->actualizar_pinfcoins_usuario();
                            $asig->insertar_asignatura_aprobada();
                            $asig->borrar_asignatura();
                        }
                        $_SESSION['identidad']->pinfcoins=$pinfcoins_t;
                        $user1=new Usuario(null,null,null,null,null,null,$_SESSION['identidad']->id,$_SESSION['identidad']->pinfcoins);
                        $user1->actualizar_pinfcoins_usuario();
                        $apuesta->insertar_apuesta();
                    }
                    else {
                        $_SESSION['error_apostar_amigo'] = "Rellena todos los campos";
                    }
                    require_once 'Vistas/apostar_amigo.phtml';
                }
                require_once 'Vistas/apostar_amigo.phtml';
                
            }
        }

        public function save(){ 
            if(!isset($_POST['register'])){
                $user=new Usuario(null,null,null,null,null,null,null);
                $carreras=$user->listado_carreras();
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
                    $usuario = new Usuario($nombre,$apellidos,$email, md5($pass),$ide,$carrera,null,40);
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
                    $password = md5($pass);
                    $usuario->insertar_contrasena($password);
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
            $usuario=new Usuario(null,null,null,null,null,$usuario_ant->id_carrera,null);
            $carreras=$usuario->listado_carreras();
            $_SESSION['error_actualizar'] = false;
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
                    $usuario_nuevo=new Usuario($nombre,$apellidos,$email,md5($contrasena),$ide,$usuario_ant->id_carrera,$usuario_ant->id,$usuario_ant->pinfcoins);
                    $usuario_nuevo->actualizar_usuario();
                    $_SESSION['identidad'] = null;
                    session_destroy();
                    header("Location:index.php?c=Usuario&&a=iniciosesion");                    
                } else {
                    if ($nombre && $apellidos && $ide && $carrera) {
                        $usuario_nuevo=new Usuario($nombre,$apellidos,$email,null,$ide,$usuario_ant->id_carrera,$usuario_ant->id,$usuario_ant->pinfcoins);
                        $usuario_nuevo->actualizar_usuario_no_password();
                        $_SESSION['identidad'] = null;
                        session_destroy();
                        header("Location:index.php?c=Usuario&&a=iniciosesion");
                    } else {
                        $_SESSION['error_actualizar'] = "Rellena todos los campos";
                        require_once 'Vistas/EditarPerfil.phtml';
                    }
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
                $_SESSION['error_asignatura_aprobada']=false;
            }
            else
            {
                $asignatura = $_POST['asignaturas']=='false' ? false : $_POST['asignaturas'];
                $nota=isset($_POST['notas']) ? $_POST['notas'] : false;
                $nota1=(int)$nota;
                if ($asignatura && $nota1)
                {
                        if($nota1 <= 10)
                        {

                            if($nota1 >= 5)
                            {
                                $id=(int)$asignatura;
                                $asig=new Asignatura(null,null,$id,null,null);
                                $asig->insertar_id_user($user->obtener_id());
                                //var_dump($id);
                                if($asig->comprobar_asignatura_aprobada() == true)
                                {
                                    $_SESSION['error_asignatura_aprobada']=false;
                                    $asig->insertar_asignatura_aprobada();
                                    $asig_ap=$asig->buscar_asignatura();
                                    $user->insertar_pinfcoins($user->obtener_pinfcoins()+ ($nota1*$asig_ap->numero_creditos));
                                    $user->actualizar_pinfcoins_usuario();
                                    $_SESSION['identidad']->pinfcoins=$user->obtener_pinfcoins();
                                    $asig->borrar_asignatura();
                                    header("Location:index.php?c=Usuario&&a=aprobadas");
                                }
                                else{
                                    $_SESSION['error_asignatura_aprobada'] = "La asignatura ya está aprobada";
                                    header("Location:index.php?c=Usuario&&a=aprobadas");
                                }
                            }
                            
                            else{
                                $_SESSION['error_asignatura_aprobada'] = "No has aprobado la asignatura";
                                    header("Location:index.php?c=Usuario&&a=aprobadas");
                            }    

                        }

                        else{
                            $_SESSION['error_asignatura_aprobada'] = "Nota no valida";
                            header("Location:index.php?c=Usuario&&a=aprobadas");
                        }
                                        
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
                $_SESSION['error_asignatura_matriculada']=false;
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
                    if($asig->comprobar_asignatura_aprobada()==true){
                        if($asig->comprobar_asignatura_matriculada()==true)
                        {
                            $_SESSION['error_asignatura_matriculada']=false;
                            $asig->insertar_asignatura_matriculada();
                            header("Location:index.php?c=Usuario&&a=matriculadas");
                        }
                        else{
                            $_SESSION['error_asignatura_matriculada']="Ya estás matriculado";
                            header("Location:index.php?c=Usuario&&a=matriculadas");
                        }
                    }else{
                        $_SESSION['error_asignatura_matriculada']="Ya has aprobado";
                        header("Location:index.php?c=Usuario&&a=matriculadas");
                    }   
  
                }
                else{
                    $_SESSION['error_asignatura_matriculada'] = "Selecciona asignatura";
                    header("Location:index.php?c=Usuario&&a=matriculadas");
                }
            }
        }
    }
        
?>
