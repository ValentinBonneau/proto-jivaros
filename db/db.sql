CREATE TABLE `Video` (
  `id` varchar(255) PRIMARY KEY,
  `thumbnails` text,
  `title` varchar(255),
  `position` int
);

CREATE TABLE `Reason` (
  `idVideo` varchar(255) PRIMARY KEY,
  `text` text
);

CREATE TABLE `TagToVideo` (
  `idVideo` varchar(255),
  `idTag` int
);

CREATE TABLE `Tag` (
  `id` int PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(255)
);

ALTER TABLE `Reason` ADD FOREIGN KEY (`idVideo`) REFERENCES `Video` (`id`);

ALTER TABLE `TagToVideo` ADD FOREIGN KEY (`idVideo`) REFERENCES `Video` (`id`);

ALTER TABLE `TagToVideo` ADD FOREIGN KEY (`idTag`) REFERENCES `Tag` (`id`);
