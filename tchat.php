<?php
session_start();
if (!isset($_SESSION['sessionid']) || $_SESSION['sessionid'] != session_id()) {
    header("Location: deconnect.php");
}
require_once 'connect.php';
$status = ($_SESSION['login'] == 'michael') ? 'Formateur' : 'Stagiaire';
?>
<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="<?php echo PATH ?>/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo PATH ?>/css/tchat.css"/>
    <link href='http://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
    <head>
        <meta charset="UTF-8">
        <title>Bonjour <?php
            echo ucfirst($_SESSION['login']);
            ?>
        </title>
        <script src="<?php echo PATH ?>/ajax.js"></script>
    </head>
    <body onload="recup_texte(
                    'recup.php',
                    'lescontenus',
                    'chargement_contenu',
                    '<?php echo PATH ?>/img/loader.gif',
                    true
                    );">
        <div class="container">
            <header>
                <h1>Bienvenue sur CF2m Tchat </h1>
            </header>
            <div class="top-grille">
                <div class="col-md-5 connect-user">
                    <div class="user-grille">
                        <section class="gauche">
                            <div class="user-icon">
                                <img src="<?php echo PATH . $_SESSION['avatar'] ?>" alt="<?php echo $_SESSION['login'] ?>" title="<?php echo ucfirst($_SESSION['login']) ?>"/>
                                <h4><?php echo ucfirst($_SESSION['login']) ?></h4>
                                <p><?php echo $status; ?></p>
                            </div>
                            <div class="user-bas">
                                <ul>
                                    <li><a href="#">12<span>Membres</span></a></li>
                                    <li><a href="deconnect.php"><span>Déconnexion</span><br /></a></li>
                                    <div class="clear"></div>
                                </ul>
                            </div>
                        </section>
                    </div>
                </div>


                <div class="col-md-7 tchat-grille">
                    <div class="titre">
                       <h2>I-Class</h2>
                       <label class="filactere"></label>
                       <div class="bull-info">
                            <label class="bull-1"> </label>
                            <label class="bull-2"> </label>
                            <label class="bull-3"> </label>
                            <div class="clear"> </div>
		               </div>
			<div class="clear"> </div>
                    </div>

                    <div id="lescontenus" class="text">

                    </div>

                    <div id="chargement_contenu"></div>


                    <div class="formulaire">
                        <a href="#" class="msg"></a><textarea name="envoi" id="envoi"></textarea>
                        <button id="envoyer" onclick="sauve_texte('<?php echo PATH ?>/sauve.php',
                                        'envoi',
                                        'chargement',
                                        '<?php echo PATH ?>/img/loading.gif');
                                recup_texte(
                    'recup.php',
                    'lescontenus',
                    'chargement_contenu',
                    '<?php echo PATH ?>/img/loader.gif',
                    true
                    );
                                            ">Envoyer</button>
                        <div id="chargement"></div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <script>
            // on crée un interval qui va appeler la fonction verif_table toutes les 3000 millisecondes    
            setInterval(function () {
                verif_table('verif.php',
                        'recup.php',
                        'lescontenus',
                        'chargement_contenu',
                        '<?php echo PATH ?>/img/loader.gif',
                        false
                        );
            }, 3000);

        </script>
    </body>
</html>