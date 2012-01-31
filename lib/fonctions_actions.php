<?php
function resultat_variajour($variation) {
    if($variation > 0) {
        return '<td width="20%"><font color="green">+' . round($variation, 2) . '%</font></td>';
    } else {
        return '<td width="20%"><font color="red">' . round($variation, 2) . '%</font></td>';
    }
}
// Fonction permettant de colorer le taux de variation
function resultat_variation($variation, $prix_action, $montant_euros) {
    // On multiplie par 100 la variation
    $varia = $variation * 100;
    if ($variation > 0 && $prix_action > 0) {
        $affichage = '<td width="20%"><font color="green">+' . round($varia, 2) . '% / +' . round($montant_euros, 2) . '&#1108;</font></td>';
    } elseif ($variation > 0 && $prix_action < 0) {
        $affichage = '<td width="20%">0 / 0</td>';
    } elseif ($variation < 0 && $prix_action > 0) {
        $affichage = '<td width="20%"><font color="red">' . round($varia, 2) . '% / ' . round($montant_euros, 2) . '&#1108;</font></td>';
    } else {
        $affichage = '<td width="20%">0 / 0</td>';
    }
    return($affichage);
}

function mes_actions() {
    verification();
    connect();
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $contenu = '<center><h2>Vos actions</h2></center>';
    $contenu .= '<table border="0">
		<tr>
			<td width="40%"><b>Libell�</b></td>
			<td width="17%"><b>Prix achat</b></td>
			<td width="17%"><b>Varia/Euros</b></td>
                                                      <td width="17%"><b>Varia Journaliere</b></td>
			<td width="17%"><b>Quantite</b></td>
			<td width="9%"><b>Vendre</b></td>
		</tr>';
    for ($i = 1; $i <= 40; $i++) {
        $contenu .= '<tr>';
        // Libell� de l'action
        $infos_action = infos_action($i); // On recupere les informations de l'action
        if ($infos_action['Nom'] == '+L&#039;OREAL') {
            $nom_action = 'L\'OREAL';
        } else {
            $nom_action = $infos_action['Nom'];
        }
        $contenu .= "<td width='40%'>" . $infos_action['Nom'] . "</td>";
        // Recuperation du prix d'achat de l'action
        $contenu .= "<td width='20%'>" . $infos_joueur[$nom_action] . "</td>";
        // Taux de variation de l'action
        if ($infos_joueur[$nom_action] <> 0) {          
            $variation = ($infos_action['Price'] - $infos_joueur[$nom_action]) / $infos_joueur[$nom_action];
        } else {
            $variation = 0;
        }
        $montant_euros = ($variation * $infos_joueur[$nom_action]);

        // Appel de la fonction pour colorer le resultat de la variation
        $affichage_variation = resultat_variation($variation, $infos_joueur[$nom_action], $montant_euros);
        $contenu .= $affichage_variation;
        // Variation journaliere
        if ($infos_joueur[$nom_action] <> 0) {
        $infosAction = infos_action($i);
        $variaJour = (($infosAction['Price'] - $infosAction['Clot_prec'])/$infosAction['Clot_prec'])*100;
        $contenu .= resultat_variajour($variaJour);
        } else {
            $contenu .= "<td width='20%'>0</td>";
        }
        // Recuperation de la quantite d'action
        $action_quantite = $nom_action . "_quantite";
        $contenu .= "<td width='20%'>" . $infos_joueur[$action_quantite] . "</td>";
        // Affichage du bouton pour vendre l'action
        if ($infos_joueur[$action_quantite] > 0) {
            $contenu .= '<td width="9%"><a href="index.php?page=formulaire_vente&actions=' . $i . '&prix=' . $infos_action['Price'] . '">Vendre</a></td>';
        }
        $contenu .= '</tr>';
    }
    $contenu .= '</table>';
    display($contenu);
}

