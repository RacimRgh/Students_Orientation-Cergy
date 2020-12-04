<?php 
session_start();

	require_once 'question_class.php';
	require_once 'reponse_class.php';
   
	$obj = new question_Class;
	$obj_reponse = new reponse_Class;

	
	$reponse2 = $obj_reponse->getReponseById($id);
	//var_dump($obj);
	$questions = $obj->getMessages();
	
	 //var_dump($questions);

 	if(isset($_POST['repondre'])){
        //echo $_POST['id'];
		$question2 = $obj->getQuestionById($_POST['id']);
		
		$_SESSION['question'] = pg_fetch_object($question2);
		
        header('location:repondre.php');
        //var_dump($borne);
        //$b= $borne->id_borne;
        //echo $borne;
        
	}
	
	if(isset($_POST['btn_select_search']) && isset($_POST['select_search'])){ 
        $select_search_result = $obj->getMessagesBySelect($_POST['select_search']); 
		var_dump($select_search_result);
		if($select_search_result)
        {
            $questions = $select_search_result;
        }
    }	
    if(isset($_POST['btn_input_search']) && isset($_POST['input_search'])){ 
        $input_search_result = $obj->getMessagesByInput($_POST['input_search']); 
        if($input_search_result)
        {
            $questions = $select_search_result;
        }
	}	
 
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/affichage.css">
	<title>
		Affichage
	</title>

</head>
<body>
<style>
        #searchbar{
    position:relative;
    width:1040px;
    height:auto;
    display:inline-block;
}
#searchbar .text{
    width:300px; 
}
#searchbar .champ{
    width:600px;
    height:35px; 
}
#formet
{
        width: 100%;
    position: fixed;

}
#searchbar .bouton{
    background-image: url(images/searchbar_button.png);
    width: fit-content; 
    padding: 10px; 
    border:none; 
}

/* button div */
#buttons {
  padding-top: 50px;
  text-align: center;
}


#alink { text-decoration: none; 
}
.p-btn { 
  text-align: center; 
  border-radius: 5px; 
  text-transform: uppercase; 
  display: inline-block; 
}
.p-btn.green-large { 
  font-size: 17px;  
  padding: 15px 24px; 
  color: rgb(255, 255, 255); 
  line-height: 1; 
}

.hp-btn { 
  padding: 25px 30px !important; 
}

.p-btn.green:hover, .p-btn.green-large:hover { 
  background: rgb(61, 204, 134); 
}
.p-btn.green:active, .p-btn.green-large:active { 
  background: rgb(20, 166, 94); 
}
.icon-mobile::before { 
  content: ""; 
}

    </style>
    <center id="searchbar"> 
        
 
	<form action=""  id="" method="POST">
            <h3>Recherche rapide <select name="select_search" id="cars">
                <option value="Classe">Classe</option>
                <option value="Scolarite">Scolarite</option>
                <option value="Frais">Fais</option>
                <option value="Calendrier">Calendrier</option>
                <option value="Campus">Campus</option>
                <option value="Autre">Autre</option>
              </select>
              <input type="submit" name="btn_select_search" class="p-btn green-large hp-btn" value="Submit" style="
              height: 30px;
              padding: 1px 15px !important;
          ">
            </h3>
            
        </form>
        <form action="" id="formet" method="POST"> 
            Par mot clé :<input class="champ" type="text" name="input_search" placeholder="Ex : licence 3 " style="border-radius:50px"/>
            <input class="p-btn green-large hp-btn" type="submit" name="btn_input_search" value="Valider"  style="border-radius:50px;
            height: 30px;
            padding: 1px 15px !important;
        "/>
        </form>
    </center>
  <div id="tableau" style="top: 25%!important;">
	<table>
    <thead>
        <tr>
            <th colspan="6">Liste des demandes</th>
        </tr>
    </thead>
    <tbody>
        <tr>
        	<td> Date :</td>
            <td>Nom :</td>
            <td>Prénom :</td>
            <td>Specialité :</td>
            <td>Messsage :</td>   
            <td>Repondre ?</td> 
        </tr>
		<?php
			while($question = pg_fetch_object($questions)):
				$id =$question->idquest;
				
			
        ?>
		<tr>
			<td><?=$question->dateq?></td>
			<td><?=$question->nom?></td>
            <td><?=$question->prenom?></td>
			<td><?=$question->spe?></td>
			<td>
				
				<details>
				
					<summary><?=$question->messages?> </summary>
					<?
						
						while($reponse = pg_fetch_object($reponse2)):?>
							<p><?=$reponse->contenuRep?></p>
						
						<? endwhile; ?>
					
					<p>Reponse 2</p>
					<p>Reponse 3</p>
				</details>
			</td>
            <td>
                <form method="post">
                	<input type="submit" class="btn btn-primary" name="Repondre"
                        value="Repondre">
                 </form>
			</td>
		</tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>

</body>
</html>