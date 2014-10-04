<?php 
    	$dbhost 	= "localhost"; 
	$dbname		= "smart_smartsocket";
	$dbuser		= "monitor";
	$dbpass		= "smartsocket";
	// database connection
	$con = mysql_connect($dbhost,$dbuser,$dbpass);
    if (!$con) {
      die('Could not connect: ' . mysql_error());
    }
    mysql_select_db($dbname, $con);			    
    if (isset($_POST['submit'])){        
        $id = $_POST['zone'];		
		$konversiid = konversi($id);        
        $query = mysql_query("SELECT status FROM switching WHERE sid='".$konversiid."'")or die(mysql_error()); 
        while ($rows = mysql_fetch_array($query)):       
                if ($rows['status']==0){
                    $status=1;
                }elseif ($rows['status']==1){
                    $status=0;
                }
        endwhile;         	        
        $update = mysql_query("UPDATE switching SET status ='".$status."' WHERE sid='".$konversiid."'")or die(mysql_error());
    }
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
<!--    <link href="css/bootstrap.min.css" rel="stylesheet">-->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link href="css/toggle-style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
</head>
<body>
    <div id="wrapper">
        <form role="form" action="present.php" method="post">    
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
            <ul class="nav navbar-top-links navbar-right">                
                    <li class="dropdown">
                        <input type="radio" name="zone" class="onoffradio-checkbox" id="1" value=0 checked>                
                        <label class="onoffradio-label" for="1">
                            <span class="onoffradio-inner" id="outlet1"></span>                    
                        </label>                                            
                    </li>                    
                    <li class="dropdown">
                        <input type="radio" name="zone" class="onoffradio-checkbox" id="2" value=1>
                        <label class="onoffradio-label" for="2">
                                <span class="onoffradio-inner" id="outlet2"></span>                
                        </label>
                    </li>                    
                    <li class="dropdown">
                        <input type="radio" name="zone" class="onoffradio-checkbox" id="3" value=2>
                        <label class="onoffradio-label" for="3">
                            <span class="onoffradio-inner" id="outlet3"></span>                
                        </label>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <button class="switcher" id="save">+</button>
                        </a>                    
                    </li>                    
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
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                         <li>
                            <a class="active" href="present.php"><i class="fa fa-flash fa-fw"></i> Realtime</a>                            
                        </li>
                        <li>
                            <a href="history.php"><i class="fa fa-bar-chart-o fa-fw"></i> History</a>                           
                        </li>
                        <li>
                            <a href="setting.php"><i class="fa fa-gear fa-fw"></i> Setting</a>                            
                        </li> 
                    </ul>
                </div><!-- /.sidebar-collapse -->
            </div><!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
            <div class="row">
             <h1 class="page-header">Real Time</h1>          
              <div class="col-lg-12 col-md-12">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3">
                        <i class="fa fa-home fa-4x"></i>
                      </div>
                      <div class="col-xs-5 text-right">
                        <div class="huge"><div id="daya"></div></div>
                        <div></div>
                      </div>              
                      <div class="col-xs-4 text-right">
                        <div class="huge">KW</div>
                      </div>
                    </div>
                  </div>
                  <a href="#">
                    <div class="panel-footer">
                        <div class="clearfix"><div id="detailtimekw"></div>View Details</div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div class="row">               
              <div class="col-lg-4 col-md-4">
                <div class="panel panel-yellow">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3">
                        <i class="fa fa-dot-circle-o fa-4x"></i>
                      </div>
                      <div class="col-xs-5 text-right">
                        <div class="huge"><div id="arus"></div></div>
                        <div></div>
                      </div>              
                      <div class="col-xs-4 text-right">
                        <div class="huge">A</div>
                      </div>
                    </div>
                  </div>
                  <a href="#">
                    <div class="panel-footer">
                      <div class="clearfix"><div id="detailtime"></div></div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="panel panel-green">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3">
                        <i class="fa fa-fire fa-4x"></i>
                      </div>
                      <div class="col-xs-5 text-right">
                        <div class="huge"><div id="tegangan"></div></div>
                        <div></div>
                      </div>              
                      <div class="col-xs-4 text-right">
                        <div class="huge">V</div>
                      </div>
                    </div>
                  </div>
                  <a href="#">
                    <div class="panel-footer">
                      <div class="clearfix"><div id="detailtime"></div>View Details</div>
                    </div>
                  </a>
                </div>
              </div>
              <div class="col-lg-4 col-md-4">
                <div class="panel panel-red">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-3">
                        <i class="fa fa-tint fa-4x"></i>
                      </div>
                      <div class="col-xs-5 text-right">
                        <div class="huge"><div id="pf"></div></div>
                        <div></div>
                      </div>              
                      <div class="col-xs-4 text-right">
                        <div class="huge">PF</div>
                      </div>
                    </div>
                  </div>
                  <a href="#">
                    <div class="panel-footer">
                      <div class="clearfix"><div id="detailtimepf"></div>View Details</div>
                    </div>
                  </a>
                </div>
              </div>               
            </div> <!-- /.widget-row -->    
            <div class="row">
              <div class="col-lg-12 col-md-12 connectedSortable">
                <!-- energy-graph-panel -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Status             
                  </div><!-- /.panel-header -->
                  <div class="panel-body no-padding">
                    <div class="row">
                      <div class="col-lg-12 col-md-12">
                        <h1> Outlet Status</h1>  
                        <div class="well">
                                <h4>Information</h4>
                                <p>This Outlet will be off when the time from <b>23:00 PM until 24:00 PM </b>everday or budget are exceed <b>100 USD</b> in a month</p>
                                <a class="btn btn-default btn-lg btn-block" href="setting.html">Click here to change the settting</a>
                        </div>
                        <h1> Outlet Switch</h1>  
                        <div class="well">                                
                            <p><i class="fa fa-warning fa-1x"></i> &nbsp;Set the Outlet ON or OFF, the process will take 1 minute so please do not turn off or on directly from the device. This will cause the program to break.</p>
                        
                        </div>  
                        <div class="switch">
							<button type="submit" class="btn btn-outline btn-success btn-lg btn-block" name="submit">Change</button>
<!--
                            <input id="cmn-toggle-4" class="cmn-toggle cmn-toggle-round-flat" type="button" checked>
                            <label for="cmn-toggle-4"></label>
                            <p>&nbsp;&nbsp;OFF&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ON</p>
-->
                        </div>                          
                      </div><!-- /.graph-sel-col -->              
                    </div><!-- /.graph-row -->
                  </div><!-- /.panel-body -->
                </div><!-- /.panel-energy-graph -->
              </div><!-- /.col-energy-graph -->
            </div> <!-- /.row-Pwr -->        
        </div><!-- /#page-wrapper -->
        </form>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>
<!--    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.min.js"></script>-->
    <script src="http://cdn.crunchify.com/wp-content/uploads/code/knob.js"></script>
    <script type="text/javascript" src="present_js.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>    
    <script src="js/plugins/jqueryKnob/jquery.knob.js"></script>    
</body>

</html>
<?php
function konversi($id) {
	if ($id==0){
		$status = "zone 1";
	}elseif ($id==1){
		$status = "zone 2";
	}elseif ($id==2){
		$status = "zone 3";
	}		
	return $status;
}
?>
