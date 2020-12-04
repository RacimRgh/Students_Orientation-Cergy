<?php

require_once('connect.php'); 
class reponse_Class{
    
    
    private $table_name1 = 'Reponse';
    //private $contenuRep = null, $idAst = null, $etat = null,$idR='B1';
    private $idM,$dateM,$heureM,$adAj,$idRe,$contenuR,$idqu,$idAs;

    function createReponse($idM,$dateM,$heureM,$adAj,$idRe,$contenuR,$idqu,$idAs){
        
        $sql = "INSERT INTO Reponse (idMessage, dateMess, heureMess, admAjout,idR, contenuRep, idq, idAst) VALUES ('$idM', '$dateM', '$heureM', '$adAj','$idRe' ,'$contenuR','$idqu','$idAs')  ";
      
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
        $sql ="SELECT * FROM reponse ORDER BY idR DESC";
        return pg_query($sql);
    } 


    function getReponseById($idRe){    
  
        $sql ="SELECT * FROM reponse WHERE idR='".$this->cleanData($idRe)."'"; 
        return pg_query($sql);
        
    } 
    function getReponseSMS(){             
        $sql ="SELECT Q.dateMess as Dateq, Q.categorie as cate, Q.contenuQ as messages, D.nom_etu as nom, D.prenom_etu as prenom, D.univ_etu as univ, D.specialite_etu as spe FROM Reponse as R, Assistant as A WHERE  A.id_ast = R.idA";
        return pg_query($sql);
    } 
    function getReponseLastId(){    
  
      
        //$sql ="SELECT * FROM reponse LIMIT 1 ORDER BY idR DESC"; 
        $sql = "SELECT idR FROM reponse ORDER BY idR ASC";
        $reponses = pg_query($sql); 
        while($reponse = pg_fetch_object($reponses)):
            $lastid = $reponse->idR;
        endwhile;
        return $lastid;
        
    } 

    function getReponseCleanedId($idR)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $idR[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($idR, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    
    function deletereponse($idRu){    
  
         $sql ="DELETE FROM reponse  WHERE idR='$idRu'"; 
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
   /* function updateBorne($idM,$dateM,$heureM,$adAj,$idRe,$contenuR,$idqu,$idAs){      
        
        $sql = "UPDATE reponse SET idMessage= '$idM', dateMess= '$dateM', heureMess= '$heureM', admAjout= '$adAj', contenuRep= '$contenuR', idq= '$idqu', idAst = '$idAs' WHERE idR = '$idRe' " ;
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
            
    }*/
    // fonction permettant Protection des données au format PostgreSQL  pour les insérer dans la base de données.
    function cleanData($val){
        return pg_escape_string($val);
    }
}

$obj = new reponse_Class;
$a = $obj->createReponse('M6', '2020-12-02', '14:18', 'A1','R2' ,'This is the way','Q3','A6531');
/*
//$bornes = $obj->getBorneLastId();

//echo $bornes;

//var_dump($bornes);

echo $a;

while($reponse = pg_fetch_object($bornes)):
    echo $reponse->contenuRep . '<br>';
    echo $reponse->idAst . '<br>';
    echo $reponse->id_borne . '<br>';
    endwhile;  
*/
?>