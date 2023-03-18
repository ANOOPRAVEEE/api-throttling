CREATE TABLE `rate_limit` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `referrer` VARCHAR(255) NOT NULL,
  `count` INT(11) NOT NULL DEFAULT '1',
  `timestamp` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
);

