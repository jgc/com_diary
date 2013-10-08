CREATE TABLE IF NOT EXISTS `#__diaryitems` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
`asset_id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`dname` VARCHAR(25)  NOT NULL ,
`ditemdate` DATE NOT NULL ,
`notes` TEXT NOT NULL ,
`createdby` INT(11)  NOT NULL ,
`created` DATETIME NOT NULL ,
`updated` DATETIME NOT NULL ,
`fileupload` VARCHAR(255)  NOT NULL ,
`dint` INT(11)  NOT NULL ,
`checkbox` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

