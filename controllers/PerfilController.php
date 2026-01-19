<?php
session_start();
include_once '../models/Usuario.php';

// Seguridad: Debe estar logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
    exit();
}

$modelo = new Usuario();

if (isset($_POST['accion']) && $_POST['accion'] == 'cambiar_clave') {
    $id = $_SESSION['id_usuario'];
    $actual = $_POST['clave_actual'];
    $nueva = $_POST['clave_nueva'];
    $confirmar = $_POST['clave_confirmar'];

    // 1. Validar que las nuevas coincidan
    if ($nueva != $confirmar) {
        header("Location: ../views/perfil/cambiar_clave.php?error=no_coinciden");
        exit();
    }

    // 2. Validar contra la base de datos (Diagrama de Secuencia)
    $clave_en_bd = $modelo->obtenerClaveActual($id);

    if ($actual == $clave_en_bd) {
        // 3. Todo correcto: Actualizamos
        if ($modelo->cambiarClavePropia($id, $nueva)) {
            header("Location: ../views/perfil/cambiar_clave.php?mensaje=exito");
        } else {
            header("Location: ../views/perfil/cambiar_clave.php?error=bd");
        }
    } else {
        // Error: La clave actual ingresada está mal
        header("Location: ../views/perfil/cambiar_clave.php?error=clave_incorrecta");
    }
}
?>