<?php
session_start();
session_destroy(); // Destruye toda la info de la sesión
header("Location: login.php");
exit();
?>