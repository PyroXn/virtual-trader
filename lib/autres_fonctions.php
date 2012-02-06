<?php

// Fichier regroupant les autres fonctions (banque, profil, classement)
function banque() {
    verification();
    connect();
    $infos_joueur = infos_joueur($_SESSION['nom']);
    if ($infos_joueur['Emprunt'] != 0) { // Si l'utilisateur a deja un emprunt, il ne peut pas en prendre un 2e
        $mensualite = $infos_joueur['Emprunt'] / 10;
        $contenu = '<center><h2>La banque</h2></center>';
        $contenu .= '<p>Vous avez déjà un emprunt en cour. Vous devez encore rembourser ' . $infos_joueur['Emprunt'] . '€. ';
        $contenu .= 'Un prélèvement automatique de ' . $mensualite . ' € sera éffectué toutes les semaines.</p>';
        display($contenu);
        exit();
    }
    $contenu = '<center><h2>La banque</h2></center>';
    $contenu .= '<p>Bienvenue dans la Banque. Vous pouvez faire un emprunt qui sera équivalent à 30% de votre <b>argent potentiel</b> (argent + valeur des actions).
			Les emprunts sont soumis à un taux d\'intéret.</p>
			<p>Le remboursement de l\'emprunt à lieu sur une période de 10 semaines. Chaques semaines, 1/10 de votre emprunt sera prélevé sur votre argent. Un seul emprunt peut être éffectué à la fois.</p>
			<p>Merci de bien vouloir saisir la somme que vous souhaitez emprunter.</p>
			<table border="0">
			<form action="index.php?page=emprunt_banque" method="post">
			<tr>
				<td>Montant :</td><td><input type="text" name="montant" size="5" maxlength="5"></td>
			</tr>
			<tr>
				<td>Taux :</td><td><b>3,50%</b></td>
			</tr>
			<tr>
				<td><input type="submit" name="envoyer" value="Envoyer"></td><td><input type="reset" value="Reset"></td>
			</tr>
			</form>
			</table>
			</p>';
    display($contenu);
}

function emprunt_banque() {
    verification();
    connect();
    $montant_emprunt = $_POST['montant'];
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $emprunt_maximum = $infos_joueur['Argent_pot'] * 0.30;
    if ($montant_emprunt > $emprunt_maximum) {
        $contenu = '<center><h2>La banque</h2></center>';
        $contenu .= 'Vous ne pouvez pas demander un emprunt aussi important. Vous pouvez demander au maximum ' . $emprunt_maximum . ' €.';
        display($contenu);
        exit();
    }
    $interet = 0.035 * $montant_emprunt;
    $total_emprunt = 1.035 * $montant_emprunt;
    $mensualite = $total_emprunt / 10;
    $insertion_emprunt = mysql_query("UPDATE joueurs SET Emprunt='" . $total_emprunt . "', Emprunt_remb='" . $mensualite . "', Argent=Argent+'" . $montant_emprunt . "' WHERE Nom='" . $_SESSION['nom'] . "'");
    $contenu = '<center><h2>La banque</h2></center>';
    $contenu .= '<p>Votre emprunt a bien eu lieu. Voici un résumé de celui-ci :</p>
					<table border="0">
						<tr>
							<td>Montant :</td><td>' . $montant_emprunt . '</td>
						</tr>
						<tr>
							<td>Taux :</td><td>3.50%</td>
						</tr>
						<tr>
							<td>Intérets :</td><td>' . $interet . '</td>
						</tr>
						<tr>
							<td>Total à rembourser :</td><td>' . $total_emprunt . '</td>
						</tr>
					</table></p>';
    display($contenu);
}

