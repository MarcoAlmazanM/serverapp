<?php

include ("ModelApp.php");
/*
Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
Class Name : ControllerRegister
Purpose: The purpose of this class is to control all the Register Process.
*/
class ControllerRegister {
    private $model;
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : constructor
    Purpose: The constructor of this class call the DB to start the connection, after that calls the register method.
    */
    public function __construct(){
        $this->model = new ModelApp;
        $this->register();
    }
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : register
    Purpose: This method handles the JSON sent by the APP to start the register process.In order to verify that a new user has all the requirements
    to be register or not.
    */
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