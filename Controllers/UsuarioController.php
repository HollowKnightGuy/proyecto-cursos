<?php


    namespace Controllers;
    use Lib\ResponseHttp;
    use Lib\Pages;
    use Controllers\ApiUsuarioController;

    class UsuarioController{

        private Pages $pages;
        private ApiUsuarioController $apiusuario;


        public function __construct()
        {
            $this -> apiusuario = new ApiUsuarioController();
            $this -> pages = new Pages();
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = $_POST['data'];
                $this -> apiusuario -> login(json_encode($data));
            } else{
                $this -> pages -> render('login');
            }
        }

        public function registro(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = $_POST['data'];
                $this -> apiusuario -> registro(json_decode($data));
            } else{
                $this -> pages -> render('registrar');
            }
        }

    }