function mon_compte() {
    verification();
    connect();
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $contenu = '<center><h2>Mon compte</h2></center>';
    $contenu .='<p>Si vous le desirez, vous pouvez modifier votre mot de passe, remettre votre compte à zero ou supprimer votre compte.
		<h2>Votre Mot de passe</h2>
		<table border="0">
		<form action="index.php?page=changement_password" method="post">
		<tr>
			<td>Ancien Mot de passe :</td><td><input type="password" name="vieu"></td>
		</tr>
		<tr>
			<td>Nouveau Mot de passe :</td><td><input type="password" name="new"></td>
		</tr>
		<tr>
			<td>Retapez le Mot de passe :</td><td><input type="password" name="new2"></td>
		</tr>
		<tr>
			<td><input type="submit" name="mdp" value="Envoyer"></td><td><input type="reset" name="reset" value="Effacer"></td>
		</tr>
		</form>
		</table></p>';
//		<p><h2>Supprimer votre compte</h2>
//		<table border="0">
//		<tr>
//			<td>Fonctionnalité retiré.</td>
//		</tr>
//		</table>
//		</p>
    display($contenu);
}

function changement_password() {
    verification();
    connect();
    $infos_joueur = infos_joueur($_SESSION['nom']);
    if (!isset($_POST['vieu']) || !isset($_POST['new']) || !isset($_POST['new2'])) {
        $contenu = 'Merci de bien vouloir saisir tous les champs.';
        display($contenu);
        exit();
    } elseif ($_POST['new'] != $_POST['new2']) {
        $contenu = 'Merci de bien vouloir re-saisir vos mot de passe.';
        display($contenu);
        exit();
    } elseif (md5($_POST['vieu']) != $infos_joueur['Password']) {
        $contenu = 'Votre ancien mot de passe ne correspond pas.';
        display($contenu);
        exit();
    }
    $nouveau_password = md5($_POST['new']);
    mysql_query("UPDATE joueurs SET Password='" . $nouveau_password . "' WHERE Nom='" . $_SESSION['nom'] . "'");
    $contenu = '<center><h2>Mon compte</h2></center>';
    $contenu .= 'Mot de passe modifié avec succès.';
    display($contenu);
}

function supprimer_compte() {
    verification();
    connect();
    mysql_query("DELETE FROM joueurs WHERE Nom='" . $_SESSION['nom'] . "'");
    $contenu = '<center><h2>Mon compte</h2></center>';
    $contenu .= 'Votre compte a bien été supprimé.';
    display($contenu);
}

function getTop10() {
    connect();
    $p = 1;
    $nb = 10;
    if (isset($_POST['page'])) {
        $p = $_POST['page'];
    }
    $first = ($p - 1) * $nb;
    $sql = "SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC LIMIT $first,$nb";
    $req = mysql_query($sql)or die("non");
    $contenu = '';
        while ($data = mysql_fetch_assoc($req)) {
            $first++;
            $contenu .= '<li><span class="numerotation">'.$first.'</span><span class="pseudo">'.$data['Nom'].'</span><span class="capital">'.$data['Argent_pot'].'</span></li>';
        }
        return $contenu;
}

function AjaxgetTop10() {
    connect();
    $p = 1;
    $nb = 10;
    if (isset($_POST['page'])) {
        $p = $_POST['page'];
    }
    $first = ($p - 1) * $nb;
    $sql = "SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC LIMIT $first,$nb";
    $req = mysql_query($sql);
    $contenu = '';
        while ($data = mysql_fetch_assoc($req)) {
            $first++;
            $contenu .= '<li><span class="numerotation">'.$first.'</span><span class="pseudo">'.$data['Nom'].'</span><span class="capital">'.$data['Argent_pot'].'</span></li>';
        }
        echo $contenu;
}

