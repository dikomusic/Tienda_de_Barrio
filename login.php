<?php
session_start();
// Si ya está dentro, lo mandamos al panel directamente
if (isset($_SESSION['id_usuario'])) { header("Location: index.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso | TuCase</title>
    
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Estilos exclusivos para centrar el Login */
        body {
            background-color: var(--primary-dark); /* Azul Noche */
            display: flex; justify-content: center; align-items: center;
            height: 100vh;
            background-image: radial-gradient(circle at top right, #1e293b 0%, var(--primary-dark) 40%);
        }
        
        .login-card {
            background: white;
            width: 400px;
            padding: 45px 40px;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Barra decorativa arriba */
        .login-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--success));
        }

        .brand { font-size: 32px; font-weight: 900; color: var(--primary-dark); margin-bottom: 5px; letter-spacing: -1px; }
        .subtitle { font-size: 14px; color: var(--text-muted); margin-bottom: 35px; display: block; font-weight: 500; }
        
        .forgot-link {
            display: block; margin-top: 20px; font-size: 13px; 
            color: var(--text-muted); text-decoration: none; font-weight: 600;
            transition: 0.2s; cursor: pointer;
        }
        .forgot-link:hover { color: var(--primary); text-decoration: underline; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand">TuCase</div>
        <span class="subtitle">Ingresa tus credenciales para continuar</span>

        <?php if(isset($_GET['error'])): ?>
            <div style="background: var(--bg-danger); color: var(--danger); padding: 12px; border-radius: 12px; font-size: 13px; font-weight: 700; margin-bottom: 25px; border: 1px solid rgba(239, 68, 68, 0.2);">
                🚫 Usuario o contraseña incorrectos
            </div>
        <?php endif; ?>

        <form action="controllers/auth.php" method="POST">
            <div style="text-align: left; margin-bottom: 20px;">
                <label style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; display: block; text-transform: uppercase;">Usuario</label>
                <input type="text" name="cuenta" class="form-input" placeholder="Ej: admin" required style="background: #f8fafc;">
            </div>

            <div style="text-align: left; margin-bottom: 30px;">
                <label style="font-size: 12px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; display: block; text-transform: uppercase;">Contraseña</label>
                <input type="password" name="clave" class="form-input" placeholder="••••••••" required style="background: #f8fafc;">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 16px; font-size: 15px; border-radius: 12px;">
                Iniciar Sesión
            </button>
        </form>

        <a onclick="abrirOlvido()" class="forgot-link">¿Olvidaste tu contraseña?</a>
        
        <p style="margin-top: 40px; font-size: 11px; color: #cbd5e1;">
            &copy; <?php echo date('Y'); ?> TuCase System • Versión 1.0
        </p>
    </div>


    <div id="modalOlvido" class="modal-overlay">
        <div class="modal-box" style="text-align: center; width: 400px;">
            <span class="close-modal" onclick="cerrarOlvido()">&times;</span>
            
            <div style="width: 60px; height: 60px; background: var(--bg-warning); color: var(--warning); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 30px;">
                🔒
            </div>

            <h3 class="panel-title" style="font-size: 18px; margin-bottom: 10px;">Recuperación de Acceso</h3>
            
            <p style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 25px;">
                Por motivos de seguridad, el restablecimiento de contraseñas es manual.
                <br><br>
                Por favor, contacta al <strong>Administrador del Sistema</strong> para que te asigne una nueva clave temporal.
            </p>

            <button onclick="cerrarOlvido()" class="btn btn-primary" style="width: 100%; justify-content: center;">
                Entendido, gracias
            </button>
        </div>
    </div>

    <script>
        function abrirOlvido() {
            document.getElementById('modalOlvido').style.display = 'flex';
        }
        function cerrarOlvido() {
            document.getElementById('modalOlvido').style.display = 'none';
        }
        
        // Cerrar si hacen clic fuera de la cajita
        window.onclick = function(event) {
            var modal = document.getElementById('modalOlvido');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>
</html>