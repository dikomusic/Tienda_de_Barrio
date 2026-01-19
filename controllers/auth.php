<?php
// controllers/auth.php

// 1. ACTIVAR REPORTE DE ERRORES (Para que no salga blanco si falla)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// 2. VERIFICAR QUE EL MODELO EXISTE
$ruta_modelo = '../models/Usuario.php';
if (!file_exists($ruta_modelo)) {
    die("ERROR CRÍTICO: No encuentro el archivo models/Usuario.php. Verifica la carpeta.");
}
include_once $ruta_modelo;

// 3. PROCESAR LOGIN
if (isset($_POST['acceder'])) {
    $cuenta = $_POST['cuenta'];
    $clave = $_POST['clave'];

    $modelo = new Usuario();
    
    // Llamamos a la función login que ya arreglamos
    $resultado = $modelo->login($cuenta, $clave);

    if (is_array($resultado)) {
        // LOGIN EXITOSO
        $_SESSION['id_usuario'] = $resultado['id_usuario'];
        $_SESSION['rol'] = $resultado['id_rol'];
        $_SESSION['nombre'] = $resultado['nombre_completo'];
        
        // Redirigir al menú principal
        header("Location: ../index.php");
        exit();
    } 
    else if ($resultado == "INACTIVO") {
        // EXCEPCIÓN 2
        header("Location: ../login.php?error=inactivo");
        exit();
    } 
    else {
        // EXCEPCIÓN 1 (ERROR_DATOS)
        header("Location: ../login.php?error=datos");
        exit();
    }
} 
else {
    // 4. SI ENTRAS AQUÍ DIRECTO (SIN FORMULARIO)
    echo "<h1>⚠️ ALERTA DE ACCESO INCORRECTO</h1>";
    echo "<p>Estás viendo esta pantalla porque entraste directamente a <b>controllers/auth.php</b>.</p>";
    echo "<p>Este archivo es un motor interno, no una página.</p>";
    echo "<h2>👉 <a href='../login.php'>Haz CLIC AQUÍ para ir al Login Correcto</a></h2>";
    
    // Si tu login está en index.php en vez de login.php, usa este enlace:
    // echo "<h2>👉 <a href='../index.php'>Haz CLIC AQUÍ para ir al Login Correcto</a></h2>";
}
?>