CREATE TABLE `feedbacks` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `head` varchar(1000) COLLATE utf8_bin NOT NULL,
  `raiting` varchar(1000) COLLATE utf8_bin NOT NULL,
  `model` varchar(1000) COLLATE utf8_bin NOT NULL,
  `date` varchar(1000) COLLATE utf8_bin NOT NULL,
  `author` varchar(1000) COLLATE utf8_bin NOT NULL,
  `link` varchar(1000) COLLATE utf8_bin NOT NULL,
  `yes` varchar(1000) COLLATE utf8_bin NOT NULL,
  `no` varchar(1000) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`feedback_id`)
);
