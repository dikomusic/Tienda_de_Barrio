<?php
session_start();
include_once '../models/Proveedor.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../index.php"); exit(); }

$modelo = new Proveedor();

if (isset($_POST['accion'])) {
    $empresa = $_POST['empresa'];
    $vendedor = $_POST['nombre_vendedor'];
    $telefono = $_POST['telefono'];
    $dias = $_POST['dias_visita'];

    if ($_POST['accion'] == 'guardar') {
        $modelo->crear($empresa, $vendedor, $telefono, $dias);
    } 
    elseif ($_POST['accion'] == 'editar') {
        $id = $_POST['id_proveedor'];
        $modelo->actualizar($id, $empresa, $vendedor, $telefono, $dias);
    }
    header("Location: ../views/proveedores/index.php");
}
?>