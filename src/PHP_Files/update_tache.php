<?php
include("connexion_db.php");
$id = htmlspecialchars($_POST['id']);
$tache = htmlspecialchars($_POST['tache']);

if (empty($tache)) {
    header("Location: /index.php?mess=error");
} else {
    $sql = "UPDATE todolist SET tache=? WHERE id=?";
    $sth = $dbh->prepare($sql);
    $res = $sth->execute([$tache,$id]);

    $dbh = null;
    exit();
}