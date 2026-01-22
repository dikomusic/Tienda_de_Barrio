<?php
session_start();
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configuración</title>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main" style="display:flex; justify-content:center; align-items:flex-start;">
        
        <div class="kpi-card" style="display:block; width: 450px; text-align:center; padding: 40px;">
            
            <div style="width: 80px; height: 80px; background: var(--primary-light); color: var(--primary); border-radius: 50%; display:flex; align-items:center; justify-content:center; font-size:30px; font-weight:800; margin: 0 auto 20px;">
                <?php echo strtoupper(substr($_SESSION['nombre'], 0, 1)); ?>
            </div>

            <h2 class="page-title" style="font-size: 22px; margin-bottom: 5px;">
                <?php echo $_SESSION['nombre']; ?>
            </h2>
            <p style="color: var(--text-muted); margin-bottom: 30px; font-weight: 500; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">
                <?php echo ($_SESSION['rol'] == 1) ? 'Administrador del Sistema' : 'Vendedor / Cajero'; ?>
            </p>

            <div style="text-align: left; background: var(--bg-body); padding: 15px; border-radius: 8px; margin-bottom: 30px; border: 1px solid var(--border);">
                <small style="color: var(--text-muted); display:block; margin-bottom:5px;">Usuario de Acceso:</small>
                <strong style="color: var(--text-main); font-size: 16px;">
                    <?php echo isset($_SESSION['cuenta']) ? $_SESSION['cuenta'] : 'No definido'; ?>
                </strong>
            </div>

            <?php if(isset($_GET['mensaje'])): ?>
                <div style="background: var(--bg-success); color: var(--success); padding: 10px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; font-size: 13px;">
                    ✅ Contraseña actualizada correctamente.
                </div>
            <?php endif; ?>
            <?php if(isset($_GET['error'])): ?>
                <div style="background: var(--bg-danger); color: var(--danger); padding: 10px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; font-size: 13px;">
                    ⛔ <?php echo ($_GET['error'] == 'no_coinciden') ? 'Las contraseñas no coinciden' : 'La contraseña es muy corta'; ?>
                </div>
            <?php endif; ?>

            <button onclick="abrirModal()" class="btn btn-primary" style="width: 100%; justify-content: center; margin-bottom: 15px; padding: 15px;">
                🔒 Cambiar Contraseña
            </button>

            <a href="../../controllers/auth.php?accion=logout" class="btn btn-danger" style="width: 100%; justify-content: center; background: white; border: 1px solid var(--danger); color: var(--danger);">
                Cerrar Sesión
            </a>
        </div>

    </div>

    <div id="modalClave" class="modal-overlay">
        <div class="modal-box">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h3 class="panel-title" style="margin-bottom: 20px;">Nueva Contraseña</h3>
            
            <form action="../../controllers/UsuarioController.php" method="POST">
                <input type="hidden" name="accion" value="cambiar_pass_perfil">
                
                <div class="form-group">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="clave" class="form-input" placeholder="Mínimo 4 caracteres" required>
                </div>

                <div class="form-group">
                    <label>Repetir Contraseña</label>
                    <input type="password" name="confirmar" class="form-input" placeholder="Escríbela de nuevo" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">
                    GUARDAR CAMBIOS
                </button>
            </form>
        </div>
    </div>

    <script>
        function abrirModal() { document.getElementById('modalClave').style.display = 'flex'; }
        function cerrarModal() { document.getElementById('modalClave').style.display = 'none'; }
    </script>

</body>
</html>