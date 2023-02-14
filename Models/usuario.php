<?php

    namespace Models;

    use Exception;
    use PDO;
    use PDOException;
    use Lib\BaseDatos;


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


        public function __construct($args = [])
        {
            parent::__construct();
            $this -> id = $args['id'] ?? null;
            $this -> nombre = $args['nombre'] ?? '';
            $this -> apellidos = $args['apellidos'] ?? '';
            $this -> email = $args['email'] ?? '';
            $this -> password = $args['password'] ?? '';
            $this -> rol = $args['rol'] ?? 'user';
            $this -> confirmado = $args['confirmado'] ?? FALSE;
            $this -> token = $args['token'] ?? '';
            $this -> token_exp = $args['token_exp'] ?? 0;
        }


    public function getId() {
        return $this -> id;
    }

    public function setId($id) {
        $this -> id = $id;
        return $this;
    }

    public function getNombre() {
        return $this -> nombre;
    }

    public function setNombre($nombre) {
        $this -> nombre = $nombre;
        return $this;
    }

    public function getApellidos() {
        return $this -> apellidos;
    }

    public function setApellidos($apellidos) {
        $this -> apellidos = $apellidos;
        return $this;
    }

    public function getEmail() {
        return $this -> email;
    }

    public function setEmail($email) {
        $this -> email = $email;
        return $this;
    }

    public function getPassword() {
        return $this -> password;
    }

    public function setPassword($password) {
        $this -> password = $password;
        return $this;
    }

    public function getRol() {
        return $this -> rol;
    }

    public function setRol($rol) {
        $this -> rol = $rol;
        return $this;
    }

    public function getConfirmado() {
        return $this -> confirmado;
    }

    public function setConfirmado($confirmado) {
        $this -> confirmado = $confirmado;
        return $this;
    }

    public function getToken() {
        return $this -> token;
    }

    public function setToken($token) {
        $this -> token = $token;
        return $this;
    }

    public function getToken_exp() {
        return $this -> token_exp;
    }

    public function setToken_exp($token_exp) {
        $this -> token_exp = $token_exp;
        return $this;
    }


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

    public function registro($datos){
        $statement = $this -> prepara ("INSERT INTO ponentes(id, nombre, apellidos, email, password, rol, confirmado) VALUES (:id, :nombre, :apellidos, :email, :password, :rol, :confirmado)");

        $statement -> bindParam(":id", $datos -> id, PDO::PARAM_STR);
        $statement -> bindParam(":nombre", $datos -> nombre, PDO::PARAM_STR);
        $statement -> bindParam(":apellidos", $datos -> apellidos, PDO::PARAM_STR);
        $statement -> bindParam(":apellidos", $datos -> apellidos, PDO::PARAM_STR);
        $statement -> bindParam(":email", $datos -> email, PDO::PARAM_STR);
        $statement -> bindParam(":password", $datos -> password, PDO::PARAM_STR);
        $statement -> bindParam(":rol", $datos -> rol, PDO::PARAM_STR);
        $statement -> bindParam(":confirmado", $datos -> confirmado, PDO::PARAM_STR);


        try{
            $statement = $statement -> execute();
            return true;
        }catch(\PDOException $e){
            return false;
        }
    }



    public function validarDatos($datos_usuario):bool{

        if(!empty($datos_usuario -> nombre) && !empty($datos_usuario -> apellidos) && !empty($datos_usuario -> email) && !empty($datos_usuario -> password) && !empty($datos_usuario -> rol) && !empty($datos_usuario -> confirmado)){
            return true;
        }else{
            return false;
        }
    }


}
?>