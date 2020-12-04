<?php

require_once('connect.php'); 
Class assistant_Class{
    
    private $matri_et, $nom_et, $prenom_et, $mail_et,$tel_et,$univ_et, $spec_et ,$idAs,$statut_as,$date_Insc;
    //Fonction permettant la création d'un assistant 
    function createAssistant($matri_et, $nom_et, $prenom_et, $mail_et,$tel_et,$univ_et, $spec_et ,$idAs,$statut_as,$date_Insc){
        
        $sql = "INSERT INTO Assistant (matricule_etu, nom_etu, prenom_etu, email_etu, numtel_etu, univ_etu, specialite_etu, id_ast, statut_ast, date_inscription) VALUES ('$matri_et', '$nom_et','$prenom_et', '$mail_et', '$tel_et', '$univ_et', '$spec_et', '$idAs', '$statut_as', '$date_Insc') ";
      
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
    function getAssistants(){             
        $sql ="SELECT * FROM Assistant ORDER BY id_ast DESC";
        return pg_query($sql);
    } 

    //Fonction permettant de lister tous les assistants par matricule
    function getAssistantById($matricule_etu){    
  
        $sql ="SELECT * FROM Assistant WHERE id_ast='".$this->cleanData($matricule_etu)."'"; 
        return pg_query($sql);
        
    } 
    //Fonction permettant de recuperer le dernier matricule 
    function getAssistantLastId(){    
  
      
        //$sql ="SELECT * FROMassistant LIMIT 1 ORDER BY id_Assistant DESC"; 
        $sql = "SELECT id_ast FROM Assistant ORDER BY id_ast ASC";
        $Assistants = pg_query($sql); 
        while($Assistant = pg_fetch_object($Assistants)):
            $lastid = $Assistant->id_ast;
        endwhile;
        return $lastid;
        
    } 
    //Fonction permettant de transformer un matricule en un varchar
    function getCleanedId_assistant($id)
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
    function deleteassistant($matricule_etu){    
  
         $sql ="DELETE FROM Assistant  WHERE id_ast='$matricule_etu'"; 
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
    
    // fonction permettant la modification des assistants
    function updateAssistant($matricule_etu,$nom_et,$prenom_et,$email_et,$numtel_et,$univ_et,$specialite_et){       
        
        $sql = "UPDATE Assistant SET nom_etu= '$nom_et, prenom_etu = '$prenom_et',email_etu = '$email_et',numtel_etu = '$numtel_et', univ_etu= '$univ_et',specialite_etu= '$specialite_et' WHERE matricule_etu= '$matricule_etu' " ;
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
$obj = new assistant_Class;
 
$Assistants = $obj->createAssistant('E6532', 'Mounirou','Yassir', 'yassir@gmail.com', '+336465132', 'CY Cergy Paris', 'Mathematiques', 'A6532', 'Hors ligne', '2020-10-30');
echo $Assistants;

var_dump($Assistants);

$a = $obj->updateAssistant('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($Assistant = pg_fetch_object($Assistants)):
    echo $Assistant->longitude . '<br>';
    echo $Assistant->latitude . '<br>';
    echo $Assistant->etatb . '<br>';
    endwhile;  
*/
?>