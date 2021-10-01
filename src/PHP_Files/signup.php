<?php
if (isset($_GET['mess'])) {
    $mess = $_GET['mess'];
    switch ($mess) {
        case 'err_mdp' :
            echo ("<p>Wrong password</p> \r\n");
            break;
        case 'err_login' :
            echo ("<p>Already exists. Choose another</p> \r\n");
            break;
        default :
            echo ("<p>Error message not supported</p> \r\n");
            break;
    }
}
?>
<div class="">
    <div class="col-sm-6 offset-sm-3 text-center">
        <form id='form_inscription' class="justify-content-center text-center" method="POST" action="index.php?choix=new_member_reception">

            <div id="form-group0" class="form-group">
                <label for="login" class="control-label"><b>Login</b></label>
                <input id="login_" name="login" class="form-control" type="text">
                <span id="form-text0" class="form-text" style="display: none;">Minimum 6 caractères</span>
            </div>

            <div id="form-group1" class="form-group">
                <label for="password" class="control-label"><b>Password </b></label>
                <input id="password_inscription" name="password" class="form-control" type="password">
                <span id="form-text1" class="form-text" style="display: none;">Mot de passe : minimum 3 caractères et minimum 2 chiffres</span>
            </div>

            <div class='form-group'>
                <label for="password_conf"><b>Confirmez le password </b></label>
                <input id="password_conf" name="password_conf" type="password" class="form-control" required>
            </div>

            <label>
                <input id="voir_mdp" name="voir_mdp" type="checkbox" onclick="fonction_voir_mdp_inscription()"> Voir le mot de passe
            </label>
            <button id="button_submit" type="SUBMIT" class="btn btn-danger">S'inscrire</button>
        </form>
    </div>
</div>