<?php

    namespace Models;

    use Exception;
    use PDO;
    use PDOException;
    use Lib\BaseDatos;
    use Lib\Security;


    class Usuario extends BaseDatos{

        private string $id;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private string $password;
        private string $rol;
        private string $confirmado;
        private string $token;
        private string $token_exp;


        public function __construct()
        {
            parent::__construct();
        }

            
            /**
             * Get the value of id
             */ 
            public function getId()
            {
                    return $this->id;
            }

            /**
             * Set the value of id
             *
             * @return  self
             */ 
            public function setId($id)
            {
                    $this->id = $id;

                    return $this;
            }

            /**
             * Get the value of nombre
             */ 
            public function getNombre()
            {
                    return $this->nombre;
            }

            /**
             * Set the value of nombre
             *
             * @return  self
             */ 
            public function setNombre($nombre)
            {
                    $this->nombre = $nombre;

                    return $this;
            }

            /**
             * Get the value of apellidos
             */ 
            public function getApellidos()
            {
                    return $this->apellidos;
            }

            /**
             * Set the value of apellidos
             *
             * @return  self
             */ 
            public function setApellidos($apellidos)
            {
                    $this->apellidos = $apellidos;

                    return $this;
            }

            /**
             * Get the value of email
             */ 
            public function getEmail()
            {
                    return $this->email;
            }

            /**
             * Set the value of email
             *
             * @return  self
             */ 
            public function setEmail($email)
            {
                    $this->email = $email;

                    return $this;
            }

            /**
             * Get the value of password
             */ 
            public function getPassword()
            {
                    return $this->password;
            }

            /**
             * Set the value of password
             *
             * @return  self
             */ 
            public function setPassword($password)
            {
                    $this->password = $password;

                    return $this;
            }

            /**
             * Get the value of rol
             */ 
            public function getRol()
            {
                    return $this->rol;
            }

            /**
             * Set the value of rol
             *
             * @return  self
             */ 
            public function setRol($rol)
            {
                    $this->rol = $rol;

                    return $this;
            }

            /**
             * Get the value of confirmado
             */ 
            public function getConfirmado()
            {
                    return $this->confirmado;
            }

            /**
             * Set the value of confirmado
             *
             * @return  self
             */ 
            public function setConfirmado($confirmado)
            {
                    $this->confirmado = $confirmado;

                    return $this;
            }

            /**
             * Get the value of token
             */ 
            public function getToken()
            {
                    return $this->token;
            }

            /**
             * Set the value of token
             *
             * @return  self
             */ 
            public function setToken($token)
            {
                    $this->token = $token;

                    return $this;
            }

            /**
             * Get the value of token_exp
             */ 
            public function getToken_exp()
            {
                    return $this->token_exp;
            }

            /**
             * Set the value of token_exp
             *
             * @return  self
             */ 
            public function setToken_exp($token_exp)
            {
                    $this->token_exp = $token_exp;

                    return $this;
            }





    /**
     * Convierte un array de datos Usuario en un objeto Usuario
     * @access public static 
     * @param mixed array de datos de usuario
     * @return Ponente
     */

            public static function fromArray(array $data): Usuario {
                return new Usuario (
                    $data['id'],
                    $data['nombre'],
                    $data['apellidos'],
                    $data['email'],
                    $data['password'],
                    $data['rol'],
                    $data['confirmado'],
                    $data['token'],
                    $data['token_esp']
                );
            }




            
    /**
     * Comprueba si un correo electronico existe en la tabla 
     * usuarios de la base de datos
     * @access public 
     * @param string email a comprobar
     * @return Ponente
     */
            public function existe($email):bool{

                $sql = ("SELECT email FROM usuarios WHERE email = :email");
                $consulta = $this -> prepara($sql);
                $consulta -> bindParam(':email', $email);

                try{
                    $consulta -> execute();
                    if($consulta -> rowCount() == 1){
                        $response = true;
                    }else{
                        $response = false;
                    }
                }catch(PDOException $err){
                    $response = false;
                }
                return $response;

            }



    /**
     * Inserta en la base de datos el objeto Usuario previamente 
     * creado en la api
     * @access public 
     * @return bool
     */

            public function registro():bool{
                $statement = $this -> prepara("INSERT INTO usuarios(nombre, apellidos, email, password, rol, confirmado) VALUES (:nombre, :apellidos, :email, :password, :rol, :confirmado)");

                $statement -> bindParam(":nombre", $this -> nombre, PDO::PARAM_STR);
                $statement -> bindParam(":apellidos", $this -> apellidos, PDO::PARAM_STR);
                $statement -> bindParam(":email", $this -> email, PDO::PARAM_STR);
                $statement -> bindParam(":password", $this -> password, PDO::PARAM_STR);
                $statement -> bindParam(":rol", $this -> rol, PDO::PARAM_STR);
                $statement -> bindParam(":confirmado", $this -> confirmado, PDO::PARAM_STR);
                
                try{
                    $statement -> execute();
                    return true;
                }catch(\PDOException $e){
                    var_dump($e);
                    return false;
                }
            }




    /**
     * Comprueba que la informacion del login es correcta con la base de datos
     * @access public 
     * @return bool
     */

            public function login(){
                $statement = $this -> prepara("SELECT password FROM usuarios WHERE email = :email");

                $statement -> bindParam(":email", $this -> email, PDO::PARAM_STR);
                try{
                    $statement -> execute();
                    if($statement -> rowCount() == 1){
                        if(Security::validaPassw($this -> password, $statement -> fetchAll(\PDO::FETCH_ASSOC)[0]['password'])){
                            return true;
                        }else{
                            return 'No se ha podido loguear';
                        }
                    }else{
                        $response = false;
                    }
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }





    /**
     * Se encarga de validar los datos del registro que se le pasan desde la api
     * @access public
     * @param array datos de usuario a validar
     * @return string|bool
     */
            public function validarDatosRegistro($datos_usuario):string|bool{
                $nombreval = "/^[a-zA-Z ]+$/";
                $emailval = "/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/";
                
                // La contraseña debe tener entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.
                $passwval = "/^(?=\w*\d)(?=\w*[A-ZÑ])(?=\w*[a-zñ])\S{8,16}$/";
                
                if(empty($datos_usuario -> nombre) ||
                    preg_match($nombreval, $datos_usuario -> nombre) === 0){
                    $message = "El nombre solo puede contener letras y espacios";
                }

                else if(empty($datos_usuario -> apellidos) ||
                    preg_match($nombreval, $datos_usuario -> apellidos) === 0){
                    $message = "El apellido solo puede contener letras y espacios";
                }

                else if(empty($datos_usuario -> email) ||
                    preg_match($emailval, $datos_usuario -> email) === 0){
                    $message = "El email debe tener el siguiente formato 'correoejemplo@server.dominio'";
                }

                else if(empty($datos_usuario -> contrasenia) ||
                    preg_match($passwval, $datos_usuario -> contrasenia) === 0){
                    $message = "La contrasena debe tener entre 8 y 16 caracteres, al menos un digito, al menos una minuscula y al menos una mayuscula. NO puede tener otros simbolos.";
                }

                else if($this -> existe($datos_usuario -> email)){
                    $message = "El correo ya existe en la base de datos";
                }
                if(isset($message)){
                    return $message;
                }else{
                    return true;
                }
                
            }




    /**
     * Se encarga de validar los datos del login que se le pasan desde la api
     * @access public
     * @param array datos de usuario a validar
     * @return string|bool
     */

            public function validarDatosLogin($datos_usuario):string|bool{
                $emailval = "/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/";

                
                if(empty($datos_usuario -> email) ||
                    preg_match($emailval, $datos_usuario -> email) === 0){
                    $message = "El email debe tener el siguiente formato 'correoejemplo@server.dominio'";
                }

                
                if(isset($message)){
                    return $message;
                }else{
                    if($this -> existe($datos_usuario -> email)){
                        return true;
                    } else{
                        $message = "El email no esta registrado";
                        return $message;
                    }
                }
            }






    /**
     * Se encarga de insertar el token cuando un usuario se registra
     * @access public
     * @param string datos de usuario a validar
     * @return string|bool
     */
            public function updateToken($exp): bool{
                $token = $this -> token;
                $email = $this -> email;
                $statement = "UPDATE usuarios SET token = '$token' WHERE email = '$email'";

                $this -> consulta($statement);

                $statement = "UPDATE usuarios SET token_exp = '$exp' WHERE email = '$email'";

                $this -> consulta($statement);

                return $this -> filasAfectadas() > 0;
            }
            




    /**
     * Devuelve los datos de un usuario desde la base de datos
     * @access public
     * @param string email del usuario
     * @return array
     */
    public function findOne($email):array{
        $statement = "SELECT * FROM ponentes WHERE id = $email;";

        try{
            $statement = $this -> consulta($statement);
            return $statement -> fetchAll(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e){
            exit($e -> getMessage());
        }
    }



}
?>