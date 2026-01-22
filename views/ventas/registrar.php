<?php
session_start();
if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }

$total_venta = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Punto de Venta</title>
    <style>
        /* ESTILOS (Idénticos a Compras/Productos) */
        * { box-sizing: border_box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        body { display: flex; background-color: #f4f4f4; height: 100vh; overflow: hidden; }
        
     
        .config-btn { background-color: #000099; text-align: center; padding: 15px; text-decoration: none; color: white; font-weight: bold; }

        .main { flex-grow: 1; padding: 30px; display: flex; flex-direction: column; }
        
        /* TABS (Igual que en Compras) */
        .top-tabs { display: flex; gap: 10px; margin-bottom: 20px; }
        .tab { padding: 10px 20px; background: #ddd; border-radius: 20px; text-decoration: none; color: #666; font-weight: bold; }
        .tab.active { background: #ccc; color: black; border: 1px solid #999; }

        /* CAJA DE BUSQUEDA MEJORADA */
        .pos-header { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; gap: 15px; margin-bottom: 20px; align-items: flex-end; }
        
        .input-group { display: flex; flex-direction: column; gap: 5px; }
        .input-group label { font-size: 12px; font-weight: bold; color: #666; }
        
        .qty-input { width: 100px; padding: 15px; font-size: 18px; border: 2px solid #ddd; border-radius: 10px; text-align: center; }
        .scan-input { flex-grow: 1; padding: 15px; font-size: 18px; border: 2px solid #0000CC; border-radius: 10px; outline: none; }
        .btn-add { background: #0000CC; color: white; border: none; padding: 15px 30px; border-radius: 10px; font-weight: bold; cursor: pointer; font-size: 16px; height: 56px; }

        /* AREA DE LISTA Y TOTALES */
        .pos-container { display: flex; gap: 20px; flex-grow: 1; overflow: hidden; }
        
        .list-section { flex-grow: 1; background: white; border-radius: 15px; overflow-y: auto; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 15px; border-bottom: 2px solid #ddd; color: #666; }
        td { padding: 15px; border-bottom: 1px solid #eee; font-size: 16px; }
        
        .summary-section { width: 350px; background: white; border-radius: 15px; padding: 30px; display: flex; flex-direction: column; justify-content: space-between; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .total-amount { font-size: 48px; font-weight: 800; color: #000; margin-bottom: 20px; text-align: right; }
        .btn-checkout { background: #00aa00; color: white; width: 100%; padding: 20px; border: none; border-radius: 10px; font-size: 20px; font-weight: bold; cursor: pointer; }
        
        /* ALERTAS */
        .alert { padding: 10px; border-radius: 5px; margin-bottom: 10px; font-size: 14px; text-align: center; }
        .alert-red { background: #ffcccc; color: #cc0000; }
        .alert-green { background: #ccffcc; color: green; }

        /* ESTILOS DEL BUSCADOR TIPO GOOGLE */
        .search-container { position: relative; flex-grow: 1; }
        
        .results-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none; /* Oculto por defecto */
        }
        
        .result-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .result-item:hover { background-color: #f9f9f9; }
        .result-item:last-child { border-bottom: none; }
        
        /* Icono de lupa gris */
        .search-icon { color: #999; font-size: 14px; }
        
        /* Texto del producto */
        .prod-name { font-weight: bold; font-size: 14px; color: #333; }
        .prod-code { color: #888; font-size: 12px; margin-left: auto; }
    </style>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main">
        <div class="top-tabs">
            <a href="#" class="tab active">PUNTO DE VENTA</a>
            <a href="historial.php" class="tab">HISTORIAL DE VENTAS</a>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-red">
                <?php 
                    if($_GET['error']=='no_existe') echo "❌ Producto no encontrado.";
                    if($_GET['error']=='stock') echo "⚠️ STOCK INSUFICIENTE. Solo quedan ".$_GET['max']." unidades.";
                    if($_GET['error']=='inactivo') echo "⛔ El producto está desactivado.";
                    if($_GET['error']=='cantidad') echo "⚠️ La cantidad debe ser mayor a 0.";
                ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['mensaje'])): ?>
            <div class="alert alert-green">✅ Venta realizada con éxito.</div>
        <?php endif; ?>

        <form action="../../controllers/VentaController.php" method="POST" class="pos-header" autocomplete="off">
            <input type="hidden" name="accion" value="agregar">
            
            <div class="input-group">
                <label>Cant.</label>
                <input type="number" name="cantidad" class="qty-input" value="1" min="1" required>
            </div>

            <div class="input-group search-container">
                <label>Código de Barras / Nombre del Producto</label>
                
                <input type="text" name="codigo" id="inputCodigo" class="scan-input" 
                       placeholder="Escribe 'Coca' o escanea..." autofocus autocomplete="off">
                
                <div id="listaResultados" class="results-list"></div>
            </div>

            <button type="submit" class="btn-add">AGREGAR</button>
        </form>

        <div class="pos-container">
            <div class="list-section">
                <?php if(!empty($_SESSION['carrito_venta'])): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cant.</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($_SESSION['carrito_venta'] as $index => $item): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $item['nombre']; ?></strong><br>
                                        <small style="color:#999;"><?php echo $item['codigo']; ?></small>
                                    </td>
                                    <td><?php echo $item['precio']; ?></td>
                                    <td><?php echo $item['cantidad']; ?></td>
                                    <td><strong><?php echo number_format($item['subtotal'], 2); ?></strong></td>
                                    <td>
                                        <a href="../../controllers/VentaController.php?accion=eliminar&index=<?php echo $index; ?>" 
                                           style="color:red; text-decoration:none; font-size:20px;">×</a>
                                    </td>
                                </tr>
                                <?php $total_venta += $item['subtotal']; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="text-align:center; margin-top:50px; color:#aaa;">
                        <p>Carrito vacío.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="summary-section">
                <div style="text-align:right;">
                    <div style="color:#888;">TOTAL A PAGAR</div>
                    <div class="total-amount"><?php echo number_format($total_venta, 2); ?> Bs</div>
                </div>
                
                <div>
                    <?php if($total_venta > 0): ?>
                        <form action="../../controllers/VentaController.php" method="POST">
                            <input type="hidden" name="accion" value="finalizar">
                            <button type="submit" class="btn-checkout">COBRAR 💵</button>
                        </form>
                    <?php else: ?>
                        <button class="btn-checkout" style="background:#ccc; cursor:not-allowed;" disabled>COBRAR</button>
                    <?php endif; ?>
                    <a href="../../controllers/VentaController.php?accion=vaciar" style="display:block; text-align:center; margin-top:15px; color:#666; text-decoration:none;">Cancelar Venta</a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Foco automático en el código, pero si tocan la cantidad no molestar
        if(document.querySelector('.scan-input').value == "") {
           document.querySelector('.scan-input').focus();
        }
    </script>
    <script>
        // LOGICA TIPO GOOGLE SEARCH
        const inputCodigo = document.getElementById('inputCodigo');
        const lista = document.getElementById('listaResultados');

        inputCodigo.addEventListener('keyup', function() {
            let termino = this.value;

            // Solo buscar si hay más de 2 letras
            if (termino.length > 1) {
                let formData = new FormData();
                formData.append('termino', termino);

                fetch('../../controllers/ajax_buscar_productos.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    lista.innerHTML = ''; // Limpiar lista anterior
                    
                    if (data.length > 0) {
                        lista.style.display = 'block'; // Mostrar lista
                        
                        data.forEach(prod => {
                            // Crear cada linea tipo Google
                            let item = document.createElement('div');
                            item.classList.add('result-item');
                            
                            // HTML interno: Lupa + Nombre + Codigo
                            item.innerHTML = `
                                <span class="search-icon">🔍</span>
                                <span class="prod-name">${prod.nombre}</span>
                                <span class="prod-code">${prod.codigo}</span>
                            `;
                            
                            // Al hacer clic, rellenar el input y enviar
                            item.onclick = function() {
                                inputCodigo.value = prod.codigo; // Pone el codigo
                                lista.style.display = 'none';    // Oculta lista
                                // Opcional: Auto-enviar el formulario
                                // document.querySelector('.pos-header').submit(); 
                            };
                            
                            lista.appendChild(item);
                        });
                    } else {
                        lista.style.display = 'none';
                    }
                });
            } else {
                lista.style.display = 'none';
            }
        });

        // Ocultar lista si haces clic fuera
        document.addEventListener('click', function(e) {
            if (e.target !== inputCodigo) {
                lista.style.display = 'none';
            }
        });
    </script>
</body>
</html>