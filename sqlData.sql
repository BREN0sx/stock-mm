CREATE DATABASE IF NOT EXISTS `storage`;
USE `storage`

set global net_buffer_length=1000000; 
set global max_allowed_packet=536870912; 
set global max_connections = 1000;
SET max_statement_time = 10;
set global innodb_buffer_pool_size = 2147483648;
set global query_cache_size = 268435456;

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `name_category` varchar(255) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `categories` VALUES (1,'Eletrônicos'),(2,'Móveis'),(3,'Laboratoriais'),(4,'Livros e Materiais'),(5,'Ferramentas'),(6,'Esportivos'),(7,'Objetos de Valor'),(8,'Cozinha'),(9,'Limpeza'),(10,'Segurança'),(11,'Roupas e Uniformes'),(12,'Eletrodomésticos');

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `name_item` varchar(255) DEFAULT NULL,
  `about_item` varchar(255) DEFAULT NULL,
  `ci_item` varchar(45) DEFAULT NULL,
  `image_item` longblob DEFAULT NULL,
  `price_item` float DEFAULT NULL,
  `got_item` int(4) DEFAULT NULL,
  `date_item` date DEFAULT NULL,
  `id_status` int(1) DEFAULT 2,
  `id_place` int(11) DEFAULT NULL,
  `id_category` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_item`),
  KEY `id_place` (`id_place`),
  KEY `id_user` (`id_user`),
  KEY `id_category` (`id_category`),
  KEY `id_status` (`id_status`),
  CONSTRAINT `item_ibfk_1` FOREIGN KEY (`id_place`) REFERENCES `places` (`id_place`),
  CONSTRAINT `item_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `item_ibfk_3` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`),
  CONSTRAINT `item_ibfk_4` FOREIGN KEY (`id_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DROP TABLE IF EXISTS `places`;