// Fonction servant � afficher le cour des actions
function bourse() {
    verification();
    connect();
    $heure = date("H");
    $code = file_get_contents('http://bourse.lesechos.fr/bourse/indices/composition.jsp?Code=FR0003500008&Place=00025-TR&Codif=ISI');
    $code = preg_replace('/\s\s+/', ' ', $code);
    $pattern_nom = <<<BEGIN
/<a[^>]*><b>([A-Z-\s*.&#039;]+)<\/b><\/a>/
BEGIN;

    $pattern_indice = <<<BEGIN
/<b>([0-9,]+)&nbsp;<\/b>/
BEGIN;

    preg_match_all(trim($pattern_nom), $code, $noms_actions);
    preg_match_all(trim($pattern_indice), $code, $cours_actions);
    $contenu = '<center><h2>Les cours de la bourse</h2></center>';
    $contenu .= '<table border=0';
    $contenu .= '<tr>';
    $contenu .= '<td width="40%"><b>Libell� </b></td>';
    $contenu .= '<td width="17%"><b>Cours </b></td>';
    $contenu .= '<td width="17%"><b>Varia </b></td>';
    $contenu .= '<td width="17%"><b>Cl�t prec</b></td>';
    $contenu .= '<td width="9%"><b>Acheter</b></td>';
    $contenu .= '</tr>';
    $o = 1;
    for ($i = 0; $i < 39; $i++) {
        //mysql_query("INSERT INTO actions SET Nom='".$noms_actions[1][$i]."',Clot_prec='10.70',Price='".$cours_actions[1][$i]."'");
        /*$cours = preg_replace("/,/",".",$cours_actions[1][$i]);
        mysql_query("INSERT INTO `actions`(Nom,Clot_prec,Price) VALUES ('".$noms_actions[1][$i]."','".$cours."','".$cours."')");*/
        $contenu .= '<tr>';
        $contenu .= '<td width="40%">' . $noms_actions[1][$i] . '</td>';
        $contenu .= '<td width="20%">' . $cours_actions[1][$i] . '</td>';
        // On recherche les informations de la cloture precedente
            if($noms_actions[1][$i] == "L&#039;&#039;OREAL") {
                $noms_actions[1][$i] = "L&#039;OREAL";
            }
        $cloture_precedente = mysql_query("SELECT * FROM `actions` WHERE `Nom`='" . $noms_actions[1][$i] . "'");
        $affichage_cloture = mysql_fetch_assoc($cloture_precedente);
        $valeur_action = str_replace(",", ".", $cours_actions[1][$i]);
        if ($heure >= 19 || $heure <= 8) {
            $update_cloture_precedente = mysql_query("UPDATE actions SET `Clot_prec`='" . $valeur_action . "' WHERE `Nom`='" . $noms_actions[1][$i] . "'");
        }
        $update_prix = mysql_query("UPDATE actions SET `Price`='" . $valeur_action . "' WHERE Nom='" . $noms_actions[1][$i] . "'");
        $taux_variation = ($valeur_action - $affichage_cloture['Clot_prec']) / $affichage_cloture['Clot_prec'] * 100;
        if ($taux_variation >= 0) {
            $contenu .= '<td width="20%"><font color="green">+ ' . round($taux_variation, 2) . '%</font></td>';
        } else {
            $contenu .= '<td width="20%"><font color="red"> ' . round($taux_variation, 2) . '%</font></td>';
        }
        $contenu .= '<td width="20%">' . $affichage_cloture['Clot_prec'] . '</td>';
        $contenu .= '<td width="9%"><a href="index.php?page=formulaire_achat&actions=' . $o . '&prix=' . $cours_actions[1][$i] . '">Acheter</a></td>';
        $o++;
    }
    $contenu .= '</tr>';
    $contenu .= '</table>';
    display($contenu);
}

function formulaire_achat() {
    verification();
    connect();
    $heure = Date("H");
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $i = $_GET['actions'];
    $infos_action = infos_action($i);
    $prix_action_brut = $_GET['prix'];
    $prix_action = str_replace(",", ".", $prix_action_brut);
    if ($heure >= 19 || $heure <= 8) {
        $contenu = '<p>La bourse est actuellement ferm�. Les achats/ventes ne peuvent se faire que lorsque celle-ci est ouverte.</p>';
        display($contenu);
        exit();
    }
    $contenu = '<p>Merci de bien vouloir choisir l\'action et la quantit� d\'action que vous d�sirez.
			<h2>Choisir l\'action</h2>
			<form action="index.php?page=achat" method="post" name="form1">
			<table border="0">
			<tr>
				<td>Action :</td><td>
			<select name="action" style="width:200px;">';
    $contenu .= '<option value="' . $infos_action['Nom'] . '">' . $infos_action['Nom'] . '</option>';
    $contenu .= '</select>
				</td></tr>
				<tr><td>Quantite :</td><td><input type="text" name="quantite" size="3" MAXLENGTH="3" onkeyup="CalculTTC(this)"></td></tr>
				<tr><td>Prix :</td><td><b>' . $prix_action . '</b></td></tr>
				<tr><td>Total TTC :</td><td><b><span id="prix"></span></b></td></tr>
				<input type="hidden" name="id" value="' . $infos_action['Id'] . '">
			<tr>
				<td></td><td><input type="submit" value="Envoyer"></td></tr>
			</table>
			</form></p><div class="clearboth"></div>';
    display($contenu);
}

// Fonction Servant � l'achat d'action
function achat() {
    verification();
    connect();
    $date = date("d.m.y");
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $infos_action = infos_action($_POST['id']);
    $nom_action = $_POST['action'];

    if ($nom_action == 'L\'OREAL') {
        $nom_action = 'L&#039;OREAL';
    }

    $quantite_action = $_POST['quantite'];
    if ($quantite_action < 0) {
        $quantite_action = 0;
    }
    $prix_total = $quantite_action * $infos_action['Price'];
    $action_quantite = $nom_action . '_quantite';
    
    // On met en place les frais
    if ($prix_total < 5000) {
        $total = $prix_total + 5;
        $frais = '5';
    } elseif ($prix_total > 5000 && $prix_total < 15000) {
        $total = $prix_total + 10;
        $frais = '10';
    } else {
        $total = $prix_total + 15;
        $frais = '15';
    }
    // On v�rifie que l'utilisateur a assez d'argent
    if ($infos_joueur['Argent'] < $total) {
        $contenu = 'Vous n\'avez pas assez d\'argent.<div class="clearboth"></div>';
        display($contenu);
        exit();
    }
    // On retire le montant, ajoute la quantite d'action achet�, et insere le prix d'achat
    mysql_query("UPDATE `joueurs` SET Argent=Argent - '" . $total . "', `$action_quantite`=`$action_quantite`+'" . $quantite_action . "', `$nom_action`='" . $infos_action['Price'] . "'  WHERE Id='" . $infos_joueur['Id'] . "'");
    mysql_query("INSERT INTO historique SET `Date`=NOW(), `Nom`='" . $nom_action . "', `Sens`='Achat', `Quantite`='" . $quantite_action . "', `PU`='" . $infos_action['Price'] . "', `Total`='" . $total . "', `Joueur`='" . $_SESSION['nom'] . "'");
    $contenu = '<center><h2>Votre achat</h2></center>';
    $contenu .= '<p>Voici un r�capitulatif de votre achat.</p>
		<center><table border="0"><p><tr><td><b>Nom :</b></td><td>' . $nom_action . '</td></tr>
		<tr><td><b>Quantite :</b></td><td>' . $quantite_action . '</td></tr>
		<tr><td><b>Prix unitaire :</b></td><td>' . $infos_action['Price'] . '</td></tr>
		<tr><td><b>Total HT :</b></td><td>' . $prix_total . ' &euro;</td></tr>
		<tr><td><b>Taxe :</b></td><td>' . $frais . ' &euro;</td></tr>
		<tr><td><b>Total TTC :</b></td><td>' . $total . ' &euro;</td></tr></p></table></center><div class="clearboth"></div>';
    display($contenu);
}

// Fonctions servant � la vente d'actions
function formulaire_vente() {
    verification();
    connect();
    $heure = Date("H");
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $i = @$_GET['actions'];
    $infos_action = infos_action($i);
    $action_quantite = $infos_action['Nom'] . '_quantite';
    $quantite_action = $infos_joueur[$action_quantite];
    $prix_action_brut = $_GET['prix'];
    $prix_action = str_replace(",", ".", $prix_action_brut);
    if ($heure >= 19 || $heure <= 8) {
        $contenu = '<p>La bourse est actuellement ferm�. Les achats/ventes ne peuvent se faire que lorsque celle-ci est ouverte.</p><div class="clearboth"></div>';
        display($contenu);
        exit();
    }
    $contenu = '<p>Merci de bien vouloir choisir l\'action et la quantit� d\'action que vous d�sirez.
					<h2>Choisir l\'action</h2>
					<form action="index.php?page=vente" method="post" name="form1">
					<table border="0">
						<tr>
							<td>Action :</td><td>
							<select name="action" style="width:200px;">';
    $contenu .= '<option value="' . $infos_action['Nom'] . '">' . $infos_action['Nom'] . '</option>';
    $contenu .= '</select></td></tr>
					<tr>
						<td>Quantit� poss�d� :</td><td>' . $quantite_action . '</td>
					</tr>
					<tr>
						<td>Quantite :</td><td><input type="text" name="quantite" size="3" MAXLENGTH="3" onkeyup="CalculPrix(this)"></td>
					</tr>
					<tr>
						<td>Prix :</td><td><b>' . $prix_action . '</b></td>
					</tr>
					<tr>
						<td>Total TTC :</td><td><b><span id="prix"></span></b></td>
					</tr>
					<input type="hidden" name="id" value="' . $infos_action['Id'] . '">
					<tr>
						<td></td><td><input type="submit" value="Envoyer"></td>
					</tr>
					</table>
					</form></p><div class="clearboth"></div>';
    display($contenu);
}

function vente() {
    verification();
    connect();
    $date = date("d.m.y");
    $infos_joueur = infos_joueur($_SESSION['nom']);
    $infos_action = infos_action($_POST['id']);
    if ($infos_action['Nom'] == 'L\'OREAL') {
        $nom_action = 'L&#039;OREAL';
    } else {
        $nom_action = $infos_action['Nom'];
    }
    $action_quantite = $nom_action . '_quantite';
    $nom_action = $_POST['action'];
    $quantite_action = $_POST['quantite'];
    if ($quantite_action > $infos_joueur[$action_quantite]) {
        $contenu = 'Vous ne pouvez pas vendre plus d\'action que vous en possedez.<div class="clearboth"></div>';
        display($contenu);
        exit();
    } elseif ($quantite_action < 0 || !is_numeric($quantite_action)) {
        $contenu = 'Merci de bien vouloir saisir un nombre d\'action positif.<div class="clearboth"></div>';
        display($contenu);
        exit();
    }
    $total_vendu = $quantite_action * $infos_action['Price'];
    // On effectue les requetes neccessaires � la vente
    if ($infos_joueur[$action_quantite] - $quantite_action == 0) {
        mysql_query("UPDATE joueurs SET Argent=Argent+'" . $total_vendu . "', `$action_quantite`=`$action_quantite`-'" . $quantite_action . "', `$nom_action`=0 WHERE Nom='" . $_SESSION['nom'] . "'");
    } else {
        mysql_query("UPDATE joueurs SET Argent=Argent+'" . $total_vendu . "', `$action_quantite`=`$action_quantite`-'" . $quantite_action . "' WHERE Nom='" . $_SESSION['nom'] . "'");
    }
    mysql_query("INSERT INTO historique SET `Date`=NOW(), `Nom`='" . $infos_action['Nom'] . "', `Sens`='Vente', `Quantite`='" . $quantite_action . "', `PU`='" . $infos_action['Price'] . "', `Total`='" . $total_vendu . "', `Joueur`='" . $_SESSION['nom'] . "'");
    // Affichage d'un r�capitulatif pour l'utilisateur
    $contenu = '<center><h2>Votre vente</h2></center>';
    $contenu .= '<p>Voici un r�capitulatif de votre vente.</p>
		<center><table border="0"><p><tr><td><b>Nom :</b></td><td>' . $nom_action . '</td></tr>
		<tr><td><b>Quantite :</b></td><td>' . $quantite_action . '</td></tr>
		<tr><td><b>Prix unitaire :</b></td><td>' . $infos_action['Price'] . '</td></tr>
		<tr><td><b>Total HT :</b></td><td>' . $total_vendu . ' �</td></tr>
		</p></table></center><div class="clearboth"></div>';
    display($contenu);
}

?>