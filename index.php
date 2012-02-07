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
function accueil() {
    $contenu = '<center><h2>Présentation</h2></center>
			<p>Virtual Trader est un jeu accessible à tous qui vous permet de goûter aux joies et aux frayeurs de la Bourse mais sans le moindre risque.</p>

			<blockquote><p>Achetez, Revendez, Gagnez ou Perdez, peu importe puisque vous ne jouez pas d\'argent réel . Vous démarrez avec un capital de 20.000 &euro; et vous devez réaliser le meilleur bénéfice. Vous figurez dans un classement sur le site de Virtual-Trader pour être confronté aux autres joueurs.</p></blockquote>
			
			<center><h2>Virtual-Trader c\'est :</h2></center>
			<p><ul>
					<li>Un jeu à la fois palpitant et instructif</li>
					<li>20.000 &euro; virtuel à faire fructifier</li>
					<li>Une mise à jour des valeurs et du classement en temps réel !</li>
					<li>Et bien d\'autres choses à découvrir</li>
				</ul>
			</p>
			<center><h2>Screenshot</h2></center>
			<p><center><a href="./templates/img/bourse.png"><img src="./templates/img/bourse.png" height="90" width="120"></a><a href="./templates/img/vos_actions.png"><img src="./templates/img/vos_actions.png" height="90" width="120"></a>
			</center><br />
			<p>Virtual Trader met à votre disposition une interface claire, simple et éfficace. Alors n\'attendez plus, et rejoignez nous !</p>';
    display($contenu);
}

function formulaire_inscription() {
    $contenu = '<center><h2>Inscription</h2></center>
		<p>Afin de jouer à Virtual-Trader, merci de bien vouloir remplir ces différents champs.</p>
			<form action="index.php?page=verification_inscription" method="post">
                        <div><input type="text" name="login" id="login" placeholder="Login"/><span class="error"></span></div>
<div><input type="password" name="mdp" id="pwd" placeholder="Mot de passe"/><span class="error"></span></div>
<div><input type="text" name="mail" id="mail" placeholder="Adresse e-mail"/><span class="error"></span></div>
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
    $contenu = '<center><h2>Contact</h2></center>
			Un problème ? Une question ? N\'hésitez pas à nous contacter.
			
			<table border="0">
			<form action="index.php?page=verification_contact" method="post">
			<tr>
				<td>Nom :</td><td><input type="text" name="nom"></td>
			</tr>
			<tr>
				<td>Prenom :</td><td><input type="text" name="prenom"></td>
			</tr>
			<tr>
				<td>E-mail :</td><td><input type="text" name="email"></td>
			</tr>
			<tr>
				<td>Sujet :</td><td><input type="text" name="sujet"></td>
			</tr>
			<tr>
				<td>Message :</td><td><textarea name="message"></textarea></td>
			</tr>
			<tr>
				<td></td><td><input type="submit" name="envoyer" value="Envoyer"></td>
			</tr>
			</form>
			</table>';
    display($contenu);
}

function verification_contact() {
    connect();
    $nom = mysql_real_escape_string($_POST['nom']);
    $prenom = mysql_real_escape_string($_POST['prenom']);
    $sujet = mysql_real_escape_string($_POST['sujet']);
    $message = mysql_real_escape_string($_POST['message']);
    $email = mysql_real_escape_string($_POST['email']);
    $destinataire = 'florian.janson@mydevhouse.com'; // Adresse e-mail du destinataire
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