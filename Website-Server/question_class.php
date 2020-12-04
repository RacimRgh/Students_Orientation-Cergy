<?php

require_once('connect.php'); 
class question_Class{
    
    
    private $idM, $dateM, $heureM,$AdmA,$idqu,$titrq, $categorie, $contenq, $idB, $idD;

    function createQuestion($idM,$dateM,$heureM,$AdmA,$idqu,$titrq,$categorie,$contenq,$idB,$idD){
        
        $sql = "INSERT INTO Question (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('$idM', '$dateM', '$heureM', '$AdmA','$idqu','$titrq', '$categorie', '$contenq', '$idB', '$idD')";
        
       $res = false;
       if(pg_query($sql))
       {
           $res = true;
       }
       else
       {
           $res = false;
       }
       return $res;
    }



    function getQuestions(){             
        $sql ="SELECT * FROM question ORDER BY idq DESC";
        return pg_query($sql);
    } 
    function getMessages(){             
        $sql ="SELECT Q.dateMess as Dateq, Q.categorie as cate, Q.contenuQ as messages, D.nom_etu as nom, D.prenom_etu as prenom, D.univ_etu as univ, D.specialite_etu as spe FROM Question as Q, Demandeur as D WHERE  D.id_dem = Q.idDem";
        return pg_query($sql);
    } 


    function getQuestionById($idqu){    
  
        $sql ="SELECT * FROM question WHERE idq='".$this->cleanData($idqu)."'"; 
        return pg_query($sql);
        
    } 
    function getQuestionLastId(){    
  
      
        //$sql ="SELECT * FROM question LIMIT 1 ORDER BY idQ DESC"; 
        $sql = "SELECT idQ FROM question ORDER BY idQ ASC";
        $bornes = pg_query($sql); 
        while($question = pg_fetch_object($bornes)):
            $lastid = $question->idQ;
        endwhile;
        return $lastid;
        
    } 

    function getCleanedId($idQ)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $idQ[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($idQ, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    
    function deletequestion($idqu){    
  
         $sql ="DELETE FROM question  WHERE idq='$idqu'"; 
        if(pg_query($sql))
        {
            $res = true;
        }
        else
        {
            $res = false;
        }
        return $res;
    } 
    // fonction permettant la modification des bornes
    function updateQuestion($idM,$dateM,$heureM,$AdmA,$idqu,$titrq,$categorie,$contenq,$idB,$idD){      
        
        $sql = "UPDATE question SET idMessage ='$dateM' , dateMess = '$heureM', heureMess='', admAjout,titreQ, categorie, contenuQ, id_borne, idDem WHERE idq = '$idqu' " ;
        $res = false;
        //var_dump((pg_query($sql)));
        if(pg_query($sql))
        {
            $res = true;
        }
        else
        {
            $res = false;
        }
        return $res;
            
    }
    // fonction permettant Protection des données au format PostgreSQL  pour les insérer dans la base de données.
    function cleanData($val){
        return pg_escape_string($val);
    }
}
/*
$obj = new question_Class;

$questions = $obj->getMessages();
var_dump($questions);
while($question = pg_fetch_object($questions)):
    echo     $question->dateq  . '<br>';
    echo     $question->nom . '<br>';
    echo     $question->prenom . '<br>';
    echo     $question->messages . '<br>';
    echo     $question->spe . '<br>';
    echo     $question->univ ;
endwhile;

//echo $bornes;

//var_dump($bornes);
$a = $obj->updateQuestion('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($question = pg_fetch_object($bornes)):
    echo $question->titreQ . '<br>';
    echo $question->contenuQ . '<br>';
    echo $question->id_borne . '<br>';
    endwhile;  
*/
?>