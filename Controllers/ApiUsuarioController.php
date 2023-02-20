<?php


    namespace Controllers;
    use Models\Usuario;
    use Lib\ResponseHttp;
    use Lib\Pages;
    use Lib\Security;

    class ApiUsuarioController{

        private Pages $pages;
        private Usuario $usuario;


        public function __construct()
        {
            $this -> usuario = new Usuario();
            $this -> pages = new Pages();
        }


        public function login(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $usuario = $this -> usuario;
                $datos_usuario = json_decode(file_get_contents("php://input"));
                $validacion = $usuario -> validarDatosLogin($datos_usuario);
                
                if(gettype($validacion) == "boolean"){
                    $usuario -> setEmail($datos_usuario -> email);
                    $usuario -> setPassword($datos_usuario -> password);
                    
                    if($usuario -> login()){
                        http_response_code(200);
                        $response = json_decode(ResponseHttp::statusMessage(200,"[ + ] Usuario logueado correctamente"));
                    }else{
                        http_response_code(404);
                        $response = json_decode(ResponseHttp::statusMessage(404,"ERROR: No se ha podido loguear el usuario"));
                    }

                }else{
                    http_response_code(404);
                    $response = json_decode(ResponseHttp::statusMessage(404, $validacion));
                }


            }else{
                $response = json_decode(ResponseHttp::statusMessage(404,"ERROR: el método de recogida de datos debe de ser POST"));
            }

            $this -> pages -> render("read",['response' => json_encode($response)]);
        }

        


        public function registro(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $usuario = $this -> usuario;
                $datos_usuario = json_decode(file_get_contents("php://input"));
                $validacion = $usuario -> validarDatosRegistro($datos_usuario);
                
                if(gettype($validacion) == "boolean"){
                    $contraseniaEncrip = Security::encriptaPassw($datos_usuario -> password);

                    $usuario -> setNombre($datos_usuario -> nombre);
                    $usuario -> setApellidos($datos_usuario -> apellidos);
                    $usuario -> setEmail($datos_usuario -> email);
                    $usuario -> setPassword($contraseniaEncrip);
                    
                    if($usuario -> registro()){
                        Security::createToken($usuario, $datos_usuario -> email);
                        http_response_code(200);
                        $response = json_decode(ResponseHttp::statusMessage(200,"[ + ] Usuario creado correctamente"));
                    }else{
                        http_response_code(404);
                        $response = json_decode(ResponseHttp::statusMessage(404,"ERROR: No se ha podido crear el usuario"));
                    }

                }else{
                    http_response_code(404);
                    $response = json_decode(ResponseHttp::statusMessage(404, $validacion));
                }


            }else{
                $response = json_decode(ResponseHttp::statusMessage(404,"ERROR: el método de recogida de datos debe de ser POST"));
            }

            $this -> pages -> render("read",['response' => json_encode($response)]);
        }

    }