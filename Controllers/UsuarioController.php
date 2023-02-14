<?php


    namespace Controllers;
    use Models\Usuario;
    use Lib\ResponseHttp;
    use Lib\Pages;

    class UsuarioController{

        private Pages $pages;
        private Usuario $usuario;


        public function __construct()
        {
            ResponseHttp::setHeaders();
            $this -> usuario = new Usuario();
            $this -> pages = new Pages();
        }


        public function login(){
            
        }

        public function registro(){
            var_dump(1);die;
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $usuario = new Usuario();
                $datos_usuario = json_decode(file_get_contents("php://input"));
                var_dump($datos_usuario);die;
                if($usuario->validarDatos($datos_usuario)){

                    $usuario -> setId($datos_usuario -> id);
                    $usuario -> setNombre($datos_usuario -> nombre);
                    $usuario -> setApellidos($datos_usuario -> apellidos);
                    $usuario -> setEmail($datos_usuario -> email);
                    $usuario -> setPassword($datos_usuario -> password);
                    $usuario -> setRol($datos_usuario -> rol);
                    $usuario -> setConfirmado($datos_usuario -> confirmado);

                    if($usuario -> registro($datos_usuario)){
                        http_response_code(200);
                        $result = json_decode(ResponseHttp::statusMessage(200,"usuario creado correctamente"));
                    }else{
                        http_response_code(404);
                        $result = json_decode(ResponseHttp::statusMessage(404,"No se ha podido crear el usuario"));
                    }

                }else{
                    http_response_code(404);
                    $result = json_decode(ResponseHttp::statusMessage(404,"Error al validar los datos de usuario"));
                }


            }else{

                $result = json_decode(ResponseHttp::statusMessage(404,"Error el método de recogida de datos debe de ser POST"));
            }

            $this -> pages -> render("read",['result' => json_encode($result)]);
        }


        /*public function getAll(){
            $usuarios = $this  ->  ponente->findAll();
            $PonenteArr = [];
            if(!empty($ponentes)){
                $PonenteArr["message"] = json_decode(ResponseHttp::statusMessage(202,'OK'));
                $PonenteArr["Ponentes"] = [];
                foreach($ponentes as $fila){
                    $PonenteArr["Ponentes"][] = $fila;
                }
            }else{
                $PonenteArr["message"] = json_decode(ResponseHttp::statusMessage(400, 'No hay ponentes'));
                $PonenteArr["Ponentes"] = [];
            }
            if($PonenteArr==[]){
                $response = json_encode(ResponseHttp::statusMessage(400,'No hay ponentes'));
            }else{
                $response = json_encode($PonenteArr);
            }
            $this -> pages -> render('read',['response' => $response]);
            
        }

        public function getPonente($id){
            $ponentes = $this -> ponente->findOne($id);
            $PonenteArr = [];
            if(!empty($ponentes)){
                $PonenteArr["message"] = json_decode(ResponseHttp::statusMessage(202,'OK'));
                $PonenteArr["Ponentes"] = [];
                foreach($ponentes as $fila){
                    $PonenteArr["Ponentes"][] = $fila;
                }
            }else{
                $PonenteArr["message"] = json_decode(ResponseHttp::statusMessage(400, 'No hay ponentes'));
                $PonenteArr["Ponentes"] = [];
            }
            if($PonenteArr==[]){
                $response = json_encode(ResponseHttp::statusMessage(400,'No hay ponentes'));
            }else{
                $response = json_encode($PonenteArr);
            }
            $this -> pages -> render('read',['response' => $response]);
        }*/
    }