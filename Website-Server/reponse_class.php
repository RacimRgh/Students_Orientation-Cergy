<?php
  session_start();
require_once('connect.php'); 
class reponse_Class{
    
    
    private $idM,$dateM,$heureM,$AdmA,$IdRu,$contenq,$idqu,$idA;

    function createReponse($idM,$dateM,$heureM,$AdmA,$IdRu,$contenq,$idqu,$idA){
        
        $sql = "INSERT INTO Reponse (idMessage, dateMess, heureMess, admAjout, idR, contenuRep, idq, idAst) VALUES ('$idM', '$dateM', '$heureM', '$AdmA','$IdRu','$contenq', '$idqu', '$idA')";
        
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



    function getReponses(){             
        $sql ="SELECT * FROM reponse ORDER BY IdR DESC";
        return pg_query($sql);
    } 
    function getAllMessages(){             
        $sql ="SELECT R.dateMess as Dateq, R.categorie as cate, R.contenuQ as messages, D.nom_etu as nom, D.prenom_etu as prenom, D.univ_etu as univ, D.specialite_etu as spe FROM Reponse as R, Demandeur as D WHERE  D.id_dem = R.idDem";
        return pg_query($sql);
    } 


    function getReponseById($IdRu){    
  
        $sql ="SELECT * FROM reponse WHERE IdR='".$this->cleanData($IdRu)."'"; 
        return pg_query($sql);
        
        
    } 
    function getReponseLastId(){    
  
      
        //$sql ="SELECT * FROM reponse LIMIT 1 ORDER BY idQ DESC"; 
        $sql = "SELECT idQ FROM reponse ORDER BY idQ ASC";
        $bornes = pg_query($sql); 
        while($reponse = pg_fetch_object($bornes)):
            $lastid = $reponse->idQ;
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

    
    function deletereponse($IdRu){    
  
         $sql ="DELETE FROM reponse  WHERE IdR='$IdRu'"; 
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
    function updateReponse($idM,$dateM,$heureM,$AdmA,$IdRu,$titrq,$categorie,$contenq,$idB,$idD){      
        
        $sql = "UPDATE reponse SET idMessage ='$dateM' , dateMess = '$heureM', heureMess='', admAjout,titreQ, categorie, contenuQ, id_borne, idDem WHERE IdR = '$IdRu' " ;
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

$obj = new reponse_Class;

$reponses = $obj->getReponseLastId();

var_dump($reponses);
/*
while($reponse = pg_fetch_object($reponses)):
    echo     $reponse->dateq  . '<br>';
    echo     $reponse->nom . '<br>';
    echo     $reponse->prenom . '<br>';
    echo     $reponse->messages . '<br>';
    echo     $reponse->spe . '<br>';
    echo     $reponse->univ ;
endwhile;

//echo $bornes;

//var_dump($bornes);
$a = $obj->updateReponse('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($reponse = pg_fetch_object($bornes)):
    echo $reponse->titreQ . '<br>';
    echo $reponse->contenuQ . '<br>';
    echo $reponse->id_borne . '<br>';
    endwhile;  
*/
?>