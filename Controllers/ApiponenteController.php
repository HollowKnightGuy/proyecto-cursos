<?php


    namespace Controllers;
    use Models\Ponente;
    use Lib\ResponseHttp;
    use Lib\Pages;

    class ApiponenteController{

        private Pages $pages;
        private Ponente $ponente;


        public function __construct()
        {
            $this -> ponente = new Ponente();
            $this -> pages = new Pages();
        }
            /**
     * Comprueba que los datos pasados por post esten correctos para loguear a un usuario
     * LLeva a cabo las validaciones
     * @access public
     * @param mixed $datos insertados de usuario
     * @return string|bool
     */


    /**
     * Devuelve todos los datos de todos los ponentes como array de objetos
     * @access public
     * @return array
     */
        public function getAll():array{
            $ponentes = $this -> ponente->findAll();
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
                return $ponentes;
            }
            $this -> pages -> render('read',['response' => $response]);
            
        }



    /**
     * Devuelve un array de un objeto ponente a partir de un id
     * @access public
     * @param int Id del ponente
     * @return Ponente
     */

        public function getPonente($id): array{
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
                return $PonenteArr;
            }
            $this -> pages -> render('read',['response' => $response]);
        }


     /**
     * LLama al modelo ponente para inserta un Ponente en la base de datos
     * @access public
     * @param array Informacion del ponente escrita por el cliente
     * @return bool|string
     */

        public function crearPonente($data):bool|string{

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $ponente = new Ponente();
                $data = json_decode($data);
                
                $validacion = $ponente -> validarDatos($data);

                if(gettype($validacion) === "boolean"){
                    $ponente -> setNombre($data -> nombre);
                    $ponente -> setApellidos($data -> apellidos);
                    $ponente -> setImagen($data -> imagen);
                    $ponente -> setTags($data -> tags);
                    $ponente -> setRedes($data -> redes);

                    if($ponente -> crear()){
                        return true;
                    }else{
                        http_response_code(404);
                        $response = json_decode(ResponseHttp::statusMessage(404,"No se ha podido crear el ponente"));
                        return $response;
                    }

                }else{
                    return $validacion;
                }


            }else{
                $response = json_decode(ResponseHttp::statusMessage(404,"Error el método de recogida de datos debe de ser POST"));
                return $response;
            }
        }



    /**
     * LLama al modelo ponente para borrar un Ponente de la base de datos
     * @access public
     * @param int id del ponente a borrar
     * @return void
     */

        public function borrarPonente($id):void{
            $ponente = new Ponente();
            if($ponente -> borrarPonente($id)){
                http_response_code(200);
                $result = json_decode(ResponseHttp::statusMessage(200,"Ponente borrado correctamente"));
            }else{

                http_response_code(404);
                $result = json_decode(ResponseHttp::statusMessage(404,"No se ha podido borrar el ponente"));
            }

            $this->pages->render("read",['result'=> json_encode($result)]);
        }




        
    /**
     * LLama al modelo ponente para actualizar un Ponente en la base de datos
     * @access public
     * @param int id del ponente a borrar
     * @param array nueva informacion para actualizar
     * @return bool|string
     */

        public function actualizaPonente($id, $data):bool|string{
            $data = json_decode($data);
            $datos_ponente = $this->ponente->findOne($id);

            if ($datos_ponente !== false) {

                $ponente = Ponente::fromArray($datos_ponente);
                $validacion = $ponente -> validarDatos($data);
                
                if (gettype($validacion) === "boolean"){

                    //reescribimos los data del ponente
                    $ponente -> setNombre($data -> nombre);
                    $ponente -> setApellidos($data -> apellidos);
                    $ponente -> setImagen($data -> imagen);
                    $ponente -> setTags($data -> tags);
                    $ponente -> setRedes($data -> redes);

                    if ($ponente -> actualiza($id)) {
                        return true;
                    }
                    else {
                        http_response_code(400);
                        $result = json_decode(ResponseHttp::statusMessage(400, "Algo ha salido mal"));
                        return $result;
                    }
                }
                else {
                    http_response_code(400);
                    $result = $validacion;
                    return $result;
                }
            }
            else {
                http_response_code(404);
                $result = json_decode(ResponseHttp::statusMessage(404, "No ha encontrado el ponente"));
                return $result;
            }
        }
    }
    




    