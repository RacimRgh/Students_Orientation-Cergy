<?php
// On inclut la connexion à la base
$db_handle = pg_connect("host=localhost dbname=dbborne user=lyse password=juju");
// On écrit notre requête
$sql = "SELECT * FROM Borne";
require_once ('borne_class.php');

if (isset($_POST['submit']) and !empty($_POST['submit']))
{

	$longitudes = $_POST['longitude'];
	$latitudes = $_POST['latitude'];
	$etats = $_POST['etat'];
 
	$obj = new borne_Class;
	$last_id = $obj->getBorneLastId();  
	$id_cleaned = $obj->getCleanedId($last_id); 
	$ret_val = $obj->createBorne($id_cleaned,$longitudes, $latitudes, $etats);
	if($ret_val === true){
		echo '<script type="text/javascript">'; 
		echo 'alert("Insertion reussie !");'; 
		echo 'window.location.href = "borne.php";';
		echo '</script>';
	}
	else
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Oups un problème est arrivé!");'; 
		echo 'window.location.href = "borne.php";';
		echo '</script>';
	}
	
	/*var_dump($ret_val);*/
	//die('here');
}

require_once ('close.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>gesborne</title>

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css" />

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="assets/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->
    <link rel="stylesheet" href="assets/css/ace-skins.min.css" />
    <link rel="stylesheet" href="assets/css/ace-rtl.min.css" />

    <!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->
</head>

<body class="no-skin">
    <div id="navbar" class="navbar navbar-default          ace-save-state">
        <div class="navbar-container ace-save-state" id="navbar-container">
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>

            <div class="navbar-header pull-left">
                <a href="index.html" class="navbar-brand">
                    <small>
                        <i class="fa fa-leaf"></i>
                        Gestion borne
                    </small>
                </a>
            </div>

        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">


        <div id="sidebar" class="sidebar                  responsive                    ace-save-state">




            <ul class="nav nav-list">
                <li class="active">
                    <a href="index.php">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text"> Tableau de bord </span>
                    </a>

                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="etudiant.php">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text"> Etudiants </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="borne.php">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text"> Bornes </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="assistance.php">
                        <i class="menu-icon fa fa-comments"></i>
                        <span class="menu-text"> Assistance </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="faq.php">
                        <i class="menu-icon fa fa-calendar"></i>
                        <span class="menu-text"> FAQ </span>
                    </a>

                    <b class="arrow"></b>
                </li>


                <li class="">
                    <a href="gallery.html">
                        <i class="menu-icon fa fa-picture-o"></i>
                        <span class="menu-text"> Gallery </span>
                    </a>

                    <b class="arrow"></b>
                </li>

            </ul><!-- /.nav-list -->


        </div>

        <div class="main-content">
            <div class="main-content-inner">
                <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="ace-icon fa fa-home home-icon"></i>
                            <a href="index.php">Accueil</a>
                        </li>
                        <li class="active">Nouvelle Borne</li>
                    </ul><!-- /.breadcrumb -->

                    <div class="nav-search" id="nav-search">
                        <form class="form-search">
                            <span class="input-icon">
                                <input type="text" placeholder="Search ..." class="nav-search-input"
                                    id="nav-search-input" autocomplete="off" />
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </form>
                    </div><!-- /.nav-search -->
                </div>

                <div class="page-content">

                    <div class="page-header">
                        <h1>
                            Nouvelle borne

                        </h1>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->


                            <div class="row">
                                <div class="col-xs-12">
                                    <!-- PAGE CONTENT BEGINS -->
                                    <form class="form-horizontal" method="post" role="form">



                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Latitude</label>

                                            <div class="col-sm-9">
                                                <span class="input-icon">
                                                    <input type="text" name="latitude" id="form-field-icon-1"
                                                        class="col-xs-12 col-sm-12" />
                                                    <i class="ace-icon fa fa-cogs blue"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Longitude</label>

                                            <div class="col-sm-9">
                                                <span class="input-icon">
                                                    <input type="text" name="longitude" id="form-field-icon-1"
                                                        class="col-xs-12 col-sm-12" />
                                                    <i class="ace-icon fa fa-cogs blue"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="space-4"></div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label no-padding-right">Etat</label>

                                            <div class="col-sm-9">
                                                <span class="input-icon">
                                                    <input type="text" name="etat" id="form-field-icon-1"
                                                        class="col-xs-12 col-sm-12" />
                                                    <i class="ace-icon fa fa-cogs blue"></i>
                                                </span>
                                            </div>
                                        </div>


                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <span class="input-icon">

                                                    <input class="btn btn-info" name="submit" type="submit">
                                                    <i class="ace-icon fa fa-check white"></i>
                                                </span>



                                                &nbsp; &nbsp; &nbsp;
                                                <button class="btn" type="reset">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    recharger
                                                </button>
                                            </div>
                                        </div>





                                    </form>



                                    <!-- PAGE CONTENT ENDS -->
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.page-content -->
                    </div>
                </div><!-- /.main-content -->

                <div class="footer">
                    <div class="footer-inner">
                        <div class="footer-content">
                            <span class="bigger-120">
                                <span class="blue bolder">Gesborne</span>
                                Application &copy; 2020-2021
                            </span>

                            &nbsp; &nbsp;
                            <span class="action-buttons">
                                <a href="#">
                                    <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                                </a>

                                <a href="#">
                                    <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                                </a>

                                <a href="#">
                                    <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
                </a>
            </div><!-- /.main-container -->


</body>

</html>
