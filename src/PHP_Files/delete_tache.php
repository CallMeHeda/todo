<?php

if(isset($_POST['id'])){
    $id = $_POST['id'];

    if(empty($id)){
        echo 0;
    }else {
        $sql = "DELETE FROM todolist WHERE id=?";
        $dbh = new PDO('');
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