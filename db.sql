-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
<<<<<<< HEAD
-- Tempo de geração: 20-Out-2024 às 02:50
=======
-- Tempo de geração: 25-Out-2024 às 17:17
>>>>>>> 9b6affaa84d51556afdb244f79d632d685a588d2
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
<<<<<<< HEAD
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
=======
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
>>>>>>> 9b6affaa84d51556afdb244f79d632d685a588d2

--
-- Extraindo dados da tabela `animals`
--

<<<<<<< HEAD
INSERT INTO `animals` (`id`, `name`, `species`, `breed`, `age`, `sex`, `description`, `image`, `location`, `contact_info`) VALUES
(24, 'Caramelo', 'Salsicha', 'Pastor', 18, '', '123', 'uploads/img4.jpeg', '123', '123'),
(26, 'Cachorro', 'Aleatoria', 'Beagle', 20, '0', 'Test de descrição 123Test de descrição 123Test de descrição 123', 'uploads/img5.jpeg', 'Colina - São Paulo', '198888'),
(35, 'Bruno', 'Test', '123', 123, 'Masculino', '123123', 'uploads/250002174688.png', '123', '123123'),
(32, 'Toddy', 'Basset ', 'PugGolden ', 20, '', '123', 'uploads/img2.jpg', 'Barretos', '1231');
=======
INSERT INTO `animals` (`id`, `name`, `species`, `breed`, `age`, `sex`, `description`, `image`, `location`, `contact_info`, `user_id`) VALUES
(24, 'Caramelo', 'Pardo', 'Pastor', 18, '', '123', 'uploads/img4.jpeg', '123', '123', 0),
(26, 'Cachorro', 'Aleatoria', 'Beagle', 20, '0', 'Test de descrição 123Test de descrição 123Test de descrição 123', 'uploads/img5.jpeg', 'Colina - São Paulo', '198888', 0),
(38, 'Gatinho', 'Gato', 'Parda', 18, '', 'Miau é uma gata brincalhona e curiosa, adora explorar cada canto da casa. Seu temperamento é amigável e ela se dá bem com crianças e outros animais. Sempre pronta para um carinho, ela gosta de se aninhar no colo dos seus humanos.', 'uploads/Loiro-gato-para-adocao_PatinhasCarentes_.jpg', 'Colina - São Paulo', '1688888888', 3),
(32, 'Toddy', 'Basset ', 'PugGolden ', 20, '', '123', 'uploads/img2.jpg', 'Barretos', '1231', 0),
(36, 'Test', '123', '123', 123, 'Masculino', '123', 'uploads/Imagem do WhatsApp de 2024-09-01 à(s) 23.56.31_82dccc4e.jpg', '123123123', '123', 1),
(37, 'Cavalo', 'Cachorro', 'Pit Bull', 210, '', 'Ele é foda demais', 'uploads/artworks-XbGkW3fmlB8pNhgG-KKLQyw-t500x500.jpg', 'Pitangueiras - SP', '69', 2),
(39, 'Gay', 'Cachorro', 'Parda', 12, '', 'Test', 'uploads/pinterestdownloader.com-1719937071.632818.jpg', 'Colina - São Paulo', '15555', 2),
(41, 'Test de envio', '12313', '123', 1231, 'Masculino', '123', 'uploads/abc1f9fd4fb649c67d3c1a22c3fa8f06.486x486x1.png', '123', '12312', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `animal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `animal_id` (`animal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `animal_id`) VALUES
(46, 2, 24),
(21, 3, 36),
(19, 3, 24),
(20, 3, 32),
(39, 2, 37),
(45, 2, 36);
>>>>>>> 9b6affaa84d51556afdb244f79d632d685a588d2

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
<<<<<<< HEAD
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
=======
  `location` varchar(100) NOT NULL,
  `contact_info` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `location`, `contact_info`) VALUES
(1, 'Guilherme', 'gui@gmail.com', '$2y$10$lFr67OcVhJYZJO.cgdyRoO9hvHxddOANGKDBYM21VUEL1veDN5TYq', 'Barretos - SP', '(15) 5555-5555'),
(2, 'Bruno', 'bruno@gmail.com', '$2y$10$g0eGyrh8oPVFoVcezD01h.b8cZgdYoNpuH17GudXD2p9ezaOLercO', 'Barretos - SP', '(12) 3111-1111'),
(3, 'Kaio Gabriel', 'kaio@gmail.com', '$2y$10$P9zGYYAGnPkZwO5WhaahlOP7WgQypoWFIe.VsD6.Hj5HwEemPZYF2', 'Barretos - SP', '(12) 31123-1321');
>>>>>>> 9b6affaa84d51556afdb244f79d632d685a588d2
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
