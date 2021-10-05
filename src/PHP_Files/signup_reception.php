<?php
$login = $_POST['login'];
$sql = "SELECT login FROM user WHERE login LIKE '$login'";
$sth = $dbh->query($sql);

$new_user = $sth->fetch(PDO::FETCH_ASSOC);
if ($new_user['login'] === $login) {
    header('Location:index.php?choix=new_member_formulaire&mess=err_login');
}elseif ($_POST['password'] != $_POST['conf_password']) {
    header('Location:index.php?choix=new_member_formulaire&mess=err_password');
}else{
    $login = $_POST['login'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO user(login,password) VALUES('$login', '$hash')";

    $nb_lignes_inserees = $dbh->exec($sql);

    if ($nb_lignes_inserees === 1) {
        header('Location:index.php?choix=se_connecter');
    } elseif ($nb_lignes_inserees === 0) {
        echo("Requete SQL syntaxiquement correcte MAIS aucune ligne n’a
été inseree en DB. Verifier la requete (table, colonnes...)");
    } elseif ($nb_lignes_inserees === FALSE) {
        echo("Requete SQL syntaxiquement incorrecte.");
    }
}
?>