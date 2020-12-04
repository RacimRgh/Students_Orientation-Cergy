<?php

require_once('connect.php'); 
class message_Class{
    
    
    private $table_name1 = 'Message';
    //private $longitude = null, $latitude = null, $etat = null,$id='B1';
    private $datemes , $heureMes , $admAjout ,$id;

    function createMessage($id,$datemes,$heureMes,$admAjout){
        
        $sql = "INSERT INTO Message (idMessage,dateMess, heureMess,admAjout) VALUES ('$id','$datemes', '$heureMes','$admAjout')";
      
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



    function getMessages(){             
        $sql ="SELECT * FROM Message ORDER BY idMessage DESC";
        return pg_query($sql);
    } 


    function getMessageById($id){    
  
        $sql ="SELECT * FROM Message WHERE idMessage='".$this->cleanData($id)."'"; 
        return pg_query($sql);
        
    } 
    function getMessageLastId(){    
  
      
        //$sql ="SELECT * FROM Message LIMIT 1 ORDER BY id_Message DESC"; 
        $sql = "SELECT idMessage FROM Message ORDER BY idMessage ASC";
        $Messages = pg_query($sql); 
        while($Message = pg_fetch_object($Messages)):
            $lastid = $Message->id_Message;
        endwhile;
        return $lastid;
        
    } 

    function getMessageCleanedId($id)
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

    
    function deleteMessage($id){    
  
         $sql ="DELETE FROM Message  WHERE idMessage='$id'"; 
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
    // fonction permettant la modification des Messages
    function updateMessage($id,$datemes,$heureMes,$admAjout){       
        
        $sql = "UPDATE Message SET dateMess= '$datemes',heureMess= '$heureMes', admAjout= '$admAjout' WHERE idMessage = '$id' " ;
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
$obj = new Message_Class;

//$Messages = $obj->getMessageLastId();

//echo $Messages;

//var_dump($Messages);
$a = $obj->updateMessage('B9',0.777,1.888,'Fonctionnelle');
echo $a;

while($Message = pg_fetch_object($Messages)):
    echo $Message->longitude . '<br>';
    echo $Message->latitude . '<br>';
    echo $Message->etatb . '<br>';
    endwhile;  
*/
?>