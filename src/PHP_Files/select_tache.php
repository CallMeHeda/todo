<?php
//include('connexion_db.php');

$sql = "SELECT id, tache FROM todolist";
$sth = $dbh->prepare($sql);
$requete_correcte = $sth->execute();

if ($requete_correcte === FALSE) {
    echo("Erreur : la requete SQL est incorrecte. <br/>");
} else {

    $les_taches = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($les_taches as $une_tache) { ?>
        <div>
            <?php echo("<p>" . $une_tache['id'] . " - " . $une_tache['tache'] . "</p> \r\n"); ?>

            <!--DELETE-->
            <span id="<?php echo $une_tache['id']; ?>" class="remove-to-do">
                <button class="btn bg-transparent"><i class='fas fa-trash-alt'></i></button>
            </span>
            <!--UPDATE-->
        </div>
        <?php
    }
}
?>