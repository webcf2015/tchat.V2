<?php

session_start();

if(!isset($_SESSION['sessionid'])|| $_SESSION['sessionid']!= session_id()){
  header("Location: deconnect.php");
}

require_once 'connect.php';

    
// requête qui insert le commentaire dans le db
$sql = "SELECT l.lemess, l.ladate, u.lelogin, u.avatar FROM lepost l
	INNER JOIN utilisateur u ON l.utilisateur_id = u.id
        ORDER BY l.ladate DESC
        LIMIT $nb_messages_tchat;";
    
// exécution de la requête
$req = $connection->query($sql);


// récupération de toutes les lignes dans un tableau indexé

$recup = $req->fetchAll(PDO::FETCH_NUM);

// on trie le contenu du tableau par les clefs par ordre descendant
krsort($recup);


// création de la variable de sortie de type text
$sortie = "";

/* tant que l'on a des éléments dans le tableau dont la "$value" sera également un tableau indexé avec comme valeurs: 
 * 0 => le texte
 * 1 => la date
 * 2 => le login
 * 3 => l'url de l'image
 */
foreach ($recup as $key => $value) {
    $sortie .= "<div id='txt$key' class='lepost'>";
    $sortie .= "<div class='message'><img class='icon-recup' src='".PATH.$value[3]."' title='".$value[2]."' alt='".$value[2]."' /></div>";
    $sortie .="<div class='msg-1'>";
    $sortie .= "<span class='login'>".ucfirst($value[2])."</span><br /><span class='ladate'>".$value[1]."</span>";
    $sortie .= "<p>".html_entity_decode($value[0])."</p>";
	$sortie .= "<i></i>";
    $sortie .= "</div>";
    $sortie .= "</div>";
	$sortie .="<div class='clear'></div>";
}
echo $sortie;


