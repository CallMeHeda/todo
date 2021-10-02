        <?php if (isset($_SESSION['login'])) { ?>
            <div class="mr-auto ml-auto container">
            <div class="logout">
                <a href="index.php?choix=authentification_stop"><i class="fas fa-sign-out-alt fa-lg"></i></a>
            </div>
            <h1><span>TODO</span> List</h1>
            <span class="loginUser"><?php echo $_SESSION['login']; ?></span>
            <div class="form-container">
                <form action="" method="POST" class="form_task">
                    <input type="text" class="tache" name="tache" id="tache" maxlength="80"
                           placeholder="Thing to remember" autocomplete="off" required><span
                            class="countChar">0/80</span>
                    <button class="btn-form">Let's remember!</button>
                </form>
            </div>
            <div id="displaydata" class="logged"><?php include('src/PHP_Files/insert_tache.php'); ?></div>
        <?php } ?>