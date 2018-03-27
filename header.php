<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $pageinfo['title']; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/startmin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<!-- jQuery -->
<script src="js/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/startmin.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/raphael.min.js"></script>
<script src="js/morris.min.js"></script>


<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Счетчики</a>
        </div>

        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <!-- Top Navigation: Left Menu 
        <ul class="nav navbar-nav navbar-left navbar-top-links">
            <li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
        </ul>-->

        <!-- Top Navigation: Right Menu -->
        <ul class="nav navbar-right navbar-top-links">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <?php echo $userinfo['login']; ?> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="index.php?page=settings" class="<?php echo $pageinfo['page']=='settings'? "active" : "" ?>"><i class="fa fa-gear fa-fw"></i> Настройки</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="index.php?page=logout"><i class="fa fa-sign-out fa-fw"></i> Выход</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Sidebar -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">

                <ul class="nav" id="side-menu">
                    <li>
                        <a href="index.php?page=home" class="<?php echo $pageinfo['page']=='home'? "active" : "" ?>"><i class="fa fa-dashboard fa-fw"></i> Главная </a>
                    </li>
                    <li>
					
<?php
$flats = dbSelect($dbconnect, "SELECT id, name FROM flats WHERE user_id='".$userinfo['id']."';");
foreach ($flats as $flat)
{
	echo "<a href=\"#\"><i class=\"fa fa-home fa-fw\"></i>".$flat['name']."<span class=\"fa arrow\"></span></a>";
	echo "<ul class=\"nav nav-second-level\">";
	
	$counters = dbSelect($dbconnect, "SELECT c.id as id, c.name as counter_name, number FROM counters c INNER JOIN flats f ON c.flat_id = f.id WHERE f.user_id='".$userinfo['id']."' AND f.id='".$flat['id']."' ORDER BY counter_name;");
	
	foreach ($counters as $counter)
	{
		echo "<li>";
        echo "<a href=\"index.php?page=counter&id=".$counter['id']."\">".$counter['counter_name']."</a>";
        echo "</li>";
	}
	
	echo "</ul>";
}

?>
                           <!-- <li>
                                <a href="#"><i class="fa fa-tachometer fa-fw"></i> Обзор</a>
                            </li> -->
						
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">