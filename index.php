<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pinfbet</title>
        <link rel="icon"  type="image/png" href="Estatico/Imagenes/pinfcoin.png">
    </head>
    <body>
        <?php
            session_start();
            require_once "Controladores/UsuarioControlador.php";
            require_once "Controladores/AmistadControlador.php";
        ?> 
        
        <main>
            <?php
                if(!isset($_GET['c']) || !isset($_GET['a'])){
                    $controlador = new UsuarioControlador();
                    $controlador->principal();
                }else{
                    $nombreControlador = $_GET['c'].'Controlador';
                    if(class_exists($nombreControlador)){
                        $controlador = new $nombreControlador();
                        if(method_exists($controlador, $_GET['a'])){
                            $action = $_GET['a'];
                            $controlador->$action();
                        }else echo "La página que buscas no existe";
                    }else echo "La página que buscas no existe";
                }
            ?>
        </main>
        
    </body>
</html>