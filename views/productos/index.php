<?php
session_start();
include_once '../../models/Producto.php';
include_once '../../models/Categoria.php';
include_once '../../models/Proveedor.php';

if (!isset($_SESSION['id_usuario'])) { header("Location: ../../login.php"); exit(); }

$prodModel = new Producto();
$productos = $prodModel->listar();

$catModel = new Categoria();
$categorias = $catModel->listar();

$provModel = new Proveedor();
$proveedores = $provModel->listar();
$rol = ($_SESSION['rol'] == 1) ? 'ADMIN' : 'EMPLEADO';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Inventario</title>
    <style>
        /* --- ESTILOS GENERALES (Reset) --- */
        * { box-sizing: border_box; font-family: 'Segoe UI', sans-serif; margin: 0; padding: 0; }
        body { display: flex; background-color: #f4f4f4; height: 100vh; overflow: hidden; }
        
        /* --- SIDEBAR FIJO (IDÉNTICO AL PANEL DE CONTROL) --- */
        
       .config-btn {
            background-color: #000099;
            text-align: center;
            padding: 15px;
            text-decoration: none;
            color: white;
            font-weight: bold;
        }

        /* MAIN CONTENT */
        .main { flex-grow: 1; padding: 40px; overflow-y: auto; }
        
        /* HEADER & TOOLBAR */
        .page-title { font-size: 32px; font-weight: 800; margin-bottom: 5px; }
        .page-subtitle { color: #666; margin-bottom: 30px; }
        
        .toolbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .search-main { width: 40%; padding: 12px; border-radius: 8px; border: none; background: #e0e0e0; font-size: 14px; }
        
        .btn-toolbar { 
            padding: 10px 20px; border-radius: 30px; border: 1px solid #333; background: white; 
            cursor: pointer; font-weight: bold; margin-left: 10px; text-decoration: none; color: black; font-size: 14px; display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-toolbar:hover { background: #f0f0f0; }

        /* --- TABLA DE PRODUCTOS --- */
        .table-container { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 20px; font-size: 14px; border-bottom: 2px solid #ddd; color: #000; font-weight: 800; }
        td { padding: 15px 20px; border-bottom: 1px solid #eee; font-size: 14px; color: #333; vertical-align: middle; }
        
        .status-badge { padding: 6px 15px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; }
        .bg-green { background: #ccffcc; color: #006600; }
        .bg-red { background: #ffcccc; color: #cc0000; }
        .bg-orange { background: #ffeebb; color: #cc6600; }

        /* --- MODALES --- */
        .modal-overlay { 
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.6); z-index: 1000; justify-content: center; align-items: center;
        }
        .modal-box { 
            background: white; padding: 40px; border-radius: 20px; width: 800px; max-height: 90vh; overflow-y: auto; 
            position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.2); 
        }
        .close-modal { position: absolute; top: 20px; right: 25px; font-size: 30px; cursor: pointer; color: #aaa; }
        
        /* ESTILOS PROVEEDOR Y CATEGORIA */
        .prov-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .prov-search { background: #eee; border: none; padding: 12px 20px; border-radius: 8px; width: 60%; }
        .btn-new-prov { background: black; color: white; border: none; padding: 12px 25px; border-radius: 10px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 10px; font-size: 14px; }
        
        .form-group { margin-bottom: 15px; }
        .form-input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; background: #fafafa; font-size: 14px; }
        .days-selector { display: flex; gap: 10px; margin-top: 10px; margin-bottom: 20px; }
        .day-circle { width: 40px; height: 40px; border-radius: 50%; background: #e0e0e0; display: flex; justify-content: center; align-items: center; cursor: pointer; font-weight: bold; font-size: 12px; }
        .day-circle.selected { background: #66ff66; color: black; border: 2px solid #44cc44; transform: scale(1.1); }
        .day-badge-small { width: 25px; height: 25px; border-radius: 50%; background: #ccffcc; color: #005500; display: inline-flex; justify-content: center; align-items: center; font-size: 10px; font-weight: bold; margin-right: 2px; }

        .action-buttons { display: flex; gap: 10px; margin-top: 20px; }
        .btn-save { flex: 1; background: black; color: white; border: none; padding: 15px; border-radius: 10px; font-weight: bold; cursor: pointer; }
        .btn-cancel { flex: 1; background: #eee; color: black; border: none; padding: 15px; border-radius: 10px; font-weight: bold; cursor: pointer; }
        /* --- ESTILOS NUEVOS PARA DETALLE Y ESTADO --- */
    .badge-gray { background: #cccccc; color: #666666; }   /* Etiqueta Gris */
    
    /* Iconos SVG (Lápiz y Ojo) */
    .icon-btn { cursor: pointer; width: 20px; height: 20px; margin-right: 10px; vertical-align: middle; transition: transform 0.2s; }
    .icon-btn:hover { transform: scale(1.2); }

    /* MODAL DETALLE (Diseño exacto Imagen) */
    .modal-detail-box { background: white; padding: 30px; border-radius: 20px; width: 380px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.3); }
    .close-detail { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #aaa; }
    
    .detail-title { text-align: center; font-weight: 800; font-size: 14px; margin-bottom: 20px; text-transform: uppercase; }
    
    .img-placeholder { width: 120px; height: 120px; background: #f0f0f0; margin: 0 auto 15px; border-radius: 20px; display: flex; justify-content: center; align-items: center; }
    .img-icon { width: 50px; opacity: 0.5; }
    
    .barcode-section { text-align: center; margin-bottom: 20px; }
    .barcode-img { height: 45px; max-width: 100%; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; text-align: left; }
    .detail-item label { display: block; color: #888; font-size: 11px; margin-bottom: 2px; }
    .detail-item span { display: block; font-weight: 800; font-size: 13px; color: #000; }
    
    .desc-section { border-top: 1px solid #eee; padding-top: 10px; margin-top: 10px; text-align: left; }
    .desc-section label { display: block; color: #888; font-size: 11px; }
    .desc-section p { font-size: 13px; color: #333; margin: 0; }
    </style>
</head>
<body>

    <?php include '../sidebar.php'; ?>

    <div class="main">
        <h1 class="page-title">Gestión de Inventario</h1>
        <p class="page-subtitle">Administra productos, categorías y proveedores</p>

        <div class="toolbar">
            <div style="flex-grow: 1; display: flex; gap: 10px;">
                <input type="text" id="inputBusqueda" class="search-main" placeholder="🔍 Buscar por nombre, código o empresa..." onkeyup="filtrarTabla()" style="flex-grow:1; padding:10px;">
            </div>

            <div>
                <button onclick="window.location.href='?modal=prov'" class="btn-toolbar">👤 Proveedores</button>
                <button onclick="window.location.href='?modal=cat'" class="btn-toolbar">📂 Categorías</button>
                <a href="formulario.php" class="btn-toolbar">➕ Nuevo Producto</a>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $p): ?>
                    <tr>
                        <td><?php echo $p['id_producto']; ?></td>
                        <td><strong><?php echo $p['nombre']; ?></strong></td>
                        <td class="col-cat"><?php echo $p['nombre_categoria']; ?></td>
                        <td><strong><?php echo $p['stock_actual']; ?></strong></td>
                        
                        <td>
                            <?php if($p['estado'] == 1): ?>
                                <span class="status-badge bg-green">Disponible</span>
                            <?php else: ?>
                                <span class="badge badge-gray">No Disponible</span>
                            <?php endif; ?>
                        </td>

                        <td style="white-space: nowrap;">
                            <a href="formulario.php?id=<?php echo $p['id_producto']; ?>" title="Modificar">
                                <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>

                            <?php if($p['estado'] == 1): ?>
                                <a href="../../controllers/ProductoController.php?accion=estado&id=<?php echo $p['id_producto']; ?>&estado=0" title="Desactivar">
                                    <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </a>
                            <?php else: ?>
                                <a href="../../controllers/ProductoController.php?accion=estado&id=<?php echo $p['id_producto']; ?>&estado=1" title="Activar">
                                    <svg class="icon-btn" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                </a>
                            <?php endif; ?>

                            <button class="btn-toolbar" style="padding: 5px 15px; font-size: 12px; margin-left:5px;" 
                                onclick="verDetalle(
                                    '<?php echo $p['codigo']; ?>', 
                                    '<?php echo $p['nombre']; ?>', 
                                    '<?php echo $p['nombre_categoria']; ?>', 
                                    '<?php echo $p['empresa']; ?>', 
                                    '<?php echo $p['precio_compra']; ?>', 
                                    '<?php echo $p['precio_venta']; ?>', 
                                    '<?php echo $p['stock_actual']; ?>', 
                                    '<?php echo ($p['estado']==1)?'Disponible':'No Disponible'; ?>',
                                    '<?php echo $p['imagen']; ?>' 
                                )">
                                Ver detalle
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalProv" class="modal-overlay">
        <div class="modal-box">
            <span class="close-modal" onclick="closeModal('modalProv')">&times;</span>
            
            <div id="viewProvList">
                <div class="prov-header">
                    <h2>Gestión de Proveedores</h2>
                    <button class="btn-new-prov" onclick="prepararNuevo()"><span>+</span> Nuevo Proveedor</button>
                </div>
                <table width="100%">
                    <thead><tr><th>Empresa</th><th>Contacto</th><th>Teléfono</th><th>Días</th><th>Acción</th></tr></thead>
                    <tbody>
                        <?php foreach($proveedores as $pr): ?>
                        <tr>
                            <td><strong><?php echo $pr['empresa']; ?></strong></td>
                            <td><?php echo $pr['nombre_vendedor']; ?></td>
                            <td><?php echo $pr['telefono']; ?></td>
                            <td>
                                <?php $dias = explode(',', $pr['dias_visita']); 
                                foreach($dias as $d) if(trim($d)!="") echo "<span class='day-badge-small'>".substr(trim($d),0,2)."</span>"; ?>
                            </td>
                            <td>
                                <span style="cursor:pointer; margin-right:10px;" onclick="editarProv('<?php echo $pr['id_proveedor']; ?>','<?php echo $pr['empresa']; ?>','<?php echo $pr['nombre_vendedor']; ?>','<?php echo $pr['telefono']; ?>','<?php echo $pr['dias_visita']; ?>')">✏️</span>
                                <a href="../../controllers/ProveedorController.php?accion=eliminar&id=<?php echo $pr['id_proveedor']; ?>" onclick="return confirm('¿Borrar?')" style="color:red; text-decoration:none;">🗑</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="viewProvForm" style="display:none;">
                <h2 id="formTitle">Nuevo Proveedor</h2>
                <form action="../../controllers/ProveedorController.php" method="POST">
                    <input type="hidden" name="accion" id="formAccion" value="guardar">
                    <input type="hidden" name="id_proveedor" id="formId">
                    <div class="form-group"><label>Empresa</label><input type="text" name="empresa" id="inEmpresa" class="form-input" required></div>
                    <div class="form-group"><label>Vendedor</label><input type="text" name="nombre_vendedor" id="inVendedor" class="form-input" required></div>
                    <div class="form-group"><label>Teléfono</label><input type="text" name="telefono" id="inTel" class="form-input" required></div>
                    <label>Días de Visita:</label>
                    <div class="days-selector">
                        <div class="day-circle" id="day_Lu" onclick="toggleDay(this,'Lu')">Lu</div>
                        <div class="day-circle" id="day_Ma" onclick="toggleDay(this,'Ma')">Ma</div>
                        <div class="day-circle" id="day_Mi" onclick="toggleDay(this,'Mi')">Mi</div>
                        <div class="day-circle" id="day_Ju" onclick="toggleDay(this,'Ju')">Ju</div>
                        <div class="day-circle" id="day_Vi" onclick="toggleDay(this,'Vi')">Vi</div>
                        <div class="day-circle" id="day_Sa" onclick="toggleDay(this,'Sa')">Sa</div>
                        <div class="day-circle" id="day_Do" onclick="toggleDay(this,'Do')">Do</div>
                    </div>
                    <input type="hidden" name="dias_visita" id="inputDiasHidden">
                    <div class="action-buttons">
                        <button type="button" class="btn-cancel" onclick="showProvList()">Cancelar</button>
                        <button type="submit" class="btn-save" id="btnSaveText">GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalCat" class="modal-overlay">
        <div class="modal-box" style="width:500px;">
            <span class="close-modal" onclick="closeModal('modalCat')">&times;</span>
            <h2>Gestionar Categorías</h2>
            
            <form action="../../controllers/CategoriaController.php" method="POST" style="display:flex; gap:10px; margin:20px 0;">
                <input type="text" name="nombre" class="form-input" placeholder="Nueva Categoría" required>
                <button type="submit" name="crear" style="background:black; color:white; border:none; border-radius:8px; width:50px; font-size:24px; cursor:pointer;">+</button>
            </form>

            <div style="max-height:300px; overflow-y:auto;">
                <?php foreach($categorias as $c): ?>
                    <div style="display:flex; justify-content:space-between; padding:15px; border-bottom:1px solid #eee;">
                        <strong><?php echo $c['nombre_categoria']; ?></strong>
                        <a href="../../controllers/CategoriaController.php?eliminar=<?php echo $c['id_categoria']; ?>" onclick="return confirm('¿Eliminar categoría?')" style="color:red; text-decoration:none;">🗑</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div id="modalDetalle" class="modal-overlay">
        <div class="modal-detail-box">
            <span class="close-detail" onclick="document.getElementById('modalDetalle').style.display='none'">&times;</span>
            
            <div class="detail-title">INFORMACION DEL PRODUCTO</div>
            
            <div class="img-placeholder">
                <img id="detImg" src="" style="width:100%; height:100%; object-fit:contain; display:none;"> 
                
                <svg id="detIcon" class="img-icon" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            </div>

            <div class="barcode-section">
                <span style="font-weight:bold; font-size:12px; display:block;">Código de Barras</span>
                <img id="barcodeImg" src="" alt="Barcode" class="barcode-img">
                <div id="barcodeNum" style="font-size:11px; letter-spacing:3px; margin-top:2px;"></div>
            </div>

            <hr style="border:0; border-top:1px solid #eee; margin-bottom:15px;">

            <div class="detail-grid">
                <div class="detail-item"><label>Código SKU</label><span id="detSku">...</span></div>
                <div class="detail-item"><label>Nombre</label><span id="detNom">...</span></div>
                
                <div class="detail-item"><label>Categoría</label><span id="detCat">...</span></div>
                <div class="detail-item"><label>Proveedor</label><span id="detProv">...</span></div>
                
                <div class="detail-item"><label>Precio Costo</label><span id="detCosto">...</span></div>
                <div class="detail-item"><label>Precio Venta</label><span id="detVenta">...</span></div>
                
                <div class="detail-item"><label>Stock Disponible</label><span id="detStock">...</span></div>
                <div class="detail-item"><label>Estado</label><span id="detEstado">...</span></div>
            </div>

            <div class="desc-section">
                <label>Descripción</label>
                <p id="detDesc">...</p>
            </div>
        </div>
    </div>

    <script>
        // --- 1. AUTO-APERTURA INTELIGENTE (EL FIX) ---
        window.addEventListener('DOMContentLoaded', (event) => {
            const urlParams = new URLSearchParams(window.location.search);
            const modalType = urlParams.get('modal');
            
            if (modalType === 'prov') {
                openModal('modalProv');
            } else if (modalType === 'cat') {
                openModal('modalCat'); // <--- ESTO ARREGLA CATEGORIAS
            }
            
            if(modalType) {
                // Limpiar URL para que no moleste al recargar
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });

        function openModal(id) { 
            let m = document.getElementById(id); 
            if(m) { m.style.display = 'flex'; if(id==='modalProv') showProvList(); } 
        }
        function closeModal(id) { document.getElementById(id).style.display = 'none'; }

        // PROVEEDORES LOGICA
        function showProvForm() { document.getElementById('viewProvList').style.display='none'; document.getElementById('viewProvForm').style.display='block'; }
        function showProvList() { document.getElementById('viewProvForm').style.display='none'; document.getElementById('viewProvList').style.display='block'; }
        
        let diasArr = [];
        function prepararNuevo() {
            document.getElementById('formTitle').innerText="Nuevo Proveedor"; document.getElementById('formAccion').value="guardar"; document.getElementById('formId').value=""; document.getElementById('btnSaveText').innerText="GUARDAR";
            document.getElementById('inEmpresa').value=""; document.getElementById('inVendedor').value=""; document.getElementById('inTel').value="";
            diasArr=[]; document.getElementById('inputDiasHidden').value=""; limpiarCirculos(); showProvForm();
        }
        function editarProv(id,emp,ven,tel,dias) {
            document.getElementById('formTitle').innerText="Editar"; document.getElementById('formAccion').value="editar"; document.getElementById('formId').value=id; document.getElementById('btnSaveText').innerText="ACTUALIZAR";
            document.getElementById('inEmpresa').value=emp; document.getElementById('inVendedor').value=ven; document.getElementById('inTel').value=tel;
            diasArr=[]; limpiarCirculos();
            if(dias) dias.split(',').forEach(d=>{ let dt=d.trim(); if(dt){ diasArr.push(dt); let c=document.getElementById('day_'+dt); if(c) c.classList.add('selected'); } });
            document.getElementById('inputDiasHidden').value=diasArr.join(','); showProvForm();
        }
        function toggleDay(el,d) { el.classList.toggle('selected'); if(diasArr.includes(d)) diasArr=diasArr.filter(x=>x!==d); else diasArr.push(d); document.getElementById('inputDiasHidden').value=diasArr.join(','); }
        function limpiarCirculos() { document.querySelectorAll('.day-circle').forEach(c=>c.classList.remove('selected')); }

        // 1. FUNCION FILTRAR (BUSQUEDA EN VIVO + CATEGORIA)
        function filtrarTabla() {
            var input = document.getElementById("inputBusqueda");
            var filter = input.value.toLowerCase();
            
            // Seleccionamos el tbody y las filas
            var table = document.querySelector("table tbody"); 
            var tr = table.getElementsByTagName("tr");

            for (var i = 0; i < tr.length; i++) {
                // Obtenemos todo el texto de la fila para buscar
                var rowText = tr[i].textContent.toLowerCase();

                // Verificamos si el texto coincide con la busqueda
                if (rowText.indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

        // 2. VER DETALLE (ACTUALIZADA CON FOTO)
        function verDetalle(codigo, nombre, cat, prov, costo, venta, stock, estado, imagenRuta) {
            document.getElementById('detSku').innerText = codigo;
            document.getElementById('detNom').innerText = nombre;
            document.getElementById('detCat').innerText = cat;
            document.getElementById('detProv').innerText = prov;
            document.getElementById('detCosto').innerText = costo + ' Bs';
            document.getElementById('detVenta').innerText = venta + ' Bs';
            document.getElementById('detStock').innerText = stock + ' unidades';
            document.getElementById('detEstado').innerText = estado;

            // --- LOGICA DE IMAGEN ---
            var imgTag = document.getElementById('detImg');
            var iconTag = document.getElementById('detIcon');

            // Si la ruta existe y no es la default, mostramos la foto
            if(imagenRuta && imagenRuta !== 'default.png' && imagenRuta !== '') {
                imgTag.src = "../../" + imagenRuta; 
                imgTag.style.display = 'block';
                iconTag.style.display = 'none';
            } else {
                // Si no, mostramos el icono
                imgTag.style.display = 'none';
                iconTag.style.display = 'block';
            }

            // Generar Codigo de Barras
            let urlBarcode = 'https://bwipjs-api.metafloor.com/?bcid=code128&text=' + codigo + '&scale=2&height=5&includetext';
            document.getElementById('barcodeImg').src = urlBarcode;


            document.getElementById('modalDetalle').style.display = 'flex';
        }

    </script>

</body>
</html>