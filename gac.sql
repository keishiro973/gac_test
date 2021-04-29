SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `gac` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gac`;

DROP TABLE IF EXISTS `abonne`;
CREATE TABLE `abonne` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `compte`;
CREATE TABLE `compte` (
  `id` int(11) NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `facture`;
CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `abonne_id` int(11) NOT NULL,
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `duree_reel` time DEFAULT NULL,
  `volume_reel` double DEFAULT NULL,
  `duree_facture` time DEFAULT NULL,
  `volume_facture` double DEFAULT NULL,
  `type_facture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection_type` int(11) NOT NULL,
  `compte_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `abonne`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `compte`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FE866410C325A696` (`abonne_id`),
  ADD KEY `IDX_FE866410F2C56620` (`compte_id`);


ALTER TABLE `abonne`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `compte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `facture`
  ADD CONSTRAINT `FK_FE866410C325A696` FOREIGN KEY (`abonne_id`) REFERENCES `abonne` (`id`),
  ADD CONSTRAINT `FK_FE866410F2C56620` FOREIGN KEY (`compte_id`) REFERENCES `compte` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
