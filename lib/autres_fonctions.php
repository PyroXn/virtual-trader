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
    $contenu = '
        <div id="form_envoie" >
            <h2>Mon compte</h2>
            <p>Si vous le desirez, vous pouvez modifier votre mot de passe. Dans le cas où vous souhaiteriez changer de pseudo, merci de bien vouloir utiliser le formulaire de contact.</p>
            <div class="center">
                <h2>Votre Mot de passe</h2>
                <form action="index.php?page=changement_password" method="post">
                    <input type="password" name="vieu" placeholder="Ancien mot de passe">
                    <input type="password" name="new" placeholder="Nouveau mot de passe">
                    <input type="password" name="new2" placeholder="Retapez le mot de passe">
                    <input type="submit" name="mdp" value="Envoyer">
                </form>
            </div>
        </div>';
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
        $contenu = 'Mot de passe incorrect.';
        display($contenu);
        exit();
    }
    $nouveau_password = md5($_POST['new']);
    mysql_query("UPDATE joueurs SET Password='" . $nouveau_password . "' WHERE Nom='" . $_SESSION['nom'] . "'");
    $contenu = '<center><h2>Mon compte</h2></center>';
    $contenu .= 'Mot de passe modifié avec succès.';
    display($contenu);
}

function lostPassword() {
    if(isset($_POST['lostPassword'])) {
    connect();
    $infos_joueur = infos_joueur($_POST['name']);
    $password = '';
    for($i=0;$i<6;$i++) {
        $nb = rand(0,9);
        $password = $password .''.$nb;
    }
    $md5 = md5($password);
    $sql = 'UPDATE joueurs SET Password="'.$md5.'" WHERE Nom="'.$infos_joueur['Nom'].'"';
    mysql_query($sql);
    $contenu = '<center><h2>Mot de passe oublié ?</h2></center>';
    $contenu .= 'Un e-mail vient de vous être envoyé. Merci de bien vouloir changer de mot de passe lors de votre prochaine connexion.';
    // Envoi du mail
    $headers = "From: contact@mydevhouse.com\n";
    $headers .= "Reply-To: contact@mydevhouse.coml\n";
    $headers .= "Content-Type: text/html; charset=\"iso-8859-1\"";
    $message_html = '<html>
                                    <head></head>
                                    <body>
                                       <p>Bonjour, vous avez récement fait une demande pour recevoir un nouveau mot de passe. Votre nouveau mot de passe : <b>'.$password.'</b>. Pensez à le modifier lors de votre prochaine connexion.</p>
                                           <p>Cordialement, l\'équipe de My Dev House - Createur de Virtual-Trader</p>
                                     </body>
                                     </html>';
    // envois du mail
    mail($infos_joueur['E-mail'], "Mot de passe oublie - Virtual trader", $message_html, $headers);
    } else {
        $contenu = '
            <div id="pass_oublie">
                <h2>Mot de passe oublié ?</h2>
                <p>Si vous avez perdu votre mot de passe, entrez ci-dessous votre identifiant. Vous recevrez quelques minutes après un e-mail vous informant de votre nouveau mot de passe.</p>
                <form method="POST">
                    <input type="text" name="name" placeholder="Identifiant" />
                    <input type="submit" value="OK" name="lostPassword" />
                </form>
            </div>';
    }
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
    $req = mysql_query($sql) or die("non");
    $contenu = '';
    while ($data = mysql_fetch_assoc($req)) {
        $first++;
        $contenu .= '<li><span class="numerotation">' . $first . '</span><span class="pseudo">' . $data['Nom'] . '</span><span class="capital">' . $data['Argent_pot'] . '</span></li>';
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
        $contenu .= '<li><span class="numerotation">' . $first . '</span><span class="pseudo">' . $data['Nom'] . '</span><span class="capital">' . $data['Argent_pot'] . '</span></li>';
    }
    echo $contenu;
}

function classement() {
    verification();
    connect();
    $myClassement = myclassement();
    $p = ceil($myClassement/$_SESSION['classement']);
    $nb = $_SESSION['classement'];
    if (isset($_POST['page'])) {
        $p = $_POST['page'];
    }
    $first = ($p - 1) * $nb;
    $nbJoueur = mysql_query("SELECT Id FROM joueurs");
    $liste_joueur_brut = mysql_query("SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC LIMIT $first,$nb");
    $nbJoueur = mysql_num_rows($nbJoueur);
    $contenu = '
        <h2>Classement</h2>
        <p>Ce classement affiche les joueurs possèdant le Potentiel le plus élevé (<b>Potentiel : Argent + Valeur des actions</b>)</p>
        <div class="contentclassement">
            <table id="bourse">
                <tr>
                    <td width="10%"></td>
                    <td width="30%"><b>Nom</b></td>
                    <td width="30%"><b>Argent</b></td>
                    <td width="30%"><b>Potentiel</b></td>
                </tr>';
    while ($liste_joueur = mysql_fetch_assoc($liste_joueur_brut)) {
        
        if ($first % 2 == 0) {
            $myClassement == $first+1 ? $contenu .= '<tr class="pair ligne_perso">' : $contenu .= '<tr class="pair">';
        } else {
            $myClassement == $first+1 ? $contenu .= '<tr class="impair ligne_perso">' : $contenu .= '<tr class="impair">';
        }
        $first++;
        
        $contenu .= '
                    <td>' . $first . '</td>
                    <td><a class="pseudo" href="index.php?page=envoyer_message&joueurs=' . $liste_joueur['Nom'] . '">' . $liste_joueur['Nom'] . '</a></td>
                    <td>' . $liste_joueur['Argent'] . '</td>
                    <td>' . $liste_joueur['Argent_pot'] . '</td>
                </tr>';
    }
    $contenu .= '</table></div>';
    // calcul du nombre de page
    $nbPage = ceil($nbJoueur / $nb);
    $contenu .= '<div class="page">';
    for ($i = 1; $i <= $nbPage; $i++) {
        if ($i == 1) {
            $contenu .= '<a id="currentcla" class="pagina" name="' . $i . '">' . $i . '</a>';
        } else {
            $contenu .= '<a class="pagina" name="' . $i . '">' . $i . '</a>';
        }
    }
    $contenu .= '</div>';
    display($contenu);
}

