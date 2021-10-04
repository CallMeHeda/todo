<?php
session_start();
include('src/PHP_Files/connexion_db.php');
if (isset($_GET['choix'])) {
    $choix = $_GET['choix'];
} else {
    $choix = 'se_connecter';
}
switch ($choix) {
    case 'authentification_start':
        include('src/PHP_Files/login_start.php');
        break;
}
?>
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="public/css/tailwind.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Italianno">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Permanent+Marker&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Ephesis&family=WindSong:wght@500&display=swap" rel="stylesheet">
    <title>ToDo List</title>
</head>

<body id="body" class="container">

<?php switch ($choix) {
    case 'authentification_stop' :
        include('src/PHP_Files/logout.php');
        break;
    case 'todos' :
        include('src/PHP_Files/todos.php');
        break;
    case 'select_task' :
        include('src/PHP_Files/select_tache.php');
        break;
    case 'new_member_formulaire' :
        include('src/PHP_Files/signup.php');
        break;
    case 'signup_reception' :
        include('src/PHP_Files/signup_reception.php');
        break;
    case 'se_connecter' :
        include('src/PHP_Files/login.php');
        break;
    default :
        include('src/PHP_Files/login.php');
}
?>
<script>
    $(document).ready(function () {
        if (!<?php echo isset($_SESSION['login'])?'true':'false'; ?>) {
            $(".login_window").show();
            console.log("not logged")
        } else {
            $(".div_log").show();
            $(".container").show();
            checkCrossOut();
        }

        // ADD NEW TO DO INTO DATABASE
        $('.btn-form').click(function (e) {
            e.preventDefault();
            var tache = $('#tache').val();

            if (tache !== "") {
                $.ajax({
                    type: "POST",
                    url: "src/PHP_Files/insert_tache.php",
                    data: {
                        tache: tache
                    },
                    success: function (data) {
                        $('.form_task')[0].reset();
                                $('#displaydata').html(data);
                                checkCrossOut();
                    }
                });
            } else {
                alert("Nothing to do?");
            }
            $(".countChar").html("0/80");
        });

        //NB CHAR INPUT
        $('.tache').keydown(function (e) {
            var tache = $(".tache").val();

            if (e.keyCode !== 8) {
                if (this.value.length >= 80) {
                    return false;
                } else {
                    $(".countChar").html((tache.length + 1) + "/80");
                }
            } else {
                if (this.value.length > 0 && this.value.length <= 80) {
                    $(".countChar").html((tache.length - 1) + "/80");
                }
            }
        });

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
    })

    // CHECK TO DO
    // function on button
    var cookieTable = [];
    function crossOut(e) {
        if (!e.parentElement.parentElement.children[0].classList.contains("line-through")) {
            console.log(e);
            e.parentElement.parentElement.children[0].classList.add("line-through");
            e.parentElement.parentElement.children[0].classList.remove("no-underline");
            e.parentElement.parentElement.classList.add("opacity-40","bg-green-400");

            e.parentElement.parentElement.children[0].classList.remove("text-black");
            e.parentElement.parentElement.children[0].classList.add("text-white");

            e.parentElement.children[0].classList.remove("text-black");
            e.parentElement.children[1].classList.remove("text-black");
            e.parentElement.children[2].classList.remove("text-black");
            e.parentElement.children[0].classList.remove("hover:text-green-200");
            e.parentElement.children[1].classList.remove("hover:text-green-200");
            e.parentElement.children[2].classList.remove("hover:text-green-200");

            e.parentElement.children[0].classList.add("text-white");
            e.parentElement.children[1].classList.add("text-white");
            e.parentElement.children[2].classList.add("text-white");
            e.parentElement.children[0].classList.add("hover:text-red-700");
            e.parentElement.children[1].classList.add("hover:text-red-700");
            e.parentElement.children[2].classList.add("hover:text-red-700");
            e.parentElement.children[1].setAttribute("disabled","");

            cookieTable = JSON.parse(localStorage.getItem('strike')) || [];
            const id = e.dataset['id'];
            cookieTable.push(id);
            localStorage.setItem('strike', JSON.stringify(cookieTable));
        }else {
            e.parentElement.parentElement.children[0].classList.add("no-underline");
            e.parentElement.parentElement.children[0].classList.remove("line-through");

            e.parentElement.parentElement.classList.remove("opacity-40","bg-green-400");

            e.parentElement.parentElement.children[0].classList.remove("text-white");
            e.parentElement.parentElement.children[0].classList.add("text-black");

            e.parentElement.children[0].classList.add("text-black");
            e.parentElement.children[1].classList.add("text-black");
            e.parentElement.children[2].classList.add("text-black");
            e.parentElement.children[0].classList.remove("hover:text-red-700");
            e.parentElement.children[1].classList.remove("hover:text-red-700");
            e.parentElement.children[2].classList.remove("hover:text-red-700");

            e.parentElement.children[0].classList.remove("text-white");
            e.parentElement.children[1].classList.remove("text-white");
            e.parentElement.children[2].classList.remove("text-white");
            e.parentElement.children[0].classList.add("hover:text-green-200");
            e.parentElement.children[1].classList.add("hover:text-green-200");
            e.parentElement.children[2].classList.add("hover:text-green-200");

            e.parentElement.children[1].removeAttribute("disabled");

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
            for (var i = 0; i < todos.length; i++){
                todos[i].classList.add("text-black");

                todos[i].parentElement.children[1].children[0].classList.add("text-black");
                todos[i].parentElement.children[1].children[1].classList.add("text-black");
                todos[i].parentElement.children[1].children[2].classList.add("text-black");

                todos[i].parentElement.children[1].children[0].classList.add("hover:text-green-200");
                todos[i].parentElement.children[1].children[1].classList.add("hover:text-green-200");
                todos[i].parentElement.children[1].children[2].classList.add("hover:text-green-200");
                for (var j = 0; j < storage.length; j++) {
                    if (todos[i].dataset['id'] === storage[j]) {
                        todos[i].classList.add("line-through");
                        todos[i].parentElement.classList.add("opacity-40","bg-green-400");

                        todos[i].classList.remove("text-black");

                        todos[i].parentElement.children[1].children[0].classList.remove("text-black");
                        todos[i].parentElement.children[1].children[1].classList.remove("text-black");
                        todos[i].parentElement.children[1].children[2].classList.remove("text-black");

                        todos[i].parentElement.children[1].children[0].classList.remove("hover:text-green-200");
                        todos[i].parentElement.children[1].children[1].classList.remove("hover:text-green-200");
                        todos[i].parentElement.children[1].children[2].classList.remove("hover:text-green-200");

                        todos[i].classList.add("text-white");

                        todos[i].parentElement.children[1].children[0].classList.add("text-white");
                        todos[i].parentElement.children[1].children[1].classList.add("text-white");
                        todos[i].parentElement.children[1].children[2].classList.add("text-white");

                        todos[i].parentElement.children[1].children[0].classList.add("hover:text-red-700");
                        todos[i].parentElement.children[1].children[1].classList.add("hover:text-red-700");
                        todos[i].parentElement.children[1].children[2].classList.add("hover:text-red-700");

                        todos[i].parentElement.children[1].children[1].setAttribute("disabled","");
                    }
                }
            }
        }
    }
    function fonction_voir_mdp() {
        var mdp = document.getElementById("password");
        if (mdp.type === "password") {
            mdp.type = "text";
        } else {
            mdp.type = "password";
        }
    }
    function fonction_voir_mdp_inscription(){
        var mdpConf = document.getElementById("conf_password");
        var mdp = document.getElementById("password");
        if (mdp.type === "password" && mdpConf.type === "password") {
            mdp.type = "text";
            mdpConf.type = "text";
        } else {
            mdp.type = "password";
            mdpConf.type = "password"
        }
    }
</script>
</body>
</html>