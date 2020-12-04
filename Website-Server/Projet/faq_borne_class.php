<?php

require_once('connect.php'); 
class faq_Class{
    
    
    private $table_name1 = 'FAQ';
    //private $id_borne = null, $idFAQ = null, $contenuFAQ = null,$idFAQ_B='B1';
    private $idFAQ_B,$id_borne,$idFAQ;

    function createFaq_borne($idFAQ_B,$id_borne,$idFAQ){
        
        $sql = "INSERT INTO faq_borne (idFAQ_B,id_borne, idFAQ) VALUES ('$idFAQ_B','$id_borne', '$idFAQ')";
      
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



    function getFaq_bornes(){             
        $sql ="SELECT * FROM faq_borne ORDER BY idFAQ_B DESC";
        return pg_query($sql);
    } 


    function getFaq_borneById($idFAQ_B){    
  
        $sql ="SELECT * FROM faq_borne WHERE idFAQ_B='".$this->cleanData($idFAQ_B)."'"; 
        return pg_query($sql);
        
    } 
    function getFaq_borneLastId(){    
  
      
        //$sql ="SELECT * FROM faq_borne LIMIT 1 ORDER BY idFAQ_B DESC"; 
        $sql = "SELECT idFAQ_B FROM faq_borne ORDER BY idFAQ_B ASC";
        $faqs = pg_query($sql); 
        while($faq_borne = pg_fetch_object($faqs)):
            $lastid = $faq_borne->idFAQ_B;
        endwhile;
        return $lastid;
        
    } 

    function getCleanedId($idFAQ_B)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $idFAQ_B[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($idFAQ_B, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    
    function deletefaq($idFAQ_B){    
  
         $sql ="DELETE FROM faq_borne  WHERE idFAQ_B='$idFAQ_B'"; 
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
    // fonction permettant la modification des faqs
    function updateFaq_borne($idFAQ_B,$id_borne,$idFAQ){       
        
        $sql = "UPDATE faq_borne SET id_borne= '$id_borne',idFAQ= '$idFAQ' WHERE idFAQ_B = '$idFAQ_B' " ;
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
$obj = new faq_Class;

//$faqs = $obj->getFaq_borneLastId();

//echo $faqs;

//var_dump($faqs);
$a = $obj->updateFaq_borne('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($faq_borne = pg_fetch_object($faqs)):
    echo $faq_borne->id_borne . '<br>';
    echo $faq_borne->idFAQ . '<br>';
    echo $faq_borne->etatb . '<br>';
    endwhile;  
*/
?>