<?php
class ModelApp{
    private $connection;
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
    private $port;
    private $sslmode;

    public function __construct(){
        $this->host     = "serverappdb.mysql.database.azure.com";
        $this->db       =  'APP';
        $this->user     ="administratorDB";
        $this->password = "m1Database!";
        $this->charset  = 'utf8mb4';
        $this->connection  = $this->connect(); 
        $this->port = "3306";
        $this->sslmode="./DigiCertGlobalRootCA.crt.pem";
    }

    function connect(){
    
        try{
            
            $connection = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db . ";ssl-ca=" . $this->sslmode . ";charset=" . $this->charset . ";--ssl-mode=REQUIRED" ;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $this->user, $this->password, $options);
    
            return $pdo;

        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }   
    }

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