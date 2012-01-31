<?php
function nbCptNoValide() {
    $sql = 'SELECT * FROM joueurs WHERE Etat=1';
    $req = mysql_query($sql);
    return mysql_num_rows($req);
}

function getCptNoValide() {
    $sql = 'SELECT * FROM joueurs WHERE Etat=1';
    $req = mysql_query($sql);
    return $req;
}

function accueilAdmin() {
    verification();
    connect();
    $listCptNoValide = getCptNoValide();
    $contenu = '<center><h2>Liste des comptes non validés</h2></center>';
    $contenu .= 'Pour valider un compte, choisissez le dans la liste déroulante et cliquez sur "Valider"';
    $contenu .= '<form method="post" action="index.php?page=validerCpt">';
    $contenu .= '<select name="listCpt">';
    while($data = mysql_fetch_assoc($listCptNoValide)) {
        $contenu .= '<option value="'.$data['Id'].'">'.$data['E-mail'].'</option>';
    }
    $contenu .= '</select>';
    $contenu .= ' <input type="submit" value="Valider">';
    $contenu .= '</form><div class="clearboth"></div>';
    display($contenu);
}

function validerCpt() {
    verification();
    connect();
    $id = $_POST['listCpt'];
    $sql = 'UPDATE joueurs SET Etat=0 WHERE Id="'.$id.'"';
    $req = mysql_query($sql);
    $contenu = '<center><h2>Compte validé avec succès</h2></center>';
    $contenu .= '<p>Le compte choisi a bien été validé.</p><div class="clearboth"></div>';
    display($contenu);
}
?>