function classement() {
    verification();
    connect();
    $p = 1;
    $nb = 20;
    if (isset($_POST['page'])) {
        $p = $_POST['page'];
    }
    $first = ($p - 1) * $nb;
    $nbJoueur = mysql_query("SELECT Id FROM joueurs");
    $liste_joueur_brut = mysql_query("SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC LIMIT $first,$nb");
    $nbJoueur = mysql_num_rows($nbJoueur);
    $contenu = '<center><h2>Classement</h2></center>';
    $contenu .= '<p>Ce classement affiche les 30 joueurs possèdant le Potentiel le plus élevé (<b>Potentiel : Argent + Valeur des actions</b>)</p>
					<div id="class"><table id="classement" border="0">
						<tr>
							<td width="10%"><b>ID</b></td>
							<td width="30%"><b>Nom</b></td>
							<td width="30%"><b>Argent</b></td>
							<td width="30%"><b>Potentiel</b></td>
						</tr>';
    while ($liste_joueur = mysql_fetch_assoc($liste_joueur_brut)) {
        $first++;
        $contenu .= '<tr>
							<td width="10%">' . $first . '</td>
							<td width="30%">' . $liste_joueur['Nom'] . '</td>
							<td width="30%">' . $liste_joueur['Argent'] . '</td>
							<td width="30%">' . $liste_joueur['Argent_pot'] . '</td>
						</tr>';
    }
    $contenu .= '</table></div>';
    // calcul du nombre de page
    $nbPage = ceil($nbJoueur / $nb);
    $contenu .= 'Page : ';
    for ($i = 1; $i <= $nbPage; $i++) {
        $contenu .= '<a class="pagina" name="' . $i . '">' . $i . '</a>';
    }
    display($contenu);
}

function ajaxclassement() {
    verification();
    connect();
    $p = 1;
    $nb = 20;
    if (isset($_POST['page'])) {
        $p = $_POST['page'];
    }
    $first = ($p - 1) * $nb;
    $nbJoueur = mysql_query("SELECT Id FROM joueurs");
    $liste_joueur_brut = mysql_query("SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC LIMIT $first,$nb");
    $nbJoueur = mysql_num_rows($nbJoueur);
    $contenu = '<table id="classement" border="0">
						<tr>
							<td width="10%"><b>ID</b></td>
							<td width="30%"><b>Nom</b></td>
							<td width="30%"><b>Argent</b></td>
							<td width="30%"><b>Potentiel</b></td>
						</tr>';
    while ($liste_joueur = mysql_fetch_assoc($liste_joueur_brut)) {
        $first++;
        $contenu .= '<tr class="noeud">
							<td width="10%">' . $first . '</td>
							<td width="30%">' . $liste_joueur['Nom'] . '</td>
							<td width="30%">' . $liste_joueur['Argent'] . '</td>
							<td width="30%">' . $liste_joueur['Argent_pot'] . '</td>
						</tr>';
    }
    $contenu .= '</table>';
    echo $contenu;
}

function historique() {
    verification();
    connect();
    $historique_brut = mysql_query("SELECT Date,Nom,Sens,Quantite,PU,Total,Joueur FROM historique WHERE `Joueur`='" . $_SESSION['nom'] . "' ORDER BY Date DESC LIMIT 20");
    $contenu = '<center><h2>Historique</h2></center>';
    $contenu .= '<p>Voici un historique de vos 20 dernières transactions.</p>';
    $contenu .= '<table border="0">
						<tr>
							<td width="15%" align="center"><b>Date</b></td>
							<td width="15%" align="center"><b>Nom</b></td>
							<td width="15%" align="center"><b>Sens</b></td>
							<td width="15%" align="center"><b>Quantite</b></td>
							<td width="15%" align="center"><b>Prix Unit</b></td>
							<td width="10%" align="center">/</td>
							<td width="15%" align="center"><b>Total</b></td>
						</tr>';
    while ($historique = mysql_fetch_assoc($historique_brut)) {
        $contenu .= '<tr>
							<td width="15%" align="center">' . $historique['Date'] . '</td>
							<td width="15%" align="center">' . $historique['Nom'] . '</td>
							<td width="15%" align="center">' . $historique['Sens'] . '</td>
							<td width="15%" align="center">' . $historique['Quantite'] . '</td>
							<td width="15%" align="center">' . $historique['PU'] . '</td>
							<td width="10%" align="center">/</td>
							<td width="15%" align="center">' . $historique['Total'] . '</td>
						</tr>';
    }
    display($contenu);
}
?>		
