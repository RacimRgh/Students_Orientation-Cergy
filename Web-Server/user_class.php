<?php 

Class User_Class
{

    private $table_name = 'user';
    function createUser(){
        $sql = "INSERT INTO PUBLIC.".$this->table_name."(name,email,mobile_no,address) "."VALUES('".$this->cleanData($_POST['name'])."','".$this->cleanData($_POST['email'])."','".$this->cleanData($_POST['mobileno'])."','".$this->cleanData($_POST['address'])."')";
        return pg_affected_rows(pg_query($sql));
    }
    function getUsers(){             
        $sql ="select *from public." . $this->table_name . " ORDER BY id DESC";
        return pg_query($sql);
    } 
    function getUserById(){    
  
        $sql ="select *from public." . $this->table_name . "  where id='".$this->cleanData($_POST['id'])."'";
        return pg_query($sql);
    } 

   
    function deleteuser(){    
  
         $sql ="delete from public." . $this->table_name . "  where id='".$this->cleanData($_POST['id'])."'";
        return pg_query($sql);
    } 
    function updateUser($data=array()){       
     
        $sql = "update public.user set name='".$this->cleanData($_POST['name'])."',email='".$this->cleanData($_POST['email'])."', mobile_no='".$this->cleanData($_POST['mobileno'])."',address='".$this->cleanData($_POST['address'])."' where id = '".$this->cleanData($_POST['id'])."' ";
        return pg_affected_rows(pg_query($sql));        
    }
    // fonction permettant Protection des données au format PostgreSQL  pour les insérer dans la base de données.
    function cleanData($val){
        return pg_escape_string($val);
   }
}
