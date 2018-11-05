/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 100136
Source Host           : localhost:3306
Source Database       : mrgeekti

Target Server Type    : MYSQL
Target Server Version : 100136
File Encoding         : 65001

Date: 2018-11-05 12:06:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for produtos
-- ----------------------------
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
  `produtoID` int(11) NOT NULL AUTO_INCREMENT,
  `tipodoproduto` varchar(255) DEFAULT NULL,
  `tecnologiasproduto` varchar(255) DEFAULT NULL,
  `nomeproduto` varchar(255) NOT NULL,
  `fotoproduto` varchar(255) DEFAULT NULL,
  `descricaoproduto` varchar(255) NOT NULL,
  `responsivoproduto` varchar(255) DEFAULT NULL,
  `datapublicacao` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`produtoID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of produtos
-- ----------------------------

-- ----------------------------
-- Table structure for tecnologias
-- ----------------------------
DROP TABLE IF EXISTS `tecnologias`;
CREATE TABLE `tecnologias` (
  `tecnologiasID` int(11) NOT NULL,
  `nometecnologia` varchar(255) NOT NULL,
  PRIMARY KEY (`tecnologiasID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tecnologias
-- ----------------------------
INSERT INTO `tecnologias` VALUES ('0', 'HTML5');
INSERT INTO `tecnologias` VALUES ('1', 'CSS3');
INSERT INTO `tecnologias` VALUES ('3', 'JavaScript');
INSERT INTO `tecnologias` VALUES ('4', 'Bootstrap');
INSERT INTO `tecnologias` VALUES ('5', 'JQuery');
INSERT INTO `tecnologias` VALUES ('6', 'React');
INSERT INTO `tecnologias` VALUES ('7', 'NodeJs');
INSERT INTO `tecnologias` VALUES ('8', 'React Native');
INSERT INTO `tecnologias` VALUES ('9', 'Python');
INSERT INTO `tecnologias` VALUES ('10', 'PHP');
INSERT INTO `tecnologias` VALUES ('11', 'LESS');
INSERT INTO `tecnologias` VALUES ('12', 'SASS');
INSERT INTO `tecnologias` VALUES ('13', 'Laravel');
INSERT INTO `tecnologias` VALUES ('14', 'MySql');
INSERT INTO `tecnologias` VALUES ('15', 'Outras');

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `usuarioID` tinyint(8) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `datadecadastro` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`usuarioID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', '', 'admin', 'admin', null, '1', '_images/publicadas/meuperfil.jpg');
INSERT INTO `usuarios` VALUES ('8', '', 'visitante', 'visitante', '03/11/18 10:32:34', '0', '_images/user_default.png');
SET FOREIGN_KEY_CHECKS=1;
