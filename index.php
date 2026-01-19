<?php
// index.php
session_start();

// Validar seguridad: Si no hay usuario en sesión, a la calle (al login)
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Tienda</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?>!</h1>
    <p>Tu rol es: <?php echo ($_SESSION['rol'] == 1) ? 'ADMINISTRADOR' : 'EMPLEADO'; ?></p>
    
    <hr>
    
    <nav>
        <ul>
            <li>
                <a href="views/productos/index.php">Gestión de Productos</a>
            </li>

            <li>
                <a href="views/ventas/registrar.php">Realizar Venta</a>
            </li>
            
            <li>
                <a href="views/compras/registrar.php">Compras (Abastecimiento)</a>
            </li>

            <li>
                <a href="views/perfil/cambiar_clave.php">Cambiar Mi Contraseña</a>
            </li>

            <?php if($_SESSION['rol'] == 1): ?>
                
                <li>
                    <a href="views/reportes/dashboard.php">Reportes y Estadísticas</a>
                </li>

                <li>
                    <a href="views/usuarios/index.php">Gestión de Usuarios</a>
                </li>

            <?php endif; ?>

            <hr>

            <li>
                <a href="logout.php">Cerrar Sesión</a>
            </li>
        </ul>
    </nav>
</body>
</html>