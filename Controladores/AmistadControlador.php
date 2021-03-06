<?php
    require_once 'Modelos/UsuarioModelo.php';
    require_once 'Modelos/AmistadModelo.php';
    class AmistadControlador{
        
        public function bandeja()
        {if(!isset($_SESSION['identidad']))
            {
                require_once "Vistas/Registro.phtml";
            }else{
                $amistad = new Amistad(null,$_SESSION['identidad']->id);
                $respuestas = $amistad->respuestas();
                require_once "Vistas/bandeja.phtml";
            }
        }

        public function amigo()
        {if(!isset($_SESSION['identidad']))
            {
                require_once "Vistas/Registro.phtml";
            }else{
                if(!isset($_POST['apostar_amigo']))
                {
                    $amistad = new Amistad($_SESSION['identidad']->id,null);
                    $amigos1 = $amistad->obtener_amigos();
                    require_once "Vistas/principal_amigos.phtml";
                } else {
                    $_SESSION['id_amigo'] = $_POST['id_amigo'];
                    header("Location:index.php?c=Usuario&&a=apostar_amigo");
                }
            }
        }

        public function buscador(){
            if(!isset($_SESSION['identidad']))
            {
                require_once "Vistas/Registro.phtml";
            }else{
                $user=$_SESSION['identidad'];
                $usuario1=new Usuario(null,null,null,null,null,null,$user->id);
                $encontrado=false;
                $_SESSION['error_buscador'] = false;
                if(!isset($_POST['amigo']))
                {
                    require_once "Vistas/buscador.phtml";
                }else{
                    $amigo= isset($_POST['amigo']) ? $_POST['amigo'] : false;
                    if ($amigo)
                    {
                        $usuario=new Usuario(null,null,null,null,$amigo,null,null);
                        $usuario2=$usuario->buscar_amigo();
                        if($usuario2==false){
                            $_SESSION['error_buscador']="No se ha encontrado";
                        } else{
                            $amistad = new Amistad($user->id, $usuario2->id);
                            $encontrado = $amistad->comprobar_amistad();
                            if ($encontrado)
                            {
                                if ($encontrado->id_user1 == $user->id) {
                                    $soySolicitante = true;
                                } else {
                                    $soySolicitante = false;
                                }
                            }
                        }
                    } else
                    {
                        $_SESSION['error_buscador'] = "Introduce un id";
                    }
                    require_once "Vistas/buscador.phtml";
                }
            }
        }

        public function enviar_solicitud() {
            if (!isset($_SESSION['identidad'])) {
                require_once 'Vistas/Registro.phtml';
            } else {
                if (isset($_POST['enviar_solicutud'])) {
                    $id2 = isset($_POST['id2']) ? $_POST['id2'] : false;

                    if ($id2) {
                        $id1 = $_SESSION['identidad']->id;
                        $amistad = new Amistad($id1, $id2);
                        $amistad->enviar_solicitud();
                        require_once 'Vistas/buscador.phtml';
                    } else {
                        $_SESSION['error_enviar'] = "No se ha podido enviar la solicitud";
                        header("Location:index.php");
                    }
                }
                require_once 'Vistas/buscador.phtml';
            }
        }

        public function responder_solicitud() {
            if (!isset($_SESSION['identidad'])) {
                require_once 'Vistas/Registro.phtml';
            } else {
                if (!isset($_POST['aceptar_amigo']) && !isset($_POST['rechazar_amigo'])) {
                    require_once 'Vistas/buscador.phtml';
                } else {

                    $id1 = isset($_POST['id1']) ? $_POST['id1'] : false;
                    if ($id1) {
                        $id2 = $_SESSION['identidad']->id;
                        $amistad = new Amistad($id1, $id2);
                        if (isset($_POST['aceptar_amigo'])) {
                            $amistad->aceptar_amigo();
                        } else {
                            $amistad->rechazar_amigo();
                        }
                        header("Location:index.php?c=Amistad&&a=buscador");
                    } else {
                        header("Location:index.php");
                    }
                }
            }
        }
    }   
?>
