<?php

require_once('connect.php'); 
class maintenance_Class{
    
    
    private $table_name1 = 'Maintenance';
    //private $idAdm = null, $id_borne = null, $etat = null,$idMain='B1';
    private $idMain,$idAdm,$id_borne,$date_maintenance,$heure_maintenance;

    function createMaintenancee($idMain,$idAdm,$id_borne,$date_maintenance,$heure_maintenance){
        
        $sql = "INSERT INTO maintenance (idMain,idAdm, id_borne,date_maintenance,heure_maintenance) VALUES ('$idMain','$idAdm', '$id_borne','$date_maintenance','$heure_maintenance')";
      
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



    function getMaintenancees(){             
        $sql ="SELECT * FROM maintenance ORDER BY idMain DESC";
        return pg_query($sql);
    } 


    function getMaintenanceeById($idMain){    
  
        $sql ="SELECT * FROM maintenance WHERE idMain='".$this->cleanData($idMain)."'"; 
        return pg_query($sql);
        
    } 
    function getMaintenanceeLastId(){    
  
      
        //$sql ="SELECT * FROM maintenance LIMIT 1 ORDER BY idMain DESC"; 
        $sql = "SELECT idMain FROM maintenance ORDER BY idMain ASC";
        $bornes = pg_query($sql); 
        while($maintenance = pg_fetch_object($bornes)):
            $lastid = $maintenance->idMain;
        endwhile;
        return $lastid;
        
    } 

    function getCleanedId($idMain)
    {
        // 0-recuperer la partie alphabetique de la chaine 
        $partie_alphabetique = $idMain[0];
        // 1-recuperer la partie entiere de la chaine 
        $int_brut = (int) substr($idMain, 1);     // bcdef;
        // 2-incrémenter de 1 la partie entiere récupérée
        $int_incremente = (int) $int_brut + 1;
        // 3-recomposer la chaine néttoyée
        $chaine_recompose = $partie_alphabetique.''.$int_incremente;
        // 4-renvoyer le cleaned Id
        return $chaine_recompose;
    }

    
    function deleteborne($idMain){    
  
         $sql ="DELETE FROM maintenance  WHERE idMain='$idMain'"; 
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
    function updateMaintenancee($idMain,$idAdm,$id_borne,$etat){      
        
        $sql = "UPDATE maintenance SET idAdm= '$idAdm',id_borne= '$id_borne', date_maintenance= '$date_maintenance', heure_maintenance= '$heure_maintenance'  WHERE idMain = '$idMain' " ;
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

//$bornes = $obj->getMaintenanceeLastId();

//echo $bornes;

//var_dump($bornes);
$a = $obj->updateMaintenancee('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($maintenance = pg_fetch_object($bornes)):
    echo $maintenance->idAdm . '<br>';
    echo $maintenance->id_borne . '<br>';
    echo $maintenance->date_maintenance . '<br>';
    endwhile;  
*/
?>