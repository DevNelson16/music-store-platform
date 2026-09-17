-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Ago-2026 às 23:10
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `banda_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `albums`
--

CREATE TABLE `albums` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `albums`
--

INSERT INTO `albums` (`id`, `title`, `image`, `created_at`) VALUES
(1, 'uniao_fez_a_forca', '1759148450_uniao_fez_a_forca.jpeg', '2025-09-29 13:05:09'),
(2, 'cozinha_aberta_2', '1759232343_cozinha_aberta_2.jpg', '2025-09-30 12:39:03');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contactos`
--

CREATE TABLE `contactos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `apelido` varchar(100) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `mensagem` text DEFAULT NULL,
  `data_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `apelido` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `mensagem` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pendente','lida') DEFAULT 'pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `nome`, `apelido`, `data_nascimento`, `email`, `telefone`, `mensagem`, `created_at`, `status`) VALUES
(1, 'Nelson Geovetty JAIME', 'Jaime', '2003-09-12', 'nelsongeovettyjaime@gmail.com', '925394533', 'Angola', '2025-09-24 11:53:59', 'lida'),
(2, 'Nelson Geovetty JAIME', 'Jaime', '2003-09-12', 'nelsongeovettyjaime@gmail.com', '925394533', 'Olá bom dia, eu sou o Nelson Geovetty Jaime, estou interessado em adquirir os teus serviços de programador. Eu quero abrir uma ouriversária e quero que tu cries um site, responsivo. Com React, Js, HTML5  e Css. Podes entrar em contacto o mais rápido? Please!!!!', '2025-09-24 12:16:03', 'lida'),
(3, 'Exemplo', 'Qualquer', '1975-04-12', 'exqualquer@gmail.com', '935557653', 'Olá, eu sou o exemplo qualquer, e estou interessado em saber mais sobre as tournês da Força Suprema. Obrigado!', '2025-09-24 12:22:58', 'lida'),
(4, 'Ricardo Ana', 'Andre', '2003-09-15', 'Ricardoana@gmail.com', '0925394533', 'Obrigad0', '2025-09-25 10:11:51', 'lida'),
(5, 'Demontração', 'demo', '1978-12-09', 'demo@gmail.com', '987574347', 'Olá, bom dia. Eu sou o Demo e quero mostrar como o meu site está a funcionar para o pessoal. Mas ainda ainda falta algumas alterações. Obrigado Engenheiro de Software.', '2025-09-25 10:40:10', 'lida'),
(7, 'Demo', 'Publicar', '1985-09-13', 'demopublicar@gmail.com', '930935581', 'Mostrar a demo ', '2026-06-02 10:52:50', 'lida'),
(8, 'Nelson Geovetty JAIME', 'JAIME', '2001-09-18', 'nelsongeovettyjaime@gmail.com', '930935581', 'ola', '2026-08-19 08:19:31', 'pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `telefone`, `phone`, `created_at`) VALUES
(1, 'Nelson Geovetty', 'nelson@email.com', NULL, '910000000', '2026-07-28 08:20:19'),
(2, 'João Silva', 'joao@email.com', NULL, '920000000', '2026-07-28 08:26:39'),
(3, 'Nelson Geovetty JAIME', 'nelsongeovettyjaime@gmail.com', '930935581', '930935581', '2026-07-28 09:03:21');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `customer_sales_summary`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `customer_sales_summary` (
`customer_id` int(11)
,`customer_name` varchar(100)
,`email` varchar(150)
,`tickets_bought` bigint(21)
,`total_spent` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `venue` varchar(150) NOT NULL,
  `event_date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `city`, `venue`, `event_date`, `price`, `image`, `created_at`) VALUES
(1, 'Força Suprema Live 2026', 'Grande concerto da Força Suprema', 'Lisboa', 'Arena MEO', '2026-08-15', 25.00, NULL, '2026-07-28 08:19:34'),
(2, 'Força Suprema Porto', 'Concerto especial Prodígio e Nga', 'Porto', 'Super Bock Arena', '2026-09-20', 30.00, NULL, '2026-07-28 08:19:47'),
(4, 'Nga Grande Show', 'Publicidade do seu album mais novo', 'LISBOA', 'Cine Tivoli', '2026-12-12', 30.00, '1785231442_Captura de ecrã 2025-08-26 115604.png', '2026-07-28 09:37:22'),
(5, 'Meu Grande Show Castelos', 'Meu grande show', 'LISBOA', 'Cine Tivoli', '2026-11-12', 15.00, '1785233608_Captura de ecrã 2025-08-11 123043.png', '2026-07-28 10:13:28');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `event_details`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `event_details` (
`event_id` int(11)
,`event_name` varchar(150)
,`city` varchar(100)
,`venue` varchar(150)
,`event_date` date
,`price` decimal(10,2)
,`total_tickets` bigint(21)
,`tickets_sold` decimal(22,0)
,`tickets_available` decimal(22,0)
);

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `event_sales_summary`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `event_sales_summary` (
`event_id` int(11)
,`event_name` varchar(150)
,`tickets_sold` bigint(21)
,`revenue` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mensagens`
--

CREATE TABLE `mensagens` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mensagem` text NOT NULL,
  `data_envio` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `total`, `created_at`) VALUES
(1, 39.98, '2025-09-15 10:49:17'),
(2, 19.99, '2025-09-15 10:49:26'),
(3, 49.48, '2025-09-15 11:16:00'),
(4, 9.50, '2025-09-15 11:16:13'),
(5, 12.00, '2025-09-15 11:16:21'),
(6, 2438.78, '2025-09-15 11:38:34'),
(7, 239.88, '2025-09-15 11:47:22'),
(8, 371.82, '2025-09-15 11:48:21'),
(9, 9.50, '2025-09-16 11:25:22'),
(10, 19.99, '2025-09-16 11:27:49'),
(11, 19.99, '2025-09-16 11:28:36'),
(12, 19.99, '2025-09-16 11:30:50'),
(13, 19.99, '2025-09-16 11:34:20'),
(14, 239.88, '2025-09-16 11:53:07'),
(15, 19.99, '2025-09-16 11:53:59'),
(16, 19.99, '2025-09-16 11:57:50'),
(17, 19.99, '2025-09-16 11:58:36'),
(18, 12.00, '2025-09-16 11:59:08'),
(19, 19.99, '2025-09-16 12:00:33'),
(20, 19.99, '2025-09-16 12:03:13'),
(21, 19.99, '2025-09-16 12:06:16'),
(22, 19.99, '2025-09-16 12:08:21'),
(23, 19.99, '2025-09-16 12:19:05'),
(24, 198.96, '2025-09-18 00:32:27'),
(25, 20.99, '2025-09-18 00:34:01'),
(26, 35.98, '2025-09-18 00:53:57'),
(27, 19.99, '2025-09-18 00:54:07'),
(28, 123.50, '2025-09-18 10:37:26'),
(29, 31.99, '2025-09-18 12:17:17'),
(30, 734.60, '2025-09-19 09:59:14'),
(31, 734.60, '2025-09-19 10:04:13'),
(32, 19.99, '2025-09-19 11:00:21'),
(33, 19.99, '2025-09-19 11:00:57'),
(34, 57.48, '2025-09-19 13:54:19'),
(35, 2024.19, '2025-09-22 09:05:12'),
(36, 239.88, '2025-09-22 09:45:46'),
(37, 184.95, '2025-09-24 12:24:47'),
(38, 53.97, '2025-09-25 10:42:16'),
(39, 199.60, '2025-09-28 18:18:38'),
(40, 9.50, '2025-10-15 13:12:09'),
(41, 140.70, '2025-12-11 19:53:31'),
(42, 2000000.00, '2025-12-11 19:59:31'),
(43, 35.45, '2026-03-11 10:18:27'),
(44, 19.00, '2026-03-11 10:18:58'),
(45, 447.71, '2026-03-11 10:35:54'),
(46, 447.71, '2026-03-11 10:37:14'),
(47, 19.00, '2026-03-11 10:37:36'),
(48, 64.47, '2026-03-11 10:40:05'),
(49, 53.98, '2026-03-11 10:40:34'),
(50, 1000065.43, '2026-05-22 16:15:24'),
(51, 60.44, '2026-06-02 10:53:45'),
(52, 9.99, '2026-07-28 07:47:21');

-- --------------------------------------------------------

--
-- Estrutura da tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 1, 2, 19.99),
(2, 2, 1, 1, 19.99),
(3, 3, 1, 2, 19.99),
(4, 3, 2, 1, 9.50),
(5, 4, 2, 1, 9.50),
(6, 5, 3, 1, 12.00),
(7, 6, 1, 122, 19.99),
(8, 7, 1, 12, 19.99),
(9, 8, 3, 1, 12.00),
(10, 8, 1, 18, 19.99),
(11, 9, 2, 1, 9.50),
(15, 13, 1, 1, 19.99),
(16, 14, 1, 12, 19.99),
(17, 15, 1, 1, 19.99),
(18, 16, 1, 1, 19.99),
(19, 17, 1, 1, 19.99),
(20, 18, 3, 1, 12.00),
(21, 19, 1, 1, 19.99),
(22, 20, 1, 1, 19.99),
(23, 21, 1, 1, 19.99),
(24, 22, 1, 1, 19.99),
(25, 23, 1, 1, 19.99),
(26, 24, 1, 2, 19.99),
(27, 24, 2, 12, 9.50),
(28, 24, 7, 1, 24.99),
(29, 24, 5, 1, 19.99),
(30, 25, 13, 1, 20.99),
(31, 26, 11, 1, 15.99),
(32, 26, 1, 1, 19.99),
(33, 27, 5, 1, 19.99),
(34, 28, 2, 13, 9.50),
(35, 29, 1, 1, 19.99),
(36, 29, 3, 1, 12.00),
(38, 31, 1, 27, 19.99),
(39, 31, 4, 13, 14.99),
(40, 32, 1, 1, 19.99),
(41, 33, 1, 1, 19.99),
(42, 34, 1, 1, 19.99),
(43, 34, 2, 1, 9.50),
(44, 34, 3, 1, 12.00),
(45, 34, 11, 1, 15.99),
(46, 35, 14, 81, 24.99),
(47, 36, 1, 12, 19.99),
(48, 37, 3, 5, 12.00),
(49, 37, 14, 5, 24.99),
(50, 38, 11, 1, 15.99),
(51, 38, 13, 1, 20.99),
(52, 38, 12, 1, 16.99),
(53, 39, 1, 8, 23.45),
(54, 39, 3, 1, 12.00),
(55, 40, 2, 1, 9.50),
(56, 41, 1, 6, 23.45),
(57, 42, 29, 2, 1000000.00),
(58, 43, 1, 1, 23.45),
(59, 43, 3, 1, 12.00),
(60, 44, 2, 2, 9.50),
(61, 45, 1, 15, 23.45),
(62, 46, 1, 15, 23.45),
(63, 46, 2, 2, 9.50),
(64, 46, 7, 1, 24.99),
(65, 46, 5, 1, 19.99),
(66, 46, 6, 2, 9.99),
(67, 46, 3, 1, 12.00),
(68, 47, 2, 2, 9.50),
(69, 48, 2, 1, 9.50),
(70, 48, 4, 1, 14.99),
(71, 48, 7, 1, 24.99),
(72, 48, 8, 1, 14.99),
(73, 49, 3, 2, 12.00),
(74, 49, 4, 2, 14.99),
(75, 50, 1, 1, 23.45),
(76, 50, 3, 1, 12.00),
(77, 50, 6, 1, 9.99),
(78, 50, 9, 1, 19.99),
(79, 50, 29, 1, 1000000.00),
(80, 51, 1, 1, 23.45),
(81, 51, 2, 2, 9.50),
(82, 51, 10, 1, 17.99),
(83, 52, 6, 1, 9.99);

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `category`, `image`) VALUES
(1, 'Camiseta Banda A', 23.50, 'Camiseta 100% algodão - tam M', NULL, 'img/t-shirt.jpg'),
(2, 'Poster Oficial', 9.50, 'Poster A2 em papel couché', NULL, 'img/poster_oficial.jpg'),
(3, 'CD Edição Especial', 12.00, 'CD com faixas bônus', NULL, 'img/baseados_em_factos reais.jpeg'),
(4, 'CD Especial - Banda Favorita', 14.99, 'Edição limitada com faixas bônus e encarte exclusivo.', NULL, 'img/faz_parte_hustle_2.jpeg'),
(5, 'Álbum Completo - Vol. 1', 19.99, 'Primeiro álbum oficial com 12 músicas inéditas.', NULL, 'img/fs4life.jpeg'),
(6, 'Poster Oficial', 9.99, 'Poster oficial da turnê mundial, tamanho A2.', NULL, 'img/poster_oficial.jpg'),
(7, 'T-shirt Oficial', 24.99, 'Camiseta oficial da banda, disponível em vários tamanhos.', NULL, 'img/t-shirt.jpg'),
(8, 'Álbum - União Fez A Força', 14.99, 'Primeiro Àlbum do grupo após 20 anos de carreira.', NULL, 'img/uniao_fez_a_forca.jpeg'),
(9, 'Álbum - Castelos', 19.99, 'Castelos de lata e areia.', NULL, 'img/castelos.jpeg'),
(10, 'Álbum - Filhos Das Ruas II', 17.99, 'Um dos vários sucessos do Nga', NULL, 'img/filhos_das_ruas_2.jpeg'),
(11, 'Álbum - Guerreiros', 15.99, 'Ep do Don G.', NULL, 'img/guerreiros.jpg'),
(12, 'Álbum - Dona Teresa', 16.99, 'Álbum feito depois da morte de sua mãe.', NULL, 'img/dona_tereza.jpg'),
(13, 'Ep - Cozinha Aberto II', 20.99, 'Ep gravada depois do álbum.', NULL, 'img/cozinha_aberta_2.jpg'),
(14, 'Ep - Atitude', 24.99, 'Feito antes do projeto do grupo.', NULL, 'img/atitude.jpg'),
(26, 'Camiseta Especial Nga_King', 145.67, NULL, NULL, 'img/t-shirt.jpg'),
(29, 'A Prenda 4', 9.99, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recuperacao_senha`
--

CREATE TABLE `recuperacao_senha` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiracao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `recuperacao_senha`
--

INSERT INTO `recuperacao_senha` (`id`, `email`, `token`, `expiracao`) VALUES
(1, 'admin@site.com', 'affa2f077d4996e5861b416f13efe9c242df64c9ff362f7c34ffc5dd4cded93b0547604add37dd6c63fe406c15a24fa540b2', '2025-09-22 13:04:23');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `sale_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `ticket_id`, `sale_date`, `payment_method`, `total`) VALUES
(1, 1, 1, '2026-07-28 08:20:39', 'Cartão', 25.00),
(3, 3, 2, '2026-07-28 09:03:21', 'Transferência', 25.00),
(6, 3, 8, '2026-07-28 10:18:19', 'MB WAY', 15.00),
(7, 3, 3, '2026-07-28 20:04:51', 'Cartão', 25.00),
(8, 3, 4, '2026-07-28 20:05:00', 'MB WAY', 25.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `status` enum('Disponível','Vendido') DEFAULT 'Disponível',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tickets`
--

INSERT INTO `tickets` (`id`, `event_id`, `ticket_number`, `status`, `created_at`) VALUES
(1, 1, 'FS001', 'Vendido', '2026-07-28 08:20:01'),
(2, 1, 'FS002', 'Vendido', '2026-07-28 08:20:01'),
(3, 1, 'FS003', 'Vendido', '2026-07-28 08:20:01'),
(4, 1, 'FS004', 'Vendido', '2026-07-28 08:20:01'),
(8, 5, 'T001', 'Vendido', '2026-07-28 10:13:28'),
(9, 5, 'T002', 'Disponível', '2026-07-28 10:13:28'),
(10, 5, 'T003', 'Disponível', '2026-07-28 10:13:28'),
(11, 5, 'T004', 'Disponível', '2026-07-28 10:13:28'),
(12, 5, 'T005', 'Disponível', '2026-07-28 10:13:28'),
(13, 5, 'T006', 'Disponível', '2026-07-28 10:13:28'),
(14, 5, 'T007', 'Disponível', '2026-07-28 10:13:28'),
(15, 5, 'T008', 'Disponível', '2026-07-28 10:13:28'),
(16, 5, 'T009', 'Disponível', '2026-07-28 10:13:28'),
(17, 5, 'T010', 'Disponível', '2026-07-28 10:13:28'),
(18, 5, 'T011', 'Disponível', '2026-07-28 10:13:28'),
(19, 5, 'T012', 'Disponível', '2026-07-28 10:13:28'),
(20, 5, 'T013', 'Disponível', '2026-07-28 10:13:28'),
(21, 5, 'T014', 'Disponível', '2026-07-28 10:13:28'),
(22, 5, 'T015', 'Disponível', '2026-07-28 10:13:28'),
(23, 5, 'T016', 'Disponível', '2026-07-28 10:13:28'),
(24, 5, 'T017', 'Disponível', '2026-07-28 10:13:28'),
(25, 5, 'T018', 'Disponível', '2026-07-28 10:13:28'),
(26, 5, 'T019', 'Disponível', '2026-07-28 10:13:28'),
(27, 5, 'T020', 'Disponível', '2026-07-28 10:13:28'),
(28, 5, 'T021', 'Disponível', '2026-07-28 10:13:28'),
(29, 5, 'T022', 'Disponível', '2026-07-28 10:13:28'),
(30, 5, 'T023', 'Disponível', '2026-07-28 10:13:28'),
(31, 5, 'T024', 'Disponível', '2026-07-28 10:13:28'),
(32, 5, 'T025', 'Disponível', '2026-07-28 10:13:28'),
(33, 5, 'T026', 'Disponível', '2026-07-28 10:13:28'),
(34, 5, 'T027', 'Disponível', '2026-07-28 10:13:28'),
(35, 5, 'T028', 'Disponível', '2026-07-28 10:13:28'),
(36, 5, 'T029', 'Disponível', '2026-07-28 10:13:28'),
(37, 5, 'T030', 'Disponível', '2026-07-28 10:13:28'),
(38, 5, 'T031', 'Disponível', '2026-07-28 10:13:28'),
(39, 5, 'T032', 'Disponível', '2026-07-28 10:13:28'),
(40, 5, 'T033', 'Disponível', '2026-07-28 10:13:28'),
(41, 5, 'T034', 'Disponível', '2026-07-28 10:13:28'),
(42, 5, 'T035', 'Disponível', '2026-07-28 10:13:28'),
(43, 5, 'T036', 'Disponível', '2026-07-28 10:13:28'),
(44, 5, 'T037', 'Disponível', '2026-07-28 10:13:28'),
(45, 5, 'T038', 'Disponível', '2026-07-28 10:13:28'),
(46, 5, 'T039', 'Disponível', '2026-07-28 10:13:28'),
(47, 5, 'T040', 'Disponível', '2026-07-28 10:13:28'),
(48, 5, 'T041', 'Disponível', '2026-07-28 10:13:28'),
(49, 5, 'T042', 'Disponível', '2026-07-28 10:13:28'),
(50, 5, 'T043', 'Disponível', '2026-07-28 10:13:28'),
(51, 5, 'T044', 'Disponível', '2026-07-28 10:13:28'),
(52, 5, 'T045', 'Disponível', '2026-07-28 10:13:28'),
(53, 5, 'T046', 'Disponível', '2026-07-28 10:13:28'),
(54, 5, 'T047', 'Disponível', '2026-07-28 10:13:28'),
(55, 5, 'T048', 'Disponível', '2026-07-28 10:13:28'),
(56, 5, 'T049', 'Disponível', '2026-07-28 10:13:28'),
(57, 5, 'T050', 'Disponível', '2026-07-28 10:13:28'),
(58, 5, 'T051', 'Disponível', '2026-07-28 10:13:28'),
(59, 5, 'T052', 'Disponível', '2026-07-28 10:13:28'),
(60, 5, 'T053', 'Disponível', '2026-07-28 10:13:28'),
(61, 5, 'T054', 'Disponível', '2026-07-28 10:13:28'),
(62, 5, 'T055', 'Disponível', '2026-07-28 10:13:28'),
(63, 5, 'T056', 'Disponível', '2026-07-28 10:13:28'),
(64, 5, 'T057', 'Disponível', '2026-07-28 10:13:28'),
(65, 5, 'T058', 'Disponível', '2026-07-28 10:13:28'),
(66, 5, 'T059', 'Disponível', '2026-07-28 10:13:28'),
(67, 5, 'T060', 'Disponível', '2026-07-28 10:13:28'),
(68, 5, 'T061', 'Disponível', '2026-07-28 10:13:28'),
(69, 5, 'T062', 'Disponível', '2026-07-28 10:13:28'),
(70, 5, 'T063', 'Disponível', '2026-07-28 10:13:28'),
(71, 5, 'T064', 'Disponível', '2026-07-28 10:13:28'),
(72, 5, 'T065', 'Disponível', '2026-07-28 10:13:28'),
(73, 5, 'T066', 'Disponível', '2026-07-28 10:13:28'),
(74, 5, 'T067', 'Disponível', '2026-07-28 10:13:28'),
(75, 5, 'T068', 'Disponível', '2026-07-28 10:13:28'),
(76, 5, 'T069', 'Disponível', '2026-07-28 10:13:28'),
(77, 5, 'T070', 'Disponível', '2026-07-28 10:13:28'),
(78, 5, 'T071', 'Disponível', '2026-07-28 10:13:28'),
(79, 5, 'T072', 'Disponível', '2026-07-28 10:13:28'),
(80, 5, 'T073', 'Disponível', '2026-07-28 10:13:28'),
(81, 5, 'T074', 'Disponível', '2026-07-28 10:13:28'),
(82, 5, 'T075', 'Disponível', '2026-07-28 10:13:28'),
(83, 5, 'T076', 'Disponível', '2026-07-28 10:13:28'),
(84, 5, 'T077', 'Disponível', '2026-07-28 10:13:28'),
(85, 5, 'T078', 'Disponível', '2026-07-28 10:13:28'),
(86, 5, 'T079', 'Disponível', '2026-07-28 10:13:28'),
(87, 5, 'T080', 'Disponível', '2026-07-28 10:13:28'),
(88, 5, 'T081', 'Disponível', '2026-07-28 10:13:28'),
(89, 5, 'T082', 'Disponível', '2026-07-28 10:13:28'),
(90, 5, 'T083', 'Disponível', '2026-07-28 10:13:28'),
(91, 5, 'T084', 'Disponível', '2026-07-28 10:13:28'),
(92, 5, 'T085', 'Disponível', '2026-07-28 10:13:28'),
(93, 5, 'T086', 'Disponível', '2026-07-28 10:13:28'),
(94, 5, 'T087', 'Disponível', '2026-07-28 10:13:28'),
(95, 5, 'T088', 'Disponível', '2026-07-28 10:13:28'),
(96, 5, 'T089', 'Disponível', '2026-07-28 10:13:28'),
(97, 5, 'T090', 'Disponível', '2026-07-28 10:13:28'),
(98, 5, 'T091', 'Disponível', '2026-07-28 10:13:28'),
(99, 5, 'T092', 'Disponível', '2026-07-28 10:13:28'),
(100, 5, 'T093', 'Disponível', '2026-07-28 10:13:28'),
(101, 5, 'T094', 'Disponível', '2026-07-28 10:13:28'),
(102, 5, 'T095', 'Disponível', '2026-07-28 10:13:28'),
(103, 5, 'T096', 'Disponível', '2026-07-28 10:13:28'),
(104, 5, 'T097', 'Disponível', '2026-07-28 10:13:29'),
(105, 5, 'T098', 'Disponível', '2026-07-28 10:13:29'),
(106, 5, 'T099', 'Disponível', '2026-07-28 10:13:29'),
(107, 5, 'T100', 'Disponível', '2026-07-28 10:13:29');

-- --------------------------------------------------------

--
-- Estrutura stand-in para vista `tickets_status`
-- (Veja abaixo para a view atual)
--
CREATE TABLE `tickets_status` (
`ticket_id` int(11)
,`ticket_number` varchar(50)
,`event_name` varchar(150)
,`event_date` date
,`status` enum('Disponível','Vendido')
);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tour_dates`
--

CREATE TABLE `tour_dates` (
  `id` int(11) NOT NULL,
  `tour_date` date NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tour_dates`
--

INSERT INTO `tour_dates` (`id`, `tour_date`, `city`, `venue`, `created_at`) VALUES
(1, '2027-09-12', 'Alverca', 'Meo Arena', '2025-09-24 11:39:40'),
(2, '2025-12-23', 'Lisboa', 'Meo Arena', '2025-09-24 12:26:32'),
(4, '2027-07-07', 'Londres', 'Meo Arena', '2025-09-28 18:21:42'),
(6, '2026-10-29', 'Londres', 'Meo Arena', '2026-06-02 10:56:27');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin@site.com', '$2y$10$qACdkGJsYO34PjId5KVwne5.1o9iGkAPQ19e0TWCV.E3NKLpx..wW', 'admin', '2025-09-19 10:17:12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_banda`
--

CREATE TABLE `users_banda` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `users_banda`
--

INSERT INTO `users_banda` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'André', 'Nelsongeovettyjaime@gmail.com', '$2y$10$i4b3IohTgzB6ZWNidFSGRObYy72cAi/duSDIB8fHp8WJ.YsO0go1i', 'user'),
(3, 'Nelson Kamba', 'Nelsonkamba123@gmail.com', '$2y$10$LVcCIToTDoybFtfx0UET6.8q2chs/iV7bfEkuQDECbVDsRBUBBQ4m', 'user'),
(4, 'Ricardo', 'Ricardo@gmail.com', '$2y$10$sC0nxjamzXZsuOR1/ye4NOOOAOCk.imnmCHdJk1tNVloSY2Sx374u', 'user'),
(5, 'Silvia Domingos', 'silviadomingos@gmail.com', '$2y$10$VM4VbeuUSss9Hqt7C0ows.R77HM.i8l3xYFMzT4itQCFzk.FJxhlW', 'user'),
(8, 'Ricardo Ana', 'Ricardoana@gmail.com', '$2y$10$7fBUwRtwabF/odJLjdDWpOJTbHSBi1IDLaabtNMlyLCyZkhdgj3ze', 'user'),
(9, 'Demonstração', 'demo@gmail.com', '$2y$10$64pf4Zz/H8pbsZq4VNr0iuWHtfJUXclAyUNFG5E81XC9ORjG19jY6', 'user'),
(14, 'André Fontes', 'Andrefontes@gmail.com', '$2y$10$s6EFpdbRfugOjebC20hawe3n0Go4GfSvMb9iaNjF42Tmz3onVTON.', 'user'),
(15, 'Angola Demo', 'Angola@gmial.com', '$2y$10$NqRTCmk3YuiOlu.m6RA/RuxJpKlDWBOpanKpmKUoxmv3ye3oXjqcq', 'user'),
(16, 'Miguel', 'miguel@gmail.com', '$2y$10$odK3VSIpZPEADg2nGwab1eheJZ7FbSxeBnlo8HA5hkigjBV3O9zzS', 'user'),
(17, 'Nelson Jaime Segundo', 'nelsongeovettysegundo@gmail.com', '$2y$10$sIvl6Cl1BwdHQHXSd55X1OXACQDnb4GT4.nDbqS43Zt1CMgw2yAz6', 'user'),
(18, 'Demo Publicar', 'demopublicar@gmail.com', '$2y$10$c99OjPeJ5tFe0/Iiym4I0edgwA.9h8YZDTNF4N0B0al.0JmSm8J9O', 'user');

-- --------------------------------------------------------

--
-- Estrutura para vista `customer_sales_summary`
--
DROP TABLE IF EXISTS `customer_sales_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customer_sales_summary`  AS SELECT `c`.`id` AS `customer_id`, `c`.`name` AS `customer_name`, `c`.`email` AS `email`, count(`s`.`id`) AS `tickets_bought`, sum(`s`.`total`) AS `total_spent` FROM (`customers` `c` left join `sales` `s` on(`c`.`id` = `s`.`customer_id`)) GROUP BY `c`.`id` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `event_details`
--
DROP TABLE IF EXISTS `event_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event_details`  AS SELECT `e`.`id` AS `event_id`, `e`.`title` AS `event_name`, `e`.`city` AS `city`, `e`.`venue` AS `venue`, `e`.`event_date` AS `event_date`, `e`.`price` AS `price`, count(`t`.`id`) AS `total_tickets`, sum(case when `t`.`status` = 'Vendido' then 1 else 0 end) AS `tickets_sold`, sum(case when `t`.`status` = 'Disponível' then 1 else 0 end) AS `tickets_available` FROM (`events` `e` left join `tickets` `t` on(`e`.`id` = `t`.`event_id`)) GROUP BY `e`.`id` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `event_sales_summary`
--
DROP TABLE IF EXISTS `event_sales_summary`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `event_sales_summary`  AS SELECT `e`.`id` AS `event_id`, `e`.`title` AS `event_name`, count(`s`.`id`) AS `tickets_sold`, sum(`s`.`total`) AS `revenue` FROM ((`events` `e` left join `tickets` `t` on(`e`.`id` = `t`.`event_id`)) left join `sales` `s` on(`t`.`id` = `s`.`ticket_id`)) GROUP BY `e`.`id` ;

-- --------------------------------------------------------

--
-- Estrutura para vista `tickets_status`
--
DROP TABLE IF EXISTS `tickets_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tickets_status`  AS SELECT `t`.`id` AS `ticket_id`, `t`.`ticket_number` AS `ticket_number`, `e`.`title` AS `event_name`, `e`.`event_date` AS `event_date`, `t`.`status` AS `status` FROM (`tickets` `t` join `events` `e` on(`t`.`event_id` = `e`.`id`)) ;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices para tabela `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Índices para tabela `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Índices para tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `recuperacao_senha`
--
ALTER TABLE `recuperacao_senha`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sale_customer` (`customer_id`),
  ADD KEY `fk_sale_ticket` (`ticket_id`);

--
-- Índices para tabela `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ticket_number` (`ticket_number`),
  ADD KEY `fk_ticket_event` (`event_id`);

--
-- Índices para tabela `tour_dates`
--
ALTER TABLE `tour_dates`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `users_banda`
--
ALTER TABLE `users_banda`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `recuperacao_senha`
--
ALTER TABLE `recuperacao_senha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT de tabela `tour_dates`
--
ALTER TABLE `tour_dates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users_banda`
--
ALTER TABLE `users_banda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Limitadores para a tabela `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sale_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_sale_ticket` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_ticket_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
