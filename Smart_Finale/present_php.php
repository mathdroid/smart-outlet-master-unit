<?php
	$dbhost 	= "localhost";
	$dbname		= "smart_smartsocket";
	$dbuser		= "monitor";
	$dbpass		= "smartsocket";	 
	  
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    $DBH = "SELECT * FROM powerlog_rt";
   // $DBH = "SELECT * FROM powerrt";
    $log = $conn->prepare($DBH);	
    $log->execute(array()); 
    header('content-type: text/javascript');
        
    echo json_encode(array("result" => $log->fetchAll(PDO::FETCH_ASSOC)));  
            
?>
