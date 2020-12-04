<?php

require_once('connect.php'); 
class question_Class{
    
    
    private $table_name1 = 'Question';
    //private $titreQ = null, $contenuQ = null, $etat = null,$idQ='B1';
    private $idQ,$titreQ,$contenuQ,$id_borne,$idDem;

    function createQuestion($idQ,$titreQ,$contenuQ,$id_borne,$idDem){
        
        $sql = "INSERT INTO question (idQ,titreQ, contenuQ,id_borne,idDem) VALUES ('$idQ','$titreQ', '$contenuQ','$id_borne','$idDem')";
      
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
        $sql ="SELECT * FROM question ORDER BY idQ DESC";
        return pg_query($sql);
    } 


    function getQuestionById($idQ){    
  
        $sql ="SELECT * FROM question WHERE idQ='".$this->cleanData($idQ)."'"; 
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

    
    function deleteborne($idQ){    
  
         $sql ="DELETE FROM question  WHERE idQ='$idQ'"; 
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
    function updateQuestion($idQ,$titreQ,$contenuQ,$id_borne,$idDem){      
        
        $sql = "UPDATE question SET titreQ= '$titreQ',contenuQ= '$contenuQ', id_borne= '$id_borne', idDem= '$idDem'  WHERE idQ = '$idQ' " ;
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
$obj = new borne_Class;

//$bornes = $obj->getQuestionLastId();

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