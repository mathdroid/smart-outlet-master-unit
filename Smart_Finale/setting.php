<?php 
    $dbhost 	= "localhost"; 
	$dbname		= "muhammad_smartmeter";
	$dbuser		= "root";
	$dbpass		= "password";
	// database connection

	$con = mysql_connect($dbhost,$dbuser,$dbpass);
    if (!$con) {
      die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($dbname, $con);			
    if (isset($_POST['submit'])){
        $id = $_POST['zone'];
        $budgets = $_POST['budget'];
        $lower_time = $_POST['lower_time'];
        $upper_time = $_POST['upper_time'];

        $update = mysql_query("UPDATE setting SET budget ='".$budgets."',lower ='".$lower_time."',upper ='".$upper_time."' WHERE sid='".$id."'")or die(mysql_error());
    }
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    $DBH = "SELECT * FROM setting WHERE sid='".$id."'";
    $log = $conn->prepare($DBH);	
    $log->execute(array()); 
    $row = $log->fetch();
    $budget = $row["budget"];
    $lower = $row["lower"];
    $upper = $row["upper"];
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Smart Monitoring</title>
    <link href="css/style.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">    

</head>

<body>
    <div id="wrapper"><!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Smart Monitoring</a>
            </div><!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
                <form role="form" action="setting.php" method="post">    
                    <li class="dropdown">        
                            <input type="radio" name="zone" class="onoffradio-checkbox" id="1" value=1 checked>                
                            <label class="onoffradio-label" for="1">
                                <span class="onoffradio-inner" id="outlet1"></span>                    
                            </label>                                            
                        </li>                    
                        <li class="dropdown">
                            <input type="radio" name="zone" class="onoffradio-checkbox" id="2" value=2>
                            <label class="onoffradio-label" for="2">
                                    <span class="onoffradio-inner" id="outlet2"></span>                
                            </label>
                        </li>                    
                        <li class="dropdown">
                            <input type="radio" name="zone" class="onoffradio-checkbox" id="3" value=3>
                            <label class="onoffradio-label" for="3">
                                <span class="onoffradio-inner" id="outlet3"></span>                
                            </label>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown">
                                <button class="switcher" id="save">+</button>
                            </a>                    
                        </li>                    
<!--                </form>-->
                </ul>      
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div><!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="present.php"><i class="fa fa-flash fa-fw"></i> Realtime</a>                            
                        </li>
                        <li>
                            <a href="history.php"><i class="fa fa-bar-chart-o fa-fw"></i> History</a>                           
                        </li>
                        <li>
                            <a class="active" href="setting.php"><i class="fa fa-gear fa-fw"></i> Setting</span></a>                            
                        </li>                                                                            
                    </ul>
                </div><!-- /.sidebar-collapse -->
            </div><!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Setting</h1>
                </div><!-- /.col-lg-12 -->
            </div><!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            User Setting                      
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
<!--                                    <form role="form" action="setting.php" method="post">-->
                                        <div class="form-group">
                                            <h1>New Setting</h1>
                                            <label>User Budget</label>
                                            <input class="form-control" name="budget" type="text" id="budget">
                                            <p class="help-block">Input your budget here</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Time Limit</label>
                                            <p><input type="time" name="lower_time" id="lower"/>
                                        &nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;&nbsp;                                                                
                                        <input type="time" name="upper_time" id="upper"/></p>       
                                            <p class="help-block">Outlet will turn off, given the time limit</p>                                         
                                        </div>                                                                                                           
                                        <button type="submit" name="submit" class="btn btn-default">Change Setting</button>
<!--                                        <input class="signup" type="submit" id="submit" value="Change" />                            -->
                                        <button type="reset" class="btn btn-default">Reset Setting</button>
                                    </form>                                                                        
                                </div><!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    <h1>Current Setting</h1>                                                                                 
                                    <label>User Budget</label>                                                                        
                                    <h2><p><?php  echo $budget;?> USD</p></h2>                                            
                                    <div class="form-group">
                                        <label>Time Limit</label>
                                       <h2><p><?php  echo $lower;?>&nbsp;&nbsp;--&nbsp;&nbsp;<?php  echo $upper;?></p></h2>
<!--                                        string date ( string format [, int timestamp])-->
                                    </div>                                                                    
                                </div>                                           
                            </div><!-- /.col-lg-6 (nested) -->
                        </div><!-- /.row (nested) -->
                    </div><!-- /.panel-body -->
                </div><!-- /.panel -->
            </div><!-- /.col-lg-12 -->
        </div> <!-- /.row -->
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
    <!-- jQuery Version 1.11.0 -->
<script src="js/jquery-1.11.0.js"></script>
    <!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
<script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>

</body>

</html>
