<?php

require_once('connect.php'); 
class reponse_Class{
    
    
    private $table_name1 = 'Reponse';
    //private $contenuRep = null, $idAst = null, $etat = null,$idR='B1';
    private $idR,$contenuRep,$idAst;

    function createBorne($idR,$contenuRep,$idAst){
        
        $sql = "INSERT INTO reponse (idR,contenuRep, idAst) VALUES ('$idR','$contenuRep', '$idAst','$id_borne','$idDem')";
      
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



    function getBornes(){             
        $sql ="SELECT * FROM reponse ORDER BY idR DESC";
        return pg_query($sql);
    } 


    function getBorneById($idR){    
  
        $sql ="SELECT * FROM reponse WHERE idR='".$this->cleanData($idR)."'"; 
        return pg_query($sql);
        
    } 
    function getBorneLastId(){    
  
      
        //$sql ="SELECT * FROM reponse LIMIT 1 ORDER BY idR DESC"; 
        $sql = "SELECT idR FROM reponse ORDER BY idR ASC";
        $bornes = pg_query($sql); 
        while($reponse = pg_fetch_object($bornes)):
            $lastid = $reponse->idR;
        endwhile;
        return $lastid;
        
    } 

    function getCleanedId($idR)
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

    
    function deleteborne($idR){    
  
         $sql ="DELETE FROM reponse  WHERE idR='$idR'"; 
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
    function updateBorne($idR,$contenuRep,$idAst){      
        
        $sql = "UPDATE reponse SET contenuRep= '$contenuRep',idAst= '$idAst'  WHERE idR = '$idR' " ;
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

//$bornes = $obj->getBorneLastId();

//echo $bornes;

//var_dump($bornes);
$a = $obj->updateBorne('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($reponse = pg_fetch_object($bornes)):
    echo $reponse->contenuRep . '<br>';
    echo $reponse->idAst . '<br>';
    echo $reponse->id_borne . '<br>';
    endwhile;  
*/
?>