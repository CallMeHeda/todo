<?php
include('connexion_db.php');

$sql = "SELECT * FROM todolist ORDER BY id";
$sth = $dbh->prepare($sql);
$requete_correcte = $sth->execute();

if ($requete_correcte === FALSE) {
    echo("Erreur : la requete SQL est incorrecte. <br/>");
} else {

    $les_taches = $sth->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="flex items-start justify-center min-h-screen bg-transparent">
        <div class="col-span-12">
            <div class="overflow-auto lg:overflow-visible">
                <table class="text-white border-separate space-y-6 text-sm mt-4 todoTable">
<!--                    <thead class="bg-red-600 uppercase">-->
<!--                    <tr>-->
<!--                        <th class="p-3 text-center">To do</th>-->
<!--                        <th class="p-3 text-center">Action</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
                    <tbody>
                    <?php foreach ($les_taches as $une_tache) { ?>
                        <tr class="bg-red-400 text-left trTask transform hover:-translate-y-1 hover:scale-110 hover:transition duration-500 ease-in-out " id="<?php echo $une_tache['id']; ?>" data-target="todo_line">
                            <td class="flex p-3 pr-52 capitalize task" id="task" data-target="todo" data-id="<?php echo $une_tache['id']; ?>"><?php echo($une_tache['tache']); ?></td>
                            <!-- ACTIONS -->
                            <td id="<?php echo $une_tache['id']; ?>"
                                class="align-items-center p-3 text-center" data-target="action">
                                <!-- CHECK WHEN TO DO IS DONE -->
                                <button class="btn bg-transparent px-2 btnCheck" id="btnCheck" data-role="check"                                                           data-id="<?php echo $une_tache['id']; ?>" onclick="crossOut(this)"><i class='fas fa-check'></i></button>
                                <!-- UPDATE TO DO -->
                                <button class="btn bg-transparent px-2 btnEdit" data-role="update"
                                        data-id="<?php echo $une_tache['id']; ?>"><i class='far fa-edit'></i></button>
                                <!-- REMOVE TO DO -->
                                <button class="btn bg-transparent px-2 btnDelete" data-role="delete"                                                          data-id="<?php echo $une_tache['id']; ?>"><i class='fas fa-trash-alt'></i>
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
                    <div class="bg-white rounded-lg fixed top-40 hidden modal">
                        <div class="sm:w-96 border-t-8 border-pink-600 rounded-lg flex">
                            <div class="w-full pt-4 pr-4">
                                <h3 class="font-bold text-pink-700 ml-9 mb-2">What was your mistake(s)?</h3>
                                <input type="text" class="edit_task" name="edit_task" id="edit_task" maxlength="80" placeholder="Edit task?"><span class="countCharEdit">0/80</span>
                            </div>
                        </div>
                        <input type="hidden" id="taskId">
                        <div class="p-4 flex space-x-4">
                            <button class="cancel w-1/2 px-4 py-3 text-center bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-black font-bold rounded-lg text-sm">Cancel</button>
                            <button class="w-1/2 px-4 py-3 text-center text-pink-100 bg-pink-600 rounded-lg hover:bg-pink-700 hover:text-white font-bold text-sm save">Update</button>
                        </div>
                    </div>
                    <!--FIN MODAL-->
                </div>

            </div>
        </div>
    </div>
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
                $('#' + id).fadeOut(1000);
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

        $.ajax({
            url : 'src/PHP_Files/update_tache.php',
            method : 'POST',
            data : {tache : task,id : id},
            success : function (){
                $('#' + id).children('td[data-target=todo]').text(task);
                // close modal
                $(".modal").addClass("hidden");
                $(".modal").removeClass("block");
                $("form").show();
            }
        });
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

    // CHECK TO DO
    // function on button
    var cookieTable = [];
    function crossOut(e) {
        if (!e.parentElement.parentElement.children[0].classList.contains("line-through")) {
            console.log(e);
            e.parentElement.parentElement.children[0].classList.add("line-through");
            e.parentElement.parentElement.children[0].classList.remove("no-underline");
            e.parentElement.parentElement.classList.add("opacity-30");

            cookieTable = JSON.parse(localStorage.getItem('strike')) || [];
            const id = e.dataset['id'];
            cookieTable.push(id);
            localStorage.setItem('strike', JSON.stringify(cookieTable));
        }else {
            e.parentElement.parentElement.children[0].classList.add("no-underline");
            e.parentElement.parentElement.children[0].classList.remove("line-through");
            e.parentElement.parentElement.classList.remove("opacity-30");

            cookieTable = JSON.parse(localStorage.getItem('strike')) || [];
            const id = e.dataset['id'];
            const index = cookieTable.indexOf(id);
            if(index >= 0) {
                cookieTable.splice(index, 1);
            }
            localStorage.setItem('strike', JSON.stringify(cookieTable));
            // window.localStorage.clear();
        }
    }
    // function on body
   function checkCrossOut() {
        var storage = JSON.parse(localStorage.getItem("strike"));
        var todos = $(".task");

        if (storage !== null) {
            for (var i = 0; i < todos.length; i++) {
                for (var j = 0; j < storage.length; j++) {
                    if (todos[i].dataset['id'] === storage[j]) {
                        todos[i].classList.add("line-through");
                        todos[i].parentElement.classList.add("opacity-60");
                        // todos[i].innerHTML;
                    }
                }
            }
        }
    }
</script>