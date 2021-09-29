<?php
include("connexion_db.php");
$tache = htmlspecialchars($_POST['tache']);

if (empty($tache)) {
    header("Location: /index.php?mess=error");
} else {
    $sql = "INSERT INTO todolist (tache) VALUES(?)";
    $sth = $dbh->prepare($sql);
    $res = $sth->execute([$tache]);

    $dbh = null;
    exit();
}
