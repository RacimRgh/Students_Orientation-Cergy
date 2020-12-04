<?php 
session_start();

    require_once 'etudiant_class.php';
    // On inclut la connexion à la base
    $db_handle = pg_connect("host=localhost dbname=dbborne user=lyse password=juju");
    // On écrit notre requête
    $sql = "SELECT * FROM Etudiant";
    $result = pg_exec($db_handle, $sql);
    $obj = new etudiant_Class;
    $etudiants = $obj->getEtudiants();
    $sn=1;

 	if(isset($_POST['update'])){
        //echo $_POST['id'];
        $etudiant2 = $obj->getEtudiantById($_POST['id']);
        $_SESSION['etudiant'] = pg_fetch_object($etudiant2);
        header('location:editetudiant.php');
        //var_dump($Etudiant);
        //$b= $Etudiant->id_Etudiant;
        //echo $Etudiant;
        


        
	}
	
	$id = $_POST['id'];
    
    if(isset($_POST['delete'])){
       $ret_val = $obj->deleteetudiant($id);
       if($ret_val==1){
           
          echo "<script language='javascript'>";
          echo "alert('Ligne supprimée avec succès')";
		  echo "</script>";
		  header('location:etudiant.php');
      }
    }
 
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
                            <a href="#">Accueil</a>
                        </li>
                        <li class="active">Tableau de bord</li>
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
                            Toutes les Etudiants

                        </h1>


                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <!-- PAGE CONTENT BEGINS -->
                            <div class="row">
                                <div class="pull-right">
                                    <a href="addetudiant.php" class="btn btn-success">
                                        <i class="ace-icon fa fa-plus-o">

                                        </i>
                                        Nouvel etudiant
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table id="simple-table" class="table  table-bordered table-hover">
                                        <thead>
                                            <tr>

                                                <th class="detail-col">id</th>
                                                <th class="detail-col">matricule</th>
                                                <th>nom</th>
                                                <th>prenom</th>
                                                <th class="hidden-480">email</th>
                                                <th class="hidden-480">Actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <?php
                                                   while($etudiant = pg_fetch_object($etudiants)):
                                                ?>

                                            <tr>

                                                <td><?=$sn++?></td>
                                                <td><?=$etudiant->matricule_etu?></td>
                                                <td><?=$etudiant->nom_etu?></td>
                                                <td><?=$etudiant->prenom_etu?></td>
                                                <td><?=$etudiant->email_etu?></td>
                                                <td>
                                                    <form method="post">
                                                        <input type="submit" class="btn btn-success" name="update"
                                                            value="Modifier">
                                                        <input type="submit"
                                                            onClick="return confirm('Please confirm deletion');"
                                                            class="btn btn-danger" name="delete" value="Supprimer">
                                                        <input type="hidden" value="<?=$etudiant->matricule_etu?>" name="id">
                                                    </form>
                                                    
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>

                                        </tbody>
                                    </table>
                                </div><!-- /.span -->
                            </div><!-- /.row -->

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
<?php  ?>