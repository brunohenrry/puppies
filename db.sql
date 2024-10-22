-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 20-Out-2024 às 02:50
-- Versão do servidor: 8.0.31
-- versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pets_adocao`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `animals`
--

DROP TABLE IF EXISTS `animals`;
CREATE TABLE IF NOT EXISTS `animals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `species` varchar(50) NOT NULL,
  `breed` varchar(50) NOT NULL,
  `age` int NOT NULL,
  `sex` varchar(10) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `animals`
--

INSERT INTO `animals` (`id`, `name`, `species`, `breed`, `age`, `sex`, `description`, `image`, `location`, `contact_info`) VALUES
(24, 'Caramelo', 'Salsicha', 'Pastor', 18, '', '123', 'uploads/img4.jpeg', '123', '123'),
(26, 'Cachorro', 'Aleatoria', 'Beagle', 20, '0', 'Test de descrição 123Test de descrição 123Test de descrição 123', 'uploads/img5.jpeg', 'Colina - São Paulo', '198888'),
(35, 'Bruno', 'Test', '123', 123, 'Masculino', '123123', 'uploads/250002174688.png', '123', '123123'),
(32, 'Toddy', 'Basset ', 'PugGolden ', 20, '', '123', 'uploads/img2.jpg', 'Barretos', '1231');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
