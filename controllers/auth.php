<?php
session_start();
include_once '../models/Usuario.php';

$usuarioModel = new Usuario();

// --- LOGOUT (CERRAR SESIÓN) ---
if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {
    session_destroy(); // Destruir la sesión
    header("Location: ../login.php");
    exit();
}

// --- LOGIN (INICIAR SESIÓN) ---
if (isset($_POST['cuenta']) && isset($_POST['clave'])) {
    $cuenta = $_POST['cuenta'];
    $clave = $_POST['clave'];

    $usuario = $usuarioModel->login($cuenta, $clave);

    if ($usuario) {
        // Guardar datos en sesión
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        
        // CORRECCIÓN CLAVE: Guardamos 'nombres' de la BD en la variable 'nombre' (singular)
        // Esto arregla el error "Undefined array key 'nombre'"
        $_SESSION['nombre'] = $usuario['nombres']; 
        
        $_SESSION['rol'] = $usuario['id_rol']; // 1: Admin, 2: Empleado
        $_SESSION['cuenta'] = $usuario['cuenta']; 
        
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: ../login.php?error=credenciales");
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>