<?php
session_start();
include_once '../models/Usuario.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../index.php"); exit(); }

$modelo = new Usuario();

if (isset($_POST['accion'])) {
    // Recogemos TODOS los datos del diagrama
    $ci = $_POST['ci'];
    $nombres = trim($_POST['nombres']);
    $paterno = trim($_POST['paterno']);
    $materno = trim($_POST['materno']);
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $nacimiento = $_POST['nacimiento'];
    $rol = $_POST['id_rol'];

    // ACCIÓN: REGISTRAR (RF-03 y RF-04)
    // CASO 1: REGISTRAR USUARIO
    // CASO 1: REGISTRAR USUARIO
    if ($_POST['accion'] == 'guardar') {
        
        // EXCEPCION 4: Validar CI Duplicado ANTES de guardar
        if ($modelo->existeCI($ci)) {
            header("Location: ../views/usuarios/formulario.php?error=ci_duplicado");
            exit();
        }

        // ALGORITMO DE GENERACION (EXCEPCION 3)
        $l1 = substr(strtolower($nombres), 0, 1);
        $p1 = strtolower(str_replace(' ', '', $paterno));
        $m1 = substr(strtolower($materno), 0, 1);
        
        $base_cuenta = $l1 . $p1 . $m1; // Ej: eguarachia
        $cuenta_final = $base_cuenta;
        $contador = 1;

        // BUCLE: Mientras exista, le agregamos un numero (eguarachia1, eguarachia2...)
        while ($modelo->existeUsuario($cuenta_final)) {
            $cuenta_final = $base_cuenta . $contador; 
            $contador++;
        }
        
        $clave_defecto = "Tienda de Barrio";

        if ($modelo->crear($ci, $nombres, $paterno, $materno, $celular, $direccion, $nacimiento, $cuenta_final, $clave_defecto, $rol)) {
            header("Location: ../views/usuarios/index.php?mensaje=creado&usr=" . $cuenta_final);
        } else {
            header("Location: ../views/usuarios/formulario.php?error=bd");
        }
    }

    // ACCIÓN: MODIFICAR (RF-07)
    if ($_POST['accion'] == 'editar') {
        $id = $_POST['id_usuario'];
        // Nota: En modificar NO cambiamos la clave ni el usuario, según diagrama
        if ($modelo->actualizar($id, $ci, $nombres, $paterno, $materno, $celular, $direccion, $nacimiento, $rol)) {
            header("Location: ../views/usuarios/index.php?mensaje=editado");
        } else {
            header("Location: ../views/usuarios/formulario.php?id=$id&error=bd");
        }
    }
}

// ACCIÓN: RESTABLECER ACCESO (RF-09) - Tal cual diagrama de secuencia
if (isset($_GET['accion']) && $_GET['accion'] == 'restablecer') {
    $id = $_GET['id'];
    $clave_defecto = "Tienda de Barrio";
    
    $modelo->restablecerClave($id, $clave_defecto);
    header("Location: ../views/usuarios/index.php?mensaje=restablecido");
}

// ACCIÓN: INHABILITAR (RF-10)
// EXCEPCION 6: Validar Autobloqueo
    if (isset($_GET['accion']) && $_GET['accion'] == 'estado') {
        $id = $_GET['id'];
        $estado = $_GET['estado'];

        if($id == $_SESSION['id_usuario']) { 
            header("Location: ../views/usuarios/index.php?error=propio"); 
            exit(); 
        }

        $modelo->cambiarEstado($id, $estado);
        header("Location: ../views/usuarios/index.php");
    }
?>