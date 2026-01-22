-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2026 a las 01:26:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tienda_barrio`
--
CREATE DATABASE IF NOT EXISTS `db_tienda_barrio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_tienda_barrio`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`, `descripcion`, `estado`) VALUES
(1, 'Bebidas', 'Gaseosas, jugos y aguas', 1),
(2, 'Abarrotes', 'Arroz, fideos, azúcar', 1),
(3, 'Lácteos', 'Leches, yogurts y quesos', 1),
(16, 'Snacks', 'Papas fritas, galletas y dulces', 1),
(17, 'Limpieza', 'Detergentes y jabones', 1),
(18, 'MASCOTAS', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_compra` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `id_proveedor`, `id_usuario`, `fecha_compra`, `total`, `estado`) VALUES
(1, 1, 1, '2026-01-16 09:03:19', 12.00, 0),
(12, 4, 1, '2026-01-18 20:00:34', 1.20, 1),
(13, 2, 1, '2026-01-19 14:24:47', 13.50, 0),
(14, 3, 1, '2026-01-19 14:26:16', 12.00, 0),
(15, 4, 1, '2026-01-20 08:29:54', 10.00, 0),
(23, 1, 1, '2026-01-20 09:45:45', 4.00, 0),
(24, 1, 1, '2026-01-20 09:46:07', 12.00, 0),
(25, 1, 1, '2026-01-20 09:51:34', 38.00, 1),
(26, 1, 1, '2026-01-20 12:12:53', 12.00, 0),
(27, 1, 1, '2026-01-20 20:24:06', 4.00, 0),
(28, 1, 1, '2026-01-21 01:22:02', 12.00, 1),
(29, 1, 1, '2026-01-21 20:01:08', 4.00, 1),
(30, 1, 1, '2026-01-21 20:15:29', 4.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compras`
--

CREATE TABLE `detalle_compras` (
  `id_detalle` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_costo` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compras`
--

INSERT INTO `detalle_compras` (`id_detalle`, `id_compra`, `id_producto`, `cantidad`, `precio_costo`, `subtotal`) VALUES
(1, 1, 2, 1, 12.00, 12.00),
(2, 12, 4, 8, 0.15, 1.20),
(3, 13, 4, 3, 4.50, 13.50),
(4, 14, 4, 3, 4.00, 12.00),
(5, 15, 4, 3, 2.00, 6.00),
(6, 15, 4, 2, 2.00, 4.00),
(7, 23, 4, 2, 2.00, 4.00),
(8, 24, 4, 2, 2.00, 4.00),
(9, 24, 4, 2, 1.00, 2.00),
(10, 24, 4, 3, 2.00, 6.00),
(11, 25, 4, 9, 4.00, 36.00),
(12, 25, 2, 2, 1.00, 2.00),
(13, 26, 4, 6, 2.00, 12.00),
(14, 27, 4, 2, 2.00, 4.00),
(15, 28, 4, 2, 5.00, 10.00),
(16, 28, 6, 1, 2.00, 2.00),
(17, 29, 6, 2, 2.00, 4.00),
(18, 30, 6, 2, 2.00, 4.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id_detalle` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detalle`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 2, 8, 19.00, 152.00),
(2, 2, 3, 1, 5.00, 5.00),
(3, 3, 3, 1, 5.00, 5.00),
(4, 4, 4, 1, 9.00, 9.00),
(5, 4, 5, 5, 5.00, 25.00),
(6, 5, 4, 8, 9.00, 72.00),
(7, 6, 4, 1, 9.00, 9.00),
(8, 7, 4, 12, 9.00, 108.00),
(9, 8, 6, 1, 5.50, 5.50),
(10, 9, 6, 6, 5.50, 33.00),
(11, 10, 6, 3, 5.50, 16.50),
(12, 10, 1, 1, 12.00, 12.00),
(13, 11, 2, 1, 19.00, 19.00),
(14, 12, 4, 1, 9.00, 9.00),
(15, 13, 4, 1, 9.00, 9.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_compra` decimal(10,2) NOT NULL DEFAULT 0.00,
  `precio_costo` decimal(10,2) DEFAULT 0.00,
  `precio_venta` decimal(10,2) NOT NULL,
  `stock_actual` int(11) DEFAULT 0,
  `stock_minimo` int(11) DEFAULT 5,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `imagen` varchar(255) DEFAULT NULL,
  `codigo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo_barras`, `nombre`, `descripcion`, `precio_compra`, `precio_costo`, `precio_venta`, `stock_actual`, `stock_minimo`, `ruta_imagen`, `id_categoria`, `id_proveedor`, `estado`, `imagen`, `codigo`) VALUES
(1, '7750123001', 'Coca Cola 2L', NULL, 9.60, 0.00, 12.00, 49, 5, NULL, 1, 1, 1, NULL, 'PROD-1'),
(2, '564553234254', 'CocaCola 3L', NULL, 15.20, 12.00, 19.00, 0, 5, 'assets/img/productos/1768567879_Captura de pantalla 2025-10-09 114646.png', 1, 1, 1, NULL, 'PROD-2'),
(3, '1234567', 'cocacola', NULL, 4.00, 0.00, 5.00, 3, 5, 'assets/img/productos/1768759626_Captura de pantalla 2025-10-09 114529.png', 3, 1, 1, NULL, 'PROD-3'),
(4, NULL, 'CocaCola 500ml', 'lasndfoasndfojn', 6.50, 0.00, 9.00, 14, 2, NULL, 1, 1, 1, NULL, '123'),
(5, NULL, 'pipocacas', 'asfsavdvasa', 3.00, 0.00, 5.00, 70, 1, NULL, 17, 3, 1, 'uploads/1768773852_Captura de pantalla 2025-12-10 101401.png', '1234'),
(6, NULL, 'DOGSHOW', 'OASNFOASNFOANSF', 2.50, 0.00, 5.50, 8, 1, NULL, 18, 1, 1, 'uploads/1768774569_Captura de pantalla 2025-10-02 122740.png', '12345'),
(7, NULL, 'defghhgfds', NULL, 0.00, 0.00, 3.50, 0, 5, NULL, 17, 3, 1, 'default.png', '12345676543'),
(8, NULL, 'SDFGBNBFD', NULL, 0.00, 0.00, 34.00, 0, 5, NULL, 17, 4, 1, 'uploads/1768953142_Captura de pantalla 2025-09-29 184123.png', '123456765432'),
(9, NULL, 'fanta', NULL, 0.00, 0.00, 7.00, 0, 5, NULL, 1, 2, 1, 'default.png', '12345');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `nombre_vendedor` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `dias_visita` varchar(100) DEFAULT 'Por definir',
  `direccion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `empresa`, `nombre_vendedor`, `telefono`, `dias_visita`, `direccion`, `estado`) VALUES
(1, 'Coca Cola Embol', 'Juan Perez', '77712345', 'Lunes y Jueves', 'Av. Industrial', 1),
(2, 'Coca Cola Embol', 'Juan Repartidor', '77712345', 'Lunes y Jueves', NULL, 1),
(3, 'Pil Andina', 'Maria Ventas', '60588999', 'Quincenal (Martes),Lu,Ma', NULL, 1),
(4, 'Arcor', 'Pedro Galletas', '71233445', 'Por definir,Mi', NULL, 1),
(11, 'ASDFVG', 'ASDFGB', '23456', 'Vi', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre_rol`) VALUES
(1, 'Administrador'),
(2, 'Empleado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `ci` varchar(20) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellido_paterno` varchar(50) NOT NULL,
  `apellido_materno` varchar(50) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `cuenta` varchar(50) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `ci`, `nombres`, `apellido_paterno`, `apellido_materno`, `celular`, `direccion`, `fecha_nacimiento`, `cuenta`, `clave`, `id_rol`, `estado`, `fecha_registro`) VALUES
(1, '000', 'Edson Guarachi', '', '', NULL, NULL, NULL, 'admin', '$2y$10$eDA1jLCRB0TTdXdPXJK4MuLjGEr.XyBSKUhSgM5sptGbiWdE1wRdO', 1, 1, '2026-01-16 08:21:20'),
(2, '000', 'Edson Franchescoli', '', '', NULL, NULL, NULL, 'edson', 'edson123', 2, 1, '2026-01-18 11:08:33'),
(3, '000', 'Edson Guarachi Alarcon', '', '', NULL, NULL, NULL, 'eguarachia', 'Tienda de Barrio', 2, 1, '2026-01-18 11:42:41'),
(4, '13280886', 'JUAN', 'MAMANI', 'QUISPE', '61117256', 'C. Las Rosas N°6 Z. Chijipata Alto Achumani', '2026-01-05', 'jmamaniq', 'Tienda de Barrio', 2, 1, '2026-01-18 12:09:04'),
(5, '1234567', 'juan', 'mamani', 'quisbert', '1234567', 'dzghkh', '2026-01-03', 'jmamaniq1', 'Tienda de Barrio', 2, 1, '2026-01-18 16:14:55'),
(6, '13280886', 'Edson', 'Guarachi', 'Alarcon', NULL, NULL, NULL, 'eguarachia1', '$2y$10$qn2OqxT.ORAwLbZDxNtsnOlTOPpcMRXug65FtMKjj0PMPxQHxLqxG', 1, 0, '2026-01-20 23:28:09'),
(7, '87654321', 'alejandro', 'aspi', 'gutiérrez', NULL, NULL, NULL, 'aaspig', '$2y$10$82Ax6MPvXpvbziACkqP9k.3gZ4aITjBVIIlyTjPjtKvWn20MhLx9a', 2, 1, '2026-01-21 01:32:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_venta` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_usuario`, `fecha_venta`, `total`, `estado`) VALUES
(1, 1, '2026-01-16 08:57:05', 152.00, 1),
(2, 1, '2026-01-18 14:16:50', 5.00, 1),
(3, 1, '2026-01-18 14:17:44', 5.00, 1),
(4, 1, '2026-01-18 19:09:05', 34.00, 0),
(5, 1, '2026-01-18 19:10:13', 72.00, 0),
(6, 1, '2026-01-20 08:28:52', 9.00, 0),
(7, 1, '2026-01-20 20:27:59', 108.00, 1),
(8, 1, '2026-01-20 21:45:20', 5.50, 1),
(9, 1, '2026-01-20 22:02:56', 33.00, 0),
(10, 1, '2026-01-20 22:25:27', 28.50, 1),
(11, 1, '2026-01-20 22:26:53', 19.00, 1),
(12, 1, '2026-01-21 01:17:25', 9.00, 0),
(13, 7, '2026-01-21 01:36:52', 9.00, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre_categoria`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compras_proveedor` (`id_proveedor`),
  ADD KEY `fk_compras_usuario` (`id_usuario`);

--
-- Indices de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_barras` (`codigo_barras`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cuenta` (`cuenta`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `fk_ventas_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `fk_compras_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `fk_compras_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `detalle_compras`
--
ALTER TABLE `detalle_compras`
  ADD CONSTRAINT `detalle_compras_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`),
  ADD CONSTRAINT `detalle_compras_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `fk_ventas_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
--
-- Base de datos: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(10) UNSIGNED NOT NULL,
  `dbase` varchar(255) NOT NULL DEFAULT '',
  `user` varchar(255) NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) NOT NULL,
  `col_name` varchar(64) NOT NULL,
  `col_type` varchar(64) NOT NULL,
  `col_length` text DEFAULT NULL,
  `col_collation` varchar(64) NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) DEFAULT '',
  `col_default` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `column_name` varchar(64) NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) NOT NULL DEFAULT '',
  `transformation_options` varchar(255) NOT NULL DEFAULT '',
  `input_transformation` varchar(255) NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) NOT NULL,
  `settings_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

--
-- Volcado de datos para la tabla `pma__designer_settings`
--

INSERT INTO `pma__designer_settings` (`username`, `settings_data`) VALUES
('root', '{\"angular_direct\":\"direct\",\"snap_to_grid\":\"off\",\"relation_lines\":\"true\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL,
  `export_type` varchar(10) NOT NULL,
  `template_name` varchar(64) NOT NULL,
  `template_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db` varchar(64) NOT NULL DEFAULT '',
  `table` varchar(64) NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp(),
  `sqlquery` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  `item_type` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) NOT NULL,
  `tables` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Volcado de datos para la tabla `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"db_tienda_barrio\",\"table\":\"usuarios\"},{\"db\":\"db_tienda_barrio\",\"table\":\"compras\"},{\"db\":\"db_tienda_barrio\",\"table\":\"ventas\"},{\"db\":\"db_tienda_barrio\",\"table\":\"detalle_ventas\"},{\"db\":\"db_tienda_barrio\",\"table\":\"categorias\"},{\"db\":\"db_tienda_barrio\",\"table\":\"proveedores\"},{\"db\":\"db_tienda_barrio\",\"table\":\"productos\"},{\"db\":\"stockdev\",\"table\":\"sistema\"}]');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) NOT NULL DEFAULT '',
  `master_table` varchar(64) NOT NULL DEFAULT '',
  `master_field` varchar(64) NOT NULL DEFAULT '',
  `foreign_db` varchar(64) NOT NULL DEFAULT '',
  `foreign_table` varchar(64) NOT NULL DEFAULT '',
  `foreign_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) NOT NULL DEFAULT '',
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `search_name` varchar(64) NOT NULL DEFAULT '',
  `search_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT 0,
  `x` float UNSIGNED NOT NULL DEFAULT 0,
  `y` float UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) NOT NULL DEFAULT '',
  `table_name` varchar(64) NOT NULL DEFAULT '',
  `display_field` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) NOT NULL,
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `prefs` text NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) NOT NULL,
  `table_name` varchar(64) NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text NOT NULL,
  `schema_sql` text DEFAULT NULL,
  `data_sql` longtext DEFAULT NULL,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `config_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Volcado de datos para la tabla `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2026-01-22 00:25:14', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"es\"}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) NOT NULL,
  `tab` varchar(64) NOT NULL,
  `allowed` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) NOT NULL,
  `usergroup` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indices de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indices de la tabla `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indices de la tabla `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indices de la tabla `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indices de la tabla `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indices de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indices de la tabla `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indices de la tabla `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indices de la tabla `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indices de la tabla `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indices de la tabla `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indices de la tabla `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indices de la tabla `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- Base de datos: `sensores_iot`
--
CREATE DATABASE IF NOT EXISTS `sensores_iot` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sensores_iot`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conexiones_log`
--

CREATE TABLE `conexiones_log` (
  `id` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_iot`
--

CREATE TABLE `estado_iot` (
  `id` int(11) NOT NULL,
  `estado` enum('conectado','desconectado') DEFAULT 'desconectado',
  `ultima_lectura` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `estado_iot`
--

INSERT INTO `estado_iot` (`id`, `estado`, `ultima_lectura`) VALUES
(1, 'desconectado', '2025-10-15 18:41:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lecturas`
--

CREATE TABLE `lecturas` (
  `id` int(11) NOT NULL,
  `temperatura` float NOT NULL,
  `distancia` float NOT NULL,
  `luz` int(11) NOT NULL,
  `potenciometro` float NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado_dispositivo` enum('conectado','desconectado') DEFAULT 'conectado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `lecturas`
--

INSERT INTO `lecturas` (`id`, `temperatura`, `distancia`, `luz`, `potenciometro`, `fecha_hora`, `estado_dispositivo`) VALUES
(1, 21.25, 0, 2819, 91.01, '2025-10-15 19:43:24', 'conectado'),
(2, 21.75, 0, 2821, 91.04, '2025-10-15 19:43:26', 'conectado'),
(3, 21.5, 0, 2821, 91.04, '2025-10-15 19:43:29', 'conectado'),
(4, 21.25, 0, 2820, 90.87, '2025-10-15 19:43:32', 'conectado'),
(5, 21.25, 0, 2811, 91.04, '2025-10-15 19:43:35', 'conectado'),
(6, 21.75, 0, 2813, 90.87, '2025-10-15 19:43:38', 'conectado'),
(7, 21.25, 0, 2800, 90.77, '2025-10-15 19:43:40', 'conectado'),
(8, 21.75, 0, 2797, 90.87, '2025-10-15 19:43:43', 'conectado'),
(9, 21.25, 0, 2804, 90.92, '2025-10-15 19:43:46', 'conectado'),
(10, 21.75, 0, 2801, 90.96, '2025-10-15 19:43:49', 'conectado'),
(11, 21.25, 0, 2805, 90.92, '2025-10-15 19:43:51', 'conectado'),
(12, 22, 0, 2803, 90.96, '2025-10-15 19:43:54', 'conectado'),
(13, 21.25, 0, 2800, 90.99, '2025-10-15 19:43:57', 'conectado'),
(14, 22, 0, 2799, 91.09, '2025-10-15 19:44:00', 'conectado'),
(15, 21.75, 0, 2800, 90.99, '2025-10-15 19:44:02', 'conectado'),
(16, 21.75, 0, 2799, 90.92, '2025-10-15 19:44:05', 'conectado'),
(17, 21.75, 0, 2813, 90.96, '2025-10-15 19:44:08', 'conectado'),
(18, 21.5, 0, 2814, 90.92, '2025-10-15 19:44:11', 'conectado'),
(19, 21.5, 0, 2811, 90.96, '2025-10-15 19:44:13', 'conectado'),
(20, 22, 0, 2817, 90.94, '2025-10-15 19:44:16', 'conectado'),
(21, 21.75, 0, 2798, 90.96, '2025-10-15 19:44:19', 'conectado'),
(22, 22.5, 9.78, 2687, 91.79, '2025-10-15 22:18:56', 'conectado'),
(23, 22.25, 4.85, 2559, 91.16, '2025-10-15 22:18:59', 'conectado'),
(24, 22.25, 7.02, 2823, 91.4, '2025-10-15 22:19:02', 'conectado'),
(25, 22, 8.92, 2831, 91.36, '2025-10-15 22:19:05', 'conectado'),
(26, 21.75, 4.28, 2512, 91.6, '2025-10-15 22:19:07', 'conectado'),
(27, 22.25, 4.83, 2686, 91.18, '2025-10-15 22:19:10', 'conectado'),
(28, 22.25, 5.38, 2789, 91.38, '2025-10-15 22:19:13', 'conectado'),
(29, 22.25, 7, 2717, 91.38, '2025-10-15 22:19:16', 'conectado'),
(30, 22, 9.76, 2833, 91.45, '2025-10-15 22:19:18', 'conectado'),
(31, 22, 9.71, 2491, 91.38, '2025-10-15 22:19:21', 'conectado'),
(32, 22.25, 5.58, 2773, 91.31, '2025-10-15 22:19:24', 'conectado'),
(33, 22.25, 0, 2653, 91.65, '2025-10-15 22:19:27', 'conectado'),
(34, 22.25, 4.49, 2800, 91.18, '2025-10-15 22:19:30', 'conectado'),
(35, 22, 4.15, 2803, 91.26, '2025-10-15 22:19:33', 'conectado'),
(36, 21.75, 8.3, 2805, 91.31, '2025-10-15 22:19:35', 'conectado'),
(37, 22.25, 1.58, 2601, 91.16, '2025-10-15 22:19:38', 'conectado'),
(38, 22, 4.43, 2686, 91.28, '2025-10-15 22:19:41', 'conectado'),
(39, 22.25, 3.18, 2806, 91.21, '2025-10-15 22:19:44', 'conectado'),
(40, 22.25, 2.02, 2705, 91.06, '2025-10-15 22:19:46', 'conectado'),
(41, 21.75, 122.86, 2771, 91.36, '2025-10-15 22:19:49', 'conectado'),
(42, 0, 0, 3138, 98.02, '2025-10-15 22:19:52', 'conectado'),
(43, 0, 0, 3306, 98.07, '2025-10-15 22:19:55', 'conectado'),
(44, 0, 0, 3297, 98, '2025-10-15 22:19:57', 'conectado'),
(45, 21.5, 0, 2817, 91.31, '2025-10-15 22:20:00', 'conectado'),
(46, 0, 0, 3298, 97.75, '2025-10-15 22:20:03', 'conectado'),
(47, 0, 0, 3129, 98, '2025-10-15 22:20:05', 'conectado'),
(48, 0, 0, 3200, 97.95, '2025-10-15 22:20:08', 'conectado'),
(49, 24.5, 0, 2762, 91.28, '2025-10-15 22:20:11', 'conectado'),
(50, 24.5, 0, 2781, 91.36, '2025-10-15 22:20:14', 'conectado'),
(51, 24, 0, 2589, 91.18, '2025-10-15 22:20:17', 'conectado'),
(52, 24.5, 0, 2496, 91.18, '2025-10-15 22:20:20', 'conectado'),
(53, 24.5, 0, 2508, 91.23, '2025-10-15 22:20:23', 'conectado'),
(54, 24.5, 0, 2836, 91.18, '2025-10-15 22:20:25', 'conectado'),
(55, 24.25, 0, 2703, 91.31, '2025-10-15 22:20:28', 'conectado'),
(56, 24.25, 0, 2624, 91.16, '2025-10-15 22:20:31', 'conectado'),
(57, 24.25, 0, 2832, 91.28, '2025-10-15 22:20:33', 'conectado'),
(58, 24, 0, 2517, 91.21, '2025-10-15 22:20:36', 'conectado'),
(59, 24.25, 0, 2800, 91.09, '2025-10-15 22:20:39', 'conectado'),
(60, 24.25, 0, 2829, 91.31, '2025-10-15 22:20:42', 'conectado'),
(61, 24, 0, 2534, 91.36, '2025-10-15 22:20:44', 'conectado'),
(62, 24.5, 0, 2827, 91.31, '2025-10-15 22:20:47', 'conectado'),
(63, 24, 0, 2503, 91.28, '2025-10-15 22:20:50', 'conectado'),
(64, 24.5, 0, 2752, 91.33, '2025-10-15 22:20:52', 'conectado'),
(65, 24, 0, 2525, 91.21, '2025-10-15 22:20:55', 'conectado'),
(66, 24.25, 0, 2765, 91.38, '2025-10-15 22:20:58', 'conectado'),
(67, 24.25, 0, 2511, 91.28, '2025-10-15 22:21:00', 'conectado'),
(68, 24, 0, 2503, 91.5, '2025-10-15 22:21:03', 'conectado'),
(69, 24, 0, 2768, 91.31, '2025-10-15 22:21:05', 'conectado'),
(70, 24, 0, 2522, 91.11, '2025-10-15 22:21:08', 'conectado'),
(71, 23.75, 0, 2659, 91.18, '2025-10-15 22:21:11', 'conectado'),
(72, 23.75, 0, 2725, 91.31, '2025-10-15 22:21:14', 'conectado'),
(73, 23.75, 0, 2496, 91.21, '2025-10-15 22:21:16', 'conectado'),
(74, 24.5, 0, 2611, 91.28, '2025-10-15 22:21:19', 'conectado'),
(75, 24.5, 0, 2734, 91.09, '2025-10-15 22:21:21', 'conectado'),
(76, 24, 0, 2799, 91.33, '2025-10-15 22:21:24', 'conectado'),
(77, 24.5, 0, 2606, 91.14, '2025-10-15 22:21:26', 'conectado'),
(78, 24.25, 0, 2767, 91.16, '2025-10-15 22:21:29', 'conectado'),
(79, 24.25, 0, 2613, 91.31, '2025-10-15 22:21:32', 'conectado'),
(80, 24.25, 0, 2711, 91.28, '2025-10-15 22:21:35', 'conectado'),
(81, 24.25, 0, 2646, 91.28, '2025-10-15 22:21:38', 'conectado'),
(82, 24.5, 0, 2815, 91.28, '2025-10-15 22:21:41', 'conectado'),
(83, 23.75, 0, 2585, 91.31, '2025-10-15 22:21:44', 'conectado'),
(84, 24, 0, 2503, 91.18, '2025-10-15 22:21:47', 'conectado'),
(85, 24.25, 0, 2523, 91.18, '2025-10-15 22:21:50', 'conectado'),
(86, 24.25, 0, 2799, 91.14, '2025-10-15 22:21:53', 'conectado'),
(87, 24, 0, 2736, 91.11, '2025-10-15 22:21:56', 'conectado'),
(88, 24, 0, 2781, 91.36, '2025-10-15 22:21:59', 'conectado'),
(89, 24.25, 0, 2559, 90.62, '2025-10-15 22:22:02', 'conectado'),
(90, 23.75, 0, 2666, 91.21, '2025-10-15 22:22:05', 'conectado'),
(91, 24, 0, 2745, 91.18, '2025-10-15 22:22:08', 'conectado'),
(92, 24, 0, 2691, 91.09, '2025-10-15 22:22:11', 'conectado'),
(93, 24.5, 0, 2823, 91.21, '2025-10-15 22:22:14', 'conectado'),
(94, 24.5, 0, 2497, 91.18, '2025-10-15 22:22:17', 'conectado'),
(95, 24.25, 0, 2797, 91.09, '2025-10-15 22:22:21', 'conectado'),
(96, 24.25, 0, 2592, 91.31, '2025-10-15 22:22:23', 'conectado'),
(97, 24, 0, 2703, 91.5, '2025-10-15 22:22:26', 'conectado'),
(98, 24.25, 0, 2751, 91.38, '2025-10-15 22:22:29', 'conectado'),
(99, 24.25, 0, 2527, 91.11, '2025-10-15 22:22:32', 'conectado'),
(100, 21.75, 0, 2507, 91.16, '2025-10-15 22:22:35', 'conectado'),
(101, 23.75, 0, 2812, 91.06, '2025-10-15 22:22:39', 'conectado'),
(102, 24.25, 0, 2550, 91.18, '2025-10-15 22:22:42', 'conectado'),
(103, 24.25, 0, 2719, 91.18, '2025-10-15 22:22:45', 'conectado'),
(104, 24, 0, 2643, 91.16, '2025-10-15 22:22:48', 'conectado'),
(105, 24.25, 0, 2608, 91.14, '2025-10-15 22:22:51', 'conectado'),
(106, 24.5, 0, 2555, 91.45, '2025-10-15 22:22:54', 'conectado'),
(107, 24.25, 0, 2496, 91.26, '2025-10-15 22:22:57', 'conectado'),
(108, 24.25, 0, 2743, 91.28, '2025-10-15 22:23:00', 'conectado'),
(109, 24.25, 0, 2727, 91.28, '2025-10-15 22:23:03', 'conectado'),
(110, 24, 0, 2559, 91.31, '2025-10-15 22:23:07', 'conectado'),
(111, 23.75, 0, 2706, 91.09, '2025-10-15 22:23:09', 'conectado'),
(112, 24.25, 0, 2619, 91.18, '2025-10-15 22:23:13', 'conectado'),
(113, 24, 0, 2607, 91.14, '2025-10-15 22:23:16', 'conectado'),
(114, 24.25, 0, 2497, 90.5, '2025-10-15 22:23:19', 'conectado'),
(115, 23.75, 0, 2768, 91.11, '2025-10-15 22:23:22', 'conectado'),
(116, 24.5, 0, 2487, 91.21, '2025-10-15 22:23:25', 'conectado'),
(117, 24.5, 0, 2793, 91.16, '2025-10-15 22:23:28', 'conectado'),
(118, 23.75, 0, 2523, 91.26, '2025-10-15 22:23:30', 'conectado'),
(119, 24.25, 0, 2529, 91.21, '2025-10-15 22:23:33', 'conectado'),
(120, 24.25, 0, 2592, 91.36, '2025-10-15 22:23:36', 'conectado'),
(121, 24, 0, 2635, 91.31, '2025-10-15 22:23:38', 'conectado'),
(122, 24.5, 0, 2778, 91.18, '2025-10-15 22:23:41', 'conectado'),
(123, 24.25, 0, 2658, 91.06, '2025-10-15 22:23:44', 'conectado'),
(124, 24.25, 0, 2764, 91.11, '2025-10-15 22:23:47', 'conectado'),
(125, 23.75, 0, 2794, 91.16, '2025-10-15 22:23:50', 'conectado'),
(126, 24.25, 0, 2603, 91.04, '2025-10-15 22:23:52', 'conectado'),
(127, 24.25, 0, 2809, 91.33, '2025-10-15 22:23:55', 'conectado'),
(128, 24, 0, 2527, 91.26, '2025-10-15 22:23:58', 'conectado'),
(129, 24.25, 0, 2821, 91.55, '2025-10-15 22:24:00', 'conectado'),
(130, 24.25, 0, 2815, 91.18, '2025-10-15 22:24:03', 'conectado'),
(131, 24.25, 0, 2659, 91.4, '2025-10-15 22:24:06', 'conectado'),
(132, 24.25, 0, 2807, 91.14, '2025-10-15 22:24:08', 'conectado'),
(133, 24.25, 0, 2551, 91.21, '2025-10-15 22:24:11', 'conectado'),
(134, 24, 0, 2801, 91.16, '2025-10-15 22:24:14', 'conectado'),
(135, 24, 0, 2823, 91.14, '2025-10-15 22:24:17', 'conectado'),
(136, 24.25, 0, 2745, 91.21, '2025-10-15 22:24:20', 'conectado'),
(137, 24, 0, 2817, 91.55, '2025-10-15 22:24:23', 'conectado'),
(138, 24, 0, 2559, 91.38, '2025-10-15 22:24:26', 'conectado'),
(139, 24.25, 0, 2795, 91.43, '2025-10-15 22:24:28', 'conectado'),
(140, 23.75, 0, 2817, 91.31, '2025-10-15 22:24:32', 'conectado'),
(141, 23.75, 0, 2608, 91.04, '2025-10-15 22:24:34', 'conectado'),
(142, 23.75, 0, 2559, 91.21, '2025-10-15 22:24:37', 'conectado'),
(143, 24.25, 0, 2497, 91.31, '2025-10-15 22:24:40', 'conectado'),
(144, 24.25, 0, 2823, 91.31, '2025-10-15 22:24:43', 'conectado'),
(145, 24.25, 0, 2787, 91.21, '2025-10-15 22:24:45', 'conectado'),
(146, 23.75, 0, 2555, 91.06, '2025-10-15 22:24:48', 'conectado'),
(147, 23.5, 0, 2608, 90.99, '2025-10-15 22:24:51', 'conectado'),
(148, 24, 0, 2675, 91.21, '2025-10-15 22:24:54', 'conectado'),
(149, 24.25, 0, 2659, 91.14, '2025-10-15 22:24:57', 'conectado'),
(150, 24.5, 0, 2541, 91.18, '2025-10-15 22:25:00', 'conectado'),
(151, 24.5, 0, 2688, 91.11, '2025-10-15 22:25:02', 'conectado'),
(152, 23.75, 0, 2499, 91.16, '2025-10-15 22:25:05', 'conectado'),
(153, 24, 0, 2815, 91.16, '2025-10-15 22:25:08', 'conectado'),
(154, 23.75, 0, 2526, 91.28, '2025-10-15 22:25:10', 'conectado'),
(155, 24, 0, 2516, 91.18, '2025-10-15 22:25:13', 'conectado'),
(156, 23.75, 0, 2747, 91.11, '2025-10-15 22:25:16', 'conectado'),
(157, 24, 0, 2823, 91.16, '2025-10-15 22:25:19', 'conectado'),
(158, 24.25, 0, 2582, 91.11, '2025-10-15 22:25:22', 'conectado'),
(159, 23.75, 0, 2608, 91.16, '2025-10-15 22:25:25', 'conectado'),
(160, 23.75, 0, 2513, 91.23, '2025-10-15 22:25:28', 'conectado'),
(161, 23.75, 0, 2700, 91.18, '2025-10-15 22:25:30', 'conectado'),
(162, 24, 0, 2828, 91.26, '2025-10-15 22:25:33', 'conectado'),
(163, 23.75, 0, 2786, 91.36, '2025-10-15 22:25:36', 'conectado'),
(164, 24, 0, 2688, 91.28, '2025-10-15 22:25:39', 'conectado'),
(165, 24.5, 0, 2788, 91.14, '2025-10-15 22:25:42', 'conectado'),
(166, 24.25, 0, 2538, 91.26, '2025-10-15 22:25:45', 'conectado'),
(167, 24.25, 0, 2733, 91.16, '2025-10-15 22:25:47', 'conectado'),
(168, 23.75, 0, 2802, 91.26, '2025-10-15 22:25:50', 'conectado'),
(169, 24, 0, 2585, 91.04, '2025-10-15 22:25:53', 'conectado'),
(170, 23.75, 0, 2559, 91.21, '2025-10-15 22:25:55', 'conectado'),
(171, 24, 0, 2819, 91.16, '2025-10-15 22:25:58', 'conectado'),
(172, 22, 0, 2774, 90.87, '2025-10-15 22:26:01', 'conectado'),
(173, 0, 0, 2473, 87.5, '2025-10-15 22:26:04', 'conectado'),
(174, 21.75, 0, 2767, 90.67, '2025-10-15 22:26:06', 'conectado'),
(175, 22, 0, 2459, 91.16, '2025-10-15 22:26:09', 'conectado'),
(176, 22, 0, 2667, 91.18, '2025-10-15 22:26:11', 'conectado'),
(177, 21.5, 0, 2499, 91.26, '2025-10-15 22:26:15', 'conectado'),
(178, 21.75, 0, 2526, 91.06, '2025-10-15 22:26:18', 'conectado'),
(179, 21.5, 0, 2651, 91.06, '2025-10-15 22:26:21', 'conectado'),
(180, 21.5, 0, 2557, 91.21, '2025-10-15 22:26:24', 'conectado'),
(181, 21.5, 0, 2480, 91.04, '2025-10-15 22:26:28', 'conectado'),
(182, 22, 0, 2508, 91.16, '2025-10-15 22:26:31', 'conectado'),
(183, 22, 0, 2212, 91.11, '2025-10-15 22:26:34', 'conectado'),
(184, 22, 0, 2123, 91.16, '2025-10-15 22:26:37', 'conectado'),
(185, 22, 0, 2609, 91.16, '2025-10-15 22:26:40', 'conectado'),
(186, 21.5, 0, 2497, 91.21, '2025-10-15 22:26:43', 'conectado'),
(187, 21.75, 0, 2207, 91.18, '2025-10-15 22:26:46', 'conectado'),
(188, 21.5, 0, 2450, 91.21, '2025-10-15 22:26:49', 'conectado'),
(189, 22, 0, 2229, 91.11, '2025-10-15 22:26:52', 'conectado'),
(190, 21.75, 0, 2081, 91.14, '2025-10-15 22:26:54', 'conectado'),
(191, 21.75, 0, 2544, 91.09, '2025-10-15 22:26:57', 'conectado'),
(192, 21.75, 0, 2535, 91.11, '2025-10-15 22:27:00', 'conectado'),
(193, 22, 0, 2108, 91.28, '2025-10-15 22:27:04', 'conectado'),
(194, 24.25, 0, 2107, 91.04, '2025-10-15 22:27:07', 'conectado'),
(195, 24, 0, 2800, 91.5, '2025-10-15 22:27:09', 'conectado'),
(196, 23.75, 0, 2512, 12.92, '2025-10-15 22:27:12', 'conectado'),
(197, 24.25, 0, 2624, 0, '2025-10-15 22:27:15', 'conectado'),
(198, 23.75, 0, 2496, 10.79, '2025-10-15 22:27:18', 'conectado'),
(199, 24, 0, 2675, 40.24, '2025-10-15 22:27:21', 'conectado'),
(200, 0, 0, 3002, 51.55, '2025-10-15 22:27:23', 'conectado'),
(201, 0, 0, 3107, 97.26, '2025-10-15 22:27:26', 'conectado'),
(202, 0, 0, 2779, 19.98, '2025-10-15 22:27:29', 'conectado'),
(203, 0, 0, 3002, 24.05, '2025-10-15 22:27:32', 'conectado'),
(204, 0, 0, 2817, 0, '2025-10-15 22:27:35', 'conectado'),
(205, 0, 0, 2849, 0, '2025-10-15 22:27:38', 'conectado'),
(206, 0, 0, 2833, 97.29, '2025-10-15 22:27:40', 'conectado'),
(207, 0, 0, 2896, 96.24, '2025-10-15 22:27:43', 'conectado'),
(208, 0, 0, 2864, 96.12, '2025-10-15 22:27:46', 'conectado'),
(209, 0, 0, 3135, 96.09, '2025-10-15 22:27:49', 'conectado'),
(210, 0, 0, 2879, 96.04, '2025-10-15 22:27:52', 'conectado'),
(211, 0, 0, 3056, 96.29, '2025-10-15 22:27:55', 'conectado'),
(212, 0, 0, 3118, 96.19, '2025-10-15 22:27:58', 'conectado'),
(213, 0, 0, 2864, 96.17, '2025-10-15 22:28:00', 'conectado'),
(214, 0, 0, 2944, 96.14, '2025-10-15 22:28:03', 'conectado'),
(215, 0, 0, 3088, 97.07, '2025-10-15 22:28:06', 'conectado'),
(216, 22.5, 2.96, 2822, 90.26, '2025-10-15 22:28:09', 'conectado'),
(217, 21.25, 3.89, 2535, 89.79, '2025-10-15 22:28:12', 'conectado'),
(218, 21, 1.51, 2806, 90.11, '2025-10-15 22:28:15', 'conectado'),
(219, 21.75, 4.03, 2643, 89.82, '2025-10-15 22:28:18', 'conectado'),
(220, 22, 5.83, 2054, 89.79, '2025-10-15 22:28:21', 'conectado'),
(221, 21.5, 1.34, 2833, 90.18, '2025-10-15 22:28:24', 'conectado'),
(222, 21.75, 0, 2678, 90.11, '2025-10-15 22:28:27', 'conectado'),
(223, 21.75, 0, 2512, 89.89, '2025-10-15 22:28:29', 'conectado'),
(224, 21.5, 2.5, 2662, 90.13, '2025-10-15 22:28:32', 'conectado'),
(225, 22, 2.38, 2074, 90.11, '2025-10-15 22:28:36', 'conectado'),
(226, 21.5, 2.45, 2838, 89.89, '2025-10-15 22:28:39', 'conectado'),
(227, 21.5, 0, 2493, 89.74, '2025-10-15 22:28:41', 'conectado'),
(228, 21.75, 2.13, 2463, 90.13, '2025-10-15 22:28:44', 'conectado'),
(229, 22, 1.3, 2736, 90.09, '2025-10-15 22:28:47', 'conectado'),
(230, 21.5, 1.77, 2559, 90.13, '2025-10-15 22:28:50', 'conectado'),
(231, 21.75, 1.92, 2823, 90.06, '2025-10-15 22:28:53', 'conectado'),
(232, 21.75, 1.35, 2500, 90.18, '2025-10-15 22:28:56', 'conectado'),
(233, 21.75, 0, 2832, 90.28, '2025-10-15 22:28:58', 'conectado'),
(234, 0, 0, 3212, 97.61, '2025-10-15 22:29:01', 'conectado'),
(235, 0, 0, 2501, 96, '2025-10-15 22:29:04', 'conectado'),
(236, 0, 0, 3051, 96.07, '2025-10-15 22:29:07', 'conectado'),
(237, 0, 0, 3088, 96.24, '2025-10-15 22:29:10', 'conectado'),
(238, 0, 0, 3006, 96.09, '2025-10-15 22:29:13', 'conectado'),
(239, 0, 0, 2864, 96.09, '2025-10-15 22:29:16', 'conectado'),
(240, 0, 0, 2967, 96.09, '2025-10-15 22:29:18', 'conectado'),
(241, 0, 0, 3123, 96.34, '2025-10-15 22:29:21', 'conectado'),
(242, 0, 0, 2863, 96.04, '2025-10-15 22:29:24', 'conectado'),
(243, 0, 0, 3122, 96.26, '2025-10-15 22:29:26', 'conectado'),
(244, 0, 0, 2882, 96.04, '2025-10-15 22:29:29', 'conectado'),
(245, 0, 0, 2928, 95.95, '2025-10-15 22:29:31', 'conectado'),
(246, 0, 0, 3086, 95.78, '2025-10-15 22:29:35', 'conectado'),
(247, 0, 0, 3143, 96.19, '2025-10-15 22:29:37', 'conectado'),
(248, 0, 0, 3053, 96.14, '2025-10-15 22:29:40', 'conectado'),
(249, 0, 0, 3090, 96.21, '2025-10-15 22:29:44', 'conectado'),
(250, 0, 0, 3133, 96.12, '2025-10-15 22:29:47', 'conectado'),
(251, 0, 0, 3121, 96.12, '2025-10-15 22:29:50', 'conectado'),
(252, 0, 0, 3126, 96.14, '2025-10-15 22:29:52', 'conectado'),
(253, 0, 0, 3129, 96.29, '2025-10-15 22:29:55', 'conectado'),
(254, 0, 0, 2866, 95.8, '2025-10-15 22:29:57', 'conectado'),
(255, 0, 0, 3119, 96.21, '2025-10-15 22:30:00', 'conectado'),
(256, 0, 0, 3102, 96.09, '2025-10-15 22:30:03', 'conectado'),
(257, 0, 0, 3138, 96.36, '2025-10-15 22:30:06', 'conectado'),
(258, 0, 0, 3055, 96.14, '2025-10-15 22:30:09', 'conectado'),
(259, 0, 0, 3134, 96.02, '2025-10-15 22:30:12', 'conectado'),
(260, 0, 0, 2897, 96, '2025-10-15 22:30:15', 'conectado'),
(261, 0, 0, 3083, 95.8, '2025-10-15 22:30:18', 'conectado'),
(262, 0, 0, 2859, 96.04, '2025-10-15 22:30:21', 'conectado'),
(263, 0, 0, 3126, 96.19, '2025-10-15 22:30:24', 'conectado'),
(264, 0, 0, 3106, 96.24, '2025-10-15 22:30:27', 'conectado'),
(265, 0, 0, 3135, 96.24, '2025-10-15 22:30:30', 'conectado'),
(266, 0, 0, 2975, 96.14, '2025-10-15 22:30:32', 'conectado'),
(267, 0, 0, 2863, 96.02, '2025-10-15 22:30:35', 'conectado'),
(268, 0, 0, 3082, 96.24, '2025-10-15 22:30:38', 'conectado'),
(269, 0, 0, 3056, 96.12, '2025-10-15 22:30:41', 'conectado'),
(270, 0, 0, 3062, 96.14, '2025-10-15 22:30:44', 'conectado'),
(271, 0, 0, 2986, 96.09, '2025-10-15 22:30:46', 'conectado'),
(272, 0, 0, 3056, 95.51, '2025-10-15 22:30:49', 'conectado'),
(273, 0, 0, 3134, 96.19, '2025-10-15 22:30:52', 'conectado'),
(274, 0, 0, 2926, 96.21, '2025-10-15 22:30:54', 'conectado'),
(275, 0, 0, 3088, 95.85, '2025-10-15 22:30:57', 'conectado'),
(276, 0, 0, 3011, 96.07, '2025-10-15 22:30:59', 'conectado'),
(277, 0, 0, 3061, 96.04, '2025-10-15 22:31:02', 'conectado'),
(278, 0, 0, 2849, 96.09, '2025-10-15 22:31:05', 'conectado'),
(279, 0, 0, 2979, 96.12, '2025-10-15 22:31:08', 'conectado'),
(280, 0, 0, 3041, 95.65, '2025-10-15 22:31:10', 'conectado'),
(281, 0, 0, 2852, 95.85, '2025-10-15 22:31:13', 'conectado'),
(282, 0, 0, 2880, 95.75, '2025-10-15 22:31:16', 'conectado'),
(283, 0, 0, 2875, 96.02, '2025-10-15 22:31:19', 'conectado'),
(284, 0, 0, 2873, 95.73, '2025-10-15 22:31:22', 'conectado'),
(285, 0, 0, 2854, 96.04, '2025-10-15 22:31:25', 'conectado'),
(286, 0, 0, 3024, 96.14, '2025-10-15 22:31:28', 'conectado'),
(287, 0, 0, 3134, 96.46, '2025-10-15 22:31:31', 'conectado'),
(288, 0, 0, 2930, 96.14, '2025-10-15 22:31:34', 'conectado'),
(289, 0, 0, 2849, 96.07, '2025-10-15 22:31:37', 'conectado'),
(290, 0, 0, 3055, 96.14, '2025-10-15 22:31:40', 'conectado'),
(291, 0, 0, 2962, 96.02, '2025-10-15 22:31:43', 'conectado'),
(292, 0, 0, 3014, 96.26, '2025-10-15 22:31:46', 'conectado'),
(293, 0, 0, 2990, 96.09, '2025-10-15 22:31:48', 'conectado'),
(294, 0, 0, 3127, 95.85, '2025-10-15 22:31:51', 'conectado'),
(295, 0, 0, 3119, 96.41, '2025-10-15 22:31:54', 'conectado'),
(296, 0, 0, 3120, 96.34, '2025-10-15 22:31:57', 'conectado'),
(297, 0, 0, 3136, 95.85, '2025-10-15 22:31:59', 'conectado'),
(298, 0, 0, 2838, 95.85, '2025-10-15 22:32:02', 'conectado'),
(299, 0, 0, 3129, 96.07, '2025-10-15 22:32:05', 'conectado'),
(300, 0, 0, 3087, 95.95, '2025-10-15 22:32:08', 'conectado'),
(301, 0, 0, 2987, 96.29, '2025-10-15 22:32:10', 'conectado'),
(302, 0, 0, 2905, 95.95, '2025-10-15 22:32:13', 'conectado'),
(303, 0, 0, 3137, 96, '2025-10-15 22:32:16', 'conectado'),
(304, 0, 0, 2869, 95.85, '2025-10-15 22:32:19', 'conectado'),
(305, 0, 0, 3041, 96.17, '2025-10-15 22:32:22', 'conectado'),
(306, 0, 0, 3120, 96.48, '2025-10-15 22:32:24', 'conectado'),
(307, 0, 0, 2999, 96.68, '2025-10-15 22:32:27', 'conectado'),
(308, 0, 0, 3103, 96.12, '2025-10-15 22:32:30', 'conectado'),
(309, 0, 0, 2879, 95.87, '2025-10-15 22:32:33', 'conectado'),
(310, 0, 0, 2975, 96.07, '2025-10-15 22:32:36', 'conectado'),
(311, 0, 0, 2902, 96.19, '2025-10-15 22:32:39', 'conectado'),
(312, 0, 0, 2947, 96.14, '2025-10-15 22:32:42', 'conectado'),
(313, 0, 0, 2847, 96.04, '2025-10-15 22:32:45', 'conectado'),
(314, 0, 0, 2937, 95.82, '2025-10-15 22:32:48', 'conectado'),
(315, 0, 0, 3088, 95.73, '2025-10-15 22:32:51', 'conectado'),
(316, 0, 0, 2866, 96.48, '2025-10-15 22:32:54', 'conectado'),
(317, 0, 0, 2944, 95.9, '2025-10-15 22:32:57', 'conectado'),
(318, 0, 0, 2861, 96, '2025-10-15 22:32:59', 'conectado'),
(319, 0, 0, 2849, 95.9, '2025-10-15 22:33:02', 'conectado'),
(320, 0, 0, 3130, 96, '2025-10-15 22:33:06', 'conectado'),
(321, 0, 0, 4095, 23.42, '2025-10-15 22:36:46', 'conectado'),
(322, 0, 0, 4095, 15.65, '2025-10-15 22:36:49', 'conectado'),
(323, 0, 0, 4095, 16.17, '2025-10-15 22:36:52', 'conectado'),
(324, 0, 0, 4095, 3.52, '2025-10-15 22:36:54', 'conectado'),
(325, 0, 0, 4095, 0, '2025-10-15 22:36:57', 'conectado'),
(326, 0, 0, 4095, 16, '2025-10-15 22:36:59', 'conectado'),
(327, 0, 0, 4095, 0, '2025-10-15 22:37:02', 'conectado'),
(328, 0, 0, 4095, 4.54, '2025-10-15 22:37:05', 'conectado'),
(329, 0, 0, 4095, 14.7, '2025-10-15 22:37:08', 'conectado'),
(330, 0, 0, 4095, 0, '2025-10-15 22:37:10', 'conectado'),
(331, 22.5, 9.94, 2519, 21.37, '2025-10-15 22:37:38', 'conectado'),
(332, 22.5, 9.69, 2687, 30.89, '2025-10-15 22:37:40', 'conectado'),
(333, 22.25, 9.98, 2615, 26.98, '2025-10-15 22:37:43', 'conectado'),
(334, 22.5, 6.59, 2804, 19.88, '2025-10-15 22:37:45', 'conectado'),
(335, 22.25, 9.95, 2534, 34.68, '2025-10-15 22:37:48', 'conectado'),
(336, 22.5, 10.07, 2806, 13.19, '2025-10-15 22:37:50', 'conectado'),
(337, 22.25, 7.63, 2627, 0, '2025-10-15 22:37:52', 'conectado'),
(338, 22.5, 0, 2835, 65.08, '2025-10-15 22:37:55', 'conectado'),
(339, 22, 0, 2821, 12.92, '2025-10-15 22:37:58', 'conectado'),
(340, 22.5, 9.91, 2829, 63.76, '2025-10-15 22:38:00', 'conectado'),
(341, 22.5, 7.31, 2768, 0, '2025-10-15 22:38:03', 'conectado'),
(342, 22.5, 9.81, 2811, 0, '2025-10-15 22:38:06', 'conectado'),
(343, 0, 0, 0, 0, '2025-10-15 22:38:09', 'conectado'),
(344, 22.5, 0, 2937, 10.04, '2025-10-15 22:38:09', 'conectado'),
(345, 22.75, 8.4, 2601, 9.91, '2025-10-15 22:38:12', 'conectado'),
(346, 22.25, 0, 2947, 90.33, '2025-10-15 22:38:15', 'conectado'),
(347, 22.5, 0, 2919, 100, '2025-10-15 22:38:18', 'conectado'),
(348, 22.5, 0, 2931, 76.51, '2025-10-15 22:38:21', 'conectado'),
(349, 22.25, 0, 2919, 64.79, '2025-10-15 22:38:24', 'conectado'),
(350, 22.5, 0, 2906, 64.81, '2025-10-15 22:38:27', 'conectado'),
(351, 22.25, 0, 2946, 64.79, '2025-10-15 22:38:30', 'conectado'),
(352, 22.25, 0, 2746, 64.79, '2025-10-15 22:38:33', 'conectado'),
(353, 22, 0, 2887, 64.84, '2025-10-15 22:38:36', 'conectado'),
(354, 22.25, 0, 2687, 64.81, '2025-10-15 22:38:39', 'conectado'),
(355, 22.75, 0, 1365, 64.93, '2025-10-15 22:39:20', 'conectado'),
(356, 22.75, 0, 2559, 64.86, '2025-10-15 22:39:23', 'conectado'),
(357, 22.5, 0, 2586, 64.74, '2025-10-15 22:39:26', 'conectado'),
(358, 22.25, 0, 2640, 64.74, '2025-10-15 22:39:28', 'conectado'),
(359, 22.25, 0, 2807, 64.81, '2025-10-15 22:39:32', 'conectado'),
(360, 22.25, 0, 1177, 64.59, '2025-10-15 22:39:35', 'conectado'),
(361, 22, 0, 2021, 64.47, '2025-10-15 22:39:38', 'conectado'),
(362, 22, 0, 2880, 64.84, '2025-10-15 22:39:41', 'conectado'),
(363, 22.5, 0, 2241, 64.59, '2025-10-15 22:39:45', 'conectado'),
(364, 22, 0, 2384, 64.71, '2025-10-15 22:39:48', 'conectado'),
(365, 22.25, 0, 2660, 64.47, '2025-10-15 22:39:50', 'conectado'),
(366, 22.25, 0, 2885, 64.88, '2025-10-15 22:39:54', 'conectado'),
(367, 22.25, 0, 2752, 64.86, '2025-10-15 22:39:57', 'conectado'),
(368, 22.5, 0, 2935, 64.81, '2025-10-15 22:40:00', 'conectado'),
(369, 21.75, 0, 2559, 64.79, '2025-10-15 22:40:03', 'conectado'),
(370, 22.5, 0, 2709, 64.74, '2025-10-15 22:40:06', 'conectado'),
(371, 22.25, 0, 2687, 64.74, '2025-10-15 22:40:09', 'conectado'),
(372, 22.5, 0, 2627, 64.79, '2025-10-15 22:40:11', 'conectado'),
(373, 22.25, 0, 2695, 64.79, '2025-10-15 22:40:15', 'conectado'),
(374, 22, 0, 2559, 64.79, '2025-10-15 22:40:18', 'conectado'),
(375, 22, 0, 2559, 64.71, '2025-10-15 22:40:20', 'conectado'),
(376, 22, 0, 2903, 64.84, '2025-10-15 22:40:23', 'conectado'),
(377, 22.25, 0, 2772, 64.79, '2025-10-15 22:40:26', 'conectado'),
(378, 22.5, 0, 2606, 64.59, '2025-10-15 22:40:29', 'conectado'),
(379, 22.5, 0, 2715, 64.49, '2025-10-15 22:40:32', 'conectado'),
(380, 22.25, 0, 2621, 64.74, '2025-10-15 22:40:35', 'conectado'),
(381, 22.5, 0, 2915, 64.84, '2025-10-15 22:40:38', 'conectado'),
(382, 22, 0, 2812, 64.81, '2025-10-15 22:40:41', 'conectado'),
(383, 22.25, 0, 2886, 64.86, '2025-10-15 22:40:44', 'conectado'),
(384, 21.75, 0, 2100, 64.76, '2025-10-15 22:40:47', 'conectado'),
(385, 22.25, 0, 2559, 64.64, '2025-10-15 22:40:49', 'conectado'),
(386, 22.5, 0, 2375, 64.71, '2025-10-15 22:40:52', 'conectado'),
(387, 21.5, 0, 2747, 64.81, '2025-10-15 22:40:55', 'conectado'),
(388, 22.25, 0, 2902, 64.84, '2025-10-15 22:40:58', 'conectado'),
(389, 22.75, 0, 2658, 64.76, '2025-10-15 22:41:01', 'conectado'),
(390, 22.25, 0, 2848, 64.88, '2025-10-15 22:41:04', 'conectado'),
(391, 88, 0, 3553, 88.67, '2025-10-15 22:41:07', 'conectado'),
(392, 176, 0, 3390, 88.33, '2025-10-15 22:41:10', 'conectado'),
(393, 176, 0, 3530, 88.47, '2025-10-15 22:41:12', 'conectado'),
(394, 352, 0, 3550, 88.67, '2025-10-15 22:41:15', 'conectado'),
(395, 44, 0, 3472, 88.47, '2025-10-15 22:41:18', 'conectado'),
(396, 176, 0, 3451, 88.64, '2025-10-15 22:41:22', 'conectado'),
(397, 176, 0, 3458, 88.3, '2025-10-15 22:41:25', 'conectado'),
(398, 176, 0, 3493, 88.47, '2025-10-15 22:41:28', 'conectado'),
(399, 176, 0, 3501, 88.57, '2025-10-15 22:41:31', 'conectado'),
(400, 176, 0, 3443, 88.38, '2025-10-15 22:41:34', 'conectado');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `conexiones_log`
--
ALTER TABLE `conexiones_log`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_iot`
--
ALTER TABLE `estado_iot`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lecturas`
--
ALTER TABLE `lecturas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_fecha` (`fecha_hora`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `conexiones_log`
--
ALTER TABLE `conexiones_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lecturas`
--
ALTER TABLE `lecturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=401;
--
-- Base de datos: `stockdev`
--
CREATE DATABASE IF NOT EXISTS `stockdev` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `stockdev`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `monto` varchar(9) DEFAULT NULL,
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(12) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajachica`
--

CREATE TABLE `cajachica` (
  `id` int(11) NOT NULL,
  `monto` varchar(9) DEFAULT NULL,
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(12) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajachicaregistros`
--

CREATE TABLE `cajachicaregistros` (
  `id` int(15) NOT NULL,
  `monto` varchar(9) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(12) DEFAULT NULL,
  `Detalle` text DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajaregistros`
--

CREATE TABLE `cajaregistros` (
  `id` int(15) NOT NULL,
  `monto` varchar(9) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(12) DEFAULT NULL,
  `detalle` varchar(75) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajatmp`
--

CREATE TABLE `cajatmp` (
  `id` int(25) NOT NULL,
  `idfactura` int(25) DEFAULT NULL,
  `producto` int(2) DEFAULT NULL,
  `cantidad` int(5) DEFAULT 1,
  `precio` float DEFAULT NULL,
  `totalprecio` float DEFAULT NULL,
  `vendedor` int(9) DEFAULT NULL,
  `cliente` int(9) DEFAULT 1,
  `stockTmp` int(9) DEFAULT 0,
  `stock` int(9) DEFAULT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canton`
--

CREATE TABLE `canton` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `id_provincia` smallint(5) UNSIGNED NOT NULL,
  `canton` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `canton`
--

INSERT INTO `canton` (`id`, `id_provincia`, `canton`) VALUES
(101, 1, 'San Jos??'),
(102, 1, 'Escaz??'),
(103, 1, 'Desamparados'),
(104, 1, 'Puriscal'),
(105, 1, 'Tarraz??'),
(106, 1, 'Aserr??'),
(107, 1, 'Mora'),
(108, 1, 'Goicoechea'),
(109, 1, 'Santa Ana'),
(110, 1, 'Alajuelita'),
(111, 1, 'Vasquez de Coronado'),
(112, 1, 'Acosta'),
(113, 1, 'Tib??s'),
(114, 1, 'Moravia'),
(115, 1, 'Montes de Oca'),
(116, 1, 'Turrubares'),
(117, 1, 'Dota'),
(118, 1, 'Curridabat'),
(119, 1, 'P??rez Zeled??n'),
(120, 1, 'Le??n Cort??s'),
(201, 2, 'Alajuela'),
(202, 2, 'San Ram??n'),
(203, 2, 'Grecia'),
(204, 2, 'San Mateo'),
(205, 2, 'Atenas'),
(206, 2, 'Naranjo'),
(207, 2, 'Palmares'),
(208, 2, 'Po??s'),
(209, 2, 'Orotina'),
(210, 2, 'San Carlos'),
(211, 2, 'Alfaro Ruiz'),
(212, 2, 'Valverde Vega'),
(213, 2, 'Upala'),
(214, 2, 'Los Chiles'),
(215, 2, 'Guatuso'),
(301, 3, 'Cartago'),
(302, 3, 'Para??so'),
(303, 3, 'La Uni??n'),
(304, 3, 'Jim??nez'),
(305, 3, 'Turrialba'),
(306, 3, 'Alvarado'),
(307, 3, 'Oreamuno'),
(308, 3, 'El Guarco'),
(401, 4, 'Heredia'),
(402, 4, 'Barva'),
(403, 4, 'Santo Domingo'),
(404, 4, 'Santa B??rbara'),
(405, 4, 'San Rafael'),
(406, 4, 'San Isidro'),
(407, 4, 'Bel??n'),
(408, 4, 'Flores'),
(409, 4, 'San Pablo'),
(410, 4, 'Sarapiqu?? '),
(501, 5, 'Liberia'),
(502, 5, 'Nicoya'),
(503, 5, 'Santa Cruz'),
(504, 5, 'Bagaces'),
(505, 5, 'Carrillo'),
(506, 5, 'Ca??as'),
(507, 5, 'Abangares'),
(508, 5, 'Tilar??n'),
(509, 5, 'Nandayure'),
(510, 5, 'La Cruz'),
(511, 5, 'Hojancha'),
(601, 6, 'Puntarenas'),
(602, 6, 'Esparza'),
(603, 6, 'Buenos Aires'),
(604, 6, 'Montes de Oro'),
(605, 6, 'Osa'),
(606, 6, 'Aguirre'),
(607, 6, 'Golfito'),
(608, 6, 'Coto Brus'),
(609, 6, 'Parrita'),
(610, 6, 'Corredores'),
(611, 6, 'Garabito'),
(701, 7, 'Lim??n'),
(702, 7, 'Pococ??'),
(703, 7, 'Siquirres'),
(704, 7, 'Talamanca'),
(705, 7, 'Matina'),
(706, 7, 'Gu??cimo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cierre`
--

CREATE TABLE `cierre` (
  `id` int(25) NOT NULL,
  `numero` int(2) DEFAULT NULL,
  `valor` int(5) DEFAULT NULL,
  `tipo` varchar(35) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL,
  `vendedor` varchar(35) DEFAULT NULL,
  `cliente` varchar(35) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(9) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descuento` varchar(4) DEFAULT '0',
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `descuento`, `habilitado`) VALUES
(1, 'Cliente Contado', '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credito`
--

CREATE TABLE `credito` (
  `id` int(25) NOT NULL,
  `id_cliente` int(25) DEFAULT NULL,
  `deuda` int(25) DEFAULT NULL,
  `deudaNeta` int(25) DEFAULT NULL,
  `saldo` int(25) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `interes` int(5) DEFAULT NULL,
  `cuota` varchar(25) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(9) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `habilitada` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`, `habilitada`) VALUES
(1, 'Gen??rico ', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `distrito`
--

CREATE TABLE `distrito` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_canton` smallint(5) UNSIGNED NOT NULL,
  `distrito` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `distrito`
--

INSERT INTO `distrito` (`id`, `id_canton`, `distrito`) VALUES
(10101, 101, 'Carmen'),
(10102, 101, 'Merced'),
(10103, 101, 'Hospital'),
(10104, 101, 'Catedral'),
(10105, 101, 'Zapote'),
(10106, 101, 'San Francisco de Dos R??os'),
(10107, 101, 'Uruca'),
(10108, 101, 'Mata Redonda'),
(10109, 101, 'Pavas'),
(10110, 101, 'Hatillo'),
(10111, 101, 'San Sebasti??n'),
(10201, 102, 'Escaz??'),
(10202, 102, 'San Antonio'),
(10203, 102, 'San Rafael'),
(10301, 103, 'Desamparados'),
(10302, 103, 'San Miguel'),
(10303, 103, 'San Juan de Dios'),
(10304, 103, 'San Rafael Arriba'),
(10305, 103, 'San Antonio'),
(10306, 103, 'Frailes'),
(10307, 103, 'Patarr??'),
(10308, 103, 'San Crist??bal'),
(10309, 103, 'Rosario'),
(10310, 103, 'Damas'),
(10311, 103, 'San Rafael Abajo'),
(10312, 103, 'Gravilias'),
(10313, 103, 'Los Guido'),
(10401, 104, 'Santiago'),
(10402, 104, 'Mercedes Sur'),
(10403, 104, 'Barbacoas'),
(10404, 104, 'Grifo Alto'),
(10405, 104, 'San Rafael'),
(10406, 104, 'Candelaria'),
(10407, 104, 'Desamparaditos'),
(10408, 104, 'San Antonio'),
(10409, 104, 'Chires'),
(10501, 105, 'San Marcos'),
(10502, 105, 'San Lorenzo'),
(10503, 105, 'San Carlos'),
(10601, 106, 'Aserr??'),
(10602, 106, 'Tarbaca o Praga'),
(10603, 106, 'Vuelta de Jorco'),
(10604, 106, 'San Gabriel'),
(10605, 106, 'La Legua'),
(10606, 106, 'Monterrey'),
(10607, 106, 'Salitrillos'),
(10701, 107, 'Col??n'),
(10702, 107, 'Guayabo'),
(10703, 107, 'Tabarcia'),
(10704, 107, 'Piedras Negras'),
(10705, 107, 'Picagres'),
(10801, 108, 'Guadalupe'),
(10802, 108, 'San Francisco'),
(10803, 108, 'Calle Blancos'),
(10804, 108, 'Mata de Pl??tano'),
(10805, 108, 'Ip??s'),
(10806, 108, 'Rancho Redondo'),
(10807, 108, 'Purral'),
(10901, 109, 'Santa Ana'),
(10902, 109, 'Salitral'),
(10903, 109, 'Pozos o Concepci??n'),
(10904, 109, 'Uruca o San Joaqu??n'),
(10905, 109, 'Piedades'),
(10906, 109, 'Brasil'),
(11001, 110, 'Alajuelita'),
(11002, 110, 'San Josecito'),
(11003, 110, 'San Antonio'),
(11004, 110, 'Concepci??n'),
(11005, 110, 'San Felipe'),
(11101, 111, 'San Isidro'),
(11102, 111, 'San Rafael'),
(11103, 111, 'Dulce Nombre de Jes??s'),
(11104, 111, 'Patalillo'),
(11105, 111, 'Cascajal'),
(11201, 112, 'San Ignacio'),
(11202, 112, 'Guaitil'),
(11203, 112, 'Palmichal'),
(11204, 112, 'Cangrejal'),
(11205, 112, 'Sabanillas'),
(11301, 113, 'San Juan'),
(11302, 113, 'Cinco Esquinas'),
(11303, 113, 'Anselmo Llorente'),
(11304, 113, 'Le??n XIII'),
(11305, 113, 'Colima'),
(11401, 114, 'San Vicente'),
(11402, 114, 'San Jer??nimo'),
(11403, 114, 'Trinidad'),
(11501, 115, 'San Pedro'),
(11502, 115, 'Sabanilla'),
(11503, 115, 'Mercedes o Betania'),
(11504, 115, 'San Rafael'),
(11601, 116, 'San Pablo'),
(11602, 116, 'San Pedro'),
(11603, 116, 'San Juan de Mata'),
(11604, 116, 'San Luis'),
(11605, 116, 'C??rara'),
(11701, 117, 'Santa Mar??a'),
(11702, 117, 'Jard??n'),
(11703, 117, 'Copey'),
(11801, 118, 'Curridabat'),
(11802, 118, 'Granadilla'),
(11803, 118, 'S??nchez'),
(11804, 118, 'Tirrases'),
(11901, 119, 'San Isidro de el General'),
(11902, 119, 'General'),
(11903, 119, 'Daniel Flores'),
(11904, 119, 'Rivas'),
(11905, 119, 'San Pedro'),
(11906, 119, 'Platanares'),
(11907, 119, 'Pejibaye'),
(11908, 119, 'Caj??n'),
(11909, 119, 'Bar??'),
(11910, 119, 'R??o Nuevo'),
(11911, 119, 'P??ramo'),
(12001, 120, 'San Pablo'),
(12002, 120, 'San Andr??s'),
(12003, 120, 'Llano Bonito'),
(12004, 120, 'San Isidro'),
(12005, 120, 'Santa Cruz'),
(12006, 120, 'San Antonio'),
(20101, 201, 'Alajuela'),
(20102, 201, 'San Jos??'),
(20103, 201, 'Carrizal'),
(20104, 201, 'San Antonio'),
(20105, 201, 'Gu??cima'),
(20106, 201, 'San Isidro'),
(20107, 201, 'Sabanilla'),
(20108, 201, 'San Rafael'),
(20109, 201, 'R??o Segundo'),
(20110, 201, 'Desamparados'),
(20111, 201, 'Turrucares'),
(20112, 201, 'Tambor'),
(20113, 201, 'La Garita'),
(20114, 201, 'Sarapiqu??'),
(20201, 202, 'San Ram??n'),
(20202, 202, 'Santiago'),
(20203, 202, 'San Juan'),
(20204, 202, 'Piedades Norte'),
(20205, 202, 'Piedades Sur'),
(20206, 202, 'San Rafael'),
(20207, 202, 'San Isidro'),
(20208, 202, 'Angeles'),
(20209, 202, 'Alfaro'),
(20210, 202, 'Volio'),
(20211, 202, 'Concepci??n'),
(20212, 202, 'Zapotal'),
(20213, 202, 'San Isidro de Pe??as Blancas'),
(20301, 203, 'Grecia'),
(20302, 203, 'San Isidro'),
(20303, 203, 'San Jos??'),
(20304, 203, 'San Roque'),
(20305, 203, 'Tacares'),
(20306, 203, 'R??o Cuarto'),
(20307, 203, 'Puente Piedra'),
(20308, 203, 'Bol??var'),
(20401, 204, 'San Mateo'),
(20402, 204, 'Desmonte'),
(20403, 204, 'Jes??s Mar??a'),
(20501, 205, 'Atenas'),
(20502, 205, 'Jes??s'),
(20503, 205, 'Mercedes'),
(20504, 205, 'San Isidro'),
(20505, 205, 'Concepci??n'),
(20506, 205, 'San Jos??'),
(20507, 205, 'Santa Eulalia'),
(20508, 205, 'Escobal'),
(20601, 206, 'Naranjo'),
(20602, 206, 'San Miguel'),
(20603, 206, 'San Jos??'),
(20604, 206, 'Cirr?? Sur'),
(20605, 206, 'San Jer??nimo'),
(20606, 206, 'San Juan'),
(20607, 206, 'Rosario'),
(20701, 207, 'Palmares'),
(20702, 207, 'Zaragoza'),
(20703, 207, 'Buenos Aires'),
(20704, 207, 'Santiago'),
(20705, 207, 'Candelaria'),
(20706, 207, 'Esquipulas'),
(20707, 207, 'La Granja'),
(20801, 208, 'San Pedro'),
(20802, 208, 'San Juan'),
(20803, 208, 'San Rafael'),
(20804, 208, 'Carrillos'),
(20805, 208, 'Sabana Redonda'),
(20901, 209, 'Orotina'),
(20902, 209, 'Mastate'),
(20903, 209, 'Hacienda Vieja'),
(20904, 209, 'Coyolar'),
(20905, 209, 'Ceiba'),
(21001, 210, 'Quesada'),
(21002, 210, 'Florencia'),
(21003, 210, 'Buenavista'),
(21004, 210, 'Aguas Zarcas'),
(21005, 210, 'Venecia'),
(21006, 210, 'Pital'),
(21007, 210, 'Fortuna'),
(21008, 210, 'Tigra'),
(21009, 210, 'Palmera'),
(21010, 210, 'Venado'),
(21011, 210, 'Cutris'),
(21012, 210, 'Monterrey'),
(21013, 210, 'Pocosol'),
(21101, 211, 'Zarcero'),
(21102, 211, 'Laguna'),
(21103, 211, 'Tapezco'),
(21104, 211, 'Guadalupe'),
(21105, 211, 'Palmira'),
(21106, 211, 'Zapote'),
(21107, 211, 'Las Brisas'),
(21201, 212, 'Sarch?? Norte'),
(21202, 212, 'Sarch?? Sur'),
(21203, 212, 'Toro Amarillo'),
(21204, 212, 'San Pedro'),
(21205, 212, 'Rodr??guez'),
(21301, 213, 'Upala'),
(21302, 213, 'Aguas Claras'),
(21303, 213, 'San Jos?? o Pizote'),
(21304, 213, 'Bijagua'),
(21305, 213, 'Delicias'),
(21306, 213, 'Dos R??os'),
(21307, 213, 'Yolillal'),
(21401, 214, 'Los Chiles'),
(21402, 214, 'Ca??o Negro'),
(21403, 214, 'Amparo'),
(21404, 214, 'San Jorge'),
(21501, 215, 'San Rafael'),
(21502, 215, 'Buenavista'),
(21503, 215, 'Cote'),
(30101, 301, 'Oriental'),
(30102, 301, 'Occidental'),
(30103, 301, 'Carmen'),
(30104, 301, 'San Nicol??s'),
(30105, 301, 'Aguacaliente o San Francisco'),
(30106, 301, 'Guadalupe o Arenilla'),
(30107, 301, 'Corralillo'),
(30108, 301, 'Tierra Blanca'),
(30109, 301, 'Dulce Nombre'),
(30110, 301, 'Llano Grande'),
(30111, 301, 'Quebradilla'),
(30201, 302, 'Para??so'),
(30202, 302, 'Santiago'),
(30203, 302, 'Orosi'),
(30204, 302, 'Cach??'),
(30205, 302, 'Los Llanos de Santa Luc??a'),
(30301, 303, 'Tres R??os'),
(30302, 303, 'San Diego'),
(30303, 303, 'San Juan'),
(30304, 303, 'San Rafael'),
(30305, 303, 'Concepci??n'),
(30306, 303, 'Dulce Nombre'),
(30307, 303, 'San Ram??n'),
(30308, 303, 'R??o Azul'),
(30401, 304, 'Juan Vi??as'),
(30402, 304, 'Tucurrique'),
(30403, 304, 'Pejibaye'),
(30501, 305, 'Turrialba'),
(30502, 305, 'La Suiza'),
(30503, 305, 'Peralta'),
(30504, 305, 'Santa Cruz'),
(30505, 305, 'Santa Teresita'),
(30506, 305, 'Pavones'),
(30507, 305, 'Tuis'),
(30508, 305, 'Tayutic'),
(30509, 305, 'Santa Rosa'),
(30510, 305, 'Tres Equis'),
(30511, 305, 'La Isabel'),
(30512, 305, 'Chirrip??'),
(30601, 306, 'Pacayas'),
(30602, 306, 'Cervantes'),
(30603, 306, 'Capellades'),
(30701, 307, 'San Rafael'),
(30702, 307, 'Cot'),
(30703, 307, 'Potrero Cerrado'),
(30704, 307, 'Cipreses'),
(30705, 307, 'Santa Rosa'),
(30801, 308, 'El Tejar'),
(30802, 308, 'San Isidro'),
(30803, 308, 'Tobosi'),
(30804, 308, 'Patio de Agua'),
(40101, 401, 'Heredia'),
(40102, 401, 'Mercedes'),
(40103, 401, 'San Francisco'),
(40104, 401, 'Ulloa'),
(40105, 401, 'Varablanca'),
(40201, 402, 'Barva'),
(40202, 402, 'San Pedro'),
(40203, 402, 'San Pablo'),
(40204, 402, 'San Roque'),
(40205, 402, 'Santa Luc??a'),
(40206, 402, 'San Jos?? de la Monta??a'),
(40301, 403, 'Santo Domingo'),
(40302, 403, 'San Vicente'),
(40303, 403, 'San Miguel'),
(40304, 403, 'Paracito'),
(40305, 403, 'Santo Tom??s'),
(40306, 403, 'Santa Rosa'),
(40307, 403, 'Tures'),
(40308, 403, 'Par??'),
(40401, 404, 'Santa B??rbara'),
(40402, 404, 'San Pedro'),
(40403, 404, 'San Juan'),
(40404, 404, 'Jes??s'),
(40405, 404, 'Santo Domingo del Roble'),
(40406, 404, 'Puraba'),
(40501, 405, 'San Rafael'),
(40502, 405, 'San Josecito'),
(40503, 405, 'Santiago'),
(40504, 405, 'Angeles'),
(40505, 405, 'Concepci??n'),
(40601, 406, 'San Isidro'),
(40602, 406, 'San Jos??'),
(40603, 406, 'Concepci??n'),
(40604, 406, 'San Francisco'),
(40701, 407, 'San Antonio'),
(40702, 407, 'La Ribera'),
(40703, 407, 'Asunci??n'),
(40801, 408, 'San Joaqu??n'),
(40802, 408, 'Barrantes'),
(40803, 408, 'Llorente'),
(40901, 409, 'San Pablo'),
(41001, 410, 'Puerto Viejo'),
(41002, 410, 'La Virgen'),
(41003, 410, 'Horquetas'),
(41004, 410, 'Llanuras de Gaspar'),
(41005, 410, 'Cure??a'),
(50101, 501, 'Liberia'),
(50102, 501, 'Ca??as Dulces'),
(50103, 501, 'Mayorga'),
(50104, 501, 'Nacascolo'),
(50105, 501, 'Curubande'),
(50201, 502, 'Nicoya'),
(50202, 502, 'Mansi??n'),
(50203, 502, 'San Antonio'),
(50204, 502, 'Quebrada Honda'),
(50205, 502, 'S??mara'),
(50206, 502, 'N??sara'),
(50207, 502, 'Bel??n de Nosarita'),
(50301, 503, 'Santa Cruz'),
(50302, 503, 'Bols??n'),
(50303, 503, 'Veintisiete de Abril'),
(50304, 503, 'Tempate'),
(50305, 503, 'Cartagena'),
(50306, 503, 'Cuajiniquil'),
(50307, 503, 'Diri??'),
(50308, 503, 'Cabo Velas'),
(50309, 503, 'Tamarindo'),
(50401, 504, 'Bagaces'),
(50402, 504, 'Fortuna'),
(50403, 504, 'Mogote'),
(50404, 504, 'R??o Naranjo'),
(50501, 505, 'Filadelfia'),
(50502, 505, 'Palmira'),
(50503, 505, 'Sardinal'),
(50504, 505, 'Bel??n'),
(50601, 506, 'Ca??as'),
(50602, 506, 'Palmira'),
(50603, 506, 'San Miguel'),
(50604, 506, 'Bebedero'),
(50605, 506, 'Porozal'),
(50701, 507, 'Juntas'),
(50702, 507, 'Sierra'),
(50703, 507, 'San Juan'),
(50704, 507, 'Colorado'),
(50801, 508, 'Tilar??n'),
(50802, 508, 'Quebrada Grande'),
(50803, 508, 'Tronadora'),
(50804, 508, 'Santa Rosa'),
(50805, 508, 'L??bano'),
(50806, 508, 'Tierras Morenas'),
(50807, 508, 'Arenal'),
(50901, 509, 'Carmona'),
(50902, 509, 'Santa Rita'),
(50903, 509, 'Zapotal'),
(50904, 509, 'San Pablo'),
(50905, 509, 'Porvenir'),
(50906, 509, 'Bejuco'),
(51001, 510, 'La Cruz'),
(51002, 510, 'Santa Cecilia'),
(51003, 510, 'Garita'),
(51004, 510, 'Santa Elena'),
(51101, 511, 'Hojancha'),
(51102, 511, 'Monte Romo'),
(51103, 511, 'Puerto Carrillo'),
(51104, 511, 'Huacas'),
(60101, 601, 'Puntarenas'),
(60102, 601, 'Pitahaya'),
(60103, 601, 'Chomes'),
(60104, 601, 'Lepanto'),
(60105, 601, 'Paquera'),
(60106, 601, 'Manzanillo'),
(60107, 601, 'Guacimal'),
(60108, 601, 'Barranca'),
(60109, 601, 'Monte Verde'),
(60110, 601, 'Isla del Coco'),
(60111, 601, 'C??bano'),
(60112, 601, 'Chacarita'),
(60113, 601, 'Chira'),
(60114, 601, 'Acapulco'),
(60115, 601, 'Roble'),
(60116, 601, 'Arancibia'),
(60201, 602, 'Esp??ritu Santo'),
(60202, 602, 'San Juan Grande'),
(60203, 602, 'Macacona'),
(60204, 602, 'San Rafael'),
(60205, 602, 'San Jer??nimo'),
(60301, 603, 'Buenos Aires'),
(60302, 603, 'Volc??n'),
(60303, 603, 'Potrero Grande'),
(60304, 603, 'Boruca'),
(60305, 603, 'Pilas'),
(60306, 603, 'Colinas o Bajo de Ma??z'),
(60307, 603, 'Ch??nguena'),
(60308, 603, 'Bioley'),
(60309, 603, 'Brunka'),
(60401, 604, 'Miramar'),
(60402, 604, 'Uni??n'),
(60403, 604, 'San Isidro'),
(60501, 605, 'Puerto Cort??s'),
(60502, 605, 'Palmar'),
(60503, 605, 'Sierpe'),
(60504, 605, 'Bah??a Ballena'),
(60505, 605, 'Piedras Blancas'),
(60601, 606, 'Quepos'),
(60602, 606, 'Savegre'),
(60603, 606, 'Naranjito'),
(60701, 607, 'Golfito'),
(60702, 607, 'Puerto Jim??nez'),
(60703, 607, 'Guaycar??'),
(60704, 607, 'Pavon'),
(60801, 608, 'San Vito'),
(60802, 608, 'Sabalito'),
(60803, 608, 'Agua Buena'),
(60804, 608, 'Limoncito'),
(60805, 608, 'Pittier'),
(60901, 609, 'Parrita'),
(61001, 610, 'Corredor'),
(61002, 610, 'La Cuesta'),
(61003, 610, 'Paso Canoas'),
(61004, 610, 'Laurel'),
(61101, 611, 'Jac??'),
(61102, 611, 'T??rcoles'),
(70101, 701, 'Lim??n'),
(70102, 701, 'Valle La Estrella'),
(70103, 701, 'R??o Blanco'),
(70104, 701, 'Matama'),
(70201, 702, 'Gu??piles'),
(70202, 702, 'Jim??nez'),
(70203, 702, 'Rita'),
(70204, 702, 'Roxana'),
(70205, 702, 'Cariari'),
(70206, 702, 'Colorado'),
(70301, 703, 'Siquirres'),
(70302, 703, 'Pacuarito'),
(70303, 703, 'Florida'),
(70304, 703, 'Germania'),
(70305, 703, 'Cairo'),
(70306, 703, 'Alegr??a'),
(70401, 704, 'Bratsi'),
(70402, 704, 'Sixaola'),
(70403, 704, 'Cahuita'),
(70404, 704, 'Telire'),
(70501, 705, 'Matina'),
(70502, 705, 'Bat??n'),
(70503, 705, 'Carrand??'),
(70601, 706, 'Gu??cimo'),
(70602, 706, 'Mercedes'),
(70603, 706, 'Pocora'),
(70604, 706, 'R??o Jim??nez'),
(70605, 706, 'Duacar??');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradasalidaregistro`
--

CREATE TABLE `entradasalidaregistro` (
  `id` int(15) NOT NULL,
  `monto` varchar(9) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `fecha` varchar(12) DEFAULT NULL,
  `hora` varchar(12) DEFAULT NULL,
  `Detalle` text DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `establecimiento`
--

CREATE TABLE `establecimiento` (
  `id` int(9) NOT NULL,
  `nombre` varchar(35) DEFAULT NULL,
  `telefono` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `establecimiento`
--

INSERT INTO `establecimiento` (`id`, `nombre`, `telefono`) VALUES
(1, 'Souvenir #1', '26661234'),
(2, 'Souvenir #2', '26661235'),
(3, 'Souvenir #3', '26665432');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(20) NOT NULL,
  `total` varchar(20) DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL,
  `hora` varchar(25) DEFAULT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `cliente` varchar(30) DEFAULT '1',
  `tipo` tinyint(1) DEFAULT 1,
  `habilitado` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `total`, `fecha`, `hora`, `usuario`, `cliente`, `tipo`, `habilitado`) VALUES
(1, '6,0', '10-01-2026', '07:32:04 pm', '2', '1', 0, 0),
(2, '61,0', '10-01-2026', '08:32:35 pm', '2', '1', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iva`
--

CREATE TABLE `iva` (
  `id` int(9) NOT NULL COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)',
  `nombre` varchar(50) DEFAULT NULL COMMENT 'Nombre del impuesto de venta',
  `valor` int(4) DEFAULT NULL COMMENT 'Valor del impuesto de venta',
  `habilitado` tinyint(1) DEFAULT NULL COMMENT 'Determina si el registro es v??lido para utilizarse o se debe ignorar para operaciones sobre los datos.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `iva`
--

INSERT INTO `iva` (`id`, `nombre`, `valor`, `habilitado`) VALUES
(1, 'Sin Impuesto de Venta', 0, 1),
(2, 'Impuesto de Venta', 13, 1),
(3, 'Impuesto de Servicio', 10, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id` int(5) NOT NULL,
  `producto` varchar(255) DEFAULT NULL,
  `entrada` int(11) DEFAULT 0,
  `salida` int(11) DEFAULT 0,
  `stock` int(11) DEFAULT NULL,
  `preciounitario` varchar(15) DEFAULT NULL,
  `preciototal` varchar(15) DEFAULT NULL,
  `detalle` varchar(50) DEFAULT 'Salida de Producto',
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `kardex`
--

INSERT INTO `kardex` (`id`, `producto`, `entrada`, `salida`, `stock`, `preciounitario`, `preciototal`, `detalle`, `fecha`, `hora`) VALUES
(1, '1', 0, 1, 2, '6', '6', 'Salida de Producto', '10-01-2026', '07:31:44 pm'),
(2, '1', 0, 2, 0, '6', '12', 'Salida de Producto', '10-01-2026', '08:30:45 pm'),
(3, '2', 0, 7, 0, '7', '49', 'Salida de Producto', '10-01-2026', '08:32:00 pm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medida`
--

CREATE TABLE `medida` (
  `id` int(9) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `signo` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `medida`
--

INSERT INTO `medida` (`id`, `nombre`, `signo`) VALUES
(1, 'Unidad/Pza', 'U'),
(2, 'Litro', 'L'),
(3, 'Kilo', 'K');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `id` int(9) NOT NULL,
  `moneda` varchar(55) DEFAULT NULL,
  `signo` varchar(25) DEFAULT NULL,
  `valor` int(9) DEFAULT NULL,
  `rango` tinyint(1) DEFAULT 0,
  `habilitada` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`id`, `moneda`, `signo`, `valor`, `rango`, `habilitada`) VALUES
(1, 'Col??n', '??', 528, 2, 1),
(2, 'Dolar', '$', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientostipo`
--

CREATE TABLE `movimientostipo` (
  `id` int(2) NOT NULL,
  `nombre` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `movimientostipo`
--

INSERT INTO `movimientostipo` (`id`, `nombre`) VALUES
(1, 'Apertura de Caja'),
(2, 'Cierre de Caja'),
(3, 'Entrada de Dinero'),
(4, 'Salida de Dinero'),
(5, 'Entrada de Dinero Caja Chica'),
(6, 'Salida de Dinero Caja Chica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `notificacion` text DEFAULT NULL,
  `fecha` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `notificacion`, `fecha`) VALUES
(1, 'hola', '2026-01-10 19:32:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` int(9) NOT NULL COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)',
  `perfil` varchar(50) DEFAULT NULL COMMENT 'Nombre del perfil de usuario',
  `comentario` text DEFAULT NULL COMMENT 'aclaraci??n o comentario explicativo del tipo de perfil',
  `habilitado` tinyint(1) DEFAULT 1 COMMENT 'Determina si el registro es v??lido para utilizarse o se debe ignorar para operaciones sobre los datos.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `perfil`, `comentario`, `habilitado`) VALUES
(1, 'Administrador', '', 1),
(2, 'Vendedor', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(9) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `preciocosto` float DEFAULT NULL,
  `precioventa` float DEFAULT NULL,
  `proveedor` int(9) DEFAULT NULL,
  `departamento` int(6) DEFAULT NULL,
  `stock` int(9) DEFAULT NULL,
  `stockMin` int(9) DEFAULT NULL,
  `impuesto` int(3) DEFAULT 0,
  `medida` varchar(50) DEFAULT NULL,
  `especificaciones` text DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(9) NOT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  `telefono` varchar(35) DEFAULT NULL,
  `contacto` varchar(80) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `nombre`, `telefono`, `contacto`, `direccion`, `habilitado`) VALUES
(3, 'Edson', '12134124', '21323', 'fm{ldmfñmsdfñlms', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `provincia` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `provincia`) VALUES
(1, 'San Jos??'),
(2, 'Alajuela'),
(3, 'Cartago'),
(4, 'Heredia'),
(5, 'Guanacaste'),
(6, 'Puntarenas'),
(7, 'Lim??n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sistema`
--

CREATE TABLE `sistema` (
  `id` int(1) NOT NULL,
  `logo` varchar(55) DEFAULT 'logo.jpg',
  `TipoCambio` tinyint(1) DEFAULT 1,
  `version` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `sistema`
--

INSERT INTO `sistema` (`id`, `logo`, `TipoCambio`, `version`) VALUES
(1, '48362999_201763310761703_4837492253272309760_n.jpg', 1, 'v1.0.5 Estable');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema`
--

CREATE TABLE `tema` (
  `id` int(5) NOT NULL,
  `nombre` varchar(35) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `tema`
--

INSERT INTO `tema` (`id`, `nombre`, `habilitado`) VALUES
(1, 'Amelia', 0),
(2, 'Cerulean', 0),
(3, 'Cosmo', 0),
(4, 'Cyborg', 0),
(5, 'Darkly', 0),
(6, 'Defecto', 1),
(7, 'Flatly', 0),
(8, 'Journal', 0),
(9, 'Lumen', 0),
(10, 'Paper', 0),
(11, 'Readable', 0),
(12, 'Sandstone', 0),
(13, 'Simplex', 0),
(14, 'Slate', 0),
(15, 'Spacelab', 0),
(16, 'Superhero', 0),
(17, 'United', 0),
(18, 'Yeti', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)',
  `usuario` varchar(50) DEFAULT NULL COMMENT 'Nombre del pseudonimo del usuario del sistema',
  `contrasena` varchar(40) DEFAULT NULL COMMENT 'Contrase??a de acceso al sistema',
  `id_vendedor` int(9) DEFAULT NULL COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave For??nea-Tabla Perfil)(1:1)',
  `id_perfil` int(1) DEFAULT 2,
  `habilitado` tinyint(1) DEFAULT 1 COMMENT 'Determina si el registro es v??lido para utilizarse o se debe ignorar para operaciones sobre los datos.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `contrasena`, `id_vendedor`, `id_perfil`, `habilitado`) VALUES
(2, 'admin', '8301316d0d8448a34fa6d0c6bf1cbfa2b4a1a93a', NULL, 1, 1),
(3, 'testuser999', '789b49606c321c8cf228d17942608eff0ccc4171', NULL, 2, 1),
(4, 'ricardo', '83f7cd0628892eb78671f9c0620f64b89bfdbe0d', 2, 2, 1),
(5, 'usuario2', '8a2ee32bf7e5db326f98587fdbfa48ae607f2818', 3, 2, 1),
(6, 'admin1', '1fb8ecac209e1acc2d2007fe860738d54891a155', 4, 2, 1),
(7, 'usuario3', '8f61006dd8c87a71b3127b57c47ae5f27650ebce', 5, 2, 1),
(8, 'testvendedor', 'a662868c32bd727e82fa291e0359d5a80dfd1996', NULL, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vendedores`
--

CREATE TABLE `vendedores` (
  `id` int(9) NOT NULL COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)',
  `nombre` varchar(50) DEFAULT NULL COMMENT 'Nombre real de la persona que va a utilizar el sistema',
  `apellido1` varchar(50) DEFAULT NULL COMMENT 'Primer apellido de la persona que va a utilizar el sistema',
  `apellido2` varchar(50) DEFAULT NULL COMMENT 'Segundo apellido de la persona que va a utilizar el sistema',
  `establecimiento` varchar(80) DEFAULT NULL COMMENT 'Nombre del Establecimiento',
  `nota` text DEFAULT NULL COMMENT 'Direcci??n de la residencia de la persona',
  `provincia` int(15) DEFAULT NULL,
  `canton` int(10) DEFAULT NULL,
  `distrito` int(10) DEFAULT NULL,
  `id_usuario` int(9) DEFAULT NULL COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave For??nea-Tabla Usuario(1:1). Relaciona un usuario espec??fico con un empleado en una relaci??n uno a uno.',
  `habilitado` tinyint(1) DEFAULT 1 COMMENT 'Determina si el registro es v??lido para utilizarse o se debe ignorar para operaciones sobre los datos.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `vendedores`
--

INSERT INTO `vendedores` (`id`, `nombre`, `apellido1`, `apellido2`, `establecimiento`, `nota`, `provincia`, `canton`, `distrito`, `id_usuario`, `habilitado`) VALUES
(1, 'Luis', 'Cort??s', 'Ju??rez', 'Qualtiva WebApp', '600 metros este y 75 norte del Liceo Nocturno de Liberia', 5, 501, 50101, 1, 1),
(2, 'ricardo', 'quispe', 'mamani', 'Souvenir #1', '', 0, 0, 0, 4, 1),
(3, '123', '123', '123', 'Souvenir #2', '', 0, 0, 0, 5, 1),
(4, 'edson', 'Guarachi', 'Alarcon', 'Souvenir #1', '', 2, 211, 21102, 6, 1),
(5, 'alejandro ', 'GUTIERREZ', 'ASPI', 'Souvenir #1', '', 1, 112, 11203, 7, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(25) NOT NULL,
  `idfactura` int(25) DEFAULT NULL,
  `producto` int(2) DEFAULT NULL,
  `cantidad` int(5) DEFAULT 1,
  `precio` float DEFAULT NULL,
  `totalprecio` float DEFAULT NULL,
  `vendedor` int(9) DEFAULT NULL,
  `cliente` int(9) DEFAULT 1,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(11) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL,
  `habilitada` int(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `idfactura`, `producto`, `cantidad`, `precio`, `totalprecio`, `vendedor`, `cliente`, `fecha`, `hora`, `tipo`, `habilitada`) VALUES
(1, 1, 1, 1, 6, 6, 2, 1, '10-01-2026', '07:31:44 pm', NULL, 0),
(2, 2, 1, 2, 6, 12, 2, 1, '10-01-2026', '08:30:45 pm', NULL, 1),
(3, 2, 2, 7, 7, 49, 2, 1, '10-01-2026', '08:32:00 pm', NULL, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cajachica`
--
ALTER TABLE `cajachica`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cajachicaregistros`
--
ALTER TABLE `cajachicaregistros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cajaregistros`
--
ALTER TABLE `cajaregistros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cajatmp`
--
ALTER TABLE `cajatmp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `canton`
--
ALTER TABLE `canton`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `FK_CANTON_PROVINCIA` (`id_provincia`);

--
-- Indices de la tabla `cierre`
--
ALTER TABLE `cierre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `credito`
--
ALTER TABLE `credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_credito` (`id_cliente`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_DISTRITO_CANTON` (`id_canton`);

--
-- Indices de la tabla `entradasalidaregistro`
--
ALTER TABLE `entradasalidaregistro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `establecimiento`
--
ALTER TABLE `establecimiento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `iva`
--
ALTER TABLE `iva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medida`
--
ALTER TABLE `medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `movimientostipo`
--
ALTER TABLE `movimientostipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_producto` (`departamento`),
  ADD KEY `FK_id_proveedor` (`proveedor`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indices de la tabla `sistema`
--
ALTER TABLE `sistema`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tema`
--
ALTER TABLE `tema`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuario` (`id_vendedor`),
  ADD KEY `FK_perfil` (`id_perfil`);

--
-- Indices de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_usuario` (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajachica`
--
ALTER TABLE `cajachica`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajachicaregistros`
--
ALTER TABLE `cajachicaregistros`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajaregistros`
--
ALTER TABLE `cajaregistros`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cajatmp`
--
ALTER TABLE `cajatmp`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cierre`
--
ALTER TABLE `cierre`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `credito`
--
ALTER TABLE `credito`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entradasalidaregistro`
--
ALTER TABLE `entradasalidaregistro`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `establecimiento`
--
ALTER TABLE `establecimiento`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `iva`
--
ALTER TABLE `iva`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `medida`
--
ALTER TABLE `medida`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `moneda`
--
ALTER TABLE `moneda`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `movimientostipo`
--
ALTER TABLE `movimientostipo`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sistema`
--
ALTER TABLE `sistema`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tema`
--
ALTER TABLE `tema`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT COMMENT 'Identificador num??rico para cada uno de los registros de la tabla.(Llave Primaria)', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `canton`
--
ALTER TABLE `canton`
  ADD CONSTRAINT `FK_CANTON_PROVINCIA` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id`);

--
-- Filtros para la tabla `distrito`
--
ALTER TABLE `distrito`
  ADD CONSTRAINT `FK_DISTRITO_CANTON` FOREIGN KEY (`id_canton`) REFERENCES `canton` (`id`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK_id_categoria` FOREIGN KEY (`departamento`) REFERENCES `departamento` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_id_proveedor` FOREIGN KEY (`proveedor`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Base de datos: `test`
--
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `test`;
--
-- Base de datos: `tu_emi_db`
--
CREATE DATABASE IF NOT EXISTS `tu_emi_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tu_emi_db`;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
