<?php
if (file_exists('views/sidebar.php')) {
    $path_root = "";
    $path_css  = "css/";
    $path_views = "views/";
} else {
    $path_root = "../../";
    $path_css  = "../../css/";
    $path_views = "../";
}
$url_actual = $_SERVER['REQUEST_URI'];
?>

<link rel="stylesheet" href="<?php echo $path_css; ?>estilos.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="sidebar">
    <div class="sidebar-logo">
        TuCase
        <span><?php echo (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) ? 'ADMINISTRADOR' : 'EMPLEADO'; ?></span>
    </div>
    
    <div class="sidebar-menu">
        <a href="<?php echo $path_root; ?>index.php" class="menu-link <?php echo (strpos($url_actual, 'index.php') !== false && strpos($url_actual, 'views') === false) ? 'active' : ''; ?>">
            <span>📊</span> Panel de Control
        </a>

        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
            <a href="<?php echo $path_views; ?>usuarios/index.php" class="menu-link <?php echo (strpos($url_actual, 'usuarios') !== false) ? 'active' : ''; ?>">
                <span>👥</span> Usuarios
            </a>
        <?php endif; ?>

        <a href="<?php echo $path_views; ?>ventas/registrar.php" class="menu-link <?php echo (strpos($url_actual, 'ventas/registrar.php') !== false) ? 'active' : ''; ?>">
            <span>🛒</span> Punto de Venta
        </a>

        <a href="<?php echo $path_views; ?>compras/registrar.php" class="menu-link <?php echo (strpos($url_actual, 'compras') !== false) ? 'active' : ''; ?>">
            <span>🚚</span> Compras
        </a>

        <a href="<?php echo $path_views; ?>productos/index.php" class="menu-link <?php echo (strpos($url_actual, 'productos') !== false) ? 'active' : ''; ?>">
            <span>📦</span> Productos
        </a>

        <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 1): ?>
            <a href="<?php echo $path_views; ?>reportes/dashboard.php" class="menu-link <?php echo (strpos($url_actual, 'reportes') !== false) ? 'active' : ''; ?>">
                <span>📈</span> Reportes
            </a>
        <?php endif; ?>
    </div>
    
    <a href="<?php echo $path_views; ?>configuracion/index.php" class="config-btn">
        ⚙️ CONFIGURACIÓN
    </a>
</div>