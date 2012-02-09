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


function accueil() {
    $contenu = '<center><h2>Présentation</h2></center>
			<p>Bienvenue sur Virtual Trader, la plateforme de simulation boursière créée par <a href="http://www.mydevhouse.com" title="My Dev House">My Dev House</a> pour le challenge boursier organisé par <b>Sup\'Invest</b>.</p>

			<p>Tu vas pouvoir goûter aux joies et aux frayeurs de la Bourse mais sans le moindre risque sauf celui de repartir avec un super lot.</p>
<p>Pour te permettre de réaliser la meilleure plus-value et devenir le meilleur espoir Trader de l\'ESCEM, Sup\'Invest met à ta disposition 100.000&euro; fictifs.</p>
			
			<center><h2>Virtual-Trader c\'est :</h2></center>
			<p><ul>
					<li>- Un jeu à la fois palpitant et instructif</li>
					<li>- 100.000 &euro; virtuel à faire fructifier</li>
					<li>- Une mise à jour des valeurs et du classement en temps réel !</li>
					<li>- Et bien d\'autres choses à découvrir</li>
				</ul>
			</p>
                                                        <p>Toute l\'équipe de Sup\'Invest te remercie de ta participation et te souhaite une bonne chance.</p>
			<center><h2>Remerciements</h2></center>
			<p><center><img src="./templates/img/remerciement.jpg"></a>
			</center><br />
			<p>N\'hésite pas à <a href="index.php?page=contact" title="Nous contacter">contacter</a> l\'équipe de Sup\'Invest pour toute question dans le formulaire de contact (conseil, problème technique, questions?)</p>';
    display($contenu);
}

function formulaire_inscription() {
    $contenu = '<center><h2>Inscription</h2></center>
		<p>Afin de jouer à Virtual-Trader, merci de bien vouloir remplir ces différents champs.</p>
                    <form action="index.php?page=verification_inscription" method="post" class="cadre_bleu">
                        <div><input type="text" name="login" id="login" placeholder="Login"/><span class="error"></span></div>
                        <div><input type="password" name="mdp" id="pwd" placeholder="Mot de passe"/><span class="error"></span></div>
                        <div><input type="text" name="mail" id="mail" placeholder="Adresse e-mail"/><span class="error"></span></div>
                        <input type="checkbox"/><span>En cochant cette case j\'accepte les <a href="">CGU</a> et la politique de confidentialité.</span>
                        <input type="submit" value="Envoyer" id="submitInscription"/>
                    </form>';
    display($contenu);
}

function verification_inscription() {
    connect();
    $resultat = inscription($_POST['login'], $_POST['mdp'], $_POST['mail']);
    if ($resultat == 0) {
        $contenu = "Merci de bien vouloir compléter tous les champs.";
    } elseif ($resultat == 1) {
        $contenu = "Login ou Adresse-email déjà utilisé.";
    } else {
        $contenu = "Inscription réalisé avec succès. Vous pouvez dès maintenant vous connecter.";
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
                <p>Votre compte n'a pas encore été validé par les administrateurs.</p>";
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
            <p>Un problème ? Une question ? N\'hésitez pas à nous contacter.</p>

            <form action="index.php?page=verification_contact" method="post">
                <select name="probleme">
                    <option value="1">Problème technique</option>
                    <option value="2">Le jeu</option>
                </select>
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
    $contenu = 'Message envoyé avec succès. Nous vous répondrons dans les plus bref délais.';
    display($contenu);
}

function deconnexion() {
    verification();
    session_destroy();
    $contenu = 'Vous vous étes bien déconnecté.';
    display($contenu);
}

?>