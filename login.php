<?php

include ("ModelApp.php");
/*
Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
Class Name : Controller
Purpose: The purpose of this class is to control all the Login Process.
*/
class Controller {
    private $model;
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : constructor
    Purpose: The constructor of this class call the DB to start the connection, after that calls the login method.
    */
    public function __construct(){
        $this->model = new ModelApp;
        $this->login();
    }
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : login
    Purpose: This method handles the JSON sent by the APP to start the login process.In order to verify that a user is authorized to login.
    */
    public function login(){
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