<?php
// prueba_error.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🔍 Diagnóstico del Sistema</h1>";

// 1. Verificar ruta de conexión
$ruta = __DIR__ . '/config/conexion.php';
echo "1. Buscando archivo de conexión... ";
if (file_exists($ruta)) {
    echo "<span style='color:green'>ENCONTRADO (OK)</span><br>";
    include_once $ruta;
} else {
    die("<span style='color:red'>ERROR: No existe config/conexion.php</span>");
}

// 2. Verificar la Clase Conexion
echo "2. Verificando Clase Conexion... ";
if (class_exists('Conexion')) {
    echo "<span style='color:green'>CARGADA (OK)</span><br>";
} else {
    die("<span style='color:red'>ERROR: El archivo existe pero no tiene la clase 'Conexion'.</span>");
}

// 3. Probar Conexión a Base de Datos
echo "3. Intentando conectar a MySQL... ";
try {
    $db = new Conexion();
    $conn = $db->getConexion();
    if ($conn) {
        echo "<span style='color:green'>CONECTADO EXITOSAMENTE (OK)</span><br>";
    } else {
        echo "<span style='color:red'>FALLÓ (Null)</span><br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red'>ERROR: " . $e->getMessage() . "</span><br>";
}

// 4. Intentar cargar el Modelo Usuario
echo "4. Cargando Modelo Usuario... ";
$ruta_modelo = __DIR__ . '/models/Usuario.php';
if (file_exists($ruta_modelo)) {
    include_once $ruta_modelo;
    echo "<span style='color:green'>ARCHIVO INCLUIDO (OK)</span><br>";
    
    if (class_exists('Usuario')) {
        echo "<span style='color:green'>CLASE USUARIO EXISTE (OK)</span><br>";
    } else {
        echo "<span style='color:red'>ERROR: El archivo models/Usuario.php tiene errores de sintaxis o no define la clase.</span>";
    }
} else {
    echo "<span style='color:red'>ERROR: No existe models/Usuario.php</span>";
}
?>