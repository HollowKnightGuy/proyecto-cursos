<?php


    namespace Controllers;
    use Models\Usuario;
    use Lib\ResponseHttp;
    use Lib\Pages;
    use Lib\Security;

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
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $usuario = new Usuario();
                $datos_usuario = json_decode(file_get_contents("php://input"));
                $validacion = $usuario -> validarDatos($datos_usuario);
                if(gettype($validacion) == "boolean"){
                    $contraseniaEncrip = Security::encriptaPassw($datos_usuario -> password);

                    $usuario -> setNombre($datos_usuario -> nombre);
                    $usuario -> setApellidos($datos_usuario -> apellidos);
                    $usuario -> setEmail($datos_usuario -> email);
                    $usuario -> setPassword($contraseniaEncrip);
                    // $usuario -> setRol($datos_usuario -> rol);
                    // $usuario -> setConfirmado($datos_usuario -> confirmado);

                    
                    if($usuario -> registro()){
                        http_response_code(200);
                        $response = json_decode(ResponseHttp::statusMessage(200,"usuario creado correctamente"));
                    }else{
                        http_response_code(404);
                        $response = json_decode(ResponseHttp::statusMessage(404,"ERROR: No se ha podido crear el usuario"));
                    }

                }else{
                    http_response_code(404);
                    $response = json_decode(ResponseHttp::statusMessage(404, $validacion));
                }


            }else{

                $response = json_decode(ResponseHttp::statusMessage(404,"Error el método de recogida de datos debe de ser POST"));
            }

            $this -> pages -> render("read",['response' => json_encode($response)]);
        }

    }