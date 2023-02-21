<?php


    namespace Controllers;
    use Models\Usuario;
    use Lib\ResponseHttp;
    use Lib\Pages;
    use Lib\Security;

    class ApiUsuarioController{

        private Usuario $usuario;

        public function __construct()
        {
            $this -> usuario = new Usuario();
        }


        public function login($data){
            $data = json_decode($data);
            $usuario = $this -> usuario;
            $validacion = $usuario -> validarDatosLogin($data);
            
            if(gettype($validacion) == "boolean"){
                $usuario -> setEmail($data -> email);
                $usuario -> setPassword($data -> contrasenia);
                
                if($usuario -> login()){
                    return true;
                }else{
                    return 'No se ha podido loguear el usuario';
                }

            }else{
                return $validacion;
            }
        }
    

        


        public function registro($data){
            $data = json_decode($data);

            $usuario = $this -> usuario;
            $validacion = $usuario -> validarDatosRegistro($data);
            
            if(gettype($validacion) == "boolean"){
                $contraseniaEncrip = Security::encriptaPassw($data -> contrasenia);

                $usuario -> setNombre($data -> nombre);
                $usuario -> setApellidos($data -> apellidos);
                $usuario -> setEmail($data -> email);
                $usuario -> setPassword($contraseniaEncrip);
                $usuario -> setRol('user');
                $usuario -> setConfirmado('no');
                
                if($usuario -> registro()){
                    Security::createToken($usuario, $data -> email);
                    http_response_code(200);
                    return true;
                }else{
                    return 'No se ha podido registrar el usuario';
                }

            }else{
                return $validacion;
            }


        }
    
    }
    