function ajaxclassement() {
    verification();
    connect();
    $myClassement = myclassement();
    $p = ceil($myClassement/$_SESSION['classement']);
    $nb = $_SESSION['classement'];
    if (isset($_POST['page'])) {
        $p = $_POST['page'];
    }
    $first = ($p - 1) * $nb;
    $nbJoueur = mysql_query("SELECT Id FROM joueurs");
    $liste_joueur_brut = mysql_query("SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC LIMIT $first,$nb");
    $nbJoueur = mysql_num_rows($nbJoueur);
    $contenu = '<table id="bourse">
                    <tr>
                        <td width="10%"></td>
                        <td width="30%"><b>Nom</b></td>
                        <td width="30%"><b>Argent</b></td>
                        <td width="30%"><b>Potentiel</b></td>
                    </tr>';
    while ($liste_joueur = mysql_fetch_assoc($liste_joueur_brut)) {   
        if ($first % 2 == 0) {
            $myClassement == $first+1 ? $contenu .= '<tr class="pair ligne_perso">' : $contenu .= '<tr class="pair">';
        } else {
            $myClassement == $first+1 ? $contenu .= '<tr class="impair ligne_perso">' : $contenu .= '<tr class="impair">';
        }
        $first++;
        $contenu .= '
                    <td>' . $first . '</td>
                    <td>' . $liste_joueur['Nom'] . '</td>
                    <td>' . $liste_joueur['Argent'] . '</td>
                    <td>' . $liste_joueur['Argent_pot'] . '</td>
            </tr>';
    }
    $contenu .= '</table>';
    echo $contenu;
}

function historique() {
    verification();
    connect();
    $historique_brut = mysql_query("SELECT Date,Nom,Sens,Quantite,PU,Total,Joueur FROM historique WHERE `Joueur`='" . $_SESSION['nom'] . "' ORDER BY Date DESC LIMIT 50");
    $contenu = '
        <h2>Historique</h2>
        <p>Voici un historique de vos 50 dernières transactions.</p>
        <table id="bourse">
            <tr>
                <td width="25%"><b>Date</b></td>
                <td width="25%"><b>Nom</b></td>
                <td width="17%"><b>Sens</b></td>
                <td width="11%"><b>Quantite</b></td>
                <td width="11%"><b>Prix Unit</b></td>
                <td width="11%"><b>Total</b></td>
            </tr>';
    $i = 0;
    while ($historique = mysql_fetch_assoc($historique_brut)) {
        if ($i % 2 == 0) {
            $contenu .= '<tr class="pair">';
        } else {
            $contenu .= '<tr class="impair">';
        }
        $date = new DateTime($historique['Date']);
        $contenu .= '
            <td>' . $date->format("H:i:s d/m/Y") . '</td>
            <td>' . $historique['Nom'] . '</td>';
        $historique['Sens'] == "Achat" ? $contenu .= '<td class="red">' . $historique['Sens'] . '</td>' : $contenu .= '<td class="green">' . $historique['Sens'] . '</td>';
        $contenu .= '
            <td>' . $historique['Quantite'] . '</td>
            <td>' . $historique['PU'] . '</td>
            <td>' . $historique['Total'] . '</td>
        </tr>';
        $i++;
    }
    $contenu .= '</table>';
    display($contenu);
}

function myclassement() {
//    $nbJoueur = mysql_query("SELECT Id FROM joueurs");
    $liste_joueur_brut = mysql_query("SELECT Id,Nom,Argent,Argent_pot FROM joueurs ORDER BY Argent_pot DESC");
    $nbJoueur = mysql_num_rows($liste_joueur_brut);
    $i = 1;
    while($liste = mysql_fetch_assoc($liste_joueur_brut)) {
        if($liste['Nom'] == $_SESSION['nom']) {
//            $pa = ceil($i/$_SESSION['classement']); 
            return $i;
        }
        $i++;
    }
    return null;
}
?>		
