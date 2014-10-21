-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 21/10/2014 às 13:56:34
-- Versão do Servidor: 5.5.38
-- Versão do PHP: 5.4.4-14+deb7u14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `evilwatcher`
--
CREATE DATABASE `evilwatcher`;
-- --------------------------------------------------------

--
-- Estrutura da tabela `asn_checks`
--

CREATE TABLE IF NOT EXISTS `asn_checks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_check` bigint(20) NOT NULL,
  `asn` varchar(6) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `bgp_prefix` varchar(20) NOT NULL,
  `cc` varchar(4) NOT NULL,
  `registry` varchar(20) NOT NULL,
  `allocated` varchar(10) NOT NULL,
  `asname` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dns_checks`
--

CREATE TABLE IF NOT EXISTS `dns_checks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_server` int(6) NOT NULL,
  `dns_host` varchar(200) NOT NULL,
  `dns_ip` varchar(15) NOT NULL,
  `dns_type` varchar(20) NOT NULL,
  `dns_target` varchar(200) NOT NULL,
  `dns_ip_target` varchar(15) NOT NULL,
  `dns_geo_country_code` varchar(3) NOT NULL,
  `dns_geo_country_name` varchar(50) NOT NULL,
  `dns_geo_region` varchar(50) NOT NULL,
  `dns_geo_city` varchar(100) NOT NULL,
  `dns_geo_latitude` varchar(50) NOT NULL,
  `dns_geo_longitude` varchar(50) NOT NULL,
  `dns_timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `count` bigint(20) NOT NULL DEFAULT '1',
  `last_check` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `scanned` int(1) NOT NULL DEFAULT '0',
  `check_asn` int(1) NOT NULL DEFAULT '0',
  `val_reputation` int(11) NOT NULL,
  `reputation` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `full_portscan` int(11) NOT NULL DEFAULT '0',
  `pause` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nmap`
--

CREATE TABLE IF NOT EXISTS `nmap` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(20) NOT NULL,
  `ports` varchar(250) NOT NULL,
  `obs` text NOT NULL,
  `deleted` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nmap_checks`
--

CREATE TABLE IF NOT EXISTS `nmap_checks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_server` bigint(20) NOT NULL,
  `id_nmap` int(6) NOT NULL,
  `service_name` varchar(200) NOT NULL,
  `port` int(6) NOT NULL,
  `protocol` varchar(50) NOT NULL,
  `prod_info` text NOT NULL,
  `prod_ver` text NOT NULL,
  `prod_add` text NOT NULL,
  `port_status` varchar(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `servers`
--

CREATE TABLE IF NOT EXISTS `servers` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `full_portscan` int(11) NOT NULL DEFAULT '0',
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inactive` int(1) NOT NULL DEFAULT '0',
  `pause` int(1) NOT NULL DEFAULT '0',
  `stop_time` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
