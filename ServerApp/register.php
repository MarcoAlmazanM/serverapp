<?php

include ("ModelApp.php");

class ControllerRegister {
    private $model;
    public function __construct(){
        $this->model = new ModelApp;
        $this->register();
    }

    public function register(){
        $_POST = json_decode(file_get_contents('php://input'), true);
        if(isset($_POST['idUsuario']) && isset($_POST['nombre']) && isset($_POST['apellidoP']) && isset($_POST['apellidoM'])
        && isset($_POST['correo']) && isset($_POST['contrasena'])){
            $username = $_POST['idUsuario'];
            $name = $_POST['nombre'];
            $lastName = $_POST['apellidoP'];
            $lastNameM = $_POST['apellidoM'];
            $email = $_POST['correo'];
            $pass = $_POST['contrasena'];
            $this->model->register_user($username, $name, $lastName, $lastNameM, $email, $pass);
        }
    }

}

$admin = new ControllerRegister;
?>