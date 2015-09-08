<?php
sleep(1);
session_start();
if(!isset($_SESSION['sessionid'])|| $_SESSION['sessionid']!= session_id()){
  header("Location: deconnect.php");
}
require_once 'connect.php';

if(isset($_POST['contenu'])&&!empty($_POST['contenu'])){
    
    // récupération de contenu en toute sécurité
    $contenu = htmlentities(strip_tags($_POST['contenu']),ENT_QUOTES);
    
    // variable locale où on récupère l'id de l'utilisateur
    $id_util = $_SESSION['id'];
    
    
    // requête préparée qui insert le commentaire dans le db
    $sql = $connection->prepare("INSERT INTO lepost (lemess,utilisateur_id) VALUES (?,?);");
    
    $sql->execute(array($contenu,$id_util));
    // exécution de la requête
    // mysqli_query($mysqli,$sql) or die('blabla');
}



