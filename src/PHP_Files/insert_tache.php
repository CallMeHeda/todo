<?php
if(!isset($_SESSION['login'])) {
    session_start();
    $tache = htmlspecialchars($_POST['tache']);
    $user_id = htmlspecialchars($_SESSION['login']);

    $sql = "INSERT INTO todolist (tache,user_id) VALUES(:tache,(SELECT id from user WHERE login=:user_id))";
    $dbh = new PDO('mysql:host=', '****', '*****');
    $sth = $dbh->prepare($sql);
    $sth->bindvalue(':tache', $tache);
    $sth->bindvalue(':user_id', $user_id);

    $requete_correcte = $sth->execute();
    if ($requete_correcte === FALSE) {
        echo("Erreur : la requete SQL est incorrecte. <br/>");
    } else {
        $nb_lignes_inserees = $sth->rowCount();

        if ($nb_lignes_inserees === 1) {
//        header('Location:../index.php?choix=todos');
        } elseif ($nb_lignes_inserees === 0) {
            echo("Requete SQL syntaxiquement correcte MAIS aucune ligne n’a
été inseree en DB. Verifiez la requete (table, colonnes...)");
        } elseif ($nb_lignes_inserees === FALSE) {
            echo("Requete SQL syntaxiquement incorrecte.");
        }
    }
}
///////////////////////////////////////////////////////////////////////////
$id = $_SESSION['id'];

$sql = "SELECT todolist.id,todolist.tache,todolist.user_id FROM todolist INNER JOIN user ON todolist.user_id=user.id WHERE todolist.user_id='$id'";
$dbh = new PDO('mysql:host=', '', '');
$sth = $dbh->prepare($sql);
$requete_correcte = $sth->execute();

if ($requete_correcte === FALSE) {
    echo("Erreur : la requete SQL est incorrecte. <br/>");
} else {
    $les_taches = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="col-span-12">
            <div class="overflow-auto lg:overflow-visible">
                <table class="todoTable">
                    <tbody>
                    <?php foreach ($les_taches as $une_tache) { ?>
                        <tr class="trTask bg-red-400" id="<?php echo $une_tache['id']; ?>" data-target="todo_line">
                            <td class="task text-black" id="task" data-target="todo" data-id="<?php echo $une_tache['id']; ?>"><?php echo($une_tache['tache']); ?></td>
                            <!-- ACTIONS -->
                            <td id="<?php echo $une_tache['id']; ?>"
                                class="actions" data-target="action">
                                <!-- CHECK WHEN TO DO IS DONE -->
                                <button class="btn btnCheck text-black" id="btnCheck" data-role="check"                                                           data-id="<?php echo $une_tache['id']; ?>" onclick="crossOut(this)"><i class='fas fa-check'></i></button>
                                <!-- UPDATE TO DO -->
                                <button class="btn btnEdit text-black" id="btnEdit" data-role="update"
                                        data-id="<?php echo $une_tache['id']; ?>"><i class='far fa-edit'></i></button>
                                <!-- REMOVE TO DO -->
                                <button class="btn btnDelete text-black" data-role="delete"                                                          data-id="<?php echo $une_tache['id']; ?>"><i class='fas fa-trash-alt'></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <!--MODAL-->
                <div class="flex justify-center items-center bg-transparent mt-6">
                    <div class="modal hidden">
                        <div class="sm:w-96 border-t-8 border-pink-600 rounded-lg flex">
                            <div class="w-full pt-4 pr-4">
                                <h3 class="font-bold text-pink-700 ml-9 mb-2">What was your mistake(s)?</h3>
                                <input type="text" class="edit_task" name="edit_task" id="edit_task" maxlength="80" placeholder="Edit task?"><span class="countCharEdit">0/80</span>
                            </div>
                        </div>
                        <input type="hidden" id="taskId">
                        <div class="p-4 flex space-x-4">
                            <button class="cancel">Cancel</button>
                            <button class="save">Update</button>
                        </div>
                    </div>
                    <!--FIN MODAL-->
                </div>

            </div>
        </div>
    </div> <!--insert in 'todo'-->
<?php }
?>
<script>
    // DELETE TO DO
    $(document).on('click', 'button[data-role=delete]', function () {
        var id = $(this).data('id');
        var task = $('.task').val();

        $.ajax({
            url : 'src/PHP_Files/delete_tache.php',
            method : 'POST',
            data : {tache : task,id : id},
            success : function (){
                $('#' + id).remove();
            }
        });
    });

    // UPDATE TO DO
    $(document).on('click', 'button[data-role=update]', function () {
        var id = $(this).data('id');
        var tache = $('#' + id).children('td[data-target=todo]').text();
        $(".modal").removeClass("hidden");
        $(".modal").addClass("block");
        $("form").hide();

        $('.edit_task').val(tache);
        $('#taskId').val(id);
    });

    // Confirm update
    $('.save').click(function (e){
        e.preventDefault();
        var id = $('#taskId').val();
        var task = $('.edit_task').val();

        if(task !== "") {
            $.ajax({
                url: 'src/PHP_Files/update_tache.php',
                method: 'POST',
                data: {tache: task, id: id},
                success: function () {
                    $('#' + id).children('td[data-target=todo]').text(task);
                    // close modal
                    $(".modal").addClass("hidden");
                    $(".modal").removeClass("block");
                    $("form").show();
                }
            });
        }else {
            alert("Nothing to do?");
        }
    });

    //NB CHAR INPUT
    $('.edit_task').keydown(function (e) {
        var tache = $(".edit_task").val();

        if (e.keyCode !== 8) {
            if (this.value.length >= 80) {
                return false;
            } else {
                $(".countCharEdit").html((tache.length + 1) + "/80");
            }
        } else {
            if (this.value.length > 0 && this.value.length <= 80) {
                $(".countCharEdit").html((tache.length - 1) + "/80");
            }
        }
    });

    // Close the modal when cancel button clicked
    $(".cancel").click(function () {
        $(".modal").addClass("hidden");
        $(".modal").removeClass("block");
        $("form").show();
    });
</script>
