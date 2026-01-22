<?php
session_start();
include_once '../models/Usuario.php';

// 1. VALIDACIÓN BÁSICA: ¿Está logueado?
if (!isset($_SESSION['id_usuario'])) { 
    header("Location: ../login.php"); 
    exit(); 
}

$modelo = new Usuario();

// ==========================================================
// ZONA PÚBLICA (ACCIONES PARA CUALQUIER EMPLEADO O ADMIN)
// ==========================================================

// --- CAMBIAR MI PROPIA CONTRASEÑA (Desde Perfil) ---
if (isset($_POST['accion']) && $_POST['accion'] == 'cambiar_pass_perfil') {
    $id = $_SESSION['id_usuario']; // Usamos el ID de la sesión (Seguro)
    $clave = $_POST['clave'];
    $confirmar = $_POST['confirmar'];

    // Validaciones
    if ($clave != $confirmar) {
        header("Location: ../views/configuracion/index.php?error=no_coinciden");
        exit();
    }
    if (strlen($clave) < 4) {
        header("Location: ../views/configuracion/index.php?error=muy_corta");
        exit();
    }

    // Ejecutar cambio
    $modelo->cambiarPropiaClave($id, $clave);
    header("Location: ../views/configuracion/index.php?mensaje=clave_actualizada");
    exit();
}

// ==========================================================
// ZONA RESTRINGIDA (SOLO ADMINISTRADORES)
// ==========================================================

// Si intenta hacer algo de abajo y NO es admin (Rol 1), lo expulsamos.
if ($_SESSION['rol'] != 1) {
    header("Location: ../index.php?error=acceso_denegado");
    exit();
}

// --- CREAR O EDITAR OTROS USUARIOS ---
if (isset($_POST['accion'])) {
    $id = $_POST['id_usuario'];
    $ci = $_POST['ci'];
    $nombres = $_POST['nombres'];
    $apaterno = $_POST['apellido_paterno'];
    $amaterno = $_POST['apellido_materno'];
    $rol = $_POST['rol'];

    if ($_POST['accion'] == 'guardar') {
        $modelo->crear($ci, $nombres, $apaterno, $amaterno, $rol);
        header("Location: ../views/usuarios/index.php?mensaje=creado");
    } elseif ($_POST['accion'] == 'editar') {
        $modelo->actualizar($id, $ci, $nombres, $apaterno, $amaterno, $rol);
        header("Location: ../views/usuarios/index.php?mensaje=actualizado");
    }
    exit();
}

// --- RESTABLECER CLAVE DE OTRO USUARIO ---
if (isset($_GET['accion']) && $_GET['accion'] == 'restablecer') {
    $id = $_GET['id'];
    $modelo->restablecerClave($id);
    header("Location: ../views/usuarios/index.php?mensaje=restablecido");
    exit();
}

// --- CAMBIAR ESTADO (ACTIVAR/DESACTIVAR) ---
if (isset($_GET['accion']) && $_GET['accion'] == 'estado') {
    $id = $_GET['id'];
    $estado = $_GET['estado'];
    
    if ($id == $_SESSION['id_usuario'] && $estado == 0) {
        header("Location: ../views/usuarios/index.php?error=auto_desactivar");
        exit();
    }

    $modelo->cambiarEstado($id, $estado);
    header("Location: ../views/usuarios/index.php?mensaje=estado_cambiado");
    exit();
}
?>