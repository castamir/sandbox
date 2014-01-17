-- Adminer 3.5.0 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = 'SYSTEM';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(100) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `state` enum('active','freezed','removed') COLLATE utf8_bin NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (1,	'A',	'12345',	'miras.paulik@seznam.cz',	'active') ON DUPLICATE KEY UPDATE `id` = 1, `username` = 'castamir', `password` = '12345', `email` = 'miras.paulik@seznam.cz', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (2,	'B',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 2, `username` = 'B', `password` = '', `email` = '', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (3,	'C',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 3, `username` = 'C', `password` = '', `email` = '', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (4,	'D',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 4, `username` = 'D', `password` = '', `email` = '', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (5,	'E',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 5, `username` = 'E', `password` = '', `email` = '', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (6,	'F',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 6, `username` = 'F', `password` = '', `email` = '', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (7,	'G',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 7, `username` = 'G', `password` = '', `email` = '', `state` = 'active';
INSERT INTO `user` (`id`, `username`, `password`, `email`, `state`) VALUES (8,	'H',	'',	'',	'active') ON DUPLICATE KEY UPDATE `id` = 8, `username` = 'H', `password` = '', `email` = '', `state` = 'active';

DROP TABLE IF EXISTS `user_closure`;
CREATE TABLE `user_closure` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `ancestor` int(11) NOT NULL,
  `descendant` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ancestor_descendant_depth` (`ancestor`,`descendant`,`depth`),
  KEY `descendant` (`descendant`),
  CONSTRAINT `user_closure_ibfk_1` FOREIGN KEY (`ancestor`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_closure_ibfk_2` FOREIGN KEY (`descendant`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (1,	1,	1,	0) ON DUPLICATE KEY UPDATE `id` = 1, `ancestor` = 1, `descendant` = 1, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (11,	1,	2,	1) ON DUPLICATE KEY UPDATE `id` = 11, `ancestor` = 1, `descendant` = 2, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (10,	1,	3,	1) ON DUPLICATE KEY UPDATE `id` = 10, `ancestor` = 1, `descendant` = 3, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (12,	1,	4,	2) ON DUPLICATE KEY UPDATE `id` = 12, `ancestor` = 1, `descendant` = 4, `depth` = 2;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (13,	1,	5,	2) ON DUPLICATE KEY UPDATE `id` = 13, `ancestor` = 1, `descendant` = 5, `depth` = 2;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (14,	1,	6,	2) ON DUPLICATE KEY UPDATE `id` = 14, `ancestor` = 1, `descendant` = 6, `depth` = 2;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (15,	1,	7,	2) ON DUPLICATE KEY UPDATE `id` = 15, `ancestor` = 1, `descendant` = 7, `depth` = 2;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (16,	1,	8,	3) ON DUPLICATE KEY UPDATE `id` = 16, `ancestor` = 1, `descendant` = 8, `depth` = 3;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (3,	2,	2,	0) ON DUPLICATE KEY UPDATE `id` = 3, `ancestor` = 2, `descendant` = 2, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (17,	2,	4,	1) ON DUPLICATE KEY UPDATE `id` = 17, `ancestor` = 2, `descendant` = 4, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (18,	2,	5,	1) ON DUPLICATE KEY UPDATE `id` = 18, `ancestor` = 2, `descendant` = 5, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (19,	2,	8,	2) ON DUPLICATE KEY UPDATE `id` = 19, `ancestor` = 2, `descendant` = 8, `depth` = 2;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (4,	3,	3,	0) ON DUPLICATE KEY UPDATE `id` = 4, `ancestor` = 3, `descendant` = 3, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (20,	3,	6,	1) ON DUPLICATE KEY UPDATE `id` = 20, `ancestor` = 3, `descendant` = 6, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (21,	3,	7,	1) ON DUPLICATE KEY UPDATE `id` = 21, `ancestor` = 3, `descendant` = 7, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (5,	4,	4,	0) ON DUPLICATE KEY UPDATE `id` = 5, `ancestor` = 4, `descendant` = 4, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (22,	4,	8,	1) ON DUPLICATE KEY UPDATE `id` = 22, `ancestor` = 4, `descendant` = 8, `depth` = 1;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (6,	5,	5,	0) ON DUPLICATE KEY UPDATE `id` = 6, `ancestor` = 5, `descendant` = 5, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (7,	6,	6,	0) ON DUPLICATE KEY UPDATE `id` = 7, `ancestor` = 6, `descendant` = 6, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (8,	7,	7,	0) ON DUPLICATE KEY UPDATE `id` = 8, `ancestor` = 7, `descendant` = 7, `depth` = 0;
INSERT INTO `user_closure` (`id`, `ancestor`, `descendant`, `depth`) VALUES (9,	8,	8,	0) ON DUPLICATE KEY UPDATE `id` = 9, `ancestor` = 8, `descendant` = 8, `depth` = 0;

-- 2013-09-28 17:04:04
