<?php
	// Fichiers regroupants les fonctions réccurentes
	function connect()
	{
		mysql_connect("localhost","root","root");
		mysql_select_db("bourse");
	}
	// Inscription
	// 0 : Login ou Mot de passe vide
	// 1 : Login déjà utilisé
	// 2 : Inscription réussi
	function inscription($login, $mdp, $mail)
	{
		$verification = mysql_query("SELECT * FROM joueurs WHERE Nom='".$login."'");
		$verif = mysql_fetch_assoc($verification);
		$mdp5 = md5($mdp);
		if ($login == '' or $mdp5 == '' or $mail == '')
		{
			return 0;
		}
		elseif ($verif['Nom'] == $login or $verif['E-mail'] == $mail)
		{
			return 1;
		}
		else
		{
			mysql_query("INSERT INTO joueurs SET `Nom`='".$login."', `Password`='".$mdp5."', `E-mail`='".$mail."'");
			return 2;
		}
	}
	// 0 : Connexion accepté
	// 1 : Connexion impossible
                  // 2 : Compte en validation
	function connexion($login, $mdp)
	{
		$information = mysql_query("SELECT Id, Nom, Password,Etat FROM joueurs WHERE Nom='".$login."'");
		$infos = mysql_fetch_assoc($information);
		$md5=md5($_POST['mdp']);
		if ($login == $infos['Nom'] && $md5 == $infos['Password'] && $infos['Etat'] == 0)
		{
			$_SESSION['nom'] = $login;
			$_SESSION['membre'] = 'oui';
			return 0;
		}
		elseif ($infos['Etat'] == 1)
		{
			return 2;
		}
                                    else {
                                        return 1;
                                    }
	}
	// Fonction servant à afficher le design
	function display($contenu)
	{
		include('templates/haut.php');
		echo $contenu;
		include('templates/bas.php');
	}
	// Fonction qui verifie si le membre est connecté
	function verification()
	{
		if ((!isset($_SESSION['membre'])) || ($_SESSION['membre'] != 'oui'))
		{
			$contenu = 'Page réservé aux membres';
			display($contenu);
			exit();
		}
	}
	// Fonctions permettant de renvoyer un tableau avec toutes les informations sur le joueur
	function infos_joueur($nom_joueur)
	{
		$info_joueur = mysql_query("SELECT * FROM `joueurs` WHERE Nom='".$nom_joueur."'");
		$info_trie = mysql_fetch_assoc($info_joueur);
		return($info_trie);
	}
	// Fonction permettant de renvoyer un tableau avec les informations sur une action
	function infos_action($i)
	{
		$info_action = mysql_query("SELECT * FROM `actions` WHERE Id='".$i."'");
		$info_trie = mysql_fetch_assoc($info_action);
		return($info_trie);
	}
	// Fonction servant à selectionner la quantite d'une action
	function update_argent($montant,$joueur)
	{
		mysql_query("UPDATE joueurs SET Argent_pot='".$montant."' WHERE Nom='".$joueur."'");
	}
?>