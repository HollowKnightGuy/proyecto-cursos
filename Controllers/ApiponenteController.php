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
            ResponseHttp::setHeaders();
            $this -> ponente = new Ponente();
            $this -> pages = new Pages();
        }

        public function getAll(){
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
                $response = json_encode($PonenteArr);
            }
            $this -> pages -> render('read',['response' => $response]);
            
        }

        public function getPonente($id){
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
                $response = json_encode($PonenteArr);
            }
            $this -> pages -> render('read',['response' => $response]);
        }


        public function crearPonente(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $ponente = new Ponente();
                $datos_ponente = json_decode(file_get_contents("php://input"));

                if($ponente -> validarDatos($datos_ponente)){
                    $ponente -> setNombre($datos_ponente -> nombre);
                    $ponente -> setApellidos($datos_ponente -> apellidos);
                    $ponente -> setImagen($datos_ponente -> imagen);
                    $ponente -> setTags($datos_ponente -> tags);
                    $ponente -> setRedes($datos_ponente -> redes);

                    if($ponente -> crear()){
                        http_response_code(200);
                        $result = json_decode(ResponseHttp::statusMessage(200,"Ponente creado correctamente"));
                    }else{
                        http_response_code(404);
                        $result = json_decode(ResponseHttp::statusMessage(404,"No se ha podido crear el ponente"));
                    }

                }else{
                    http_response_code(404);
                    $result = json_decode(ResponseHttp::statusMessage(404,"Error al validar los datos"));
                }


            }else{

                $result = json_decode(ResponseHttp::statusMessage(404,"Error el método de recogida de datos debe de ser POST"));
            }

            $this->pages->render("read",['result' => json_encode($result)]);

        }

        public function borrarPonente($id){
            if($_SERVER['REQUEST_METHOD'] == 'DELETE'){
                
                $ponente = new Ponente();
                if($ponente -> borrarPonente($id)){
                    http_response_code(200);
                    $result = json_decode(ResponseHttp::statusMessage(200,"Ponente borrado correctamente"));
                }else{

                    http_response_code(404);
                    $result = json_decode(ResponseHttp::statusMessage(404,"No se ha podido borrar el ponente"));
                }

            }

            $this->pages->render("read",['result'=> json_encode($result)]);
        }


        public function actualizaPonente($ponenteid): void{
        if ($_SERVER['REQUEST_METHOD'] == 'PUT'){

            $datos_ponente = $this->ponente->findOne($ponenteid);

            if ($datos_ponente !== false) {

                $ponente = Ponente::fromArray($datos_ponente);
                $datos = json_decode(file_get_contents("php://input"));

                if ($ponente->validarDatos($datos)){

                    //reescribimos los datos del ponente
                    $ponente->setNombre($datos->nombre);
                    $ponente->setApellidos($datos->apellidos);
                    $ponente->setImagen($datos->imagen);
                    $ponente->setTags($datos->tags);
                    $ponente->setRedes($datos->redes);

                    if ($ponente->actualiza($ponenteid)) {
                        http_response_code(200);
                        $result = json_decode(ResponseHttp::statusMessage(200, "Ponente actualizado"));
                    }
                    else {
                        http_response_code(404);
                        $result = json_decode(ResponseHttp::statusMessage(404, "No se ha podido actualizar el ponente"));
                    }
                }
                else {
                    http_response_code(400);
                    $result = json_decode(ResponseHttp::statusMessage(400, "Algo ha salido mal"));
                }
            }
            else {
                http_response_code(404);
                $result = json_decode(ResponseHttp::statusMessage(404, "No ha encontrado el ponente"));
            }
        }
        else {
            $result = json_decode(ResponseHttp::statusMessage(400, "Método no permitido, se debe usar PUT"));
        }

        $this->pages->render('read', ['result' => json_encode($result)]);
    }
    




    }