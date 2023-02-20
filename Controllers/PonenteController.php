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
            $this -> pages -> render('ponente/mostrar', ['ponentes' => $ponente]);
        }
        

        // public function actualizar($id){
        //     $ponente = $this -> apiponente -> actualizar
        // }

    }