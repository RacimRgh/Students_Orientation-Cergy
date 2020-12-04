<?php

require_once ('etudiant_class.php');

if (isset($_POST['submit']) and !empty($_POST['submit']))
{
    //$matricule_et , $nom_et, $prenom_et ,$email_et,$numtel_et, $univ_et ,$specialite_et
	echo $nom_ets = $_POST['nomEt'];
	echo $prenom_ets = $_POST['prenomEt'];
    echo $email_ets = $_POST['emailEt'];
    echo $numtel_ets = $_POST['numtelEt'];
	echo $univ_ets = $_POST['univEt'];
    echo $specialite_ets = $_POST['specialiteEt'];
    die();
 
	$obj = new etudiant_Class;
	$last_id = $obj->getEtudiantLastId();  
	$id_cleaned = $obj->getCleanedId($last_id); 
	$ret_val = $obj->createEtudiant($id_cleaned,$nom_ets,$prenom_ets, $email_ets, $numtel_ets,$univ_ets,$specialite_ets);
	if($ret_val === true){
		echo '<script type="text/javascript">'; 
		echo 'alert("Insertion reussie !");'; 
		echo 'window.location.href = "etudiant.php";';
		echo '</script>';
	}
	else
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Oups un problème est arrivé!");'; 
		echo 'window.location.href = "etudiant.php";';
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
    <title>gesEtudiant</title>

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
                        Gestion Etudiant
                    </small>
                </a>
            </div>

        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">


        <div id="sidebar" class="sidebar  responsive                    ace-save-state">
				
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
							<i class="menu-icon fa fa-help"></i>
							<span class="menu-text"> Assistance </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="">
						<a href="faq.php">
							<i class="menu-icon fa fa-comments"></i>
							<span class="menu-text"> FAQ </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="reponse.php">
							<i class="menu-icon fa fa-comment"></i>
							<span class="menu-text"> Reponse </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="question.php">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text"> Question </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="">
						<a href="message.php">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text"> Message </span>
						</a>

						<b class="arrow"></b>
					</li>


					<li class="">
						<a href="maintenace.php">
							<i class="menu-icon fa fa-picture-o"></i>
							<span class="menu-text"> Maintenance </span>
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
                        <li class="active">Nouvelle Etudiant</li>
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
                            Nouvelle Etudiant

                        </h1>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->


                            <div class="row">
                                <div class="col-xs-12">
                                    <!-- PAGE CONTENT BEGINS -->
                                    <form class="form-horizontal" method="post" role="form">

                                        <div class="col-md-6">
                                        
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right">Nom</label>

                                                <div class="col-sm-9">
                                                    <span class="input-icon">
                                                        <input type="text" name="nomET" id="form-field-icon-1"
                                                            class="col-xs-12 col-sm-12" />
                                                        <i class="ace-icon fa fa-user blue"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right">Prenom</label>

                                                <div class="col-sm-9">
                                                    <span class="input-icon">
                                                        <input type="text" name="prenomEt" id="form-field-icon-1"
                                                            class="col-xs-12 col-sm-12" />
                                                        <i class="ace-icon fa fa-users blue"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div>
                                            <div>
											    <label for="form-field-select-1">Université</label>

													<select class="form-control" name="univET" id="form-field-select-1">
																<option value=""></option>
																<option value="CY Paris Cergy">CY Paris Cergy</option>
																<option value="Paris 1">Paris 1</option>
																<option value="Paris 2">Paris 2</option>
																<option value="Paris 7">Paris 7</option>
																<option value="universite de lyon">universite de lyon</option>
																<option value="universite de lille">universite de lille</option>
													</select>
											</div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right">Telephone</label>

                                                <div class="col-sm-9">
                                                    <span class="input-icon">
                                                        <input type="text" name="numtelET" id="form-field-icon-1"
                                                            class="col-xs-12 col-sm-12" />
                                                        <i class="ace-icon fa fa-cogs blue"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="space-4"></div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label no-padding-right">Email</label>

                                                <div class="col-sm-9">
                                                    <span class="input-icon">
                                                        <input type="text" name="emailEt" id="form-field-icon-1"
                                                            class="col-xs-12 col-sm-12" />
                                                        <i class="ace-icon fa fa-envelope blue"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="space-4"></div>
                                            <div>
											    <label for="form-field-select-1">Spécialité</label>

													<select class="form-control" name="specialiteEt" id="form-field-select-1">
																<option value=""></option>
																<option value="Informatique">Informatique</option>
																<option value="Biologie">Biologie</option>
																<option value="Mathematique">Mathematique</option>
																<option value="Economie">Economie</option>
																<option value="Physique">Physique</option>
																<option value="Chimie">Chimie</option>
													</select>
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
                                <span class="blue bolder">GesEtudiant</span>
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
