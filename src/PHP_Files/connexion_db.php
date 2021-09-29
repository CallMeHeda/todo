<?php
define('USER', 'root');
define('PASSWORD', '');
define('DSN', 'mysql:host=localhost;dbname=todo;charset=UTF8');
try {
    $dbh = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $exception) {
    echo ("Connexion à la DB : erreur <br/>");
    echo ("Vérifiez en premier lieu USER, PASSWORD, dbname <br/>");
    echo ("Cause : " . $exception->getMessage() . "<br/>");
    die();
}
