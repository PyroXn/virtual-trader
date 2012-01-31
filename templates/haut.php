<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns ="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"/>
        <meta name="description" content="description"/>
        <meta name="keywords" content="keywords"/> 
        <meta name="author" content="author"/> 
        <link rel="stylesheet" type="text/css" href="./templates/style.css" media="screen"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="./js/javascript.js"></script>
        <title>Virtual Trader</title>
        <?php
        if (@$_GET['page'] == 'formulaire_achat') {
            ?>
            <script type="text/javascript">
                function CalculTTC(nbr)
                {
                    var nbr = nbr.value;
                    var price = <?php echo str_replace(",", ".", $_GET['prix']); ?>;
                    var prixht = price*nbr;
                        	
                    if (prixht < 5000)
                    {
                        prixttc = prixht+5;
                    }
                    else if (prixht > 5000 && prixht < 15000)
                    {
                        prixttc = prixht+10;
                    }
                    else {
                        prixttc = prixht+15;
                    }
                        	
                    document.getElementById("prix").innerHTML = prixttc;
                }
            </script>
            <?php
        } elseif (@$_GET['page'] == 'formulaire_vente') {
            ?>
            <script type="text/javascript">
                function CalculPrix(nbr)
                {
                    var nbr = nbr.value;
                    var price = <?php echo str_replace(",", ".", $_GET['prix']); ?>;
                    var prixht = price*nbr;
                    document.getElementById("prix").innerHTML = prixht;
                }
            </script>
            <?php
        }
        ?>
    </head>

    <body>
        <div id="header">
            <div id="banniere">
                <ul>
                    <li>Faites fructifier 20 000&euro; virtuels.</li>
                    <li>Une mise à jour en temps réel du CAC40.</li>
                    <li>Un jeu à la fois palpitant et instructif.</li>
                </ul></div>
            <div id="navigation">
                <ul>
                    <?php
                    if (@$_SESSION['membre'] == 'oui') {   // Lien à modifier
                        connect(); // Connection à la base de données
                        $infos_joueur = infos_joueur($_SESSION['nom']);
                        if ($infos_joueur['Admin'] == 1) {
                            include_once('./lib/fonctions_admin.php');
                            $nb = nbCptNoValide();
                            ?>
                            <li class="currentpage"><a href="index.php?page=accueil" title="Accueil">Accueil</a></li>
                            <li><a href="" title="">Présentation</a></li>
                            <li><a href="index.php?page=contact" title="Contact">Contact</a></li>
                            <li><a href="index.php?page=accueilAdmin">Admin (<?php echo $nb; ?>)</a></li>
                            <?php
                        } else {
                            ?>
                            <li class="currentpage"><a href="index.php?page=accueil" title="">Accueil</a></li>
                            <li><a href="" title="">Présentation</a></li>
                            <li><a href="index.php?page=contact" title="Contact">Contact</a></li>
                            <?php
                        }
                    } else {
                        ?>
                        <li><a href="index.php?page=accueil" title="Accueil">Accueil</a></li>
                        <li><a href="index.php?page=inscription" title="Inscription">Inscription</a></li>
                        <li><a href="index.php?page=#">Explication</a></li>
                        <li><a href="index.php?page=contact" title="Contact">Contact</a></li>
                        <?php
                    }
                    ?>

                </ul>

            </div>
            <hr></hr>
        </div>

        <div id="content">
            <div class="colonne_droite">
                <div class="connexion cadre_bleu">
                    <?php
                    if (@$_SESSION['membre'] == 'oui') {
                        connect();
                        $valeur_action = '';
                        for ($i = 1; $i <= 40; $i++) {
                            $action = infos_action($i);
                            $nom_compose = $action['Nom'] . "_quantite";
                            $quantite_action = $infos_joueur[$nom_compose];
                            $valeur_action = $valeur_action + ($action['Price'] * $quantite_action);
                        }
                        $argent_potentiel = $infos_joueur['Argent'] + $valeur_action;
                        update_argent($argent_potentiel, $_SESSION['nom']);
                        ?>
                        <h2>Vos informations</h2>
                        <table border="0">
                            <tr><td>Nom :</td><td><?php echo $infos_joueur['Nom']; ?></td></tr>
                            <tr><td>Argent :</td><td><?php echo $infos_joueur['Argent']; ?></td></tr>
                            <tr><td>Potentiel :</td><td><?php echo $infos_joueur['Argent_pot']; ?></td></tr>
                        </table>
                        <h2><img src="./templates/img/house.png"> Menu</h2>
                        <ul>
                            <li><a href="index.php?page=mes_actions">Mes actions</a></li>
                            <li><a href="index.php?page=bourse">Bourse</a></li>
                            <?php
                            $nb_message = nb_message($_SESSION['nom']);
                            ?>
                            <li><a href="index.php?page=messagerie">Messagerie(<?php echo $nb_message; ?>)</a></li>
                        </ul>
                        <h2><img src="./templates/img/user.png"> Utilisateur</h2>
                        <ul>
                            <li><a href="index.php?page=mon_compte">Mon compte</a></li>
                            <li><a href="index.php?page=historique">Historique</a></li>
                            <li><a href="index.php?page=classement">Classement</a></li>

                            <li><a href="index.php?page=deconnexion">Deconnexion</a></li>
                        </ul>
                        <?php
                    } else {
                        ?>
                        <h2>
                            Espace connexion
                        </h2>
                        <form action="index.php?page=verification_connexion" method="post">
                            <div><input type="text" placeholder="Identifiant" name="login" id="loginCo"/><span class="error"></span></div>
                            <input type="password" placeholder="Mot de passe" name="mdp" id="pwdCo"/><span class="error"></span>
                            <a href="" class="mini_texte">Mot de passe oublié ?</a>
                            <input type="submit" value="Se connecter" id="submitConnexion" />
                        </form>
                    <?php } ?>
                </div>
                <div class="classement cadre_bleu">
                    <h2>
                        Classement Top 30
                    </h2>
                    <ul>
                        <?php
                            echo getTop10();
                            ?>
                    </ul>
                    Page : <a class="pagination" name="1">1</a> <a class="pagination" name="2">2</a> <a class="pagination" name="3">3</a>
                </div>

            </div>
            <div class="contenu">


