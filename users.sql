CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_un` (`username`),
  UNIQUE KEY `users_email_un` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
