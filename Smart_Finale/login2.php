<?php

$dbhost 	= "localhost";
$dbname		= "smartmeter";
$dbuser		= "root";
$dbpass		= "password";	 

define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username. 
define("PASSWORD", "password");    // The database password. 
define("DATABASE", "muhammad_smartmeter");// The database 

Class login{
    public $username = null;
    public $userpass = null;
    public $salt = "Zo4rU5Z1YyKJAASY0PT6EUg7BBYdlEhPaNLuxAwU8lqu1ElzHv0Ri7EM6irpx5w";
    
    public function __construct( $data = array() ) {
        if( isset( $data['username'] ) ) $this->username = stripslashes( strip_tags( $data['username'] ) );
        if( isset( $data['password'] ) ) $this->password = stripslashes( strip_tags( $data['password'] ) );
    }
    public function storeFormValues($params){
        $this->__construct($params);
    }
    public function Userlogin(){
    $success = false;
        try {
        $conn = new PDO("mysql:host=".HOST.";dbname=".DATABASE."",USER, PASSWORD);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );     
        $sql = "SELECT * FROM login WHERE username = :username AND password = :password"; //MASALAH, coba dicek kenapa
        $log = $conn->prepare($sql);    
        $log->bindValue("username", $this->username, PDO::PARAM_STR );
	    $log->bindValue("password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
        $log->execute();
        
        $valid = $log->fetchColumn();
        if( $valid ) {
            $success = true;
			}    
        $con = null;
        return $success;
		}
        catch (PDOException $e) {
            echo $e->getMessage();
			return $success;
            }
        }
    public function UserRegister(){
    $success = false;
        try {
        $conn = new PDO("mysql:host=".HOST.";dbname=".DATABASE."",USER, PASSWORD);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );     
        $sql = "INSERT INTO login(username, password) VALUES(:username, :password)";
        //$sql = "INSERT INTO login WHERE username = :username AND password = :password"; MASALAH, coba dicek kenapa
        $log = $conn->prepare($sql);    
        $log->bindValue("username", $this->username, PDO::PARAM_STR );
	    $log->bindValue( "password", hash("sha256", $this->password . $this->salt), PDO::PARAM_STR );
        $log->execute();
                   
        header('Location: login.php') ;	
		}
        catch (PDOException $e) {
            return $e->getMessage();		            
        }
    }
}
?>