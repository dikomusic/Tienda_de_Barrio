<?php
session_start();
include_once '../../models/Usuario.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) { header("Location: ../../index.php"); exit(); }

$modelo = new Usuario();
$usuarios = $modelo->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <?php include '../sidebar.php'; ?>
    <div class="main">
        <div class="page-header">
            <div>
                <h1 class="page-title">Personal y Accesos</h1>
                <p style="color:#666;">Gestión de empleados y cuentas</p>
            </div>
            <button onclick="prepararNuevo()" class="btn-new">+ Nuevo Usuario</button>
        </div>

        <?php if(isset($_GET['mensaje'])): ?>
            <div class="alert alert-green">
                <?php 
                    if($_GET['mensaje']=='creado') echo "✅ Usuario creado. Contraseña: 'Tienda de Barrio'";
                    if($_GET['mensaje']=='restablecido') echo "✅ Contraseña restablecida a 'Tienda de Barrio'";
                    if($_GET['mensaje']=='estado_cambiado') echo "✅ Estado actualizado correctamente.";
                    if($_GET['mensaje']=='actualizado') echo "✅ Datos actualizados.";
                ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['error']) && $_GET['error']=='auto_desactivar'): ?>
            <div class="alert alert-red">⛔ No puedes desactivar tu propia cuenta.</div>
        <?php endif; ?>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>CI</th>
                        <th>Empleado (Nombre Completo)</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th style="text-align:center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $u): 
                        // Preparar nombre completo
                        $nombreCompleto = $u['nombres'] . ' ' . $u['apellido_paterno'] . ' ' . $u['apellido_materno'];
                        $rolTexto = ($u['id_rol'] == 1) ? 'Administrador' : 'Empleado';
                        $estadoTexto = ($u['estado'] == 1) ? 'ACTIVO' : 'INACTIVO';
                    ?>
                    <tr style="<?php echo ($u['estado']==0)?'opacity:0.6; background:#fafafa;':''; ?>">
                        <td><?php echo $u['ci']; ?></td>
                        <td><strong><?php echo $nombreCompleto; ?></strong></td>
                        <td><?php echo $u['cuenta']; ?></td>
                        <td><?php echo $rolTexto; ?></td>
                        <td><?php echo $estadoTexto; ?></td>
                        <td style="text-align:center; white-space: nowrap;">
                            
                            <button class="action-btn btn-edit" title="Modificar Datos"
                                  onclick="editarUsuario(
                                    '<?php echo $u['id_usuario']; ?>',
                                    '<?php echo $u['ci']; ?>',
                                    '<?php echo $u['nombres']; ?>',
                                    '<?php echo $u['apellido_paterno']; ?>',
                                    '<?php echo $u['apellido_materno']; ?>',
                                    '<?php echo $u['id_rol']; ?>'
                                  )">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>

                            <a href="../../controllers/UsuarioController.php?accion=restablecer&id=<?php echo $u['id_usuario']; ?>" 
                               onclick="return confirm('¿Restablecer contraseña del usuario <?php echo $u['cuenta']; ?> a \'Tienda de Barrio\'?')" 
                               class="action-btn btn-reset" title="Restablecer Contraseña">
                               <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                            </a>

                            <?php if($u['estado'] == 1): ?>
                                <a href="../../controllers/UsuarioController.php?accion=estado&id=<?php echo $u['id_usuario']; ?>&estado=0" 
                                   onclick="return confirm('¿Desactivar acceso?')"
                                   class="action-btn btn-danger" title="Desactivar">
                                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"></path><line x1="12" y1="2" x2="12" y2="12"></line></svg>
                                </a>
                            <?php else: ?>
                                <a href="../../controllers/UsuarioController.php?accion=estado&id=<?php echo $u['id_usuario']; ?>&estado=1" 
                                   class="action-btn btn-success" title="Activar">
                                   <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"></path></svg>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalUsuario" class="modal-overlay">
        <div class="modal-box">
            <span class="close-modal" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle" style="margin-bottom:20px;">Nuevo Usuario</h2>
            
            <form action="../../controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="accion" id="formAccion" value="guardar">
                <input type="hidden" name="id_usuario" id="formId">

                <div class="form-group"><label>C.I.</label><input type="text" name="ci" id="inCI" class="form-input" required></div>
                <div class="form-group"><label>Nombres</label><input type="text" name="nombres" id="inNom" class="form-input" required></div>
                <div class="form-group"><label>Apellido Paterno</label><input type="text" name="apellido_paterno" id="inPat" class="form-input" required></div>
                <div class="form-group"><label>Apellido Materno</label><input type="text" name="apellido_materno" id="inMat" class="form-input" required></div>
                
                <div class="form-group">
                    <label>Rol</label>
                    <select name="rol" id="inRol" class="form-input">
                        <option value="2">Empleado</option>
                        <option value="1">Administrador</option>
                    </select>
                </div>

                <p style="font-size:12px; color:#666; margin-top:20px; background:#eee; padding:10px; border-radius:5px;">
                    ℹ️ El usuario se genera automáticamente. <br>
                    ℹ️ Contraseña por defecto: <strong>Tienda de Barrio</strong>
                </p>

                <button type="submit" class="btn-save" id="btnText">GUARDAR DATOS</button>
            </form>
        </div>
    </div>

    <script>
        function closeModal() { document.getElementById('modalUsuario').style.display = 'none'; }
        
        function prepararNuevo() {
            document.getElementById('modalUsuario').style.display = 'flex';
            document.getElementById('modalTitle').innerText = "Nuevo Usuario";
            document.getElementById('formAccion').value = "guardar";
            document.getElementById('formId').value = "";
            document.getElementById('btnText').innerText = "GUARDAR DATOS";
            document.getElementById('inCI').value = ""; document.getElementById('inNom').value = ""; document.getElementById('inPat').value = ""; document.getElementById('inMat').value = ""; 
        }

        function editarUsuario(id, ci, nom, pat, mat, rol) {
            document.getElementById('modalUsuario').style.display = 'flex';
            document.getElementById('modalTitle').innerText = "Modificar Usuario";
            document.getElementById('formAccion').value = "editar";
            document.getElementById('formId').value = id;
            document.getElementById('btnText').innerText = "GUARDAR CAMBIOS";
            document.getElementById('inCI').value = ci;
            document.getElementById('inNom').value = nom;
            document.getElementById('inPat').value = pat;
            document.getElementById('inMat').value = mat;
            document.getElementById('inRol').value = rol;
        }
    </script>
</body>
</html>