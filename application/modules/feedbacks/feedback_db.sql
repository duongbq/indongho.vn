DROP TABLE IF EXISTS `feedbacks`;
CREATE TABLE `feedbacks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `customer` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `menus` VALUES ('36', 'Thông tin phản hồi', '/dashboard/feedbacks', '10', '1', '100', '');