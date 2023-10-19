CREATE DATABASE supplychain;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `product` varchar(100) DEFAULT 0,
  `role` int(3) DEFAULT NULL,
  `owner` varchar(3) DEFAULT no,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `email`, `username`, `password`,`product`, `role`,`owner`) VALUES
(1, 'riteshxxxxx', 'Ritesh ', '0cc175b9c0f1b6a831c399e269772661', 0,0,'no');
