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
                $login = $this -> apiusuario -> login(json_encode($_POST['data']));
                if(gettype($login) === "boolean"){
                    $_SESSION['nombreUsuario'] = $_POST['data']['email'];
                    $_SESSION['login'] = true;
                    header('Location: '.$_ENV['BASE_URL']);
                } else{
                    $this -> pages -> render('usuario/login', ['mensaje' => $login]);
                }
            } else{
                $this -> pages -> render('usuario/login');
            }
        }

        public function registro(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $login = $this -> apiusuario -> registro(json_encode($_POST['data']));
                if(gettype($login) === "boolean"){
                    header('Location: '.$_ENV['BASE_URL']);
                } else{
                    $this -> pages -> render('usuario/registrar', ['mensaje' => $login]);
                }
            } else{
                $this -> pages -> render('usuario/registrar');
            }
        }

        public function cerrarSesion(){
            session_destroy();
            header("Location: ".$_ENV['BASE_URL']);
        }
    }