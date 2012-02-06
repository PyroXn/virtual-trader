<?php
	// Fichier regroupant les principales fonctions liés à la messagerie
	function nb_message($nom_joueur)
	{
		$messagerie = mysql_query("SELECT * FROM messages WHERE `Destinataire`='".$nom_joueur."' AND `Etat`=0");
		$nb_message = mysql_num_rows($messagerie);
		return($nb_message);
	}
	function messagerie()
	{
		verification();
		connect();
		$liste_message_brut = mysql_query("SELECT * FROM messages WHERE `Destinataire`='".$_SESSION['nom']."' ORDER BY Id DESC");
		$contenu = '<center><h2>Messagerie</h2></center>';
		$contenu .= '<p>Voici votre messagerie. Vous pouvez envoyer, consulter et répondre à vos messages privés.</p>
                    <div class="double_choix">
                        <span><a href="index.php?page=envoyer_message">Envoyer un message</a></span>
                        <span><a href="index.php?page=messagerie">Boite de reception</a></span>
                    </div>';
                
		$contenu .= '                   
                    <table id="messagerie">
                        <tr>
                            <td><b>Expediteur</b></td>
                            <td><b>Objet</b></td>
                            <td><b>Etat</b></td>
                        </tr>';
		while($liste_message = mysql_fetch_assoc($liste_message_brut))
		{
			$contenu .= '<tr>';
			$contenu .= '<td>'.$liste_message['Expediteur'].'</td>';
			$contenu .= '<td><a href="index.php?page=afficher_message&id='.$liste_message['Id'].'">'.$liste_message['Objet'].'</a></td>';
			if ($liste_message['Etat'] == 0)
			{
				$contenu .= '<td><b><font color="red">Non lu</font></b></td>';
			}
			else
			{
				$contenu .= '<td><b><font color="green">Lu</font></b></td>';
			}
			$contenu .= '<td class="repondre"><a title="Répondre" href="index.php?page=envoyer_message&joueurs='.$liste_message['Expediteur'].'"></a></td>';
			$contenu .= '<td class="supprimer"><a title="Supprimer" href="index.php?page=supprimer_message&id='.$liste_message['Id'].'"></a></td>';
			$contenu .= '</tr>';
		}
		$contenu .= '</table>';
		display($contenu);
	}
	// Fonction d'envois de message
	function envoyer_message()
	{
		verification();
		$destinataire = @$_GET['joueurs'];
		$contenu = '<center><h2>Messagerie</h2></center>';
		$contenu .= '<p>Voici votre messagerie. Vous pouvez envoyer, consulter et répondre à vos messages privés.</p>
                 <div class="double_choix">
                        <span><a href="index.php?page=envoyer_message">Envoyer un message</a></span>
                        <span><a href="index.php?page=messagerie">Boite de reception</a></span>
                    </div>';
		$contenu .= '<table border="0">
		<form action="index.php?page=message_envoye" method="post">
		<tr>
			<td>Destinataire :</td><td><input type="text" maxlength="20" name="destinataire" value="'.$destinataire.'"></td></tr>
			<tr><td>Objet :</td><td><input type="text" maxlength="20" name="objet"></td></tr>
			<tr><td>Message :</td><td><TEXTAREA name="message" rows=10 COLS=40>Tapez votre message</textarea></td></tr>
			<tr><td><input type="submit" value="Envoyer"></td><td><input type="reset" name="Annuler"></td></tr>
		</tr>
		</table>';
		display($contenu);
	}

	function message_envoye()
	{
		verification();
		connect();
		$destinataire = $_POST['destinataire'];
		$objet = $_POST['objet'];
		$message = mysql_real_escape_string($_POST['message']);
		$expediteur = $_SESSION['nom'];
		$verification_destinataire = mysql_query("SELECT * FROM `joueurs` WHERE `Nom`='".$destinataire."'");
		$nombre_destinataire = mysql_num_rows($verification_destinataire);
		if ($expediteur == '' || $destinataire == '' | $objet == '' || $message == '')
		{
			$contenu = 'Merci de bien vouloir remplir tous les champs.';
			display($contenu);
			exit();
		}
		elseif ($nombre_destinataire == 0)
		{
			$contenu = 'Le destinataire n\'éxiste pas.';
			display($contenu);
			exit();
		}
		elseif ($nombre_destinataire == 1)
		{
			$contenu = 'Message envoyé avec succès.';
			$insertion_message = mysql_query("INSERT INTO messages SET `Expediteur`='".$expediteur."', `Destinataire`='".$destinataire."', `Objet`='".$objet."', `Message`='".$message."',`Etat`=0");
			display($contenu);
		}
	}
	function supprimer_message()
	{
		verification();
		connect();
		$id_a_supprimer = @$_GET['id'];
		$securisation = mysql_query("SELECT * FROM messages WHERE Id='".$id_a_supprimer."' AND Destinataire='".$_SESSION['nom']."'");
		$email = mysql_num_rows($securisation);
		if ($email == 1)
		{
			mysql_query("DELETE FROM messages WHERE Id='".$id_a_supprimer."'");
			$contenu = '<h2>Messagerie</h2>';
			$contenu .= 'Message supprimé avec succès.';
		}
		else
		{
			$contenu = '<h2>Tentative de piratage</h2>';
			$contenu .= 'Tentative de piratage détecté. Votre ID a été transmis à l\'administrateur.';
		}
		display($contenu);
	}
	// Fonction servant à afficher les messages privés
	function afficher_message()
	{
		verification();
		connect();
		$id = @$_GET['id'];
		$message_brut = mysql_query("SELECT * FROM messages WHERE id='".$id."' AND Destinataire='".$_SESSION['nom']."'");
		$nb_message = mysql_num_rows($message_brut);
		if ($nb_message == 0) // On verifie que le MP est bien destiné à l'utilisateur <== SECURITE
		{
			$contenu = 'Tentative de triche détectée. Votre ID a été transmis à l\'administrateur.';
			display($contenu);
			exit();
		}
		$message_trie = mysql_fetch_assoc($message_brut);
		if ($message_trie['Etat'] == 0)
		{
			$update_etat = mysql_query("UPDATE messages SET Etat=1 WHERE id='".$id."'"); // Sert à indiquer que l'utilisateur vient de lire le message
		}
		// Affichage du MP
		$contenu = '<center><h2>Messagerie</h2></center>';
		$contenu .= '<p>Voici le message de '.$message_trie['Expediteur'].'</b></p>
		<table border="0">
		<tr>
			<td><b>Expediteur :</b></td><td>'.$message_trie['Expediteur'].'</td>
		</tr>
		<tr>
			<td><b>Objet :</b></td><td>'.$message_trie['Objet'].'</td>
		</tr>
		<tr>
			<td><b>Message :</b></td><td width="80%" rows=10 COLS=30>'.$message_trie['Message'].'</td></tr>
		</table>
		<p><a href="index.php">Retour à l\'accueil</a> | <a href="index.php?page=messagerie">Retour à la messagerie</a>';
		display($contenu);
	}
	
		
	
?>