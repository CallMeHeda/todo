<?php
//include("connexion_db.php");

$login_tentative = htmlspecialchars($_POST['login']);
$password_tentative = htmlspecialchars($_POST['password']);

$sql = "SELECT * FROM user WHERE login=:login_tentative";
$sth = $dbh->prepare($sql);
$sth->bindvalue(':login_tentative', $login_tentative);

$requete_correcte = $sth->execute();

if ($requete_correcte === FALSE) {
    var_dump($requete_correcte);
//    header('Location:index.php?choix=accueil&msg=err_sql');
} else {
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    if (empty($user)) {
        header('Location:index.php?choix=home&msg=err_login');
    } elseif ($password_tentative === $user['password']) {
        session_regenerate_id();
        @ini_set('session.gc_maxlifetime', 10800);
        $_SESSION['login'] = $user['login'];
//        var_dump($user);
//        header('Location:index.php?choix=home');
    }else {
        header('Location:index.php?choix=home&msg=err_password');
    }
}
?>