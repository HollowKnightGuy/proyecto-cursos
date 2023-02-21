<?php

    require_once __DIR__.'../../vendor/autoload.php';
    use Dotenv\Dotenv;
    use Lib\ResponseHttp;
    use Lib\Router;
    use Controllers\ApiponenteController;
    use Controllers\ApiUsuarioController;
    use Controllers\PonenteController;
    use Controllers\UsuarioController;



    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv -> safeLoad();  

    require_once '../views/layout/header.php';



    //Ruta para obtener todos los ponentes
    Router::add('GET','/',function(){
        (new PonenteController()) -> getAll();
    });

    //Ruta para crear ponente
    Router::add('GET','ponente/crear',function(){
        (new PonenteController())->crearPonente();
    });

    //Ruta para crear ponente
    Router::add('POST','ponente/crear',function(){
        (new PonenteController())->crearPonente();
    });
    
    //Ruta para borrar ponente
    Router::add('GET','ponente/borrar/:id',function(int $ponenteid){
        (new PonenteController()) -> borrarPonente($ponenteid);
    });

    //Ruta para editar ponente
    Router::add('GET','ponente/actualizar/:id',function($ponenteid){
        (new PonenteController()) -> actualizaPonente($ponenteid);
    });

    Router::add('POST','ponente/actualizar/:id',function($ponenteid){
        (new PonenteController()) -> actualizaPonente($ponenteid);
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
