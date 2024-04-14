CREATE TABLE `movies`
(
	`id`          int unsigned NOT NULL AUTO_INCREMENT,
	`slug`        varchar(255) COLLATE utf8mb4_unicode_ci                       DEFAULT NULL,
	`title`       text COLLATE utf8mb4_unicode_ci       NOT NULL,
	`genre`       varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
	`author`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
	`description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
	`year`        int unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `slug` (`slug`),
	KEY           `title` (`title`(20)),
	KEY           `author` (`author`(20)),
	KEY           `year` (`year`),
	FULLTEXT KEY `ft_title` (`title`),
	FULLTEXT KEY `ft_description` (`description`),
	FULLTEXT KEY `ft_title_description` (`title`,`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;