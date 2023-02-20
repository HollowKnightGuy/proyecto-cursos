<?php

    require_once __DIR__.'../../vendor/autoload.php';
    use Dotenv\Dotenv;
    use Lib\ResponseHttp;
    use Lib\Router;
    use Controllers\ApiponenteController;
    use Controllers\ApiUsuarioController;
    use Controllers\PonenteController;
    use Controllers\UsuarioController;

    require_once '../views/layout/header.php';




    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv -> safeLoad();  



    //Ruta para obtener todos los ponentes
    Router::add('GET','ponente',function(){
        (new PonenteController()) -> getAll();
    });

    //Ruta para obtener datos de un ponente
    Router::add('GET','ponente/:id',function(int $ponenteid){
         (new ApiponenteController()) -> getPonente($ponenteid);
    });

    //Ruta para crear ponente
    Router::add('POST','ponente/crear',function(){
        (new ApiponenteController())->crearPonente();
    });
    
    //Ruta para borrar ponente
    Router::add('DELETE','ponente/:id',function(int $ponenteid){
        (new ApiponenteController()) -> borrarPonente($ponenteid);
    });

    //Ruta para editar ponente
    Router::add('PUT','ponente/:id',function($ponenteid){
        (new ApiponenteController()) -> actualizaPonente($ponenteid);
    });

    //Ruta para registrar un usuario
    Router::add('GET','usuario/crear',function(){
        (new UsuarioController()) -> registro();
    });

    //Ruta para loguearse como usuario
    Router::add('GET','usuario/login',function(){
        (new UsuarioController()) -> login();
    });
    

    Router::dispatch();


require_once '../views/layout/footer.php';

?>
