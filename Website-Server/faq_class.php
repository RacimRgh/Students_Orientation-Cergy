<?php

require_once('connect.php'); 
class faq_Class{
    
    
    private $idM, $dateM, $heureM,$AdmA,$idqu,$titrq, $categorie, $contenq, $idB, $idD;

    function createQuestion($idM,$dateM,$heureM,$AdmA,$idqu,$titrq,$categorie,$contenq,$idB,$idD){
        
        $sql = "INSERT INTO Faq (idMessage, dateMess, heureMess, admAjout, idq,titreQ, categorie, contenuQ, id_borne, idDem) VALUES ('$idM', '$dateM', '$heureM', '$AdmA','$idqu','$titrq', '$categorie', '$contenq', '$idB', '$idD')";
        
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
        $sql ="SELECT * FROM Faq ORDER BY idq DESC";
        return pg_query($sql);
    } 
    function getMessages(){             
        $sql ="SELECT Q.dateMess as Dateq, Q.categorie as cate, Q.contenuQ as messages, D.nom_etu as nom, D.prenom_etu as prenom, D.univ_etu as univ, D.specialite_etu as spe FROM Faq as Q, Demandeur as D WHERE  D.id_dem = Q.idDem";
        return pg_query($sql);
    } 


    function getQuestionById($idqu){    
  
        $sql ="SELECT * FROM Faq WHERE idq='".$this->cleanData($idqu)."'"; 
        return pg_query($sql);
        
    } 
    function getQuestionLastId(){    
  
      
        //$sql ="SELECT * FROM Faq LIMIT 1 ORDER BY idQ DESC"; 
        $sql = "SELECT idQ FROM Faq ORDER BY idQ ASC";
        $bornes = pg_query($sql); 
        while($Faq = pg_fetch_object($bornes)):
            $lastid = $Faq->idQ;
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
  
         $sql ="DELETE FROM Faq  WHERE idq='$idqu'"; 
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
        
        $sql = "UPDATE Faq SET idMessage ='$dateM' , dateMess = '$heureM', heureMess='', admAjout,titreQ, categorie, contenuQ, id_borne, idDem WHERE idq = '$idqu' " ;
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
while($Faq = pg_fetch_object($questions)):
    echo     $Faq->dateq  . '<br>';
    echo     $Faq->nom . '<br>';
    echo     $Faq->prenom . '<br>';
    echo     $Faq->messages . '<br>';
    echo     $Faq->spe . '<br>';
    echo     $Faq->univ ;
endwhile;

//echo $bornes;

//var_dump($bornes);
$a = $obj->updateQuestion('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($Faq = pg_fetch_object($bornes)):
    echo $Faq->titreQ . '<br>';
    echo $Faq->contenuQ . '<br>';
    echo $Faq->id_borne . '<br>';
    endwhile;  
*/
?>