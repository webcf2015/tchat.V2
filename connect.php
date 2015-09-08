<?php
// pour les erreurs
ini_set('display_errors', '1');
require_once 'config.php';
/*
$mysqli=  mysqli_connect(DBHOST, DBLOGIN, DBMDP, DBNAME) or die("erreur: ".mysqli_connect_error($mysqli));
mysqli_set_charset($mysqli, "utf8"); 
 * 
 */
// connexion PDO (non permanente par défaut)
try{

$connection = @new PDO(
        'mysql:host='.DBHOST.';dbname='.DBNAME.';charset=UTF8',
        DBLOGIN,
        DBMDP);
        // ajout des erreurs automatiques
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  catch (PDOException $e){
    echo "Erreur : ".$e->getMessage()."<br/>";
    echo "Erreur numéro : ".$e->getCode();
    die();
}