<?php

require_once('connect.php'); 
class borne_Class{
    
    
    private $table_name1 = 'Borne';
    //private $longitude = null, $latitude = null, $etat = null,$id='B1';
    private $longitude , $latitude , $etat ,$id;

    function createBorne($id,$longitude,$latitude,$etat){
        
        $sql = "INSERT INTO borne (id_borne,longitude, latitude,etatB) VALUES ('$id','$longitude', '$latitude','$etat')";
      
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
        $sql ="SELECT * FROM borne ORDER BY id_borne DESC";
        return pg_query($sql);
    } 


    function getBorneById($id){    
  
        $sql ="SELECT * FROM borne WHERE id_borne='".$this->cleanData($id)."'"; 
        return pg_query($sql);
        
    } 
    function getBorneLastId(){    
  
      
        //$sql ="SELECT * FROM borne LIMIT 1 ORDER BY id_borne DESC"; 
        $sql = "SELECT id_borne FROM borne ORDER BY id_borne ASC";
        $bornes = pg_query($sql); 
        while($borne = pg_fetch_object($bornes)):
            $lastid = $borne->id_borne;
        endwhile;
        return $lastid;
        
    } 

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

    
    function deleteborne($id){    
  
         $sql ="DELETE FROM borne  WHERE id_borne='$id'"; 
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
    function updateBorne($id,$longitude,$latitude,$etat){       
        
        $sql = "UPDATE borne SET longitude= '$longitude',latitude= '$latitude', etatb= '$etat' WHERE id_borne = '$id' " ;
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

while($borne = pg_fetch_object($bornes)):
    echo $borne->longitude . '<br>';
    echo $borne->latitude . '<br>';
    echo $borne->etatb . '<br>';
    endwhile;  
*/
?>