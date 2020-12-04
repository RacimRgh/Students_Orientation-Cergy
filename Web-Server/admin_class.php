<?php

require_once('connect.php'); 
class administrateur_Class{
    
    
    private $table_name1 = 'Administrateur';
    //private $roleAdm = null, $nomAdm = null, $telAdm = null,$idAdm='B1';
    private $idAd,$roleAd,$nomAd,$prenomAd,$telAd;
 
    function createAdministrateur($idAd,$roleAd,$nomAd,$prenomAd,$telAd){
        
        $sql = "INSERT INTO administrateur (idAdm,roleAdm, nomAdm,prenomAdm,telAdm) VALUES ('$idAd','$roleAd', '$nomAd','$prenomAd','$telAd')";
      
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



    function getAdministrateurs(){             
        $sql ="SELECT * FROM Administrateur ORDER BY idAdm DESC";
        return pg_query($sql);
    } 


    function getAdministrateurById($idAd){    
  
        $sql ="SELECT * FROM Administrateur WHERE idAdm='".$this->cleanData($idAd)."'"; 
        return pg_query($sql);
        
    } 
    function getAdministrateurLastId(){    
  
      
        //$sql ="SELECT * FROM administrateur LIMIT 1 ORDER BY idAdm DESC"; 
        $sql = "SELECT idAdm FROM administrateur ORDER BY idAdm ASC";
        $administrateur = pg_query($sql); 
        while($administrateur = pg_fetch_object($administrateur)):
            $lastid = $administrateur->idAdm;
        endwhile;
        return $lastid;
        
    } 

    function getCleanedId($idAdm)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $idAdm[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($idAdm, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    
    function deleteadministrateur($idAd){    
  
         $sql ="DELETE FROM administrateur  WHERE idAdm='$idAd'"; 
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
    // fonction permettant la modification des administrateur
    function updateAdministrateur($idAd,$roleAd,$nomAd,$prenomAd,$telAd){       
        
        $sql = "UPDATE administrateur SET roleAdm= '$roleAd',nomAdm= '$nomAd',prenomAdm= '$prenomAd', telAdm= '$telAd' WHERE idAdm = '$idAd' " ;
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
$obj = new administrateur_Class;

//$administrateur = $obj->getAdministrateurLastId();

//echo $administrateur;

//var_dump($administrateur);
//$a = $obj->createAdministrateur('A1','Moderateur','Hassane','said','+3588976656');
//echo $a;

$administrateurs = $obj->getAdministrateurs();
var_dump($administrateurs);

while($administrateur = pg_fetch_object($administrateurs)):
    var_dump($administrateur);
    echo $administrateur->roleAdm . '<br>';
    echo $administrateur->nomAdm . '<br>';
    echo $administrateur->prenomAdm . '<br>';
    echo $administrateur->telAdm . '<br>';
endwhile; 
while($administrateur = pg_fetch_object($administrateur)):
    echo $administrateur->roleAdm . '<br>';
    echo $administrateur->nomAdm . '<br>';
    echo $administrateur->telAdm . '<br>';
    endwhile;  

*/
?>