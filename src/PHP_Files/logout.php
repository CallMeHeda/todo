<?php
session_destroy();
unset($_SESSION);
header("Location:index.php?choix=se_connecter");
exit();
?>