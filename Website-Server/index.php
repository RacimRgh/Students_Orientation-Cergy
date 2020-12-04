<?php 
    session_start();
   	
	 
   	if(isset($_POST['btn_inscription']))
   	{
		$type = $_POST["type_inscription"];
		require_once('assistant_class.php');
		
		require_once('etudiant_class.php');
       
        /**
         *Switch sur le type d'inscription
         *assistant ou demandeur
         */
        
       if($type == 'assistant')
       { 
		  
             $nom_et = $_POST["nom_et"];
             $prenom_et = $_POST["prenom_et"];
             $mail_et = $_POST["email_et"];
             $tel_et = $_POST["numtel_et"];
             $univ_et = $_POST["univ_et"];
			$spec_etu = $_POST["spec_et"];
			$statut_as = "hors ligne";
			 $date_Insc =  date('d-m-y');
			'<br>';
			$obj_assistant = new assistant_Class;
			
			$obj_etudiant = new etudiant_Class;
			
            $last_id_assistant = $obj_assistant->getAssistantLastId();  
             $id_cleaned_assistant = $obj_assistant->getCleanedId_assistant($last_id_assistant); 

			$last_id_etudiant = $obj_etudiant->getEtudiantLastId(); 
			
	         $id_cleaned_etudiant = $obj_etudiant->getCleanedId_etudiant($last_id_etudiant);
			
			$ret_val = $obj_assistant->createAssistant($id_cleaned_etudiant, $nom_et, $prenom_et,$mail_et,$tel_et,$univ_et, $spec_etu ,$id_cleaned_assistant,$statut_as,$date_Insc);
			#var_dump($ret_val); 
			if($ret_val === true)
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Inscription reussie !");'; 
                echo 'window.location.href = "affichage.php";';
                echo '</script>';
            }
            else
            {
                echo '<script type="text/javascript">'; 
                echo 'alert("Oups un problème est arrivé!");'; 
                //echo 'window.location.href = "";';
                echo '</script>';
            }
       }
    }
	else
	{
		echo '<script type="text/javascript">'; 
		echo 'alert("Attention! Probleme pendant la validation");'; 
		//echo 'window.location.href = "";';
		echo '</script>'; 
	} 
?>

<!DOCTYPE HTML>

<html>

<head>
    <title>Aide aux étudiants</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
</head>

<body class="is-preload">

    <!-- Wrapper-->
    <div id="wrapper">

        <!-- Nav -->
        <nav id="nav">
            <a href="#" class="icon solid fa-home"><span>Acceuil</span></a>
            <a href="#work" class="icon solid fa-folder"><span>Inscription</span></a>
            <a href="#contact" class="icon solid fa-envelope"><span>Connexion</span></a>

        </nav>

        <!-- Main -->
        <div id="main">

            <!-- Me -->
            <article id="acceuil" class="panel intro">
                <header>
                    <h2>Qui sommes-nous ?</h2>
                    <p class="presentation">
                        Nous sommes trois étudiants étrangers, en arrivant dans notre université nous étions un peu
                        paumés et à ce moment là on a eu du mal à aller vers nos camarades pour demander de l'aide. Par
                        chance, nous nous sommes retrouvés nous trois pour travailler sur un projet, ce site ! Alors on
                        s'est dit qu'on fera d'une pierre deux coups, un projet et une aide pour les étudiants qui
                        seront dans le même cas que nous !</p>
                </header>
                <a href="#work" class="jumplink pic">
                    <span class="arrow icon solid fa-chevron-right"><span>See my work</span></span>
                    <img src="images/bienvenu.jpg" alt="" />
                </a>
            </article>

            <!-- Work -->
            <article id="work" class="panel">
                <header>
                    <h2>Inscription</h2>
                </header>
                <p>
                    Inscrit-toi pour aider ou pour demander de l'aide.
                </p>

                <section>
                    <div class="row">
                        <form id="infos" method="POST">
 
                            <div>
                                <label>Que voulez-vous faire ?</label>
                                <select name="type_inscription" placeholder="Que voulez-vous?">
                                    <option value="demandeur">Demander de l'aide</option>
                                    <option value="assistant">Aider un étudiant</option>
                                </select>
                            </div> 
                            <div>
                                <input type="text" name="nom_et" placeholder="Nom">
                            </div>
                            <div>
                                <input type="text" name="prenom_et" placeholder="Prénom">
                            </div>
                            <div>
                                <input type="text" name="email_et" placeholder="E-mail">
                            </div>
                            <div>
                                <input type="text" name="numtel_et" placeholder="Numéro de téléphone">
                            </div> 
                            <div>
                                <select name="univ_et" placeholder="Université">
                                    <option>CY Paris Cergy</option>
                                    <option>Paris 1</option>
                                    <option>Paris 2</option>
                                </select>
							</div>
							<div>
                                <select name="spec_et" placeholder="Specialite">
                                    <option>Informatique</option>
                                    <option>Mathematique</option>
                                    <option>Droit</option>
                                    <option>Economie</option>
                                    <option>Biologie</option>
                                    <option>Physique</option>
                                    <option>Chimie</option>
                                    <option>Français</option>
                                    <option>Anglais</option>
                                </select>
                            </div> 
                            <div>
                                <input type="submit" name="btn_inscription" value="Inscription">
                            </div>
                        </form>
                    </div>
                </section>
            </article>

            <!-- Contact -->
            <article id="contact" class="panel">
                <header>
                    <h2>Connexion</h2>
                </header>
                <form action="#" method="post">
                    <div>
                        <div class="row">
                            <div class="col-6 col-12-medium">
                                <input type="text" name="id_E" placeholder="N° Etudiant" />
                            </div>
                            <div class="col-6 col-12-medium">
                                <input type="text" name="email" placeholder="E-mail" />
                            </div>

                            <div class="col-12">
                                <a href="affichage.php"><button type="button">connexion</button> </a>
                            </div>
                        </div>
                    </div>
                </form>
            </article>

        </div>

        <!-- Footer -->
        <div id="footer">
            <ul class="copyright">

            </ul>
        </div>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>