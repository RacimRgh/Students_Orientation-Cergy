<!DOCTYPE HTML>

<html>
	<head>
		<title>Aide aux étudiants</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
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
									Nous sommes trois étudiants étrangers, en arrivant dans notre université nous étions un peu paumés et à ce moment là on a eu du mal à aller vers nos camarades pour demander de l'aide. Par chance, nous nous sommes retrouvés nous trois pour travailler sur un projet, ce site ! Alors on s'est dit qu'on fera d'une pierre deux coups, un projet et une aide pour les étudiants qui seront dans le même cas que nous !</p>
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
									Commence par t'enregistrer, on trouvera quelqu'un à aider !
								</p>
								<section>
									<div class="row">
										<form id="infos">
											<div>
											<input type="text" name="id_E" placeholder="N° Etudiant"> 
											</div>
											<div>
											<input type="text" name="nom_E" placeholder="Nom"> 
											</div>
											<div>
											<input type="text" name="prenom_E" placeholder="Prénom">
											</div>
											<div>
											<input type="text" name="tel_E" placeholder="Numéro de téléphone">
											</div>
											<div>
											<input type="text" name="universite_E" placeholder="Université">
											</div>
											<div>
											<select name="specialite" placeholder="Specialite">
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
											<input type="text" name="classe" placeholder="Classe">
											</div>
											<div>
											<input type="password" name="psw" placeholder="Mot de passe">
											</div>
											<div>
											<input type="submit" name="Submit" value="Inscription">
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
												<input type="password" name="psw" placeholder="Mot de passe" />
											</div>

											<div class="col-12">
												<a href="affichage.php"><button type="button">Connexion</button></a>
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
