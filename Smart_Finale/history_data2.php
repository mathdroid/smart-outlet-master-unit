<?php
//	$dbhost 	= "localhost";
//	$dbname		= "muhammad_smartmeter";
//	$dbuser		= "root";
//	$dbpass		= "password";	 
//	$con = mysql_connect($dbhost,$dbuser,$dbpass);
//    if (!$con) {
//      die('Could not connect: ' . mysql_error());
//    }
//    mysql_select_db($dbname, $con);					
//	$sth = mysql_query("SELECT budget FROM total WHERE sid=2 ORDER BY days");
//    if($sth === FALSE) {
//        die(mysql_error()); 
//    }
//    $rows = array();
//    $rows['name'] = 'Budget';
//    while($r = mysql_fetch_array($sth)) {
//        $rows['data'][] = $r['budget'];        
//    }    
//    $sth = mysql_query("SELECT kwh FROM total WHERE sid=2 ORDER BY days");
//    $rows1 = array();
//    $rows1['name'] = 'kwh';
//    while($rr = mysql_fetch_assoc($sth)) {
//        $rows1['data'][] = $rr['kwh'];
//    }    
//    $result = array();
//    array_push($result,$rows);
//    array_push($result,$rows1);
//    print json_encode($result, JSON_NUMERIC_CHECK);
//    mysql_close($con);
	$dbhost 	= "localhost";
	$dbname		= "temps";
	$dbuser		= "monitor";
	$dbpass		= "smartsocket";
    
    $Minggu_budget = 0;
    $Minggu_kwh = 0;
    $Senin_budget = 0;
    $Senin_kwh = 0;
    $Selasa_budget = 0;
    $Selasa_kwh = 0;
    $Rabu_budget = 0;
    $Rabu_kwh = 0;
    $Kamis_budget = 0;
    $Kamis_kwh = 0;
    $Jumat_budget = 0;
    $Jumat_kwh = 0;
    $Sabtu_budget = 0;
    $Sabtu_kwh = 0;
	// database connection
	$con = mysql_connect($dbhost,$dbuser,$dbpass);
    if (!$con) {
      die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($dbname, $con);			

    $query = mysql_query("SELECT * FROM powerlog WHERE sid=2")or die(mysql_error()); 
    while ($rows = mysql_fetch_array($query)):
       $mysqltime = $rows['timestamp'];        
       $timestamp = strtotime($mysqltime);
       $hari = date('l',$timestamp); 
       $kwh = $rows['kwh'];        
       $budget = $rows['budget'];                

        if ($hari == "Wednesday") {
            $Rabu_budget = $Rabu_budget + $budget;
            $Rabu_kwh = $Rabu_kwh + $kwh;
        }elseif ($hari == "Tuesday") {
            $Selasa_budget = $Selasa_budget + $budget;
            $Selasa_kwh = $Selasa_kwh + $kwh;
        } elseif ($hari == "Monday") {
            $Senin_budget = $Senin_budget + $budget;
            $Senin_kwh = $Senin_kwh + $kwh;
        }elseif ($hari == "Thursday") {
            $Kamis_budget = $Kamis_budget + $budget;
            $Kamis_kwh = $Kamis_kwh + $kwh;
        }elseif ($hari == "Friday") {
            $Jumat_budget = $Jumat_budget + $budget;
            $Jumat_kwh = $Jumat_kwh + $kwh; 
        }elseif ($hari == "Saturday") {
            $Sabtu_budget = $Sabtu_budget + $budget;
            $Sabtu_kwh = $Sabtu_kwh + $kwh;
        }elseif ($hari == "Sunday") {
           $Minggu_budget = Minggu_budget + $budget;
            $Minggu_kwh  = Minggu_kwh + $kwh;
        } 
    endwhile;   
    UpdateTotal(1,$Minggu_kwh,$Minggu_budget);                
    UpdateTotal(2,$Senin_kwh,$Senin_budget);                
    UpdateTotal(3,$Selasa_kwh,$Selasa_budget);                
    UpdateTotal(4,$Rabu_kwh,$Rabu_budget);                
    UpdateTotal(5,$Kamis_kwh,$Kamis_budget);                
    UpdateTotal(6,$Jumat_kwh,$Jumat_budget);                
    UpdateTotal(7,$Sabtu_kwh,$Sabtu_budget);     

    function UpdateTotal($day,$kwh,$budget) {       
        $retval = mysql_query("UPDATE total SET kwh ='".$kwh."', budget ='".$budget."' WHERE days = '".$day."' AND sid=2");
        if(! $retval ){
            die('Could not update data: ' . mysql_error());
        }        
    }    

//database handle
	$sth = mysql_query("SELECT budget FROM total WHERE sid=2 ORDER BY days");
    if($sth === FALSE) {
        die(mysql_error()); // TODO: better error handling
    }

    $rows = array();
    $rows['name'] = 'Budget';
    while($r = mysql_fetch_array($sth)) {
        $rows['data'][] = $r['budget'];        
    }
    
    $sth = mysql_query("SELECT kwh FROM total WHERE sid=2 ORDER BY days");
    $rows1 = array();
    $rows1['name'] = 'kwh';
    while($rr = mysql_fetch_assoc($sth)) {
        $rows1['data'][] = $rr['kwh'];
    }
    
    $result = array();
    array_push($result,$rows);
    array_push($result,$rows1);

    print json_encode($result, JSON_NUMERIC_CHECK);
    mysql_close($con);
?>


