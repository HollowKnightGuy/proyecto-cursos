<?php
    namespace Models;

    use Exception;
    use PDO;
    use PDOException;
    use Lib\BaseDatos;


    class Ponente{
        
            private string $id;
            private string $nombre;
            private string $apellidos;
            private string $imagen;
            private string $tags;
            private string $redes;

            private BaseDatos $conexion;

            public function __construct()
            {
                $this -> conexion = new BaseDatos();
            }

            /**
             * Get the value of id
             */ 
            public function getId()
            {
                        return $this -> id;
            }

            /**
             * Set the value of id
             *
             * @return  self
             */ 
            public function setId($id)
            {
                        $this -> id = $id;

                        return $this;
            }

            /**
             * Get the value of nombre
             */ 
            public function getNombre()
            {
                        return $this -> nombre;
            }

            /**
             * Set the value of nombre
             *
             * @return  self
             */ 
            public function setNombre($nombre)
            {
                        $this -> nombre = $nombre;

                        return $this;
            }

            /**
             * Get the value of apellidos
             */ 
            public function getApellidos()
            {
                        return $this -> apellidos;
            }

            /**
             * Set the value of apellidos
             *
             * @return  self
             */ 
            public function setApellidos($apellidos)
            {
                        $this -> apellidos = $apellidos;

                        return $this;
            }

            /**
             * Get the value of imagen
             */ 
            public function getImagen()
            {
                        return $this -> imagen;
            }

            /**
             * Set the value of imagen
             *
             * @return  self
             */ 
            public function setImagen($imagen)
            {
                        $this -> imagen = $imagen;

                        return $this;
            }

            /**
             * Get the value of tags
             */ 
            public function getTags()
            {
                        return $this -> tags;
            }

            /**
             * Set the value of tags
             *
             * @return  self
             */ 
            public function setTags($tags)
            {
                        $this -> tags = $tags;

                        return $this;
            }

            /**
             * Get the value of redes
             */ 
            public function getRedes()
            {
                        return $this -> redes;
            }

            /**
             * Set the value of redes
             *
             * @return  self
             */ 
            public function setRedes($redes)
            {
                        $this -> redes = $redes;

                        return $this;
            }


            
    /**
     * Convierte un array de datos Ponente en un objeto Ponente
     * @access public static 
     * @param mixed array de datos de ponente
     * @return Ponente
     */
            public static function fromArray($datos):Ponente{

                $ponente=new Ponente();
                $ponente -> setNombre($datos[0]['nombre']);
                $ponente -> setApellidos($datos[0]['apellidos']);
                $ponente -> setImagen($datos[0]['imagen']);
                $ponente -> setTags($datos[0]['tags']);
                $ponente -> setRedes($datos[0]['redes']);
        
                return $ponente;
        
            }





    /**
     * Devuelve todos los ponentes desde la base de datos
     * @access public
     * @return array
     */

            public function findAll():array{
                $statement = "SELECT * FROM ponentes;";

                try{
                    $statement = $this -> conexion -> consulta($statement);
                    return $statement -> fetchAll(\PDO::FETCH_ASSOC);
                }catch(\PDOException $e){
                    exit($e -> getMessage());
                }
            }






    /**
     * Devuelve los datos de un ponente desde la base de datos
     * @access public
     * @param int el id del ponente
     * @return array
     */
            public function findOne($id):array{
                $statement = "SELECT * FROM ponentes WHERE id = $id;";

                try{
                    $statement = $this -> conexion -> consulta($statement);
                    return $statement -> fetchAll(\PDO::FETCH_ASSOC);
                }catch(\PDOException $e){
                    exit($e -> getMessage());
                }
            }





    /**
     * Se encarga de validar los datos que se le pasan desde la api
     * @access public
     * @param array datos de ponente a validar
     * @return string|bool
     */
            public function validarDatos($datos_ponente):string|bool{

                $nombreval = "/^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
                $tagval = "/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s]+$/";
                $redesval = "/^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ\s:_\-.,]+$/";
                $imgval = "/^.*\.(jpg|png|jpeg)$/";

                if(empty($datos_ponente -> nombre) ||
                    preg_match($nombreval, $datos_ponente -> nombre) === 0){
                    $message = "El nombre solo puede contener letras y espacios";
                }
        
                else if(empty($datos_ponente -> apellidos) ||
                    preg_match($nombreval, $datos_ponente -> apellidos) === 0){
                    $message = "El apellido solo puede contener letras y espacios";
                }

                else if(empty($datos_ponente -> imagen) ||
                    preg_match($imgval, $datos_ponente -> imagen) === 0){
                    $message = "La imagen debe tener el siguiente formato: nombreimagen.jpg/png/jpeg";
                }

                else if(empty($datos_ponente -> tags) ||
                    preg_match($tagval, $datos_ponente -> tags) === 0){
                    $message = "Al menos un tag es requerido y los tags deben tener el siguiente formato: Tag1 Tag2";

                }

                else if(empty($datos_ponente -> redes) ||
                    preg_match($redesval, $datos_ponente -> redes) === 0){
                    $message = "Al menos una red es requerida. No se admiten simbolos. Formato: red_1 red_2";
                }

                if(isset($message)){
                    return $message;
                }else{
                    return true;
                }

            }





    /**
     * Se encarga de insertar los datos de un ponente en la base de datos
     * @access public
     * @return bool
     */

            public function crear():bool{

                $statement = $this -> conexion -> prepara("INSERT INTO ponentess(nombre,apellidos,imagen,tags,redes) VALUES (:nombre,:apellidos,:imagen,:tags,:redes)");

                $statement -> bindParam(":nombre", $this -> nombre, PDO::PARAM_STR);
                $statement -> bindParam(":apellidos", $this -> apellidos, PDO::PARAM_STR);
                $statement -> bindParam(":imagen", $this -> imagen, PDO::PARAM_STR);
                $statement -> bindParam(":tags", $this -> tags, PDO::PARAM_STR);
                $statement -> bindParam(":redes", $this -> redes, PDO::PARAM_STR);


                try{
                    $statement = $statement -> execute();
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }




    /**
     * Se encarga de borrar un ponente en la base de datos
     * @access public
     * @return bool
     */
            
            public function borrarPonente($id):bool{
                $statement = $this -> conexion -> prepara("DELETE FROM ponentes WHERE id = :id");
                $statement -> bindParam(":id",$id);

                try{
                    $statement = $statement -> execute();
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }




    /**
     * Se encarga de actualizar un ponente en la base de datos
     * @access public
     * @return bool
     */
            public function actualiza($ponenteid):bool{
                $statement = $this -> conexion -> prepara("UPDATE ponentes SET nombre = :nombre, apellidos = :apellidos, imagen = :imagen, tags = :tags, redes = :redes WHERE id = :id");


                $statement -> bindParam(":nombre",$this -> nombre,PDO::PARAM_STR);
                $statement -> bindParam(":apellidos",$this -> apellidos,PDO::PARAM_STR);
                $statement -> bindParam(":imagen",$this -> imagen,PDO::PARAM_STR);
                $statement -> bindParam(":tags",$this -> tags,PDO::PARAM_STR);
                $statement -> bindParam(":redes",$this -> redes,PDO::PARAM_STR);
                $statement -> bindParam(":id",$ponenteid,PDO::PARAM_INT);


                try{
                    $statement = $statement -> execute();
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }
        }