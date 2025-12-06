-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/12/2025 às 12:08
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `e_stock`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `estoque`
--

CREATE TABLE `estoque` (
  `id_estoque` int(11) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `id_usuario` int(11) NOT NULL,
  `lucro_estoque` decimal(10,2) DEFAULT NULL,
  `faturamento_estoque` decimal(10,2) DEFAULT NULL,
  `gastos_estoque` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `estoque`
--

INSERT INTO `estoque` (`id_estoque`, `categoria`, `criado_em`, `id_usuario`, `lucro_estoque`, `faturamento_estoque`, `gastos_estoque`) VALUES
(11, 'maquiagem', '2025-11-20 13:29:17', 7, NULL, NULL, NULL),
(13, 'acessorios', '2025-11-22 21:46:34', 7, NULL, NULL, NULL),
(24, 'cafezes', '2025-11-29 21:16:13', 14, 62.99, 76.39, 13.40),
(25, 'teclados', '2025-11-30 03:33:36', 15, 31.30, 137.80, 106.50),
(26, 'mouses', '2025-11-30 03:33:44', 15, NULL, NULL, NULL),
(27, 'microfones', '2025-11-30 11:51:05', 15, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id_produto` int(11) NOT NULL,
  `id_estoque` int(11) NOT NULL,
  `nome_produto` varchar(50) DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `criado_em` datetime DEFAULT current_timestamp(),
  `entrada` int(11) DEFAULT NULL,
  `saida` int(11) DEFAULT NULL,
  `custo` decimal(10,2) DEFAULT NULL,
  `lucro` decimal(10,2) DEFAULT NULL,
  `gasto` decimal(10,2) DEFAULT NULL,
  `faturamento` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `id_estoque`, `nome_produto`, `preco`, `quantidade`, `criado_em`, `entrada`, `saida`, `custo`, `lucro`, `gasto`, `faturamento`) VALUES
(6, 11, 'base glow', 159.00, 15000, '2025-11-20 13:30:02', 111, 21, NULL, NULL, NULL, NULL),
(7, 11, 'blush stick', 100.00, 5000, '2025-11-20 13:31:03', NULL, NULL, NULL, NULL, NULL, NULL),
(18, 11, 'blush terra', 135.00, 1000000, '2025-11-22 21:46:01', NULL, NULL, NULL, NULL, NULL, NULL),
(19, 13, 'cordao beach', 209.00, 10000, '2025-11-22 21:46:57', NULL, NULL, NULL, NULL, NULL, NULL),
(23, 11, 'pó rosa', 145.00, 10000, '2025-11-23 10:56:35', NULL, NULL, NULL, NULL, NULL, NULL),
(51, 24, 'cafe negro', 70.89, 7, '2025-11-29 21:16:56', 8, 1, 1.00, 62.89, 8.00, 70.89),
(52, 24, 'cafezin podre', 5.50, 3, '2025-11-30 00:04:55', 4, 1, 1.35, 0.10, 5.40, 5.50),
(53, 25, 'mouse gamer branco', 68.90, 1, '2025-11-30 03:34:49', 3, 2, 35.50, 31.30, 106.50, 137.80);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `nome_comercio` varchar(150) DEFAULT NULL,
  `cep` varchar(20) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `criado_em` datetime DEFAULT NULL,
  `descricao` varchar(200) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `lucro_total` decimal(10,2) DEFAULT NULL,
  `faturamento_total` decimal(10,2) DEFAULT NULL,
  `gasto_total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `cpf`, `telefone`, `nome_comercio`, `cep`, `senha`, `criado_em`, `descricao`, `foto`, `lucro_total`, `faturamento_total`, `gasto_total`) VALUES
(7, 'mariane gama da silva', 'gamamariane53@gmail.com', '20217119786', '2197884392', 'MD BEAUTY', '23040573', 'Vaidartudocerto10@', NULL, 'loja da mariane', 'uploads/foto_691b14525d42a4.24494663.jpg', NULL, NULL, NULL),
(14, 'DANIEL BREVES NUNES', 'danielbrevesnunes@gmail.com', '15270478730', '21983844472', 'café', '23042110', 'Daniel070821*', NULL, 'cafezin nigga', 'uploads/foto_692b8d44db83e7.05673477.jpg', 62.99, 76.39, 13.40),
(15, 'user1', 'user1@gmail.com', '15270478730', '21983844472', 'USER ELETRONICOS', '23042110', 'Useeer1*', NULL, 'eletronicos de qualidade vendidos pelo user de numero 1', 'uploads/foto_692be4eb7e02d9.07281943.jpg', 31.30, 137.80, 106.50);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`id_estoque`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id_produto`),
  ADD KEY `id_estoque` (`id_estoque`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `estoque`
--
ALTER TABLE `estoque`
  MODIFY `id_estoque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estoque`
--
ALTER TABLE `estoque`
  ADD CONSTRAINT `estoque_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`id_estoque`) REFERENCES `estoque` (`id_estoque`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
