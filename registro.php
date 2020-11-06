<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pinfbet</title>
        <link rel="icon"  type="image/png" href="Estatico/Imagenes/5.png">
        <link rel="stylesheet" href="Estatico/Estilos/estilos.css">
    </head>
    <body>
        <?php
            session_start();
            require_once "Controladores/UsuarioControlador.php";
        ?>
        <header>
            <?php
                require_once "Plantillas/navegacion.html";
            ?>
        </header>
        <main>
            <?php
                if(!isset($_GET['c']) || !isset($_GET['a'])){
                    $controlador = new UsuarioControlador();
                    $controlador->registro();
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