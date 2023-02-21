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

    public function infoUserParaToken(){
        $statement = $this -> prepara("SELECT id, email FROM usuarios WHERE email = :email;");
        $statement -> bindParam(":email", $this -> email, PDO::PARAM_STR);
        try{
            $statement -> execute();
            return $statement -> fetchAll(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e){
            exit($e -> getMessage());
        }
    }

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


    public function registro(){
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

    public function login(){
        $statement = $this -> prepara("SELECT password FROM usuarios WHERE email = :email");

        $statement -> bindParam(":email", $this -> email, PDO::PARAM_STR);
        try{
            $statement -> execute();
            if($statement -> rowCount() == 1){
                if(Security::validaPassw($this -> password, $statement -> fetchAll(\PDO::FETCH_ASSOC)[0]['password'])){
                    return true;
                }else{
                    
                    var_dump($this -> password);die;
                }
            }else{
                $response = false;
            }
            return true;
        }catch(\PDOException $e){
            return false;
        }
    }



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

    public function updateToken($exp): bool{
        $token = $this -> token;
        $email = $this -> email;
        $statement = "UPDATE usuarios SET token = '$token' WHERE email = '$email'";

        $this -> consulta($statement);

        $statement = "UPDATE usuarios SET token_exp = '$exp' WHERE email = '$email'";

        $this -> consulta($statement);

        return $this -> filasAfectadas() > 0;
    }
    


}
?>