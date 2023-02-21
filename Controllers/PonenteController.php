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


    /**
     * LLama a la api para que le devuelva los datos de toods los ponentes
     * @access public
     * @return void
     */

        public function getAll():void{
            $ponentes = $this -> apiponente -> getAll();
            $this -> pages -> render('ponente/mostrar', ['ponentes' => $ponentes]);
        }


    /**
     * LLama a la api para para actualizar un Ponente mandandole los datos de la vista
     * @access public
     * @param int id del ponente a actualizar
     * @return void
     */

        public function actualizaPonente($id):void{
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $actualizar = $this -> apiponente -> actualizaPonente($id, json_encode($_POST['data']));
                if(gettype($actualizar) === "boolean"){
                    header('Location: '.$_ENV['BASE_URL']);
                } else{
                    $this -> pages -> render('ponente/editar', ['ponente' => ($this -> apiponente -> getPonente($id)['Ponentes'][0]), 'mensaje' => $actualizar]);
                }
            } else{
                $this -> pages -> render('ponente/editar', ['ponente' => ($this -> apiponente -> getPonente($id)['Ponentes'][0])]);
            }
        }



    /**
     * LLama a la api para para crear un Ponente mandandole los datos de la vista
     * @access public
     * @return void
     */

        public function crearPonente():void{
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = json_encode($_POST['data']);
                
                $crear = $this -> apiponente -> crearPonente($data);
                if(gettype($crear) === "boolean"){
                    header('Location: '.$_ENV['BASE_URL']);
                } else{
                    $this -> pages -> render('ponente/crear', ['mensaje' => $crear]);
                }
            } else{
                $this -> pages -> render('ponente/crear');
            }
            
        }


    /**
     * LLama a la api para para borrar un Ponente mandandole los datos de la vista
     * @access public
     * @return void
     */

        public function borrarPonente($id){
            $this -> apiponente -> borrarPonente($id);
            header('Location: '.$_ENV['BASE_URL']);
        }

    }