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


    
    /**
     * Comprueba que los datos pasados por post esten correctos para loguear a un usuario
     * LLeva a cabo las validaciones
     * @access public
     * @param mixed $datos insertados de usuario
     * @return string|bool
     */
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
    


    /**
     * Registra un usuario en la base de datos
     * LLeva a cabo las validaciones
     * @access public
     * @param mixed $datos insertados de usuario
     * @return string|bool
     */
        public function registro($data):string|bool{
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
    