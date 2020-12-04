<?php


require_once ('reponse_class.php');

$question3 = $_SESSION['question'];
echo $question->idQ ;

if (isset($_POST['submit']) and !empty($_POST['submit']))
{
	$idM;
	$dateM =date('d-m-y');
	$heure = date('h:i:s');
	$AdmA = 'A1';
	$contenq = $_POST['message'];
	$idqu= $_POST['longitude'];
	$idA = $_POST['longitude'];

	$obj_assistant = new assistant_Class;
			
	$obj_etudiant = new message_Class;
			
    $last_id_assistant = $obj_assistant->getAssistantLastId();  
    $id_cleaned_assistant = $obj_assistant->getCleanedId_assistant($last_id_assistant); 

	$last_id_message = $obj_etudiant->getMessageLastId(); 
			
	$id_cleaned_message = $obj_etudiant->getCleanedId_message($last_id_message);
			
			
	$obj = new reponse_Class;
	$last_id = $obj->getReponseLastId();  
	$id_reponsecleaned = $obj->getReponseCleanedId($last_id); 
	$ret_val = $obj->createReponse($idM,$dateM,$heureM,$AdmA,$id_reponsecleaned,$contenq,$idqu,$idA);
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
<!DOCTYPE html>
<html>
<head>
	<title> Repondre à un message </title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/repondre.css">
</head>
<body>
	<article id="contact" class="panel">
		<header>
			<h2>Repondre à l'étudiant</h2>
		</header>
		<div id="corps">
			<form>
				
				<div class="col-12">
					<textarea name="message" placeholder="Message" rows="6"></textarea>
				</div>
				<div class="col-12">
					<button type="button"> Envoyer </button>
				</div>	
			</form>
		</div>				
	</article>
</body>
</html>