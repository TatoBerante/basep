-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 22, 2020 at 07:17 PM
-- Server version: 8.0.21-0ubuntu0.20.04.4
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `basep`
--
CREATE DATABASE IF NOT EXISTS `basep` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `basep`;

-- --------------------------------------------------------

--
-- Table structure for table `cirugias`
--

DROP TABLE IF EXISTS `cirugias`;
CREATE TABLE IF NOT EXISTS `cirugias` (
  `id_cirugia_sys` int UNSIGNED NOT NULL AUTO_INCREMENT,
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
  `estado` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_cirugia_sys`),
  UNIQUE KEY `recno` (`recno`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente_sys` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cliente` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `empresa` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_cliente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion_pago` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aplicable` float UNSIGNED NOT NULL DEFAULT '15',
  PRIMARY KEY (`id_cliente_sys`),
  UNIQUE KEY `unique_index` (`id_cliente`,`empresa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financiadores`
--

DROP TABLE IF EXISTS `financiadores`;
CREATE TABLE IF NOT EXISTS `financiadores` (
  `id_financiador` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre_financiador` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `aplicable` tinyint NOT NULL DEFAULT '15',
  PRIMARY KEY (`id_financiador`),
  UNIQUE KEY `nombre_financiador` (`nombre_financiador`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicos`
--

DROP TABLE IF EXISTS `medicos`;
CREATE TABLE IF NOT EXISTS `medicos` (
  `id_medico_sys` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_medico` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `medico` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_medico_sys`),
  UNIQUE KEY `id_medico` (`id_medico`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto_sys` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `empresa` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_producto_sys`),
  UNIQUE KEY `empresa` (`empresa`,`id_producto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regalias`
--

DROP TABLE IF EXISTS `regalias`;
CREATE TABLE IF NOT EXISTS `regalias` (
  `id_regalia` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_medico_sys` int UNSIGNED NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` float NOT NULL,
  PRIMARY KEY (`id_regalia`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remitos`
--

DROP TABLE IF EXISTS `remitos`;
CREATE TABLE IF NOT EXISTS `remitos` (
  `id_remito` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `monto_total` float NOT NULL DEFAULT '0',
  `monto_ctacte` float NOT NULL DEFAULT '0',
  `id_acreedor` int UNSIGNED NOT NULL,
  `fecha_preparado` date DEFAULT NULL,
  `fecha_liquidado` date DEFAULT NULL,
  PRIMARY KEY (`id_remito`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuario_nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_apellido` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_nick` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_hry` tinyint UNSIGNED NOT NULL DEFAULT '100',
  `usuario_el` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '0: desactivado / 1:activo',
  PRIMARY KEY (`usuario_id`),
  UNIQUE KEY `usuario_nick` (`usuario_nick`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendedores`
--

DROP TABLE IF EXISTS `vendedores`;
CREATE TABLE IF NOT EXISTS `vendedores` (
  `id_vendedor_sys` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_vendedor` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `vendedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_vendedor_sys`),
  UNIQUE KEY `id_vendedor` (`id_vendedor`,`vendedor`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cirugias`
--
ALTER TABLE `cirugias` ADD FULLTEXT KEY `nro_cirugia` (`nro_cirugia`);
COMMIT;
