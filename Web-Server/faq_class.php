<?php

require_once('connect.php'); 
class faq_Class{
    
    
    private $table_name1 = 'FAQ';
    //private $typeFAQ = null, $titreFAQ = null, $contenuFAQ = null,$idFAQ='B1';
    private $idFAQ,$typeFAQ,$titreFAQ,$contenuFAQ, $reponseFA;

    function createFaq($idFAQ,$typeFAQ,$titreFAQ,$contenuFAQ, $reponseFAQ){
        
        $sql = "INSERT INTO faq (idFAQ,typeFAQ, titreFAQ,contenuFAQ, reponseFAQ) VALUES ('$idFAQ','$typeFAQ', '$titreFAQ','$contenuFAQ','$reponseFAQ')";
      
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



    function getFaqs(){             
        $sql ="SELECT * FROM faq ORDER BY idFAQ DESC";
        return pg_query($sql);
    } 


    function getFaqById($idFAQ){    
  
        $sql ="SELECT * FROM faq WHERE idFAQ='".$this->cleanData($idFAQ)."'"; 
        return pg_query($sql);
        
    } 
    function getFaqLastId(){    
  
      
        //$sql ="SELECT * FROM faq LIMIT 1 ORDER BY idFAQ DESC"; 
        $sql = "SELECT idFAQ FROM faq ORDER BY idFAQ ASC";
        $faqs = pg_query($sql); 
        while($faq = pg_fetch_object($faqs)):
            $lastid = $faq->idFAQ;
        endwhile;
        return $lastid;
        
    } 

    function getCleanedId($idFAQ)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $idFAQ[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($idFAQ, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    
    function deletefaq($idFAQ){    
  
         $sql ="DELETE FROM faq  WHERE idFAQ='$idFAQ'"; 
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
    function updateFaq($idFAQ,$typeFAQ,$titreFAQ,$contenuFAQ, $reponseFAQ){       
        
        $sql = "UPDATE faq SET typeFAQ= '$typeFAQ',titreFAQ= '$titreFAQ', contenuFAQ= '$contenuFAQ', reponseFAQ= '$reponseFAQ' WHERE idFAQ = '$idFAQ' " ;
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

//$faqs = $obj->getFaqLastId();

//echo $faqs;

//var_dump($faqs);
$a = $obj->updateFaq('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($faq = pg_fetch_object($faqs)):
    echo $faq->typeFAQ . '<br>';
    echo $faq->titreFAQ . '<br>';
    echo $faq->etatb . '<br>';
    endwhile;  
*/
?>