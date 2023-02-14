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


            
            public static function fromArray($datos){

                $ponente=new Ponente();
                $ponente -> setNombre($datos[0]['nombre']);
                $ponente -> setApellidos($datos[0]['apellidos']);
                $ponente -> setImagen($datos[0]['imagen']);
                $ponente -> setTags($datos[0]['tags']);
                $ponente -> setRedes($datos[0]['redes']);
        
                return $ponente;
        
            }

            public function findAll(){
                $statement = "SELECT * FROM ponentes;";

                try{
                    $statement = $this -> conexion -> consulta($statement);
                    return $statement -> fetchAll(\PDO::FETCH_ASSOC);
                }catch(\PDOException $e){
                    exit($e -> getMessage());
                }
            }

            public function findOne($id){
                $statement = "SELECT * FROM ponentes WHERE id=$id;";

                try{
                    $statement = $this -> conexion -> consulta($statement);
                    return $statement -> fetchAll(\PDO::FETCH_ASSOC);
                }catch(\PDOException $e){
                    exit($e -> getMessage());
                }
            }

            public function validarDatos($datos_ponente):bool{

                if(!empty($datos_ponente -> nombre) && !empty($datos_ponente -> apellidos) && !empty($datos_ponente -> imagen) && !empty($datos_ponente -> tags) && !empty($datos_ponente -> redes)){
                    return true;
                }else{
                    return false;
                }

            }

            public function crear(){

                $statement = $this -> conexion->prepara("INSERT INTO ponentes(nombre,apellidos,imagen,tags,redes) VALUES (:nombre,:apellidos,:imagen,:tags,:redes)");

                $statement->bindParam(":nombre",$this->nombre,PDO::PARAM_STR);
                $statement->bindParam(":apellidos",$this->apellidos,PDO::PARAM_STR);
                $statement->bindParam(":imagen",$this->imagen,PDO::PARAM_STR);
                $statement->bindParam(":tags",$this->tags,PDO::PARAM_STR);
                $statement->bindParam(":redes",$this->redes,PDO::PARAM_STR);


                try{
                    $statement = $statement->execute();
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }


            
            public function borrarPonente($id){
                $statement = $this -> conexion->prepara("DELETE FROM ponentes WHERE id = :id");
                $statement->bindParam(":id",$id);

                try{
                    $statement = $statement->execute();
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }


            public function actualiza($ponenteid){
                $statement = $this -> conexion->prepara("UPDATE ponentes SET nombre = :nombre, apellidos = :apellidos, imagen = :imagen, tags = :tags, redes = :redes WHERE id=:id");


                $statement->bindParam(":nombre",$this->nombre,PDO::PARAM_STR);
                $statement->bindParam(":apellidos",$this->apellidos,PDO::PARAM_STR);
                $statement->bindParam(":imagen",$this->imagen,PDO::PARAM_STR);
                $statement->bindParam(":tags",$this->tags,PDO::PARAM_STR);
                $statement->bindParam(":redes",$this->redes,PDO::PARAM_STR);
                $statement->bindParam(":id",$ponenteid,PDO::PARAM_INT);


                try{
                    $statement = $statement->execute();
                    return true;
                }catch(\PDOException $e){
                    return false;
                }
            }
        }