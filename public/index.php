<?php

    require_once __DIR__.'../../vendor/autoload.php';
    use Dotenv\Dotenv;
    use Models\Ponente;
    use Lib\ResponseHttp;
    use Lib\Router;
    use Controllers\ApiponenteController;
    use Controllers\UsuarioController;


    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    http_response_code(202);
    $array = ["estado" => '202', "mensaje" => 'Estamos en el index principal'];
    echo json_encode($array);
    
    //echo ResponseHttp::statusMessage(404,'La página de ponentes no existe');

    Router::add('GET','proyecto-cursos',function(){echo 'saludo';});

    Router::add('GET','auth',function(){require '../views/auth.php';});


    //Ruta para obtener todos los ponentes
    Router::add('GET','ponente',function(){
        (new ApiponenteController()) -> getAll();
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
    Router::add('POST','usuario/crear',function(){
        (new UsuarioController()) -> registro();
    });

    //Ruta para loguearse como usuario
    Router::add('POST','usuario/login',function(){
        (new UsuarioController()) -> login();
    });
    
    Router::dispatch();

?>