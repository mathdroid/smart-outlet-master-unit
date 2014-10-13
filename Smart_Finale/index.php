<?php    
	$dbhost 	= "localhost";
	//$dbname		= "muhammad_smartmeter";
	$dbname		= "smart_smartsocket";
	$dbuser		= "monitor";
	$dbpass		= "smartsocket";
    
    	$totalbudget= 0;
	$totalkwh	= 0;
	$kwh1 = 0;
	$kwh2 = 0;	
	$kwh3 = 0;
	$con = mysql_connect($dbhost,$dbuser,$dbpass);
    if (!$con) {
      die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($dbname, $con);			

    $query = mysql_query("SELECT * FROM total")or die(mysql_error()); 
    $query_switch = mysql_query("SELECT * FROM switching")or die(mysql_error()); 
    while ($rows = mysql_fetch_array($query)):       
        $kwh = $rows['kwh'];        
        $budget = $rows['budget'];
		if ($rows['sid']==1){
			$kwh1 = $kwh1 + $rows['kwh'];
		}elseif ($rows['sid'] == 2){
			$kwh2 = $kwh2 + $rows['kwh'];
		}elseif ($rows['sid'] == 3){
			$kwh3 = $kwh3 + $rows['kwh'];
		}
        $totalkwh = $totalkwh + $kwh;
        $totalbudget = $totalbudget+ $budget;
    endwhile;    	
	while ($rows = mysql_fetch_array($query_switch)):       
        if ($rows['sid']==1){
			$status1 = $rows['status'];       
		}elseif ($rows['sid']==2){
			$status2 = $rows['status'];       
		}elseif ($rows['sid']==3){
			$status3 = $rows['status'];       
		}		
    endwhile;         	
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

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Leaflet CSS -->
    <link href="js/plugins/leaflet-0.7.3/leaflet.css">
    <link rel="stylesheet" href="js/plugins/leaflet/dist/leaflet.css"/>    
    <link href="css/style.css">
        
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->    
</head>

<body>

    <div id="wrapper">	
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Smart Monitoring</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul><!-- /.dropdown-messages -->
                </li><!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

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
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a class="active" href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="present.php"><i class="fa fa-flash fa-fw"></i> Realtime </a>                            
                        </li>
                        <li>
                            <a href="history.php"><i class="fa fa-bar-chart-o fa-fw"></i> History </a>                           
                        </li>
                        <li>
                            <a href="setting.php"><i class="fa fa-gear fa-fw"></i> Setting </a>                            
                        </li>                                                                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="wrapper">

  <div id="page-wrapper">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.widget-row -->
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-2">
                <i class="fa fa-fire fa-4x"></i>
              </div>
              <div class="col-xs-10 text-right">
                <div class="huge">Good</div>
                <div>All Device are normal</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="panel-footer">
              <span class="pull-left">View Details</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-flash fa-4x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class="huge"><?php echo $totalkwh; ?></div>
                <div>Electricity Spent</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="panel-footer">
              <span class="pull-left">Last 7 Days</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-dollar fa-4x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class="huge"><?php echo $totalbudget; ?></div>
                <div>Budget Global Spent</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="panel-footer">
              <span class="pull-left">Last 7 Day</span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-3">
                <i class="fa fa-clock-o fa-4x"></i>
              </div>
              <div class="col-xs-9 text-right">
                <div class="huge"><?php echo date('G:i',time()); ?></div>
                <div>Time</div>
              </div>
            </div>
          </div>
          <a href="#">
            <div class="panel-footer">
              <span class="pull-left"><?php echo date('M jS, l Y',time()); ?></span>
              <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
              <div class="clearfix"></div>
            </div>
          </a>
        </div>
      </div>
    </div> 
    <!-- /.widget-row -->

    <!-- /.env-row -->
    <div class="row">
      <!-- /.env-map-col -->
      <div class="col-lg-7 col-md-12 connectedSortable">
        <!-- env-map -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> House Map 
            <div class="pull-right">                            
            </div>
          </div><!-- /.panel-header -->
          <div class="panel-body no-padding">
            <div id="map" style="height:360px"></div>
          </div><!-- /.panel-body -->
        </div><!-- /.panel-env-map -->
      </div><!-- /.col-env-map -->

      <!-- /.machine-col -->
      <div class="col-lg-5 col-md-12 connectedSortable">
        <!-- machine -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <i class="fa fa-bar-chart-o fa-fw"></i> Outlet List
            <div class="pull-right">             
            </div>            
          </div><!-- /.panel-header -->
          <div class="panel-body">
          </div><!-- /.panel-body -->
          <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
              <tr>
                <th style="text-align:center">Id</th>                
                <th style="text-align:center">Location</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center">Power</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="text-align:center">01</td>                
                <td style="text-align:right">Tigor's Room</td>
                <td style="text-align:right"><?php echo konvert($status1); ?></td>
                <td style="text-align:right"><?php echo $kwh1; ?> KWH</td>				  
              </tr>
              <tr>
                <td style="text-align:center">02</td>                
                <td style="text-align:right">Kitchen</td>
                <td style="text-align:right"><?php echo konvert($status2); ?></td>
                <td style="text-align:right"><?php echo $kwh2; ?> KWH</td>				  
              </tr>
              <tr>
                <td style="text-align:center">03</td>                
                <td style="text-align:right">Dim's Room</td>
                <td style="text-align:right"><?php echo konvert($status3); ?></td>
                <td style="text-align:right"><?php echo $kwh3; ?>KWH</td>				  
              </tr>    
            </tbody>
          </table>
        </div><!-- /.panel-Pwr -->
      </div><!-- /.col-Pwr -->

    </div> <!-- /.row-env -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->  

    </div>
    <!-- /#wrapper -->    
    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>    

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>    

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script> 
    <!-- Leaflet JavaScript -->
<!--
    <script src="js/plugins/leaflet-0.7.3/leaflet-src.js"></script>
    <script src="js/plugins/leaflet-0.7.3/leaflet.js"></script>
-->
    <script src="js/plugins/leaflet/dist/leaflet.js"></script> 
    <script src="js/plugins/leaflet.awesome-markers/leaflet.awesome-markers.js"></script>
    <script src="js/plugins/HouseMap.js"></script>
</body>

</html>
<?php
function konvert($int) {
    if($int == 0){
        $stat = "OFF";
    }elseif($int == 1){    
        $stat = "ON";
    }
    return $stat;
}
?>
