<?php

include ("ModelApp.php");

class Controller {
    private $model;
    public function __construct(){
        $this->model = new ModelApp;
        $this->login();
    }

    public function login(){
        echo 'hola';
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST['username']) && isset($_POST['password']) ){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $this->model->login_user($username, $password);
        }
    }

}

$admin = new Controller;
?>