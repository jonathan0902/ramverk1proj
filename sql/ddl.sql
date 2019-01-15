-- Ensure its UTF8 on the database connection
SET NAMES utf8;

-- Create table for my own movie database
--
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `username` varchar(64) NOT NULL,
    `firstname` varchar(32) NOT NULL,
    `lastname` varchar(32) NOT NULL,
    `password` varchar(32) NOT NULL,
    `gravatar` varchar(32)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


DROP TABLE IF EXISTS `post`;
CREATE TABLE `post`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `username` varchar(64) NOT NULL,
    `message` Text(32) NOT NULL,
    `datum` TIMESTAMP
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `fromwho` varchar(64) NOT NULL,
    `receiver` varchar(64) NOT NULL,
    `message` Text(32) NOT NULL,
    `sub` int(11) NOT NULL,
    `datum` TIMESTAMP
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

DELETE FROM `user`;

DROP TABLE IF EXISTS `subcomments`;
CREATE TABLE `subcomments`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `username` varchar(64) NOT NULL,
    `message` Text(32) NOT NULL,
    `sub` int(11) NOT NULL,
    `datum` TIMESTAMP
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags`
(
    `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    `tag` varchar(64) NOT NULL,
    `sub` INT(11) NOT NULL
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;


DELETE FROM `user`;

INSERT INTO `user` (
	`username`,
    `firstname`,
    `lastname`,
    `password`,
    `gravatar`
) VALUES (
	"JonathanHellberg",
    "Jonathan",
    "Hellberg",
    "hej",
    "jonathanh9826@gmail.com"
);

INSERT INTO `user` (
	`username`,
    `firstname`,
    `lastname`,
    `password`,
    `gravatar`
) VALUES (
	"admin",
    "Alex",
    "Sandwitch",
    "hej",
    "jonathanh9826@live.se"
);

INSERT INTO `post` (
	`username`,
    `message`
) VALUES (
	"JonathanHellberg",
    "This is a random text that i wrote"
);

INSERT INTO `comments` (
	`fromwho`,
    `receiver`,
    `message`,
    `sub`
) VALUES (
	"admin",
    "JonathanHellberg	",
    "Random Comment is incoming!!",
    1
);

INSERT INTO `subcomments` (
	`username`,
    `message`,
    `sub`
) VALUES (
	"JonathanHellberg",
    "This is an random sub comment that will be under the  commend!!",
    1
);

DROP VIEW IF EXISTS `tags_count`;

CREATE VIEW tags_count AS
SELECT tag, COUNT(tag) AS 'count' from tags GROUP BY tag ORDER BY count DESC;