<?php
//session_start();
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    switch ($msg) {
        case 'err_sql' :
            echo("<p>SQL ERROR</p> \r\n");
            break;
        case 'err_login' :
            echo("<p>Login doesn't exists</p> \r\n");
            break;
        case 'err_password' :
            echo("<p>Wrong password</p> \r\n");
            break;
        default :
            echo("<p>Error message not supported</p> \r\n");
            break;
    }
}
if (!isset($_SESSION['login'])) {
    ?>
    <div class="login_window">
        <div class="bg-login">
            <div class="login-left-side">
                <h1 class="text-3xl md:text-5xl font-bold text-white my-2 md:my-0">
                    Todo list
                </h1>
                <p class="letsRemember">
                    Let's Remember!
                </p>
            </div>
            <div class="w-full md:w-1/2 flex flex-col items-center bg-white py-5 md:py-8 px-4">

                <h3 class="mb-4 font-bold text-3xl flex items-center text-red-500">
                    LOGIN
                </h3>

                <form action="index.php?choix=authentification_start" method="POST"
                      class="px-3 flex flex-col justify-center items-center w-full gap-3">

                    <input
                            type="text" id="login"
                            class="px-4 py-2 w-full rounded border border-gray-300 shadow-sm text-base placeholder-gray-500 placeholder-opacity-50 focus:outline-none focus:border-blue-500"
                            placeholder="login" name="login">
                    <input type="password" placeholder="password"
                           class="px-4 py-2 w-full rounded border border-gray-300 shadow-sm text-base placeholder-gray-500 placeholder-opacity-50 focus:outline-none focus:border-blue-500"
                           id="password" name="password">

                    <label>
                        <input id="voir_mdp" name="show_password" type="checkbox" onclick="fonction_voir_mdp()">
                        <span class="ml-4 text-sm">Show password</span>
                    </label>

                    <button class="btn-log" type="submit">
                        <i class="far fa-sign-in-alt fa-flip-horizontal"></i>
                        <p class="ml-1 text-lg">Login</p>
                    </button>
                </form>
                <p class="text-gray-700 text-sm mt-2">
                    don't have an account?
                    <a href="index.php?choix=new_member_formulaire"
                       class="text-green-400 hover:text-green-600 mt-3 focus:outline-none font-bold underline">
                        register
                    </a>
                </p>
            </div>
        </div>
    </div>
    <?php
} else {
    include("src/PHP_Files/todos.php");
}
?>