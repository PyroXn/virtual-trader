<?php

session_start();
include('lib/fonctions.php');
include('lib/fonctions_messageries.php');
include('lib/fonctions_actions.php');
include('lib/autres_fonctions.php');
include_once('lib/fonctions_admin.php');

$page = @$_GET['page'];
if (($page == '') || ($page == 'accueil')) {
    accueil();
} elseif ($page == 'deconnexion') {
    deconnexion();
} elseif ($page == 'inscription') {
    formulaire_inscription();
} elseif ($page == 'verification_inscription') {
    verification_inscription();
} elseif ($page == 'verification_connexion') {
    verification_connexion();
} elseif ($page == 'contact') {
    formulaire_contact();
} elseif ($page == 'verification_contact') {
    verification_contact();
}
// Actions
elseif ($page == 'mes_actions') {
    mes_actions();
} elseif ($page == 'bourse') {
    bourse();
} elseif ($page == 'formulaire_achat') {
    formulaire_achat();
} elseif ($page == 'achat') {
    achat();
} elseif ($page == 'formulaire_vente') {
    formulaire_vente();
} elseif ($page == 'vente') {
    vente();
}
// Messagerie
elseif ($page == 'messagerie') {
    messagerie();
} elseif ($page == 'envoyer_message') {
    envoyer_message();
} elseif ($page == 'message_envoye') {
    message_envoye();
} elseif ($page == 'supprimer_message') {
    supprimer_message();
} elseif ($page == 'afficher_message') {
    afficher_message();
}
// Autres fonctions
elseif ($page == 'banque') {
    banque();
} elseif ($page == 'emprunt_banque') {
    emprunt_banque();
} elseif ($page == 'mon_compte') {
    mon_compte();
} elseif ($page == 'classement') {
    classement();
} elseif ($page == 'historique') {
    historique();
} elseif ($page == 'changement_password') {
    changement_password();
} elseif ($page == 'supprimer_compte') {
    supprimer_compte();
} elseif ($page == 'lost_password') {
    lostPassword();
} elseif ($page == 'cgu') {
    cgu();
} elseif ($page == 'associations') {
    classementAssoc();
}
// Admin
elseif ($page == 'accueilAdmin') {
    accueilAdmin();
} elseif ($page == 'validerCpt') {
    validerCpt();
}

// AJAX
elseif ($page == 'ajaxclassement') {
    AjaxgetTop10();
} elseif ($page == 'classementajax') {
    ajaxclassement();
}

//VARIABLES
$_SESSION['classement'] = 5; // Nombre par page
$_SESSION['timeBetweenUpdate'] = 180; // seconde entre update


function accueil() {
    $contenu = '
        <center><img src="./templates/img/escem.png"/></center>
        <center><h2>Pr�sentation</h2></center>
			<p>Bienvenue sur Virtual Trader, la plateforme de simulation boursi�re cr��e par <a href="http://www.mydevhouse.com" title="My Dev House">My Dev House</a> pour le challenge boursier organis� par <b>Sup\'Invest</b>.</p>

			<p>Tu vas pouvoir go�ter aux joies et aux frayeurs de la Bourse mais sans le moindre risque sauf celui de repartir avec un super lot.</p>
<p>Pour te permettre de r�aliser la meilleure plus-value et devenir le meilleur espoir Trader de l\'ESCEM, Sup\'Invest met � ta disposition 100.000&euro; fictifs.</p>
			
			<h2 class="centrer">Virtual-Trader c\'est :</h2>
                        <p>
                        <ul>
                            <li><p>- Un jeu � la fois palpitant et instructif</p></li>
                            <li><p>- 100.000 &euro; virtuel � faire fructifier</p></li>
                            <li><p>- Une mise � jour des valeurs et du classement en temps r�el !</p></li>
                            <li><p>- Et bien d\'autres choses � d�couvrir</p></li>
                        </ul>
			
                                                        <p>Toute l\'�quipe de Sup\'Invest te remercie de ta participation et te souhaite une bonne chance.</p>
			<h2 class="centrer">Remerciements</h2>
			<p><center><img src="./templates/img/remerciement.png"></a>
			</center><br />
			<p>N\'h�site pas � <a href="index.php?page=contact" title="Nous contacter">contacter</a> l\'�quipe de Sup\'Invest pour toute question dans le formulaire de contact (conseil, probl�me technique, questions?)</p>';
    display($contenu);
}

