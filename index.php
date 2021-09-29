<?php
//session_start();
//include('src/PHP_Files/connexion_db.php');
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
    <title>ToDo List</title>
</head>

<body class="bg-yellow-50" id="body">

<h1><span>ToDo</span> List</h1>
<div class="form-container">
    <form action="" method="POST">
        <input type="text" class="tache" name="tache" id="tache" maxlength="80" placeholder="Thing to remember" autocomplete="off" required><span class="countChar">0/80</span>
        <button class="btn-form">Let's remember!</button>
    </form>
</div>
<!--TO DO-->
<div id="displaydata"><?php include('src/PHP_Files/select_tache.php'); ?></div>
<script>
    $(document).ready(function () {
        // $(function () {
        //     $('body').css('visibility', 'visible');
        // });
        checkCrossOut();
        // ADD NEW TODO
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
                    success: function () {
                        $('form')[0].reset();
                        // $("#displaydata").load('src/PHP_Files/select_tache.php');
                        // checkCrossOut();
                    }
                });
                // DISPLAY TO DO
                selectTask = tache;
                $.ajax({
                    type: "GET",
                    url: "src/PHP_Files/select_tache.php",
                    contentType: "application/json",
                    data: {
                        tache : selectTask
                    },
                    datatype: 'json',
                    success: function (data) {
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
    })
</script>
</body>
</html>