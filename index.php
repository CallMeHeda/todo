<?php
//session_start();
include('src/PHP_Files/connexion_db.php');
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
    <title>To Do List</title>
</head>

<body class="bg-yellow-100">

<h1>To Do List !</h1>
<div class="form-container">
    <form action="" method="POST">
        <input type="text" class="tache" name="tache" placeholder="Thing to remember" required>
        <button class="btn-form">Let's remember! <span>&#43;</span></button>
    </form>
</div>

<?php
if (isset($_POST['tache'])) {
    include('src/PHP_Files/insert_tache.php');
}
include("src/PHP_Files/select_tache.php");

?>

<script>
    $(document).ready(function () {
        $('.remove-to-do').click(function () {
            const id = $(this).attr('id');

            $.post("src/PHP_Files/delete_tache.php",
                {
                    id: id
                },
                (data) => {
                    if (data) {
                        $(this).parent().hide(600);
                    }
                }
            );
        });
    })
</script>


</body>
</html>