function formulaire_inscription() {
    $contenu = '<h2 class="centrer">Inscription</h2>
		<p>Afin de jouer � Virtual-Trader, merci de bien vouloir remplir ces diff�rents champs.</p>
                    <form action="index.php?page=verification_inscription" method="post" class="cadre_bleu centrer">
                        <div><input type="text" name="login" id="login" placeholder="Login"/><span class="error"></span></div>
                        <div><input type="password" name="mdp" id="pwd" placeholder="Mot de passe"/><span class="error"></span></div>
                        <div><input type="text" name="mail" id="mail" placeholder="Adresse e-mail"/><span class="error"></span></div>
                        <input name="cgu" type="checkbox"/><span>En cochant cette case j\'accepte les <a href="index.php?page=cgu">CGU</a> et la politique de confidentialit�.</span>
                        <input type="submit" value="Envoyer" id="submitInscription"/>
                    </form>';
    display($contenu);
}

function cgu() {
    $contenu = '<h1>Conditions G�n�rales d\'utilisation</h1>';
    $contenu .= '<ul id="cgu">
        <li><p>Virtual Trader est un jeu de simulation boursi�re, l\'argent que vous y gagnez ou perdez est totalement virtuel.</p></li>
<li><p>Virtual Trader est une propri�t� de My Dev House</p></li>
<li><p>La plateforme Virtual Trader est <font style="color: red; font-weight: bold;">exclusivement r�serv�e aux �tudiants de l\'ESCEM.</font></p></li>
<li><p>Vous ne pouvez ouvrir qu\'un compte par personne et par adresse de courrier �lectronique.</p></li>

<li><p>L\'�tudiant qui s\'inscrit doit obligatoirement utiliser son adresse ESCEM pour l\'inscription (ex�: ldupond@escem.com). <font style="color: red; font-weight: bold;">Si cette condition n\'est pas respect�e, le compte du joueur sera imm�diatement supprim�. </font></p></li>
<li><p>L\'�tudiant pourra en revanche utiliser le pseudonyme et le mot de passe qu\'il souhaite.</p></li>
<li><p>Les abus, s\'ils sont d�tect�s, seront sanctionn�s par un bannissement de l\'�tudiant du Challenge.</p></li>
<li><p>Le staff Sup\'Invest �tant � l\'enti�re disposition des �tudiants pour d\'�ventuelles questions, nous attendons la plus grande courtoisie de la part de ces derniers. En cas de litige, seule l\'�quipe Sup\'Invest sera habilit�e � trancher et sanctionner le ou les fautifs, pensez � les pr�venir lorsqu\'un concurrent d�rape plut�t que vous faire justice vous-m�me.</p></li>

<li><p>Toute tentative de piratage du serveur par l\'ordinateur d\'un membre sera <font style="color: red; font-weight: bold;">punie d\'une exclusion d�finitive du Challenge ainsi que de l\'�tablissement.</font></p></li>

<li><p>Le staff Sup\'Invest ne pourra �tre tenu pour responsable d\'une erreur (bug) dans le jeu ou d\'un probl�me technique vous ayant port� pr�judice.</p></li>

<li><p>Les lots ne sont pas cessibles. Les gagnants ne pourront exiger de recevoir la valeur des lots en esp�ces. L\'�quipe Sup\'Invest se r�serve le droit de choisir les lots � tout moment.</p></li>

<li><p>L\'�quipe Sup\'Invest se r�serve le droit de diffuser les informations concernant les participants aux partenaires figurants sur la plateforme Virtual Trader.</p></li>

<li><p>Conform�ment � la loi vous disposez d\'un droit d\'acc�s et de rectification de vos donn�es personnelles, pour cela contactez un membre de l\'�quipe Sup\'Invest.</p></li>

<li><p><font style="color: red; font-weight: bold;">En prenant part au concours, les participants acceptent les conditions de participation.</font></p></li>
</ul>
<p>Maintenant que nous sommes tous d\'accord, passons aux r�jouissances: bon courage � tous et que le(la) meilleur(e) gagne !</p>';
    display($contenu);
}
function verification_inscription() {
    connect();
    if(!isset($_POST['cgu'])) {
        $contenu = 'Vous devez accepter les <a href="index.php?page=cgu">conditions g�n�rales d\'utilisation</a>';
        display($contenu);
        exit();
    }
    $resultat = inscription($_POST['login'], $_POST['mdp'], $_POST['mail']);
    if ($resultat == 0) {
        $contenu = "Merci de bien vouloir compl�ter tous les champs.";
    } elseif ($resultat == 1) {
        $contenu = "Login ou Adresse-email d�j� utilis�.";
    } else {
        $contenu = "Inscription r�alis� avec succ�s. Vous pouvez d�s maintenant vous connecter.";
    }
    display($contenu);
}

