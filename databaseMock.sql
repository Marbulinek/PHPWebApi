
DROP TABLE IF EXISTS `auth`;
CREATE TABLE IF NOT EXISTS `auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(50) NULL,
  `expiration` varchar(50) NOT NULL,
  PRIMARY KEY (`auth_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `auth_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`auth_id`) REFERENCES `auth`(`auth_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;


INSERT INTO `auth` (`auth_id`, `token`, `expiration`) VALUES
(1, '227313f9ade84796dd73109c4d954b1b', '2021-05-25 00:00:00'),
(2, '583da5a5427ea0d0121f9116cfbac05b', '2021-05-25 00:00:00'),
(3, '040c821e2be47d0d38455bd3ddd7b0d2', '2021-05-25 00:00:00');

INSERT INTO `users` (`user_id`, `name`, `email`, `auth_id`) VALUES
(1, 'John Doe', 'john.doe@mail.com', 1),
(2, 'Ljuk Biskvit', 'ljuk.biskvit@gmail.com', 2),
(3, 'Domca Tofinka', 'domca.tofinka@yahoo.com', 3);