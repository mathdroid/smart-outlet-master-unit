<!DOCTYPE html>
<html>
	<head>
        <title> Smart Monitoring </title>
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
        <link href="css/style.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- jQuery Version 1.11.0 -->        
        <script src="js/jquery-1.11.0.js"></script>        
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
<!--
        <script src="js/plugins/morris/raphael.min.js"></script>
        <script src="js/plugins/morris/morris.min.js"></script>
        <script src="js/plugins/morris/morris-data.js"></script>
-->
        <!-- HighChart Charts JavaScript -->
        <script src="js/chart-js.js"></script>
        <script type="text/javascript" src="chart-js/highcharts-3d.js"></script>
		<script type="text/javascript" src="chart-js/highcharts.js"></script>
        <script type="text/javascript" src="chart-js/themes/grid-light.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/sb-admin-2.js"></script>
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
            <div class="actions">
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <button class="switcher" id="1" active value=1>Outlet 1</button>
                        </a>                                            
                    </li>                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <button class="switcher" id="2" value=2>Outlet 2</button>
                        </a>                    
                    </li>                    
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <button class="switcher" id="3" value=3>Outlet 3</button>
                        </a>                    
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <button class="switcher" id="save">+</button>
                        </a>                    
                    </li>                    
                </ul>
            </div>    
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
                            <a href="present.php"><i class="fa fa-flash fa-fw"></i> Realtime </a>                            
                        </li>
                        <li>
                            <a class="active" href="history.php"><i class="fa fa-bar-chart-o fa-fw"></i> History</a>                           
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
                <div class="col-lg-12">
                    <h1 class="page-header">History</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Budget and KWH Graph
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">                                    
                                    <div id="container" class="chart"></div> 
                                    <h1> Budget and KWH Status</h1>  
                                    <div class="well">
                                            <h4>Information</h4>
                                            <p>This outlet got a budget: <b>100 USD</b> for a month and total KWH in last seven days: <b>2000 KWH</b></p>  
                                    </div>
                                </div>                                
                            </div><!-- /.row (nested) -->
                        </div><!-- /.panel-body -->
                    </div><!-- /.panel -->
                </div><!-- /.col-lg-12 -->
            </div>
        </div><!-- /#page-wrapper -->
    </div>
	</body>
</html>