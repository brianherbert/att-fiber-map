CREATE TABLE `addresses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lon` decimal(10,7) DEFAULT NULL,
  `lat` decimal(9,7) DEFAULT NULL,
  `number` varchar(128) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `unit` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `district` varchar(128) DEFAULT NULL,
  `region` varchar(128) DEFAULT NULL,
  `postcode` varchar(128) DEFAULT NULL,
  `hash` varchar(128) DEFAULT NULL,
  `availabilityStatus` varchar(128) DEFAULT NULL,
  `lightGig` tinyint(3) unsigned DEFAULT NULL,
  `time` int(10) unsigned DEFAULT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=424324 DEFAULT CHARSET=utf8;