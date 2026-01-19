<?php
// login.php
session_start();
if (isset($_SESSION['id_usuario'])) {
    header("Location: index.php"); // Si ya entró, mandar al menú
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Sistema</title>
</head>
<body>
    <center>
        <h2>ACCESO AL SISTEMA</h2>
        <h3>TIENDA DE BARRIO</h3>

        <?php if(isset($_GET['error'])): ?>
            <div style="border: 1px solid red; color: red; padding: 10px; width: 300px;">
                <strong>ERROR:</strong>
                <?php 
                    if($_GET['error'] == 'datos') echo "Usuario o contraseña incorrectos.";
                    if($_GET['error'] == 'inactivo') echo "Cuenta inhabilitada. Contacte al Administrador.";
                ?>
            </div>
            <br>
        <?php endif; ?>

        <form action="controllers/auth.php" method="POST" autocomplete="off">
            <label>Usuario:</label><br>
            <input type="text" name="cuenta" required autocomplete="off" required placeholder="Ej: admin"><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="clave" required autocomplete="new-password"><br><br>

            <button type="submit" name="acceder">INGRESAR</button>
        </form>
    </center>
</body>
</html>