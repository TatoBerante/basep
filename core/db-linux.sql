-- phpMyAdmin SQL Dump
-- version 4.9.7deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 09, 2020 at 05:51 PM
-- Server version: 8.0.22-0ubuntu0.20.10.2
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `basep`
--

-- --------------------------------------------------------

--
-- Table structure for table `cirugias`
--

DROP TABLE IF EXISTS `cirugias`;
CREATE TABLE `cirugias` (
  `id_cirugia_sys` int UNSIGNED NOT NULL,
  `recno` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `filial` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nro_presupuesto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orden_compra` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_pedido_venta` date DEFAULT NULL,
  `nro_pedido_de_venta` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_de_venta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_cx` date DEFAULT NULL,
  `nro_cirugia` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_medico` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_paciente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `comprobante` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serie` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int UNSIGNED DEFAULT NULL,
  `cod_cliente` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_institucion` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cod_vendedor` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_vendedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `producto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` float DEFAULT '0',
  `precio_venta` double DEFAULT '0',
  `valor_total` double DEFAULT '0',
  `id_remito` int UNSIGNED DEFAULT NULL,
  `monto_a_pagar` float UNSIGNED DEFAULT NULL,
  `estado` tinyint NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id_cliente_sys` int UNSIGNED NOT NULL,
  `id_cliente` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cliente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion_pago` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aplicable` float UNSIGNED NOT NULL DEFAULT '15'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financiadores`
--

DROP TABLE IF EXISTS `financiadores`;
CREATE TABLE `financiadores` (
  `id_financiador` int UNSIGNED NOT NULL,
  `nombre_financiador` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aplicable` tinyint NOT NULL DEFAULT '15'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicos`
--

DROP TABLE IF EXISTS `medicos`;
CREATE TABLE `medicos` (
  `id_medico_sys` int UNSIGNED NOT NULL,
  `id_medico` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `medico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id_producto_sys` int UNSIGNED NOT NULL,
  `empresa` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regalias`
--

DROP TABLE IF EXISTS `regalias`;
CREATE TABLE `regalias` (
  `id_regalia` int UNSIGNED NOT NULL,
  `id_medico_sys` int UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` float NOT NULL,
  `estado` tinyint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remitos`
--

DROP TABLE IF EXISTS `remitos`;
CREATE TABLE `remitos` (
  `id_remito` int UNSIGNED NOT NULL,
  `monto_total` float NOT NULL DEFAULT '0',
  `monto_ctacte` float NOT NULL DEFAULT '0',
  `id_acreedor` int UNSIGNED NOT NULL,
  `id_portador` int UNSIGNED DEFAULT NULL COMMENT 'id_vendedor',
  `fecha_preparado` date DEFAULT NULL,
  `fecha_liquidado` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuario_id` int UNSIGNED NOT NULL,
  `usuario_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_nick` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_hry` tinyint UNSIGNED NOT NULL DEFAULT '100',
  `usuario_el` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '0: desactivado / 1:activo'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
CREATE TABLE `vendedores` (
  `id_vendedor_sys` int UNSIGNED NOT NULL,
  `id_vendedor` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cirugias`
--
ALTER TABLE `cirugias`
  ADD PRIMARY KEY (`id_cirugia_sys`),
  ADD UNIQUE KEY `recno` (`recno`);
ALTER TABLE `cirugias` ADD FULLTEXT KEY `nro_cirugia` (`nro_cirugia`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente_sys`),
  ADD UNIQUE KEY `unique_index` (`id_cliente`,`empresa`);

--
-- Indexes for table `financiadores`
--
ALTER TABLE `financiadores`
  ADD PRIMARY KEY (`id_financiador`),
  ADD UNIQUE KEY `nombre_financiador` (`nombre_financiador`);

--
-- Indexes for table `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`id_medico_sys`),
  ADD UNIQUE KEY `id_medico` (`id_medico`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto_sys`),
  ADD UNIQUE KEY `empresa` (`empresa`,`id_producto`);

--
-- Indexes for table `regalias`
--
ALTER TABLE `regalias`
  ADD PRIMARY KEY (`id_regalia`);

--
-- Indexes for table `remitos`
--
ALTER TABLE `remitos`
  ADD PRIMARY KEY (`id_remito`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `usuario_nick` (`usuario_nick`);

--
-- Indexes for table `vendedores`
--
ALTER TABLE `vendedores`
  ADD PRIMARY KEY (`id_vendedor_sys`),
  ADD UNIQUE KEY `id_vendedor` (`id_vendedor`,`vendedor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cirugias`
--
ALTER TABLE `cirugias`
  MODIFY `id_cirugia_sys` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente_sys` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financiadores`
--
ALTER TABLE `financiadores`
  MODIFY `id_financiador` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicos`
--
ALTER TABLE `medicos`
  MODIFY `id_medico_sys` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto_sys` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regalias`
--
ALTER TABLE `regalias`
  MODIFY `id_regalia` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `remitos`
--
ALTER TABLE `remitos`
  MODIFY `id_remito` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendedores`
--
ALTER TABLE `vendedores`
  MODIFY `id_vendedor_sys` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