CREATE TABLE `places` (
  `id_place` int(11) NOT NULL AUTO_INCREMENT,
  `name_place` varchar(255) NOT NULL,
  `floor_place` varchar(255) NOT NULL,
  PRIMARY KEY (`id_place`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `places` VALUES (1,'Auditório','0'),(2,'Secretaria','0'),(3,'Coordenação Pedagógica','0'),(4,'Coordenação Estágio','0'),(5,'Diretoria','0'),(6,'Sala Professores','0'),(7,'Laboratório Linguas','0'),(8,'Laboratório Informática','0'),(9,'Banheiro','0'),(10,'Laboratório Matemática','0'),(11,'Almoxarifado','0'),(12,'Laboratório Enfermagem','0'),(13,'Laboratório Biologia','0'),(14,'Laboratório Química','0'),(15,'Administração','0'),(16,'Biblioteca - Térreo','0'),(17,'Laboratório de Desenvolvimento Tecnológico','0'),(18,'Quadra','0'),(19,'Laboratório Especial 02','0'),(20,'Laboratório Especial 01','0'),(21,'Cozinha Refeitório','0'),(22,'Cozinha Café','0'),(23,'Grêmio Estudantil','0'),(24,'Refeitório','0'),(25,'Biblioteca - Andar','1'),(26,'SALA 12','1'),(27,'SALA 11','1'),(28,'SALA 10','1'),(29,'SALA 09','1'),(30,'SALA 08','1'),(31,'SALA 07','1'),(32,'SALA 06','1'),(33,'SALA 05','1'),(34,'SALA 04','1'),(35,'SALA 03','1'),(36,'SALA 02','1'),(37,'SALA 01','1');

DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `name_status` varchar(255) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `status` VALUES (0,'Péssimo'),(1,'Ruim'),(2,'Regular'),(3,'Bom'),(4,'Ótimo');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(255) NOT NULL,
  `pass_user` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` VALUES (1,'admin','123456');

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= SECRETARIA =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//

INSERT INTO item (name_item, about_item, ci_item, image_item, price_item, got_item, id_status, id_place, id_category, id_user, date_item) VALUES
('ARMÁRIO DE AÇO', '2 PORTAS', '2039390', NULL, NULL, NULL, 4, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', '2 PORTAS', NULL, NULL, NULL, NULL, 3, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', '2 PORTAS', NULL, NULL, NULL, NULL, 3, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', '2 PORTAS', NULL, NULL, NULL, NULL, 3, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', '2 PORTAS', NULL, NULL, NULL, NULL, 3, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', '2 PORTAS', NULL, NULL, NULL, NULL, 2, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', '2 PORTAS C 4 PRATELEIRAS', '2039387', NULL, 660, 2022, 4, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE AÇO', 'PARA TV E DVD MÓVEL', '1900484', NULL, 2235, 2022, 3, 2, 2, 1, '2024-03-19'),
('ARMÁRIO DE MADEIRA', NULL, NULL, NULL, NULL, NULL, 4, 2, 2, 1, '2024-03-19'),
('ARQUIVO AÇO', 'PARA PASTA SUSPENSA - 4 GAVETAS', '2037776', NULL, 623.74, 2022, 4, 2, 2, 1, '2024-03-19'),
('ARQUIVO AÇO', 'PARA PASTA SUSPENSA - 4 GAVETAS', '2037775', NULL, 623.74, 2022, 4, 2, 2, 1, '2024-03-19'),
('BEBEDOURO ESMALTEC', '02 TORNEIRAS', NULL, NULL, NULL, NULL, 3, 2, 12, 1, '2024-03-19'),
('CADEIRA FIXA', 'DE TECIDO', '2037341', NULL, 93.33, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'DE TECIDO', '2037343', NULL, 93.33, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'DE TECIDO', '2037331', NULL, 93.33, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'DE TECIDO', '2037334', NULL, 93.33, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'ACOCHOADAS SEM BRAÇOS', '2037380', NULL, 360, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'ACOCHOADAS SEM BRAÇOS', '2037379', NULL, 360, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'ACOCHOADAS SEM BRAÇOS', '2037381', NULL, 360, 2022, 3, 2, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'ACOCHOADAS SEM BRAÇOS', '2037384', NULL, 360, 2022, 3, 2, 2, 1, '2024-03-19'),
('CENTRAL DE AR', 'TURBO 38 BTUS - PHILCO', NULL, NULL, NULL, 2022, 3, 2, 12, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038954', NULL, 4753, 2022, 4, 2, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038948', NULL, 4753, 2022, 4, 2, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038921', NULL, 4753, 2022, 4, 2, 1, 1, '2024-03-19'),
('ENCADERNADORA', 'DE PERFURAR PAPEL', NULL, NULL, NULL, NULL, 3, 2, 5, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2038394', NULL, 72.50, 2022, 4, 2, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2038386', NULL, 72.50, 2022, 4, 2, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2038391', NULL, 72.50, 2022, 4, 2, 1, 1, '2024-03-19'),
('ESTAÇÃO DE TRABALHO', 'INTEGRADA', '2037521', NULL, 741.31, 2022, 3, 2, 2, 1, '2024-03-19'),
('FLANELÓGRAFO', NULL, NULL, NULL, NULL, NULL, 3, 2, 7, 1, '2024-03-19'),
('FLANELÓGRAFO', 'MÉDIO 1.20 X 2MTS - EXTERNO', '2038246', NULL, NULL, NULL, 3, 2, 7, 1, '2024-03-19'),
('GAVETEIRO VOLANTE', '3 GAVETAS', '222122107', NULL, 1097, 2022, 3, 2, 2, 1, '2024-03-19'),
('GAVETEIRO VOLANTE', '3 GAVETAS', '222122105', NULL, 1097, 2022, 4, 2, 2, 1, '2024-03-19'),
('GELADEIRA', 'CÔNSUL BRANCA', '412775', NULL, NULL, NULL, 3, 2, 12, 1, '2024-03-19'),
('GUILHOTINA', NULL, NULL, NULL, NULL, NULL, 3, 2, 5, 1, '2024-03-19'),
('GUILHOTINA', NULL, '1809800', NULL, 115.62, 2022, 3, 2, 5, 1, '2024-03-19'),
('LOGARINA', '(RETIRADA PARA BIBLIOTECA)', '2034582', NULL, 1860, 2022, 4, 2, 2, 1, '2024-03-19'),
('LOGARINA', '(RETIRADA PARA BIBLIOTECA)', '2034584', NULL, 1860, 2022, 4, 2, 2, 1, '2024-03-19'),
('RACK DE PISO', '24U', '2056082 ', NULL, NULL, 2022, 3, 2, 2, 1, '2024-03-19'),
('RACK DE PISO', '24U', '2056083 ', NULL, NULL, 2022, 3, 2, 2, 1, '2024-03-19'),
('ROTEADOR', NULL, '1974586', NULL, 264, 2022, 3, 2, 1, 1, '2024-03-19'),
('SWITCH', '24 PORTAS 1 CAT6 0/100/1000', '2005740', NULL, 947.44, 2022, 3, 2, 1, 1, '2024-03-19'),
('SWITCH', NULL, '2058083', NULL, NULL, 2022, 3, 2, 1, 1, '2024-03-19');


//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= INSERVÍVEIS =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//


INSERT INTO item (name_item, about_item, ci_item, image_item, price_item, got_item, id_status, id_place, id_category, id_user, date_item)
VALUES
    ('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579742', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '440125', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '440128', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '440130', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579731', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579746', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '440129', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579743', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579747', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579745', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', '579744', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - POSITIVO', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '332260', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '332264', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '495407', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '332266', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '332258', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '495413', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '332259', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - ITAUTEC', 'IRRECUPERÁVEIS', '332266', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '720821', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '719856', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '719851', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '719847', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '720824', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '720818', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - LENOVO', 'IRRECUPERÁVEIS', '719841', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - DELL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - DELL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CPU - DELL', 'IRRECUPERÁVEIS', '1125282', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - DELL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - DELL', 'IRRECUPERÁVEIS', '1229088', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - DELL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - DELL', 'IRRECUPERÁVEIS', '1128297', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '440262', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '440301', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '495312', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '440297', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '495325', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '332233', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '495319', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '440292', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '440269', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '455319', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - ITAUTEC', 'IRRECUPERÁVEIS', '455314', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - POSITIVO', 'IRRECUPERÁVEIS', '440119', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - POSITIVO', 'IRRECUPERÁVEIS', '440117', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - POSITIVO', 'IRRECUPERÁVEIS', '440118', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - MICROTEC', 'IRRECUPERÁVEIS', '269576', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LINCE', 'IRRECUPERÁVEIS', '219168', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', '555060', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', '719811', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', '719828', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', '719805', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', '719814', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LENOVO', 'IRRECUPERÁVEIS', '719818', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579748', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579757', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579751', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579755', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579754', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579756', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579749', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579750', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MONITOR - LG', 'IRRECUPERÁVEIS', '579764', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('PROCESSADOR', 'IRRECUPERÁVEIS', '332652', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('PROCESSADOR', 'IRRECUPERÁVEIS', '332640', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('DVD - PHILIPS', 'IRRECUPERÁVEIS', '719755', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - LENOVO', 'IRRECUPERÁVEIS', '719865', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - LENOVO', 'IRRECUPERÁVEIS', '719879', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - LENOVO', 'IRRECUPERÁVEIS', '719863', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - ITAUTEC', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - POSITIVO', 'IRRECUPERÁVEIS', '579762', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - POSITIVO', 'IRRECUPERÁVEIS', '579763', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - POSITIVO', 'IRRECUPERÁVEIS', '579759', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - POSITIVO', 'IRRECUPERÁVEIS', '579760', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO - POSITIVO', 'IRRECUPERÁVEIS', '579767', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TECLADO', 'IRRECUPERÁVEIS', '719611', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '269325', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '495498', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '579728', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '332499', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '332214', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '579730', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '481217', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440251', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '579732', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '579736', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440285', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440132', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '579734', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440283', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '269575', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440290', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '495493', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '595661', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440136', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440140', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '332696', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '269324', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '331986', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '269513', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '579729', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '481143', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440139', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '440263', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '481141', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '495492', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', '595684', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - ENERGY', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - ENERGY', 'IRRECUPERÁVEIS', '1115346', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - ENERGY', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - HYFLEX', 'IRRECUPERÁVEIS', '332670', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - HYFLEX', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROSOL', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - HYFLEX', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - HYFLEX', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - HYFLEX', 'IRRECUPERÁVEIS', '322647', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - HYFLEX', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - MICROLINS', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR', 'IRRECUPERÁVEIS', '814426', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - RAGTHEN', 'IRRECUPERÁVEIS', '722223', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('ESTABILIZADOR - RAGTHEN', 'IRRECUPERÁVEIS', '722230', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MODULO ISOLADOR', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MODULO ISOLADOR - GRANDE SMS', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('SYSTEM - X3500 M3 IBM', 'IRRECUPERÁVEIS', '787894', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('MÓDULO ', 'IRRECUPERÁVEIS', '55821', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('CENTRAL DE AR - PANASONIC', 'IRRECUPERÁVEIS', '1594621', NULL, NULL, NULL, 0, 19, 12, 1, '2024-03-19'),
('CENTRAL DE AR - PANASONIC', 'IRRECUPERÁVEIS', '1594621', NULL, NULL, NULL, 0, 19, 12, 1, '2024-03-19'),
('TV - SEMP', 'IRRECUPERÁVEIS', '183160', NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('TV - CCE', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 1, 1, '2024-03-19'),
('VENTILADOR DE PAREDE - 60 SOLART', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 12, 1, '2024-03-19'),
('VENTILADOR DE PAREDE - 60 SOLART', 'IRRECUPERÁVEIS', NULL, NULL, NULL, NULL, 0, 19, 12, 1, '2024-03-19');

//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= BIBLIOTECA (TÉRREO) =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//


INSERT INTO item (name_item, about_item, ci_item, image_item, price_item, got_item, id_status, id_place, id_category, id_user, date_item) VALUES
('ESTANTE', 'PARA LIVROS EM AÇO C BASE INFERIOR FECHADA', '2234139', NULL, 933.32, 2023, 4, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS EM AÇO C BASE INFERIOR FECHADA', '2234140', NULL, 933.32, 2023, 4, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805704', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', NULL, NULL, NULL, NULL, 2, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805705', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084949', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084956', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084957', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084958', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084960', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '744362', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084961', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084966', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084952', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084968', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '2084965', NULL, 685.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805715', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805709', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805991', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805705', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', '805708', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', NULL, NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ESTANTE', 'PARA LIVROS', NULL, NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037365', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037348', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037307', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037323', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037329', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037370', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037364', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037367', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037308', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037312', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037305', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037314', NULL, 93.33, 2022, 3, 16, 2, 1, '2024-03-19'),
('ARMÁRIO', '2 PORTAS', '740730', NULL, NULL, NULL, 2, 16, 2, 1, '2024-03-19'),
('RACK DE PISO', '24 U', '2056084', NULL, NULL, 2022, 2, 16, 1, 1, '2024-03-19'),
('SWITCH', '24 PORTAS 10/100/1000', '2006007', NULL, NULL, 2022, 3, 16, 1, 1, '2024-03-19'),
('SWITCH', NULL, '2056084', NULL, 947.44, 2022, 3, 16, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036886', NULL, NULL, 2022, 3, 16, 1, 1, '2024-03-19'),
('GAVETEIRO', '3 GAVETAS', '222122106', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('BEBEDOURO', NULL, '2087499', NULL, 848.64, 2022, 3, 16, 12, 1, '2024-03-19'),
('BIRÔ', '3 GAVETAS', '2699120', NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('ARMÁRIO DE MADEIRA', NULL, NULL, NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('CAVALETE DE MADEIRA', NULL, NULL, NULL, NULL, NULL, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036313', NULL, 360.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036314', NULL, 360.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036322', NULL, 360.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036301', NULL, 360.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036364', NULL, 360.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('MESA', 'REDONDA', '2084938', NULL, 337.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('MESA', 'REDONDA', '2084939', NULL, 337.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('MESA', 'REDONDA', '2084942', NULL, 337.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('MESA', 'REDONDA', '2084933', NULL, 337.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('LOGARINA', NULL, '2034583', NULL, 1860.00, 2022, 3, 16, 2, 1, '2024-03-19'),
('EXTINTOR', 'DE GÁS', NULL, NULL, NULL, 2022, 3, 16, 10, 1, '2024-03-19'),
('CENTRAL DE AR', 'TURBO - PHILCO 36 BTUS', NULL, NULL, NULL, 2022, 3, 16, 12, 1, '2024-03-19'),
('CENTRAL DE AR', 'TURBO - PHILCO 36 BTUS', NULL, NULL, NULL, 2022, 3, 16, 12, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038969', NULL, 4753.00, 2022, 3, 16, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038909', NULL, 4753.00, 2022, 3, 16, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038910', NULL, 4753.00, 2022, 3, 16, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038906', NULL, 4753.00, 2022, 3, 16, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038978', NULL, 4753.00, 2022, 3, 16, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036888', NULL, 72.50, 2020, 3, 16, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036897', NULL, 72.50, 2020, 3, 16, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036889', NULL, 72.50, 2020, 3, 16, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036884', NULL, 72.50, 2020, 3, 16, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036898', NULL, 72.50, 2020, 3, 16, 1, 1, '2024-03-19'),
('ROTEADOR', NULL, '2017227', NULL, 72.50, 2020, 3, 16, 1, 1, '2024-03-19'),
('TELA DE PROJEÇÃO', NULL, '1420866', NULL, NULL, NULL, 3, 16, 1, 1, '2024-03-19');


//=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= BIBLIOTECA (ANDAR) =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=//


INSERT INTO item (name_item, about_item, ci_item, image_item, price_item, got_item, id_status, id_place, id_category, id_user, date_item) VALUES
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037301', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037302', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037304', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037309', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037311', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037313', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037316', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037321', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037322', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037325', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037327', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037332', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037333', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037338', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037340', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037345', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037346', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037347', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037349', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037354', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037355', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037357', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037358', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA FIXA', 'AUXILIAR REVESTIDA EM TECIDO', '2037374', NULL, 93.33, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036307', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036312', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036320', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036321', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036323', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036334', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036335', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036347', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036355', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036359', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036365', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036367', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036371', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', '2036385', NULL, 360.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('CADEIRA GIRATÓRIA', 'C BRAÇOS REGULÁVEIS', NULL, NULL, 360.00, NULL, 3, 25, 2, 1, '2024-03-19'),
('MESA DE REUNIÃO', 'REDONDA', '2084941', NULL, 337.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('MESA DE REUNIÃO', 'REDONDA', '2084936', NULL, 337.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('MESA DE REUNIÃO', 'REDONDA', '2084937', NULL, 337.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('MESA DE REUNIÃO', 'REDONDA', '2084932', NULL, 337.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('MESA DE REUNIÃO', 'REDONDA', '2084940', NULL, 337.00, 2022, 3, 25, 2, 1, '2024-03-19'),
('MESA', 'ALUNO', NULL, NULL, NULL, NULL, 3, 25, 2, 1, '2024-03-19'),
('EXTINTOR', 'DE GÁS', NULL, NULL, NULL, 2022, 3, 25, 10, 1, '2024-03-19'),
('CENTRAL DE AR', 'TURBO - 36 BTUS - PHILCO', NULL, NULL, NULL, 2022, 3, 25, 12, 1, '2024-03-19'),
('CENTRAL DE AR', 'TURBO - 36 BTUS - PHILCO', NULL, NULL, NULL, 2022, 3, 25, 12, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038970', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038907', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038957', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038903', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038950', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038968', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('MICROCOMPUTADOR', 'TIPO DESKTOP', '2038953', NULL, 4753.00, 2022, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036899', NULL, 72.50, 2022, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036885', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2038390', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036868', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036886', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036867', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2036895', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19'),
('ESTABILIZADOR', NULL, '2038385', NULL, 72.50, 2020, 3, 25, 1, 1, '2024-03-19');