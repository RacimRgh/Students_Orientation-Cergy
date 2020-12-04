<?php

require_once('connect.php'); 
Class etudiant_Class{
    
    
   
    
    private $matricule_et , $nom_et , $prenom_et ,$email_et,$numtel_et, $univ_et ,$specialite_et;
    //Fonction permettant la création d'un etudiant
    function createEtudiant($matricule_et,$nom_et, $prenom_et,$email_et,$numtel_et, $univ_et ,$specialite_et){
        
        $sql = "INSERT INTO Etudiant (matricule_etu , nom_etu , prenom_etu ,email_etu ,numtel_etu, univ_etu ,specialite_etu) VALUES ('$matricule_et', '$nom_et', '$prenom_et', '$email_et', '$numtel_et', '$univ_et', '$specialite_et')";
      
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


    //Fonction permettant de lister tous les étudiants
    function getEtudiants(){             
        $sql ="SELECT * FROM Etudiant ORDER BY matricule_etu DESC";
        return pg_query($sql);
    } 

    //Fonction permettant de lister tous les etudiants par matricule
    function getEtudiantById($matricule_et){    
  
        $sql ="SELECT * FROM Etudiant WHERE matricule_etu='".$this->cleanData($matricule_et)."'"; 
        return pg_query($sql);
        
    } 
    //Fonction permettant de recuperer le dernier matricule 
    function getEtudiantLastId(){    
  
      
        //$sql ="SELECT * FROMetudiant LIMIT 1 ORDER BY id_Etudiant DESC"; 
        $sql = "SELECT matricule_etu FROM Etudiant ORDER BY matricule_etu ASC";
        $Etudiants = pg_query($sql); 
        while($Etudiant = pg_fetch_object($Etudiants)):
            $lastid = $Etudiant->matricule_etu;
        endwhile;
        return $lastid;
        
    } 
    //Fonction permettant de transformer un matricule en un varchar
    function getCleanedId($id)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $id[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($id, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    //Fonction permettant de supprimer un étudiant
    function deleteetudiant($matricule_et){    
  
         $sql ="DELETE FROM Etudiant  WHERE matricule_etu='$matricule_et'"; 
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
    // fonction permettant la modification des etudiants
    function updateEtudiant($matricule_et,$nom_et,$prenom_et,$email_et,$numtel_et,$univ_et,$specialite_et){       
        
        $sql = "UPDATE Etudiant SET nom_etu= '$nom_et, prenom_etu = '$prenom_et',email_etu = '$email_et',numtel_etu = '$numtel_et', univ_etu= '$univ_et',specialite_etu= '$specialite_et' WHERE matricule_etu= '$matricule_et' " ;
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
$obj = newetudiant_Class;

//$Etudiants = $obj->getEtudiantLastId();

//echo $Etudiants;

//var_dump($Etudiants);
$a = $obj->updateEtudiant('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($Etudiant = pg_fetch_object($Etudiants)):
    echo $Etudiant->longitude . '<br>';
    echo $Etudiant->latitude . '<br>';
    echo $Etudiant->etatb . '<br>';
    endwhile;  
*/
?>