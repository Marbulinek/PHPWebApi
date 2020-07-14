--
-- Database: `test`
--

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`) VALUES
(1, 'John Doe', 'john.doe@mail.com'),
(2, 'Ljuk Biskvit', 'ljuk.biskvit@gmail.com'),
(3, 'Domca Tofinka', 'domca.tofinka@yahoo.com');
COMMIT;