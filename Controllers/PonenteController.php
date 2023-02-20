<?php


    namespace Controllers;
    use Lib\ResponseHttp;
    use Lib\Pages;
    use Controllers\ApiponenteController;

    class PonenteController{

        private ApiponenteController $apiponente;
        private pages $pages;


        public function __construct()
        {
            $this -> pages = new Pages();
            $this -> apiponente = new ApiponenteController();
        }

        public function getAll(){
            $ponentes = $this -> apiponente -> getAll();
            $this -> pages -> render('ponente/mostrar', ['ponentes' => $ponentes]);
            // TODO: MANDAR PONENTES A VISTA
        }

        public function getPonente($id){
            $ponente = $this -> apiponente -> getPonente($id);
        }
        

        public function actualizaPonente($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $actualizar = $this -> apiponente -> actualizaPonente($id, json_encode($_POST['data']));
                if(gettype($actualizar) === "boolean"){
                    header('Location: '.$_ENV['BASE_URL'].'ponente');
                }
            } else{
                $this -> pages -> render('ponente/editar', ['ponente' => $this -> apiponente -> getPonente($id)['Ponentes'][0]]);
            }
        }

        public function crearPonente(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = $_POST['data'];
                $this -> apiponente -> crearPonente($data);
            }
            
        }

        public function borrarPonente($id){
            $this -> apiponente -> borrarPonente($id);
            header('Location: '.$_ENV['BASE_URL'].'ponente');
        }

    }