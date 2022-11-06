<?php
/*
Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
Class Name : ModelApp
Purpose: The purpose of this class is to handle all the queries and transactions that are need to complete the login or register.
*/
class ModelApp{
    private $connection;
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
    private $port;
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : constructor
    Purpose: The constructor of this class call the DB to start the connection.
    */
    public function __construct(){
        $this->host     = "serverappdb.mysql.database.azure.com";
        $this->db       =  'APP';
        $this->user     ="administratorDB";
        $this->password = "m1Database!";
        $this->charset  = 'utf8mb4';
        $this->port = "3306";
        $this->connection  = $this->connect(); 
    }
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : connect
    Purpose: This method handles all the connection to the database.
    */
    function connect(){
    
        try{
            
            $connection = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db  . ";charset=" . $this->charset ;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_SSL_CA => './DigiCertGlobalRootCA.crt.pem',
	            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
    
            return $pdo;

        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }   
    }
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : login_user
    Purpose: This method handles the transactions to the database related to the login process. This method return if a user is able to log in
    or not.
    */
    public function login_user($user, $pass){
        $arr = null;
        $query = $this->connect()->prepare('SELECT * FROM usuario WHERE idUsuario = :user AND contrasena = :pass');
        $query->execute(['user' => $user, 'pass' => $pass]);

        if($query->rowCount()){
            foreach ($query as $currentUser) {
                $arr = array('name' => $currentUser['nombre'], 'lastName' => $currentUser['apellidoP'], 'lastNameM' => $currentUser['apellidoM'], 'email' => $currentUser['correo'], 'username' => $currentUser['idUsuario'], 'loginApproval' => 1);
            }
            
        }else{
            $arr = array('loginApproval' => 0);
        
        }
        header("Content-Type: application/json");
        echo json_encode($arr);
        exit();
        
    }
    /*
    Author: Marco Antonio Almazan Martinez & Mariana Soto Ochoa
    Method Name : register_user
    Purpose: This method handles the transactions to the database related to the register process. This method return if a new user is able 
    to be register or not.
    */
    public function register_user($username, $name, $lastName, $lastNameM, $email, $pass){
        $arr = null;
        try{
            $sql= $this->connect()->prepare("INSERT INTO Usuario VALUES (?,?,?,?,?,?)");
            $sql->execute([$username, $name, $lastNameM,$lastName,$email,$pass]);
            if($sql->rowCount()){
                $arr = array('registerApproval' => 1);
            }
            
        }catch (PDOException $error){
            if($error->getCode() == 23000){
                $arr = array('registerApproval' => 0, 'error' => 'Usuario duplicado'); 
            }

        }
        header("Content-Type: application/json");
        echo json_encode($arr);
        exit();
    }
}
?>