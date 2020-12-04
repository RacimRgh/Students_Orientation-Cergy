<?php

$db_handle = pg_connect("host=localhost port=5432 dbname=dbborne user=postgres password=4588");


      /* 
if ($db_handle) {

    echo 'Connection attempt succeeded.';

} else {

   

    echo 'Connection attempt failed.';

}
echo "<h3>Connection Information</h3>";

    echo "DATABASE NAME:" . pg_dbname($db_handle) . "<br>";

    echo "HOSTNAME: " . pg_host($db_handle) . "<br>";

    echo "PORT: " . pg_port($db_handle) . "<br>";

    echo "<h3>Checking the query status</h3>";
 

$query = "SELECT longitude,latitude FROM Borne";

$result = pg_exec($db_handle, $query);
if ($result) {

    echo "The query executed successfully.<br>";
    
    echo "<h3>Print First and last name:</h3>";
    
    for ($row = 0; $row < pg_numrows($result); $row++) {
    
    $firstname = pg_result($result, $row, 'longitude');
    
    echo $firstname ." ";
    
    $lastname = pg_result($result, $row, 'latitude');
    
    echo $lastname ."<br>";
    
    }


} else {

    echo "The query failed with the following error:<br>";
    
    echo pg_errormessage($db_handle);
    
    }
    
    pg_close($db_handle);
        
    
$host = "localhost";
$port = "5432";
$dbname = "dbborne";
$user = "lyse";
$password = "juuju"; 
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string) or die('not able to connect:' . pg_last_error());     

Déclaration des variables statics
 $host = '127.0.0.1';
 $dbname = 'dbborne';
 $username = 'lyse';
 $password = 'juju';
 //
 $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;user=$username;password=$password";
try{
    // Connexion à la bdd
    $db = new PDO($dsn);
    $db->exec('SET NAMES "UTF8"');

    if($db){
        echo "Connecté à $dbname avec succès!";
       
       }
    //simple check
    
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();


}*/
?>
