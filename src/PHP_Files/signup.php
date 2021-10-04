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
                SIGN UP
            </h3>

            <form action="index.php?choix=signup_reception" method="POST"
                  class="px-3 flex flex-col justify-center items-center w-full gap-3">

                <input
                        type="text" id="login"
                        class="px-4 py-2 w-full rounded border border-gray-300 shadow-sm text-base placeholder-gray-500 placeholder-opacity-50 focus:outline-none focus:border-blue-500"
                        placeholder="login" name="login">
                <?php if (isset($_GET['mess'])) {
                    if ($_GET['mess'] == 'err_login') {
                        echo("<p class='relative -top-2.5 text-red-600 text-sm'>Login already exists</p>");
                    }
                }
                ?>

                <input type="password" placeholder="password"
                       class="px-4 py-2 w-full rounded border border-gray-300 shadow-sm text-base placeholder-gray-500 placeholder-opacity-50 focus:outline-none focus:border-blue-500"
                       id="password" name="password">

                <input type="password" placeholder="confirm password"
                       class="px-4 py-2 w-full rounded border border-gray-300 shadow-sm text-base placeholder-gray-500 placeholder-opacity-50 focus:outline-none focus:border-blue-500"
                       id="conf_password" name="conf_password">
                <?php if (isset($_GET['mess'])) {
                    if ($_GET['mess'] == 'err_password') {
                        echo("<p class='relative -top-2.5 text-red-600 text-sm'>Passwords doesn't match</p>");
                    }
                }
                ?>
                <label>
                    <input id="voir_mdp" name="show_password" type="checkbox" onclick="fonction_voir_mdp_inscription()">
                    <span class="ml-4 text-sm">Show password</span>
                </label>

                <button class="btn-log" type="submit">
                    <i class="far fa-sign-in-alt fa-flip-horizontal"></i>
                    <p class="ml-1 text-lg">Sign up</p>
                </button>
            </form>
        </div>
    </div>
</div>