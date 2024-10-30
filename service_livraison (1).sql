-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 02:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `service_livraison`
--

-- --------------------------------------------------------

--
-- Table structure for table `livraisons`
--

CREATE TABLE `livraisons` (
  `id_livraison` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `statut_livraison` enum('en cours','livrée') DEFAULT 'en cours',
  `position_actuelle` varchar(255) DEFAULT NULL,
  `date_livraison_estimee` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `livreurs`
--

CREATE TABLE `livreurs` (
  `id_livreur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `statut` enum('disponible','en livraison') DEFAULT 'disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `livraisons`
--
ALTER TABLE `livraisons`
  ADD PRIMARY KEY (`id_livraison`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_livreur` (`id_livreur`);

--
-- Indexes for table `livreurs`
--
ALTER TABLE `livreurs`
  ADD PRIMARY KEY (`id_livreur`),
  ADD UNIQUE KEY `telephone` (`telephone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `livraisons`
--
ALTER TABLE `livraisons`
  MODIFY `id_livraison` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `livreurs`
--
ALTER TABLE `livreurs`
  MODIFY `id_livreur` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `livraisons`
--
ALTER TABLE `livraisons`
  ADD CONSTRAINT `livraisons_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `service_commande`.`commandes` (`id`),
  ADD CONSTRAINT `livraisons_ibfk_2` FOREIGN KEY (`id_livreur`) REFERENCES `livreurs` (`id_livreur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
