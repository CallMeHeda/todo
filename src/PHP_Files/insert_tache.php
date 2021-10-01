<?php
//include("connexion_db.php");
session_start();
$tache = htmlspecialchars($_POST['tache']);
$user_id = htmlspecialchars($_SESSION['login']);

//if (empty($tache)) {
//    header("Location: /index.php?mess=error");
//} else {
$sql = "INSERT INTO todolist (tache,user_id) VALUES(:tache,(SELECT id from user WHERE login=:user_id))";
$dbh = new PDO('mysql:host=localhost;dbname=todo', 'root', '');
$sth = $dbh->prepare($sql);
$sth->bindvalue(':tache', $tache);
$sth->bindvalue(':user_id', $user_id);

$requete_correcte = $sth->execute();
if ($requete_correcte === FALSE) {
    echo("Erreur : la requete SQL est incorrecte. <br/>");
} else {
    $nb_lignes_inserees = $sth->rowCount();

    if ($nb_lignes_inserees === 1) {
        echo("Done !");
    } elseif ($nb_lignes_inserees === 0) {
        echo("Requete SQL syntaxiquement correcte MAIS aucune ligne n’a
été inseree en DB. Verifiez la requete (table, colonnes...)");
    } elseif ($nb_lignes_inserees === FALSE) {
        echo("Requete SQL syntaxiquement incorrecte.");
    }
}
//if (empty($tache)) {
//    header("Location: /index.php?mess=error");
//} else {
//    $sql = "INSERT INTO todolist (tache,user_id) VALUES(?)";
//    $sth = $dbh->prepare($sql);
//    $res = $sth->execute([$tache]);
//
//    $dbh = null;
//    exit();
//}