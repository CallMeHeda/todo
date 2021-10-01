<?php

if(isset($_POST['id'])){
//    include 'connexion_db.php';
    $id = $_POST['id'];

    if(empty($id)){
        echo 0;
    }else {
        $sql = "DELETE FROM todolist WHERE id=?";
        $dbh = new PDO('mysql:host=localhost;dbname=todo','root', '');
        $sth = $dbh->prepare($sql);
        $res = $sth->execute([$id]);

        if($res){
            echo 1;
        }else {
            echo 0;
        }
        $dbh = null;
        exit();
    }
}else {
    header("Location: /index.php?mess=error");
}