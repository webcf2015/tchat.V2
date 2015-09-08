/*
 * Création de l'objet XHR qui sert à la communication entre javascript et les autres langages :
 * côté utilisateur : javascript, HTML, CSS
 * Côté communication entre le serveur et le navigateur : texte (donc txt, xml, json)
 * côté serveur : PHP/MySQL
 */
function cree_xhr(){
            var sortie_xhr;
            if(window.XMLHttpRequest){
                sortie_xhr = new XMLHttpRequest();
                if(sortie_xhr.overrideMimeType){
                    sortie_xhr.overrideMimeType('text/xml');
                }
            }else{
                if(window.ActiveXObjet){
                    try{
                        sortie_xhr= new ActiveXObject("Msxml2.XMLHTTP");
                    }catch(e){
                        try{
                            sortie_xhr= new ActiveXObject("Microsoft.XMLHTTP");
                        }catch(e){
                            sortie_xhr=null;
                        }
                    }
                }
            }
            return sortie_xhr;
        };

/*
 * 
 * Fonction qui crée l'objet XHR et récupère les donnés depuis la bdd
 * Les paramètres sont url (de la page de récupération), monid (id du textarea où l'on souhaite afficher les donnée), id_donnees (id de l'article dans la db)
 * cette fonction appelle traite_donnees(objet XHR, (id du textarea où l'on souhaite afficher les donnée))
 * 
 *
 */
function recup_texte(lurl, id_lescontenus, id_chargement,url_img_chargement,en_bas) {

    var requete = cree_xhr();

    if (requete === null) {
        alert("Votre navigateur ne supporte pas AJAX!");
    } else {

        requete.open('POST', lurl, true) ;
        // on déclare les entêtes pour l'utilisation de la méthode POST
        requete.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        // si la fonction est appelée, on affiche le loding
        document.getElementById(id_chargement).innerHTML = 
                "<img src='"+url_img_chargement+"' alt='loading' />";
        
        requete.onreadystatechange = function(){
            if (requete.readyState===4 && requete.status === 200) {
                // on vide le div du loading
                document.getElementById(id_chargement).innerHTML ="";
                // on charge le contenu dans le div de contenu
                document.getElementById(id_lescontenus).innerHTML = requete.responseText;
                // si en_bas vaut vrai (chargement de la page)
                if(en_bas){
                    // mise de la scrollbar vers le bas
                     mettre_curseur_en_bas(id_lescontenus);
                }
            }
        };

        requete.send("?a=b");
    }
    return;
}

/*
 * Fonction qui va modifier le contenu de la db lorsqu'on l'appel
 * appel:
 * sauve_texte(url du fichier qui sauvegarde, id de l'élément dont on récupère le contenu, id du div affichant le loading, url de l'image de loading)
 */
function sauve_texte(lurl,idcontenu,idchargement,url_img_loading){
    var requete = cree_xhr();

    if (requete === null) {
        alert("Votre navigateur ne supporte pas AJAX!");
    } else {
        // variable qui récupère le contenu de l'élément à enregistrer:
        var contenu = document.getElementById(idcontenu).value;
        
        // on va utiliser la méthode POST (idéale pour des textes plus longs avec respect de la mise en forme)
        requete.open('POST', lurl, true) ;
        
        // on déclare les entêtes pour l'utilisation de la méthode POST
        requete.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        
        // on charge l'image de loading dans le div correspondant
        document.getElementById(idchargement).innerHTML = 
                "<img src='"+url_img_loading+"' alt='loading' />";
        
        // lors de changement de statut
        requete.onreadystatechange = function(){
            
            // si l'envoi a fonctionné
            if (requete.readyState===4 && requete.status === 200) {
                
               // appel de notre fonction madate() 
               document.getElementById(idchargement).innerHTML = "Sauvegarde effectuée à "+madate();
               // on va vider le textarea nommé "envoi" (idcontenu dans le javascript)
               document.getElementById(idcontenu).value="";
               // on va lui redonner le focus
               document.getElementById(idcontenu).focus();
            }
        };
        // envoi du contenu en POST
        requete.send("contenu="+contenu);
    }
    return;
}

/*
 * 
 * function qui va vérifier si il y a des changements dans la table lepost. Elle sera appelée toute les 3 secondes par un timer javascript se trouvant dans tchat.php
 * 
 */
function verif_table(lurl,url_recup,id_lescontenus, id_chargement,url_img_chargement,en_bas){
   var requete = cree_xhr();
   if (requete === null) {
       alert("Votre navigateur ne supporte pas AJAX!");
   } else { 
       requete.open('GET', lurl, true) ;
       requete.onreadystatechange = function(){
            
            // si l'envoi a fonctionné
            if (requete.readyState===4 && requete.status === 200) {
                if(requete.responseText==='change'){
                    // appel de la fonction de récupération du texte
                    recup_texte(url_recup, id_lescontenus, id_chargement,url_img_chargement,en_bas);
                }
            }
       };
       requete.send(null);
   }
   return;
}


    
/*
 * Fonction qui nous donne la date au format fr => 21:15:31 le vendredi 7 novembre 2014
 * 
 * 
 */
function madate(){
    var sortie = '';
    var jour = new Array('dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi');
    var mois = new Array('janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
    var ladate = new Date();
    // on appel la fonction metZero(numérique) pour avoir toujours le même format de dates: (3:5:17 => 03:05:17)
    sortie += metZero(ladate.getHours())+':'+metZero(ladate.getMinutes())+':'+metZero(ladate.getSeconds());
    sortie += " le "+ jour[ladate.getDay()];
    sortie += " "+ ladate.getDate()+" "+mois[ladate.getMonth()]+" "+ladate.getFullYear();
    return sortie;
}
/*
 * Rajoute 0 aux nombres plus petit que 10
 * 
 */
function metZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

/*
 * 
 * Mettre le curseur en bas
 * 
 */
function mettre_curseur_en_bas(maDiv){
    document.getElementById(maDiv).scrollTop = 900000;
}