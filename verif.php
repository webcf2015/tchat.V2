<?php
session_start();
if(!isset($_SESSION['sessionid'])|| $_SESSION['sessionid']!= session_id()){
  header("Location: deconnect.php");
}
require_once 'config.php';
require_once 'connect.php';

// on va vérifier le nombre de lignes dans la db
$sql = "SELECT COUNT(*) AS nombre FROM lepost;";
$req = $connection->query($sql);
$fetch = $req->fetch(PDO::FETCH_ASSOC);
$nombre = $fetch['nombre'];

// si la variable de session qui contient le nombre de lignes dans la db n'existe pas
if(!isset($_SESSION['nb_dans_db'])){
    // on crée la variable
    $_SESSION['nb_dans_db']= $nombre;
    echo '1';
}else{
    // on vérifie si le nombre venant de la db est différent de celui dans la session
    if($_SESSION['nb_dans_db']!=$nombre){
        // on remet la session à jour
        $_SESSION['nb_dans_db']=$nombre;
        // en envoi la réponse au javascript pour qu'il recharge la page grâce à recup_texte
        echo "change";
    }else{
        echo '1';
    }
}