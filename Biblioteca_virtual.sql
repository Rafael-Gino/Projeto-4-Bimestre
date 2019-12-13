-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 13-Dez-2019 às 01:01
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Biblioteca_virtual`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `Livro`
--

CREATE TABLE `Livro` (
  `ID_livro` int(6) NOT NULL,
  `Nome_livro` varchar(50) NOT NULL,
  `Autor_livro` varchar(20) NOT NULL,
  `Editora_livro` varchar(20) NOT NULL,
  `Imagem_livro` varchar(60) NOT NULL,
  `Descricao_livro` text NOT NULL,
  `Genero_livro` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de livros no estoque';

--
-- Extraindo dados da tabela `Livro`
--

INSERT INTO `Livro` (`ID_livro`, `Nome_livro`, `Autor_livro`, `Editora_livro`, `Imagem_livro`, `Descricao_livro`, `Genero_livro`) VALUES
(1, 'No game No Life 2', 'Yui Kamuy', 'NewPop', 'ngnl1.jpg', 'qualquer coisa', 'Fantasia - Aventura'),
(2, 'a', 'a', 'a', 'image718.jpg.png', 'asdas', 'a');

-- --------------------------------------------------------

--
-- Estrutura da tabela `User`
--

CREATE TABLE `User` (
  `ID_user` int(6) NOT NULL,
  `Nome_user` varchar(20) NOT NULL,
  `Sobrenome_user` varchar(20) NOT NULL,
  `User_user` varchar(20) NOT NULL,
  `Tipo_user` varchar(14) NOT NULL,
  `Email_user` varchar(50) NOT NULL,
  `Senha_user` varchar(80) NOT NULL,
  `Imagem_user` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela de usuário';

--
-- Extraindo dados da tabela `User`
--

INSERT INTO `User` (`ID_user`, `Nome_user`, `Sobrenome_user`, `User_user`, `Tipo_user`, `Email_user`, `Senha_user`, `Imagem_user`) VALUES
(1, 'Rafael', 'Gino', 'Rafael', 'Autor', 'rafaelgino016@gmail.com', 'rafael2019', 'rafael.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Livro`
--
ALTER TABLE `Livro`
  ADD PRIMARY KEY (`ID_livro`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`ID_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Livro`
--
ALTER TABLE `Livro`
  MODIFY `ID_livro` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `ID_user` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