function verification_connexion() {
    connect();
    $resultat = connexion($_POST['login'], $_POST['mdp']);
    if ($resultat == 0) {
        echo '<script language="Javascript">
				  document.location.replace("index.php?page=accueil");
				  </script>';
    } elseif ($resultat == 2) {
        $contenu = "<h2>Erreur !</h2>
                <p>Votre compte n'a pas encore �t� valid� par les administrateurs.</p>";
        display($contenu);
    } else {
        $contenu = "<h2>Erreur !</h2>
                <p>Login ou mot de passe incorrect.</p>";
        display($contenu);
    }
}

function formulaire_contact() {
    $contenu = '
        <div id="form_envoie">
            <h2>Contact</h2>
            <p>Un probl�me ? Une question ? N\'h�sitez pas � nous contacter.</p>
            <form action="index.php?page=verification_contact" method="post">
                <div class="radio">
                    <input type="radio" name="probleme" value="1" checked="checked">Probl�me technique</input>
                    <input type="radio" name="probleme" value="2">Le jeu</input>
                </div>
                <input type="text" name="nom" placeholder="Nom">
                <input type="text" name="prenom" placeholder="Prenom">
                <input type="text" name="email" placeholder="E-mail">
                <input type="text" name="sujet" placeholder="Sujet">
                <textarea name="message" placeholder="Message"></textarea>
                <input type="submit" name="envoyer" value="Envoyer">
            </form>
        </div>
			';
    display($contenu);
}

function verification_contact() {
    connect();
    $nom = mysql_real_escape_string($_POST['nom']);
    $prenom = mysql_real_escape_string($_POST['prenom']);
    $sujet = mysql_real_escape_string($_POST['sujet']);
    $message = mysql_real_escape_string($_POST['message']);
    $email = mysql_real_escape_string($_POST['email']);
    if($_POST['probleme'] == 1) {
        $destinataire = 'florian.janson@mydevhouse.com'; // Adresse e-mail du destinataire
    } else {
        $destinataire = 'supinvest.tours@gmail.com';
    }
    if (!preg_match("#@#", $email) || !preg_match("#[.]#", $email)) {
        $contenu = 'Adresse e-mail incorrect.';
        display($contenu);
        exit();
    } elseif ($nom == '' || $prenom == '' || $sujet == '' || $message == '') {
        $contenu = 'Merci de bien vouloir remplir tous les champs du formulaire.';
        display($contenu);
        exit();
    }
    // Mise en forme du mail
    $From = "From:" . $email . "\n";
    $From .= "MIME-version: 1.0\n";
    $From .= "Content-type: text/html; charset= iso-8859-1\n";
    $texte = "<b>Nom :</b>" . $nom . "<br /><b>Prenom :</b>" . $prenom . "<br />";
    $texte .= "<b>E-mail :</b>" . $email . "<br />";
    $texte .= "<b>Message :</b>" . $message . "";
    mail($destinataire, $sujet, $texte, $From);
    // Affichage du message de confirmation
    $contenu = 'Message envoy� avec succ�s. Nous vous r�pondrons dans les plus bref d�lais.';
    display($contenu);
}

function deconnexion() {
    verification();
    session_destroy();
    $contenu = 'Vous vous �tes bien d�connect�.';
    display($contenu);
}

?>